import { useState } from "react";
import { motion, AnimatePresence } from "motion/react";
import {
  Activity,
  Heart,
  Scale,
  Droplets,
  Thermometer,
  Brain,
  ChevronRight,
  LogIn,
  Loader2,
  CheckCircle2,
  Clock,
  Flame,
  Leaf,
  AlertCircle,
  X,
} from "lucide-react";
import { Navbar } from "../components/Navbar";
import { Link } from "react-router";

interface BodyForm {
  age: string;
  weight: string;
  height: string;
  gender: string;
  bloodPressureSystolic: string;
  bloodPressureDiastolic: string;
  bloodSugar: string;
  cholesterol: string;
  activityLevel: string;
  dietaryRestriction: string;
  healthGoal: string;
}

interface FoodRecommendation {
  name: string;
  category: string;
  calories: number;
  protein: number;
  carbs: number;
  fat: number;
  fiber: number;
  match: number;
  benefits: string[];
  timing: string;
  emoji: string;
}

const generateRecommendations = (form: BodyForm): FoodRecommendation[] => {
  const age = parseInt(form.age);
  const isHighBP = parseInt(form.bloodPressureSystolic) >= 130;
  const isHighSugar = parseInt(form.bloodSugar) >= 126;
  const isHighCholesterol = parseInt(form.cholesterol) >= 200;

  const baseRecommendations: FoodRecommendation[] = [
    {
      name: "Oatmeal with Berries",
      category: "Breakfast",
      calories: 320,
      protein: 12,
      carbs: 54,
      fat: 6,
      fiber: 8,
      match: 96,
      benefits: ["High fiber", "Antioxidants", "Heart-healthy"],
      timing: "Morning",
      emoji: "🥣",
    },
    {
      name: "Grilled Salmon & Quinoa",
      category: "Lunch",
      calories: 480,
      protein: 38,
      carbs: 42,
      fat: 14,
      fiber: 5,
      match: 93,
      benefits: ["Omega-3", "Complete protein", "Low glycemic"],
      timing: "Afternoon",
      emoji: "🐟",
    },
    {
      name: "Vegetable Stir-fry with Tofu",
      category: "Dinner",
      calories: 380,
      protein: 24,
      carbs: 35,
      fat: 12,
      fiber: 9,
      match: 89,
      benefits: ["Plant protein", "Low sodium", "High vitamins"],
      timing: "Evening",
      emoji: "🥦",
    },
  ];

  if (isHighBP) {
    baseRecommendations[0].match = 98;
    baseRecommendations[0].benefits.push("Blood pressure support");
  }
  if (isHighSugar) {
    baseRecommendations[1].match = 97;
    baseRecommendations[1].benefits.push("Glycemic control");
  }
  if (isHighCholesterol) {
    baseRecommendations[2].match = 95;
    baseRecommendations[2].benefits.push("Cholesterol reduction");
  }
  if (age > 50) {
    baseRecommendations.push({
      name: "Greek Yogurt Parfait",
      category: "Snack",
      calories: 220,
      protein: 18,
      carbs: 28,
      fat: 4,
      fiber: 3,
      match: 91,
      benefits: ["Probiotics", "Bone health", "Calcium-rich"],
      timing: "Snack",
      emoji: "🫙",
    });
  }

  return baseRecommendations;
};

const healthWarnings = (form: BodyForm): string[] => {
  const warnings: string[] = [];
  if (parseInt(form.bloodPressureSystolic) >= 140) warnings.push("High blood pressure detected. Reduce sodium intake.");
  if (parseInt(form.bloodSugar) >= 126) warnings.push("Elevated blood sugar. Limit refined carbohydrates.");
  if (parseInt(form.cholesterol) >= 240) warnings.push("High cholesterol. Increase fiber and omega-3 intake.");
  return warnings;
};

