<?php

namespace App\Services;

use App\Models\Food;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FoodCsvImportService
{
    private const CATEGORY_OPTIONS = [
        'Protein Hewani',
        'Protein Nabati',
        'Karbohidrat',
        'Sayuran',
        'Buah',
        'Dairy',
        'Lainnya',
    ];

    private const MAX_ROWS = 5000;

    public function previewFromStoragePath(string $storagePath, array $manualMapping = []): array
    {
        if (!Storage::exists($storagePath)) {
            return [
                'schema' => 'unknown',
                'total_rows' => 0,
                'valid_rows' => 0,
                'duplicate_rows' => 0,
                'error_rows' => 1,
                'insertable_rows' => [],
                'preview_rows' => [],
                'duplicate_names' => [],
                'errors' => ['File CSV tidak ditemukan di storage sementara.'],
                'detected_headers' => [],
                'requires_mapping' => false,
                'mappable_fields' => $this->mappableFields(),
                'mapping_errors' => [],
                'selected_mapping' => [],
                'auto_mapping_applied' => false,
            ];
        }

        $absolutePath = Storage::path($storagePath);

        return $this->parseCsv($absolutePath, $manualMapping);
    }

    public function importFromStoragePath(string $storagePath, array $manualMapping = []): array
    {
        $preview = $this->previewFromStoragePath($storagePath, $manualMapping);

        $rows = $preview['insertable_rows'];
        $inserted = 0;

        foreach (array_chunk($rows, 200) as $chunk) {
            $payload = array_map(function (array $row) {
                return [
                    ...$row,
                    'dietary_tags' => json_encode($row['dietary_tags']),
                    'health_benefits' => json_encode($row['health_benefits']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $chunk);

            Food::insert($payload);
            $inserted += count($payload);
        }

        return [
            'schema' => $preview['schema'],
            'total_rows' => $preview['total_rows'],
            'inserted_rows' => $inserted,
            'duplicate_rows' => $preview['duplicate_rows'],
            'error_rows' => $preview['error_rows'],
            'duplicate_names' => $preview['duplicate_names'],
            'errors' => $preview['errors'],
        ];
    }

    private function parseCsv(string $absolutePath, array $manualMapping = []): array
    {
        $file = fopen($absolutePath, 'r');

        if ($file === false) {
            return [
                'schema' => 'unknown',
                'total_rows' => 0,
                'valid_rows' => 0,
                'duplicate_rows' => 0,
                'error_rows' => 1,
                'insertable_rows' => [],
                'preview_rows' => [],
                'duplicate_names' => [],
                'errors' => ['Gagal membuka file CSV.'],
                'detected_headers' => [],
                'requires_mapping' => false,
                'mappable_fields' => $this->mappableFields(),
                'mapping_errors' => [],
                'selected_mapping' => [],
                'auto_mapping_applied' => false,
            ];
        }

        $headers = fgetcsv($file) ?: [];
        $normalizedHeaders = array_map(fn ($header) => $this->normalizeHeader((string) $header), $headers);
        $schema = $this->detectSchema($normalizedHeaders);
        $manualMappingProvided = !empty($manualMapping);

        if ($schema === 'unknown') {
            $autoSuggestion = $this->suggestMapping($headers, $normalizedHeaders);
            $effectiveMapping = $manualMappingProvided ? $manualMapping : $autoSuggestion;

            if (empty($effectiveMapping)) {
                $analysis = $this->analyzeUnknownSchemaRows($file, $headers, $normalizedHeaders);
                fclose($file);

                return [
                    'schema' => 'unknown',
                    'total_rows' => $analysis['total_rows'],
                    'valid_rows' => 0,
                    'duplicate_rows' => 0,
                    'error_rows' => 1,
                    'insertable_rows' => [],
                    'preview_rows' => [],
                    'duplicate_names' => [],
                    'errors' => ['Format CSV belum dikenali otomatis. Pilih mapping kolom dulu untuk lanjut preview import.'],
                    'detected_headers' => $headers,
                    'requires_mapping' => true,
                    'mappable_fields' => $this->mappableFields(),
                    'mapping_errors' => [],
                    'selected_mapping' => $autoSuggestion,
                    'source_preview_rows' => $analysis['source_preview_rows'],
                    'auto_mapping_applied' => false,
                ];
            }

            $mappingValidation = $this->validateManualMapping($effectiveMapping, $normalizedHeaders);
            if (!empty($mappingValidation)) {
                $analysis = $this->analyzeUnknownSchemaRows($file, $headers, $normalizedHeaders);
                fclose($file);

                return [
                    'schema' => 'unknown',
                    'total_rows' => $analysis['total_rows'],
                    'valid_rows' => 0,
                    'duplicate_rows' => 0,
                    'error_rows' => count($mappingValidation),
                    'insertable_rows' => [],
                    'preview_rows' => [],
                    'duplicate_names' => [],
                    'errors' => [],
                    'detected_headers' => $headers,
                    'requires_mapping' => true,
                    'mappable_fields' => $this->mappableFields(),
                    'mapping_errors' => $mappingValidation,
                    'selected_mapping' => $effectiveMapping,
                    'source_preview_rows' => $analysis['source_preview_rows'],
                    'auto_mapping_applied' => false,
                ];
            }

            $schema = 'mapped';
            $manualMapping = $effectiveMapping;
        }

        $existingNames = Food::pluck('name')->map(fn ($name) => Str::lower(trim($name)))->toArray();
        $knownNames = array_fill_keys($existingNames, true);

        $insertableRows = [];
        $previewRows = [];
        $duplicateNames = [];
        $errors = [];
        $totalRows = 0;

        while (($row = fgetcsv($file)) !== false) {
            if ($this->rowIsEmpty($row)) {
                continue;
            }

            $totalRows++;

            if ($totalRows > self::MAX_ROWS) {
                $errors[] = 'Baris melebihi batas maksimal ' . self::MAX_ROWS . ' data per import.';
                break;
            }

            $mapped = $this->mapRowBySchema($schema, $normalizedHeaders, $row, $manualMapping);
            $rowNumber = $totalRows + 1;

            $nameKey = Str::lower(trim((string) ($mapped['name'] ?? '')));
            if ($nameKey === '') {
                $errors[] = 'Baris ' . $rowNumber . ': nama makanan wajib diisi.';
                continue;
            }

            if (isset($knownNames[$nameKey])) {
                $duplicateNames[] = $mapped['name'];
                continue;
            }

            $normalized = $this->normalizeMappedRow($mapped);
            $validator = Validator::make($normalized, $this->validationRules());

            if ($validator->fails()) {
                $messages = implode('; ', $validator->errors()->all());
                $errors[] = 'Baris ' . $rowNumber . ': ' . $messages;
                continue;
            }

            $validated = $validator->validated();
            $insertableRows[] = $validated;
            $knownNames[$nameKey] = true;

            if (count($previewRows) < 20) {
                $previewRows[] = $validated;
            }
        }

        fclose($file);

        return [
            'schema' => $schema,
            'total_rows' => $totalRows,
            'valid_rows' => count($insertableRows),
            'duplicate_rows' => count($duplicateNames),
            'error_rows' => count($errors),
            'insertable_rows' => $insertableRows,
            'preview_rows' => $previewRows,
            'duplicate_names' => array_slice($duplicateNames, 0, 20),
            'errors' => array_slice($errors, 0, 30),
            'detected_headers' => $headers,
            'requires_mapping' => false,
            'mappable_fields' => $this->mappableFields(),
            'mapping_errors' => [],
            'selected_mapping' => $manualMapping,
            'source_preview_rows' => [],
            'auto_mapping_applied' => $schema === 'mapped' && !$manualMappingProvided,
        ];
    }

    private function detectSchema(array $headers): string
    {
        $headerSet = array_fill_keys($headers, true);

        $isNutrition = isset($headerSet['calories'], $headerSet['proteins'], $headerSet['fat'], $headerSet['carbohydrate'], $headerSet['name']);
        if ($isNutrition) {
            return 'nutrition';
        }

        $isNilaiGizi = isset($headerSet['name'], $headerSet['serving_size'], $headerSet['energy_kcal'], $headerSet['protein_g'], $headerSet['carbohydrate_g'], $headerSet['fat_g']);
        if ($isNilaiGizi) {
            return 'nilai_gizi';
        }

        $isSimple = isset($headerSet['name'], $headerSet['calories'])
            && (isset($headerSet['protein']) || isset($headerSet['proteins']))
            && (isset($headerSet['carbs']) || isset($headerSet['carbohydrate']))
            && isset($headerSet['fat']);

        return $isSimple ? 'simple' : 'unknown';
    }

    private function mapRowBySchema(string $schema, array $headers, array $row, array $manualMapping = []): array
    {
        $data = [];
        foreach ($headers as $index => $header) {
            $data[$header] = $row[$index] ?? null;
        }

        if ($schema === 'mapped') {
            $mapped = [];
            foreach ($manualMapping as $targetField => $sourceHeader) {
                $normalizedSource = $this->normalizeHeader((string) $sourceHeader);
                $mapped[$targetField] = $data[$normalizedSource] ?? null;
            }

            $name = (string) ($mapped['name'] ?? '');
            $category = (string) ($mapped['category'] ?? '');
            $resolvedCategory = in_array($category, self::CATEGORY_OPTIONS, true)
                ? $category
                : $this->determineCategory($name);

            return [
                'name' => $mapped['name'] ?? null,
                'category' => $resolvedCategory,
                'calories' => $mapped['calories'] ?? 0,
                'protein' => $mapped['protein'] ?? $mapped['proteins'] ?? 0,
                'carbs' => $mapped['carbs'] ?? $mapped['carbohydrate'] ?? 0,
                'fat' => $mapped['fat'] ?? 0,
                'fiber' => $mapped['fiber'] ?? null,
                'sugars' => $mapped['sugars'] ?? null,
                'sodium' => $mapped['sodium'] ?? null,
                'cholesterol' => $mapped['cholesterol'] ?? null,
                'meal_type' => $mapped['meal_type'] ?? $this->determineMealType($name),
                'description' => $mapped['description'] ?? null,
                'image_url' => $mapped['image_url'] ?? $mapped['image'] ?? null,
                'dietary_tags' => $mapped['dietary_tags'] ?? null,
                'health_benefits' => $mapped['health_benefits'] ?? null,
                'emoji' => $mapped['emoji'] ?? $this->determineEmoji($resolvedCategory, $name),
            ];
        }

        if ($schema === 'nutrition') {
            return [
                'name' => $data['name'] ?? null,
                'category' => $this->determineCategory((string) ($data['name'] ?? '')),
                'calories' => $data['calories'] ?? 0,
                'protein' => $data['proteins'] ?? 0,
                'carbs' => $data['carbohydrate'] ?? 0,
                'fat' => $data['fat'] ?? 0,
                'fiber' => $this->estimateFiber(
                    $this->determineCategory((string) ($data['name'] ?? '')),
                    (int) ($data['calories'] ?? 0),
                    (float) ($data['carbohydrate'] ?? 0)
                ),
                'sugars' => null,
                'sodium' => null,
                'cholesterol' => null,
                'meal_type' => $this->determineMealType((string) ($data['name'] ?? '')),
                'description' => 'Imported from nutrition dataset',
                'image_url' => $data['image'] ?? null,
                'dietary_tags' => [],
                'health_benefits' => [],
                'emoji' => $this->determineEmoji(
                    $this->determineCategory((string) ($data['name'] ?? '')),
                    (string) ($data['name'] ?? '')
                ),
            ];
        }

        if ($schema === 'nilai_gizi') {
            $servingSize = $this->parseServingSize((string) ($data['serving_size'] ?? '100 g'));

            $calories = (float) ($data['energy_kcal'] ?? 0);
            $protein = (float) ($data['protein_g'] ?? 0);
            $carbs = (float) ($data['carbohydrate_g'] ?? 0);
            $fat = (float) ($data['fat_g'] ?? 0);
            $sugar = (float) ($data['sugar_g'] ?? 0);
            $sodium = (float) ($data['sodium_mg'] ?? 0);
            $fiber = (float) ($data['fiber_g'] ?? 0);

            if ($servingSize > 0 && $servingSize !== 100.0 && $servingSize >= 10) {
                $multiplier = 100 / $servingSize;

                $testCarbs = $carbs * $multiplier;
                $testProtein = $protein * $multiplier;
                $testFat = $fat * $multiplier;

                if ($testCarbs <= 100 && $testProtein <= 100 && $testFat <= 100) {
                    $calories = round($calories * $multiplier, 1);
                    $protein = round($protein * $multiplier, 2);
                    $carbs = round($carbs * $multiplier, 2);
                    $fat = round($fat * $multiplier, 2);
                    $sugar = round($sugar * $multiplier, 2);
                    $sodium = round($sodium * $multiplier, 2);
                    $fiber = round($fiber * $multiplier, 2);
                }
            }

            $category = $this->determineCategory((string) ($data['name'] ?? ''));

            return [
                'name' => $data['name'] ?? null,
                'category' => $category,
                'calories' => $calories,
                'protein' => $protein,
                'carbs' => $carbs,
                'fat' => $fat,
                'fiber' => $fiber > 0 ? $fiber : null,
                'sugars' => $sugar > 0 ? $sugar : null,
                'sodium' => $sodium > 0 ? $sodium : null,
                'cholesterol' => null,
                'meal_type' => $this->determineMealType((string) ($data['name'] ?? '')),
                'description' => 'Imported from nilai gizi dataset',
                'image_url' => null,
                'dietary_tags' => [],
                'health_benefits' => [],
                'emoji' => $this->determineEmoji($category, (string) ($data['name'] ?? '')),
            ];
        }

        $name = (string) ($data['name'] ?? '');
        $category = (string) ($data['category'] ?? '');
        $resolvedCategory = in_array($category, self::CATEGORY_OPTIONS, true)
            ? $category
            : $this->determineCategory($name);

        return [
            'name' => $data['name'] ?? null,
            'category' => $resolvedCategory,
            'calories' => $data['calories'] ?? 0,
            'protein' => $data['protein'] ?? $data['proteins'] ?? 0,
            'carbs' => $data['carbs'] ?? $data['carbohydrate'] ?? 0,
            'fat' => $data['fat'] ?? 0,
            'fiber' => $data['fiber'] ?? null,
            'sugars' => $data['sugars'] ?? null,
            'sodium' => $data['sodium'] ?? null,
            'cholesterol' => $data['cholesterol'] ?? null,
            'meal_type' => $data['meal_type'] ?? $this->determineMealType($name),
            'description' => $data['description'] ?? null,
            'image_url' => $data['image_url'] ?? $data['image'] ?? null,
            'dietary_tags' => $data['dietary_tags'] ?? null,
            'health_benefits' => $data['health_benefits'] ?? null,
            'emoji' => $data['emoji'] ?? $this->determineEmoji($resolvedCategory, $name),
        ];
    }

    private function mappableFields(): array
    {
        return [
            'required' => ['name', 'calories', 'protein', 'carbs', 'fat'],
            'optional' => [
                'category',
                'fiber',
                'sugars',
                'sodium',
                'cholesterol',
                'meal_type',
                'description',
                'image_url',
                'dietary_tags',
                'health_benefits',
                'emoji',
            ],
        ];
    }

    private function suggestMapping(array $headers, array $normalizedHeaders): array
    {
        $aliases = $this->fieldAliases();
        $available = [];

        foreach ($headers as $index => $rawHeader) {
            $normalized = $normalizedHeaders[$index] ?? $this->normalizeHeader((string) $rawHeader);
            if ($normalized === '') {
                continue;
            }

            $available[$normalized] = (string) $rawHeader;
        }

        $used = [];
        $mapping = [];
        $targets = [...$this->mappableFields()['required'], ...$this->mappableFields()['optional']];

        foreach ($targets as $target) {
            $source = $this->findBestSourceHeader($aliases[$target] ?? [$target], $available, $used);
            if ($source === null) {
                continue;
            }

            $mapping[$target] = $source;
            $used[$this->normalizeHeader($source)] = true;
        }

        return $mapping;
    }

    private function fieldAliases(): array
    {
        return [
            'name' => ['name', 'food_name', 'nama', 'nama_makanan', 'item', 'menu', 'food'],
            'calories' => ['calories', 'calorie', 'energy_kcal', 'kcal', 'energi', 'kalori', 'kkal'],
            'protein' => ['protein', 'proteins', 'protein_g', 'prot', 'protein_gram'],
            'carbs' => ['carbs', 'carbohydrate', 'carbohydrates', 'carbohydrate_g', 'karbo', 'karbohidrat', 'karbohidrat_g'],
            'fat' => ['fat', 'fats', 'fat_g', 'lemak', 'lemak_g'],
            'category' => ['category', 'kategori', 'group', 'food_group'],
            'fiber' => ['fiber', 'fibre', 'fiber_g', 'serat', 'serat_g'],
            'sugars' => ['sugar', 'sugars', 'sugar_g', 'gula', 'gula_g'],
            'sodium' => ['sodium', 'sodium_mg', 'natrium', 'garam', 'salt', 'salt_mg'],
            'cholesterol' => ['cholesterol', 'kolesterol', 'kolesterol_mg'],
            'meal_type' => ['meal_type', 'meal', 'tipe_makan', 'waktu_makan'],
            'description' => ['description', 'desc', 'deskripsi', 'keterangan', 'notes'],
            'image_url' => ['image_url', 'image', 'img', 'photo', 'foto', 'picture', 'thumbnail'],
            'dietary_tags' => ['dietary_tags', 'diet_tags', 'tags', 'label_diet'],
            'health_benefits' => ['health_benefits', 'benefits', 'manfaat', 'benefit'],
            'emoji' => ['emoji', 'icon', 'ikon'],
        ];
    }

    private function findBestSourceHeader(array $aliases, array $available, array $used): ?string
    {
        $bestSource = null;
        $bestScore = -1;

        foreach ($available as $normalizedHeader => $rawHeader) {
            if (isset($used[$normalizedHeader])) {
                continue;
            }

            $score = 0;
            foreach ($aliases as $alias) {
                $normalizedAlias = $this->normalizeHeader($alias);
                if ($normalizedAlias === '') {
                    continue;
                }

                if ($normalizedHeader === $normalizedAlias) {
                    $score = max($score, 100);
                    continue;
                }

                if (str_contains($normalizedHeader, $normalizedAlias) || str_contains($normalizedAlias, $normalizedHeader)) {
                    $score = max($score, 80);
                    continue;
                }

                $distance = levenshtein($normalizedHeader, $normalizedAlias);
                if ($distance <= 2) {
                    $score = max($score, 65);
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestSource = $rawHeader;
            }
        }

        if ($bestScore < 65) {
            return null;
        }

        return $bestSource;
    }

    private function validateManualMapping(array $manualMapping, array $normalizedHeaders): array
    {
        $errors = [];
        $allFields = [
            ...$this->mappableFields()['required'],
            ...$this->mappableFields()['optional'],
        ];

        foreach ($manualMapping as $targetField => $sourceHeader) {
            if (!in_array($targetField, $allFields, true)) {
                continue;
            }

            $normalizedSource = $this->normalizeHeader((string) $sourceHeader);
            if (!in_array($normalizedSource, $normalizedHeaders, true)) {
                $errors[] = 'Kolom sumber untuk field "' . $targetField . '" tidak ditemukan di header CSV.';
            }
        }

        foreach ($this->mappableFields()['required'] as $requiredField) {
            if (!array_key_exists($requiredField, $manualMapping) || trim((string) $manualMapping[$requiredField]) === '') {
                $errors[] = 'Mapping wajib untuk field "' . $requiredField . '" belum dipilih.';
            }
        }

        $selectedSources = [];
        foreach ($manualMapping as $sourceHeader) {
            $normalizedSource = $this->normalizeHeader((string) $sourceHeader);
            if ($normalizedSource === '') {
                continue;
            }

            if (isset($selectedSources[$normalizedSource])) {
                $errors[] = 'Satu kolom CSV tidak boleh dipakai untuk beberapa field target.';
                break;
            }

            $selectedSources[$normalizedSource] = true;
        }

        return $errors;
    }

    private function analyzeUnknownSchemaRows($file, array $headers, array $normalizedHeaders): array
    {
        $totalRows = 0;
        $previewRows = [];

        while (($row = fgetcsv($file)) !== false) {
            if ($this->rowIsEmpty($row)) {
                continue;
            }

            $totalRows++;

            if (count($previewRows) < 5) {
                $rowData = [];
                foreach ($normalizedHeaders as $index => $normalizedHeader) {
                    $rawHeader = $headers[$index] ?? $normalizedHeader;
                    $rowData[(string) $rawHeader] = $row[$index] ?? null;
                }
                $previewRows[] = $rowData;
            }

            if ($totalRows > self::MAX_ROWS) {
                break;
            }
        }

        return [
            'total_rows' => $totalRows,
            'source_preview_rows' => $previewRows,
        ];
    }

    private function normalizeMappedRow(array $mapped): array
    {
        $dietaryTags = $this->parseListValue($mapped['dietary_tags'] ?? null);
        $healthBenefits = $this->parseListValue($mapped['health_benefits'] ?? null);

        return [
            'name' => trim((string) ($mapped['name'] ?? '')),
            'category' => (string) ($mapped['category'] ?? 'Lainnya'),
            'calories' => (int) round((float) ($mapped['calories'] ?? 0)),
            'protein' => (float) ($mapped['protein'] ?? 0),
            'carbs' => (float) ($mapped['carbs'] ?? 0),
            'fat' => (float) ($mapped['fat'] ?? 0),
            'fiber' => $this->nullableFloat($mapped['fiber'] ?? null),
            'sugars' => $this->nullableFloat($mapped['sugars'] ?? null),
            'sodium' => $this->nullableFloat($mapped['sodium'] ?? null),
            'cholesterol' => $this->nullableFloat($mapped['cholesterol'] ?? null),
            'meal_type' => $this->nullableString($mapped['meal_type'] ?? null),
            'description' => $this->nullableString($mapped['description'] ?? null),
            'image_url' => $this->nullableString($mapped['image_url'] ?? null),
            'dietary_tags' => $dietaryTags,
            'health_benefits' => $healthBenefits,
            'emoji' => $this->nullableString($mapped['emoji'] ?? null),
        ];
    }

    private function validationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category' => 'required|in:Protein Hewani,Protein Nabati,Karbohidrat,Sayuran,Buah,Dairy,Lainnya',
            'calories' => 'required|integer|min:0|max:2000',
            'protein' => 'required|numeric|min:0|max:200',
            'carbs' => 'required|numeric|min:0|max:300',
            'fat' => 'required|numeric|min:0|max:200',
            'fiber' => 'nullable|numeric|min:0|max:50',
            'sugars' => 'nullable|numeric|min:0|max:200',
            'sodium' => 'nullable|numeric|min:0|max:5000',
            'cholesterol' => 'nullable|numeric|min:0|max:500',
            'meal_type' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_url' => 'nullable|url|max:500',
            'dietary_tags' => 'nullable|array',
            'dietary_tags.*' => 'string|max:100',
            'health_benefits' => 'nullable|array',
            'health_benefits.*' => 'string|max:150',
            'emoji' => 'nullable|string|max:10',
        ];
    }

    private function parseListValue(mixed $value): array
    {
        if (is_array($value)) {
            $items = $value;
        } elseif (is_string($value) && trim($value) !== '') {
            $items = preg_split('/[,|;]/', $value) ?: [];
        } else {
            $items = [];
        }

        $cleaned = array_map(fn ($item) => trim((string) $item), $items);
        $cleaned = array_values(array_filter($cleaned, fn ($item) => $item !== ''));

        return array_slice($cleaned, 0, 10);
    }

    private function nullableFloat(mixed $value): ?float
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value) && trim($value) === '') {
            return null;
        }

        return (float) $value;
    }

    private function nullableString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim((string) $value);

        return $trimmed === '' ? null : $trimmed;
    }

    private function normalizeHeader(string $header): string
    {
        return Str::of($header)
            ->lower()
            ->replace([' ', '-'], '_')
            ->trim()
            ->toString();
    }

    private function rowIsEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    private function parseServingSize(string $servingSizeStr): float
    {
        $cleaned = trim(str_replace(['g', 'G'], '', $servingSizeStr));

        return (float) $cleaned ?: 100.0;
    }

    private function determineCategory(string $name): string
    {
        $name = Str::lower($name);

        if (str_contains($name, 'sayur') || str_contains($name, 'bayam') || str_contains($name, 'kangkung')
            || str_contains($name, 'sawi') || str_contains($name, 'brokoli') || str_contains($name, 'wortel')
            || str_contains($name, 'tomat') || str_contains($name, 'timun') || str_contains($name, 'terong')
            || str_contains($name, 'labu') || str_contains($name, 'kol') || str_contains($name, 'kubis')
            || str_contains($name, 'selada') || str_contains($name, 'lobak')) {
            return 'Sayuran';
        }

        if (str_contains($name, 'buah') || str_contains($name, 'pisang') || str_contains($name, 'apel')
            || str_contains($name, 'jeruk') || str_contains($name, 'mangga') || str_contains($name, 'anggur')
            || str_contains($name, 'pepaya') || str_contains($name, 'semangka') || str_contains($name, 'melon')
            || str_contains($name, 'durian') || str_contains($name, 'rambutan') || str_contains($name, 'salak')
            || str_contains($name, 'jambu') || str_contains($name, 'nanas') || str_contains($name, 'bengkuang')
            || str_contains($name, 'belimbing')) {
            return 'Buah';
        }

        if (str_contains($name, 'ayam') || str_contains($name, 'sapi') || str_contains($name, 'ikan')
            || str_contains($name, 'daging') || str_contains($name, 'kambing') || str_contains($name, 'bebek')
            || str_contains($name, 'telur') || str_contains($name, 'udang') || str_contains($name, 'cumi')
            || str_contains($name, 'kepiting') || str_contains($name, 'salmon') || str_contains($name, 'tuna')
            || str_contains($name, 'lele') || str_contains($name, 'gurame') || str_contains($name, 'bandeng')
            || str_contains($name, 'tongkol')) {
            return 'Protein Hewani';
        }

        if (str_contains($name, 'tahu') || str_contains($name, 'tempe') || str_contains($name, 'kacang')
            || str_contains($name, 'oncom') || str_contains($name, 'kedelai') || str_contains($name, 'ampas')) {
            return 'Protein Nabati';
        }

        if (str_contains($name, 'nasi') || str_contains($name, 'roti') || str_contains($name, 'mie')
            || str_contains($name, 'bihun') || str_contains($name, 'kentang') || str_contains($name, 'singkong')
            || str_contains($name, 'ubi') || str_contains($name, 'jagung') || str_contains($name, 'gandum')
            || str_contains($name, 'pasta') || str_contains($name, 'talas') || str_contains($name, 'sagu')) {
            return 'Karbohidrat';
        }

        if (str_contains($name, 'susu') || str_contains($name, 'keju') || str_contains($name, 'yogurt')
            || str_contains($name, 'yoghurt')) {
            return 'Dairy';
        }

        return 'Lainnya';
    }

    private function determineMealType(string $name): string
    {
        $name = Str::lower($name);

        if (str_contains($name, 'roti') || str_contains($name, 'telur') || str_contains($name, 'bubur')
            || str_contains($name, 'oat')) {
            return 'Sarapan';
        }

        if (str_contains($name, 'kue') || str_contains($name, 'biskuit') || str_contains($name, 'cemilan')
            || str_contains($name, 'gorengan') || str_contains($name, 'keripik')) {
            return 'Camilan';
        }

        return 'Makan Utama';
    }

    private function determineEmoji(string $category, string $name): string
    {
        return match ($category) {
            'Sayuran' => '🥬',
            'Buah' => '🍎',
            'Protein Hewani' => '🍗',
            'Protein Nabati' => '🥜',
            'Karbohidrat' => '🍚',
            'Dairy' => '🥛',
            default => '🍽️',
        };
    }

    private function estimateFiber(string $category, int $calories, float $carbs): float
    {
        return match ($category) {
            'Sayuran' => max(2.0, $carbs * 0.3),
            'Buah' => max(1.5, $carbs * 0.2),
            'Protein Nabati' => max(3.0, $carbs * 0.25),
            'Karbohidrat' => $carbs * 0.1,
            'Protein Hewani' => 0,
            'Dairy' => 0,
            default => $carbs * 0.05,
        };
    }
}