export default function GuestPage() {
  const [form, setForm] = useState<BodyForm>({
    age: "",
    weight: "",
    height: "",
    gender: "male",
    bloodPressureSystolic: "",
    bloodPressureDiastolic: "",
    bloodSugar: "",
    cholesterol: "",
    activityLevel: "moderate",
    dietaryRestriction: "none",
    healthGoal: "balanced",
  });
  const [submitted, setSubmitted] = useState(false);
  const [loading, setLoading] = useState(false);
  const [recommendations, setRecommendations] = useState<FoodRecommendation[]>([]);
  const [warnings, setWarnings] = useState<string[]>([]);
  const [activeTab, setActiveTab] = useState<"all" | "breakfast" | "lunch" | "dinner" | "snack">("all");

  const handleChange = (field: keyof BodyForm, value: string) => {
    setForm((prev) => ({ ...prev, [field]: value }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    await new Promise((r) => setTimeout(r, 2000));
    const recs = generateRecommendations(form);
    const warns = healthWarnings(form);
    setRecommendations(recs);
    setWarnings(warns);
    setLoading(false);
    setSubmitted(true);
    setTimeout(() => {
      document.getElementById("results")?.scrollIntoView({ behavior: "smooth" });
    }, 100);
  };

  const filteredRecs =
    activeTab === "all"
      ? recommendations
      : recommendations.filter((r) => r.category.toLowerCase() === activeTab);

  const bmi =
    form.weight && form.height
      ? (parseFloat(form.weight) / Math.pow(parseFloat(form.height) / 100, 2)).toFixed(1)
      : null;

  const getBMIStatus = (bmi: number) => {
    if (bmi < 18.5) return { label: "Underweight", color: "text-blue-600" };
    if (bmi < 25) return { label: "Normal", color: "text-[#16A34A]" };
    if (bmi < 30) return { label: "Overweight", color: "text-yellow-600" };
    return { label: "Obese", color: "text-[#C62828]" };
  };

  return (
    <div className="min-h-screen bg-[#F9FAFB] dark:bg-[#0F172A]" style={{ fontFamily: "Poppins, sans-serif" }}>
      <Navbar />

      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          className="text-center mb-10"
        >
          <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#C62828]/10 text-[#C62828] text-xs font-semibold mb-4">
            <Brain className="w-3 h-3" />
            AI Body Analysis
          </div>
          <h1 className="text-gray-900 dark:text-white mb-3" style={{ fontSize: "clamp(1.6rem, 3vw, 2.2rem)", fontWeight: 700 }}>
            Get Your Personalized Food Plan
          </h1>
          <p className="text-gray-600 dark:text-gray-400 max-w-lg mx-auto">
            Enter your body condition details below and our AI will generate a personalized nutrition plan for you.
          </p>
        </motion.div>

        {/* Form Card */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.1 }}
          className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 shadow-xl shadow-gray-900/5 p-8"
        >
          <form onSubmit={handleSubmit}>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {/* Basic Info */}
              <div className="md:col-span-2">
                <h3 className="text-gray-900 dark:text-white font-semibold mb-4 flex items-center gap-2">
                  <div className="w-6 h-6 rounded-full bg-[#C62828] text-white text-xs flex items-center justify-center font-bold">1</div>
                  Basic Information
                </h3>
                <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Age</label>
                    <input
                      type="number"
                      placeholder="e.g. 28"
                      value={form.age}
                      onChange={(e) => handleChange("age", e.target.value)}
                      required
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    />
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Weight (kg)</label>
                    <input
                      type="number"
                      placeholder="e.g. 70"
                      value={form.weight}
                      onChange={(e) => handleChange("weight", e.target.value)}
                      required
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    />
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Height (cm)</label>
                    <input
                      type="number"
                      placeholder="e.g. 170"
                      value={form.height}
                      onChange={(e) => handleChange("height", e.target.value)}
                      required
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    />
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Gender</label>
                    <select
                      value={form.gender}
                      onChange={(e) => handleChange("gender", e.target.value)}
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    >
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                  </div>
                </div>

                {/* BMI Preview */}
                {bmi && (
                  <div className="mt-3 flex items-center gap-2 text-sm">
                    <Scale className="w-4 h-4 text-gray-400" />
                    <span className="text-gray-500 dark:text-gray-400">BMI:</span>
                    <span className={`font-semibold ${getBMIStatus(parseFloat(bmi)).color}`}>
                      {bmi} — {getBMIStatus(parseFloat(bmi)).label}
                    </span>
                  </div>
                )}
              </div>

              {/* Health Metrics */}
              <div className="md:col-span-2">
                <h3 className="text-gray-900 dark:text-white font-semibold mb-4 flex items-center gap-2">
                  <div className="w-6 h-6 rounded-full bg-[#C62828] text-white text-xs flex items-center justify-center font-bold">2</div>
                  Health Metrics
                </h3>
                <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 flex items-center gap-1">
                      <Heart className="w-3 h-3 text-[#C62828]" /> BP Systolic
                    </label>
                    <input
                      type="number"
                      placeholder="e.g. 120"
                      value={form.bloodPressureSystolic}
                      onChange={(e) => handleChange("bloodPressureSystolic", e.target.value)}
                      required
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    />
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 flex items-center gap-1">
                      <Activity className="w-3 h-3 text-[#C62828]" /> BP Diastolic
                    </label>
                    <input
                      type="number"
                      placeholder="e.g. 80"
                      value={form.bloodPressureDiastolic}
                      onChange={(e) => handleChange("bloodPressureDiastolic", e.target.value)}
                      required
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    />
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 flex items-center gap-1">
                      <Droplets className="w-3 h-3 text-[#C62828]" /> Blood Sugar
                    </label>
                    <input
                      type="number"
                      placeholder="mg/dL"
                      value={form.bloodSugar}
                      onChange={(e) => handleChange("bloodSugar", e.target.value)}
                      required
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    />
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 flex items-center gap-1">
                      <Thermometer className="w-3 h-3 text-[#C62828]" /> Cholesterol
                    </label>
                    <input
                      type="number"
                      placeholder="mg/dL"
                      value={form.cholesterol}
                      onChange={(e) => handleChange("cholesterol", e.target.value)}
                      required
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    />
                  </div>
                </div>
              </div>

              {/* Preferences */}
              <div className="md:col-span-2">
                <h3 className="text-gray-900 dark:text-white font-semibold mb-4 flex items-center gap-2">
                  <div className="w-6 h-6 rounded-full bg-[#C62828] text-white text-xs flex items-center justify-center font-bold">3</div>
                  Lifestyle & Preferences
                </h3>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Activity Level</label>
                    <select
                      value={form.activityLevel}
                      onChange={(e) => handleChange("activityLevel", e.target.value)}
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    >
                      <option value="sedentary">Sedentary</option>
                      <option value="light">Lightly Active</option>
                      <option value="moderate">Moderately Active</option>
                      <option value="active">Very Active</option>
                      <option value="athlete">Athlete</option>
                    </select>
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Dietary Restriction</label>
                    <select
                      value={form.dietaryRestriction}
                      onChange={(e) => handleChange("dietaryRestriction", e.target.value)}
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    >
                      <option value="none">None</option>
                      <option value="vegetarian">Vegetarian</option>
                      <option value="vegan">Vegan</option>
                      <option value="halal">Halal</option>
                      <option value="gluten-free">Gluten-free</option>
                      <option value="dairy-free">Dairy-free</option>
                    </select>
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Health Goal</label>
                    <select
                      value={form.healthGoal}
                      onChange={(e) => handleChange("healthGoal", e.target.value)}
                      className="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    >
                      <option value="balanced">Balanced Health</option>
                      <option value="weight-loss">Weight Loss</option>
                      <option value="muscle-gain">Muscle Gain</option>
                      <option value="heart-health">Heart Health</option>
                      <option value="diabetes-control">Diabetes Control</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div className="mt-8">
              <button
                type="submit"
                disabled={loading}
                className="w-full flex items-center justify-center gap-2 py-3.5 bg-[#C62828] hover:bg-[#b71c1c] disabled:opacity-70 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-red-900/20"
              >
                {loading ? (
                  <>
                    <Loader2 className="w-4 h-4 animate-spin" />
                    Analyzing your body condition...
                  </>
                ) : (
                  <>
                    <Brain className="w-4 h-4" />
                    Generate My Food Plan
                    <ChevronRight className="w-4 h-4" />
                  </>
                )}
              </button>
            </div>
          </form>
        </motion.div>

        {/* Results */}
        <AnimatePresence>
          {submitted && !loading && (
            <motion.div
              id="results"
              initial={{ opacity: 0, y: 40 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5 }}
              className="mt-10"
            >
              {/* Health Warnings */}
              {warnings.length > 0 && (
                <div className="mb-6 space-y-2">
                  {warnings.map((w, i) => (
                    <div key={i} className="flex items-start gap-3 px-4 py-3 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/50 rounded-xl">
                      <AlertCircle className="w-4 h-4 text-amber-600 dark:text-amber-400 mt-0.5 shrink-0" />
                      <p className="text-sm text-amber-800 dark:text-amber-200">{w}</p>
                    </div>
                  ))}
                </div>
              )}

              <div className="flex items-center justify-between mb-6">
                <div>
                  <h2 className="text-gray-900 dark:text-white font-bold" style={{ fontSize: "1.3rem" }}>
                    Your Personalized Food Plan
                  </h2>
                  <p className="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Based on your body condition analysis
                  </p>
                </div>
                <div className="flex items-center gap-2 px-3 py-1.5 bg-[#16A34A]/10 rounded-full">
                  <CheckCircle2 className="w-4 h-4 text-[#16A34A]" />
                  <span className="text-xs font-semibold text-[#16A34A]">AI Analyzed</span>
                </div>
              </div>

              {/* Filter Tabs */}
              <div className="flex flex-wrap gap-2 mb-5">
                {["all", "breakfast", "lunch", "dinner", "snack"].map((tab) => (
                  <button
                    key={tab}
                    onClick={() => setActiveTab(tab as typeof activeTab)}
                    className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all capitalize ${
                      activeTab === tab
                        ? "bg-[#C62828] text-white shadow-sm"
                        : "bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-[#C62828]/40"
                    }`}
                  >
                    {tab === "all" ? "All Meals" : tab}
                  </button>
                ))}
              </div>

              <div className="grid gap-4">
                {filteredRecs.map((rec, i) => (
                  <motion.div
                    key={rec.name}
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: i * 0.1 }}
                    className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm hover:shadow-md transition-all"
                  >
                    <div className="flex items-start justify-between gap-4">
                      <div className="flex items-start gap-3">
                        <div className="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-2xl shrink-0">
                          {rec.emoji}
                        </div>
                        <div>
                          <div className="flex items-center gap-2 flex-wrap">
                            <h3 className="text-gray-900 dark:text-white font-semibold">{rec.name}</h3>
                            <span className="px-2 py-0.5 bg-[#C62828]/10 text-[#C62828] text-xs font-semibold rounded-full">{rec.category}</span>
                          </div>
                          <div className="flex items-center gap-1.5 mt-1">
                            <Clock className="w-3 h-3 text-gray-400" />
                            <span className="text-xs text-gray-500 dark:text-gray-400">{rec.timing}</span>
                          </div>
                          <div className="flex flex-wrap gap-1.5 mt-2">
                            {rec.benefits.map((b) => (
                              <span key={b} className="flex items-center gap-1 px-2 py-0.5 bg-[#16A34A]/10 text-[#16A34A] text-xs rounded-full">
                                <Leaf className="w-2.5 h-2.5" />
                                {b}
                              </span>
                            ))}
                          </div>
                        </div>
                      </div>
                      <div className="text-right shrink-0">
                        <div className="text-2xl font-bold text-[#16A34A]">{rec.match}%</div>
                        <div className="text-xs text-gray-500 dark:text-gray-400">match</div>
                      </div>
                    </div>

                    <div className="mt-4 grid grid-cols-4 gap-3">
                      {[
                        { icon: Flame, label: "Calories", val: `${rec.calories}`, unit: "kcal" },
                        { icon: Activity, label: "Protein", val: `${rec.protein}g`, unit: "" },
                        { icon: Droplets, label: "Carbs", val: `${rec.carbs}g`, unit: "" },
                        { icon: Leaf, label: "Fiber", val: `${rec.fiber}g`, unit: "" },
                      ].map(({ icon: Icon, label, val }) => (
                        <div key={label} className="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-2.5 text-center">
                          <Icon className="w-3.5 h-3.5 text-[#C62828] mx-auto mb-1" />
                          <p className="text-xs font-semibold text-gray-900 dark:text-white">{val}</p>
                          <p className="text-xs text-gray-500 dark:text-gray-400">{label}</p>
                        </div>
                      ))}
                    </div>

                    <div className="mt-3">
                      <div className="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                        <span>Match Score</span>
                        <span className="font-semibold text-[#16A34A]">{rec.match}%</span>
                      </div>
                      <div className="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                        <div
                          className="h-1.5 rounded-full bg-gradient-to-r from-[#16A34A] to-emerald-400"
                          style={{ width: `${rec.match}%` }}
                        />
                      </div>
                    </div>
                  </motion.div>
                ))}
              </div>

              {/* Save History CTA */}
              <motion.div
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ delay: 0.5 }}
                className="mt-8 p-5 bg-gradient-to-br from-[#C62828]/5 to-[#16A34A]/5 border border-[#C62828]/20 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4"
              >
                <div>
                  <p className="font-semibold text-gray-900 dark:text-white">Save your history?</p>
                  <p className="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Login to track your progress and get long-term insights.</p>
                </div>
                <Link
                  to="/login"
                  className="flex items-center gap-2 px-5 py-2.5 bg-[#C62828] hover:bg-[#b71c1c] text-white rounded-xl font-semibold transition-all duration-200 shadow-md shadow-red-900/20 whitespace-nowrap"
                >
                  <LogIn className="w-4 h-4" />
                  Login to Track
                </Link>
              </motion.div>
            </motion.div>
          )}
        </AnimatePresence>
      </div>
    </div>
  );
}
