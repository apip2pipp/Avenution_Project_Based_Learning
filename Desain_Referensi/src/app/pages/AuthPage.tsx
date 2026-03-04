import { useState } from "react";
import { useNavigate, Link, useLocation } from "react-router";
import { motion, AnimatePresence } from "motion/react";
import {
  HeartPulse,
  Eye,
  EyeOff,
  Loader2,
  AlertCircle,
  ArrowLeft,
  Moon,
  Sun,
  Brain,
  Utensils,
  TrendingUp,
  Star,
  X,
  Activity,
  User,
  Mail,
  Lock,
  Sparkles,
  Check,
  Shield,
} from "lucide-react";
import { useAuth } from "../context/AuthContext";
import { useTheme } from "../context/ThemeContext";

// ── Mock Google accounts ──────────────────────────────────────────────────────
const GOOGLE_ACCOUNTS = [
  {
    id: "g1",
    name: "Siti Rahayu",
    email: "siti.rahayu@gmail.com",
    initials: "SR",
    bg: "bg-blue-500",
  },
  {
    id: "g2",
    name: "Budi Santoso",
    email: "budi.santoso@gmail.com",
    initials: "BS",
    bg: "bg-emerald-500",
  },
];

// ── Health goal options ───────────────────────────────────────────────────────
const HEALTH_GOALS = [
  { id: "lose_weight", emoji: "🏃", label: "Lose Weight" },
  { id: "build_muscle", emoji: "💪", label: "Build Muscle" },
  { id: "improve_health", emoji: "❤️", label: "Improve Health" },
  { id: "stay_balanced", emoji: "⚖️", label: "Stay Balanced" },
];

// ── Brand features (left panel) ───────────────────────────────────────────────
const FEATURES = [
  { icon: Brain, text: "AI-powered body condition analysis" },
  { icon: Utensils, text: "Personalized nutrition plans" },
  { icon: TrendingUp, text: "Real-time progress tracking" },
  { icon: Shield, text: "HIPAA-compliant & secure" },
];

// ── Password strength helper ──────────────────────────────────────────────────
function getStrength(pwd: string) {
  if (!pwd) return null;
  if (pwd.length < 6)
    return { bars: 1, label: "Weak", color: "bg-red-500", text: "text-red-500" };
  if (pwd.length < 10)
    return { bars: 2, label: "Fair", color: "bg-yellow-500", text: "text-yellow-500" };
  return { bars: 3, label: "Strong", color: "bg-green-500", text: "text-green-500" };
}

// ─────────────────────────────────────────────────────────────────────────────
export default function AuthPage() {
  const location = useLocation();
  const navigate = useNavigate();
  const { login, register: doRegister, loginWithGoogle } = useAuth();
  const { theme, toggleTheme } = useTheme();

  // Determine initial mode from URL
  const [mode, setMode] = useState<"login" | "register">(
    location.pathname === "/register" ? "register" : "login"
  );

  // ── Form state ──
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPwd, setConfirmPwd] = useState("");
  const [healthGoal, setHealthGoal] = useState("");
  const [showPwd, setShowPwd] = useState(false);
  const [showConfirmPwd, setShowConfirmPwd] = useState(false);

  // ── UI state ──
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [showGooglePicker, setShowGooglePicker] = useState(false);
  const [googleLoadingId, setGoogleLoadingId] = useState<string | null>(null);

  // ── Switch login ↔ register ──
  const switchMode = (m: "login" | "register") => {
    setMode(m);
    setError("");
    setPassword("");
    setConfirmPwd("");
    navigate(m === "register" ? "/register" : "/login", { replace: true });
  };

  // ── Form submit ──
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");

    if (mode === "register") {
      if (!name.trim()) { setError("Please enter your full name."); return; }
      if (password.length < 6) { setError("Password must be at least 6 characters."); return; }
      if (password !== confirmPwd) { setError("Passwords do not match."); return; }
    }

    setLoading(true);
    await new Promise((r) => setTimeout(r, 1100));

    if (mode === "login") {
      const ok = login(email, password);
      if (ok) {
        navigate(email === "admin@avenution.com" ? "/admin" : "/dashboard");
      } else {
        setError("Incorrect email or password. Please try again.");
        setLoading(false);
      }
    } else {
      const ok = doRegister(name.trim(), email, password, healthGoal || undefined);
      if (ok) {
        navigate("/dashboard");
      } else {
        setError("An account with this email already exists.");
        setLoading(false);
      }
    }
  };

  // ── Google mock ──
  const handleGoogleSelect = (acc: (typeof GOOGLE_ACCOUNTS)[0]) => {
    setGoogleLoadingId(acc.id);
    setTimeout(() => {
      loginWithGoogle({ name: acc.name, email: acc.email });
      setShowGooglePicker(false);
      setGoogleLoadingId(null);
      navigate("/dashboard");
    }, 1600);
  };

  const strength = getStrength(password);
  const pwdMatch = confirmPwd.length > 0 && confirmPwd === password;
  const pwdMismatch = confirmPwd.length > 0 && confirmPwd !== password;

  // ── Render ────────────────────────────────────────────────────────────────
  return (
    <div
      className="flex min-h-screen bg-white dark:bg-[#0F172A]"
      style={{ fontFamily: "Poppins, sans-serif" }}
    >
      {/* ═══════════════════════════════════════════════════════════════════
          LEFT — Brand Panel (desktop only)
      ═══════════════════════════════════════════════════════════════════ */}
      <div className="hidden lg:flex lg:w-[44%] xl:w-2/5 sticky top-0 h-screen flex-col overflow-hidden relative">
        {/* Background */}
        <div className="absolute inset-0 bg-gradient-to-br from-[#0c0f1a] via-[#111827] to-[#0c0f1a]" />
        {/* Glows */}
        <div className="absolute -top-20 -right-20 w-96 h-96 bg-[#C62828]/25 rounded-full blur-[80px]" />
        <div className="absolute bottom-0 left-0 w-80 h-80 bg-[#C62828]/10 rounded-full blur-[60px]" />
        <div className="absolute top-1/2 right-0 w-64 h-64 bg-[#16A34A]/8 rounded-full blur-[80px]" />

        {/* Subtle grid texture */}
        <div
          className="absolute inset-0 opacity-[0.04]"
          style={{
            backgroundImage:
              "linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px)",
            backgroundSize: "40px 40px",
          }}
        />

        {/* Content */}
        <div className="relative z-10 flex flex-col h-full px-10 py-8">
          {/* Logo */}
          <motion.div
            initial={{ opacity: 0, y: -10 }}
            animate={{ opacity: 1, y: 0 }}
            className="flex items-center gap-2.5"
          >
            <div className="w-9 h-9 rounded-xl bg-[#C62828] flex items-center justify-center shadow-lg shadow-red-900/50">
              <HeartPulse className="w-5 h-5 text-white" />
            </div>
            <span
              className="text-white tracking-tight"
              style={{ fontWeight: 700, fontSize: "1.15rem" }}
            >
              Avenution
            </span>
          </motion.div>

          {/* Main text */}
          <div className="flex-1 flex flex-col justify-center">
            <motion.div
              initial={{ opacity: 0, y: 24 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.15 }}
            >
              <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#C62828]/20 border border-[#C62828]/30 mb-6">
                <Sparkles className="w-3 h-3 text-red-300" />
                <span className="text-red-200 text-xs font-medium">
                  AI-Powered Nutrition Platform
                </span>
              </div>

              <h2
                className="text-white mb-4"
                style={{
                  fontSize: "clamp(1.9rem, 2.4vw, 2.6rem)",
                  fontWeight: 700,
                  lineHeight: 1.18,
                }}
              >
                Your Personal
                <br />
                <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#ef5350] to-[#ff8a80]">
                  AI Nutrition
                </span>
                <br />
                Coach
              </h2>

              <p className="text-gray-400 mb-8 leading-relaxed max-w-xs text-sm">
                Advanced AI analyzes your body metrics to deliver personalized
                nutrition plans that actually work for you.
              </p>

              {/* Features */}
              <div className="space-y-3.5">
                {FEATURES.map((f, i) => (
                  <motion.div
                    key={f.text}
                    initial={{ opacity: 0, x: -15 }}
                    animate={{ opacity: 1, x: 0 }}
                    transition={{ delay: 0.3 + i * 0.08 }}
                    className="flex items-center gap-3"
                  >
                    <div className="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                      <f.icon className="w-4 h-4 text-red-300" />
                    </div>
                    <span className="text-gray-300 text-sm">{f.text}</span>
                  </motion.div>
                ))}
              </div>
            </motion.div>

            {/* Stat card */}
            <motion.div
              initial={{ opacity: 0, y: 16 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.65 }}
              className="mt-10 bg-white/5 border border-white/10 rounded-2xl p-4 backdrop-blur-sm"
            >
              <div className="flex items-center gap-3 mb-3">
                <div className="w-9 h-9 rounded-full bg-[#C62828]/30 flex items-center justify-center shrink-0">
                  <Activity className="w-4 h-4 text-red-300" />
                </div>
                <div className="flex-1 min-w-0">
                  <p className="text-white text-xs font-semibold">
                    Today's Nutrition Score
                  </p>
                  <p className="text-gray-400 text-xs truncate">
                    Mediterranean Diet Plan
                  </p>
                </div>
                <div className="text-right shrink-0">
                  <p className="text-[#4ade80] font-bold text-sm">96%</p>
                  <p className="text-gray-500 text-xs">Match</p>
                </div>
              </div>
              <div className="w-full bg-white/10 rounded-full h-1.5">
                <div
                  className="bg-gradient-to-r from-[#C62828] to-[#4ade80] h-1.5 rounded-full transition-all"
                  style={{ width: "96%" }}
                />
              </div>
            </motion.div>
          </div>

          {/* Testimonial */}
          <motion.div
            initial={{ opacity: 0, y: 16 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.85 }}
            className="bg-white/5 border border-white/10 rounded-2xl p-5 backdrop-blur-sm"
          >
            <div className="flex gap-0.5 mb-3">
              {Array.from({ length: 5 }).map((_, i) => (
                <Star
                  key={i}
                  className="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"
                />
              ))}
            </div>
            <p className="text-gray-300 text-sm leading-relaxed mb-4">
              "Avenution completely transformed how I think about food. Lost 8kg
              in 3 months with the AI recommendations!"
            </p>
            <div className="flex items-center gap-2.5">
              <div className="w-8 h-8 rounded-full bg-gradient-to-br from-[#C62828] to-[#ef5350] flex items-center justify-center text-white text-xs font-bold shrink-0">
                RD
              </div>
              <div>
                <p className="text-white text-xs font-semibold">Rina Dewi</p>
                <p className="text-gray-500 text-xs">Jakarta, Indonesia 🇮🇩</p>
              </div>
            </div>
          </motion.div>
        </div>
      </div>

      {/* ═══════════════════════════════════════════════════════════════════
          RIGHT — Form Panel
      ═══════════════════════════════════════════════════════════════════ */}
      <div className="flex-1 flex flex-col min-h-screen">
        {/* Top bar */}
        <div className="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800/60">
          <Link
            to="/"
            className="flex items-center gap-1.5 text-gray-500 dark:text-gray-400 hover:text-[#C62828] transition-colors text-sm font-medium"
          >
            <ArrowLeft className="w-4 h-4" />
            Back to Home
          </Link>

          {/* Mobile logo */}
          <div className="flex lg:hidden items-center gap-2">
            <div className="w-7 h-7 rounded-lg bg-[#C62828] flex items-center justify-center">
              <HeartPulse className="w-3.5 h-3.5 text-white" />
            </div>
            <span
              className="text-gray-900 dark:text-white"
              style={{ fontWeight: 700, fontSize: "0.95rem" }}
            >
              Avenution
            </span>
          </div>

          <button
            onClick={toggleTheme}
            className="w-9 h-9 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            aria-label="Toggle theme"
          >
            {theme === "dark" ? (
              <Sun className="w-4 h-4" />
            ) : (
              <Moon className="w-4 h-4" />
            )}
          </button>
        </div>

        {/* Scrollable form area */}
        <div className="flex-1 flex items-start justify-center px-6 py-10 overflow-y-auto">
          <div className="w-full max-w-[360px]">
            {/* Heading */}
            <AnimatePresence mode="wait">
              <motion.div
                key={mode + "-heading"}
                initial={{ opacity: 0, y: -8 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0, y: 8 }}
                transition={{ duration: 0.18 }}
                className="mb-7"
              >
                <h1
                  className="text-gray-900 dark:text-white"
                  style={{ fontSize: "1.55rem", fontWeight: 700 }}
                >
                  {mode === "login" ? "Welcome back 👋" : "Create your account"}
                </h1>
                <p className="text-gray-500 dark:text-gray-400 text-sm mt-1.5">
                  {mode === "login"
                    ? "Sign in to continue your nutrition journey"
                    : "Join thousands getting personalized nutrition plans"}
                </p>
              </motion.div>
            </AnimatePresence>

            {/* Mode toggle tabs */}
            <div className="flex bg-gray-100 dark:bg-gray-800 rounded-xl p-1 mb-6">
              {(["login", "register"] as const).map((m) => (
                <button
                  key={m}
                  onClick={() => switchMode(m)}
                  className={`flex-1 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 ${
                    mode === m
                      ? "bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm"
                      : "text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                  }`}
                >
                  {m === "login" ? "Sign In" : "Sign Up"}
                </button>
              ))}
            </div>

            {/* ── Google button ── */}
            <button
              type="button"
              onClick={() => setShowGooglePicker(true)}
              className="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-700 dark:text-gray-200 font-medium text-sm hover:bg-gray-50 dark:hover:bg-gray-700/80 hover:border-gray-300 dark:hover:border-gray-600 transition-all duration-200 shadow-sm mb-5 group"
            >
              {/* Google G SVG */}
              <svg width="18" height="18" viewBox="0 0 18 18" className="shrink-0">
                <path
                  d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z"
                  fill="#4285F4"
                />
                <path
                  d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z"
                  fill="#34A853"
                />
                <path
                  d="M3.964 10.707c-.18-.54-.282-1.117-.282-1.707s.102-1.167.282-1.707V4.961H.957C.347 6.175 0 7.55 0 9s.348 2.825.957 4.039l3.007-2.332z"
                  fill="#FBBC05"
                />
                <path
                  d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.961L3.964 7.293C4.672 5.163 6.656 3.58 9 3.58z"
                  fill="#EA4335"
                />
              </svg>
              Continue with Google
            </button>

            {/* OR divider */}
            <div className="flex items-center gap-3 mb-5">
              <div className="flex-1 h-px bg-gray-200 dark:bg-gray-700" />
              <span className="text-gray-400 dark:text-gray-500 text-xs font-medium">
                or continue with email
              </span>
              <div className="flex-1 h-px bg-gray-200 dark:bg-gray-700" />
            </div>

            {/* Error banner */}
            <AnimatePresence>
              {error && (
                <motion.div
                  initial={{ opacity: 0, height: 0, marginBottom: 0 }}
                  animate={{ opacity: 1, height: "auto", marginBottom: 16 }}
                  exit={{ opacity: 0, height: 0, marginBottom: 0 }}
                  className="flex items-start gap-2.5 px-3.5 py-3 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/50 rounded-xl overflow-hidden"
                >
                  <AlertCircle className="w-4 h-4 text-[#C62828] shrink-0 mt-0.5" />
                  <p className="text-sm text-red-700 dark:text-red-400">{error}</p>
                </motion.div>
              )}
            </AnimatePresence>

            {/* ── Form ── */}
            <form onSubmit={handleSubmit} noValidate>
              <AnimatePresence mode="wait">
                <motion.div
                  key={mode}
                  initial={{ opacity: 0, x: mode === "register" ? 18 : -18 }}
                  animate={{ opacity: 1, x: 0 }}
                  exit={{ opacity: 0, x: mode === "register" ? -18 : 18 }}
                  transition={{ duration: 0.22 }}
                  className="space-y-4"
                >
                  {/* Full Name (register only) */}
                  {mode === "register" && (
                    <div>
                      <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        Full Name
                      </label>
                      <div className="relative">
                        <User className="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
                        <input
                          type="text"
                          value={name}
                          onChange={(e) => setName(e.target.value)}
                          placeholder="Your full name"
                          required
                          className="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                        />
                      </div>
                    </div>
                  )}

                  {/* Email */}
                  <div>
                    <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                      Email Address
                    </label>
                    <div className="relative">
                      <Mail className="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
                      <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        placeholder="you@example.com"
                        required
                        className="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                      />
                    </div>
                  </div>

                  {/* Password */}
                  <div>
                    <div className="flex items-center justify-between mb-1.5">
                      <label className="text-xs font-semibold text-gray-600 dark:text-gray-400">
                        Password
                      </label>
                      {mode === "login" && (
                        <button
                          type="button"
                          className="text-xs text-[#C62828] hover:underline font-medium"
                        >
                          Forgot password?
                        </button>
                      )}
                    </div>
                    <div className="relative">
                      <Lock className="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
                      <input
                        type={showPwd ? "text" : "password"}
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        placeholder={
                          mode === "login" ? "Enter your password" : "Min. 6 characters"
                        }
                        required
                        className="w-full pl-10 pr-11 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                      />
                      <button
                        type="button"
                        onClick={() => setShowPwd(!showPwd)}
                        className="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                      >
                        {showPwd ? (
                          <EyeOff className="w-4 h-4" />
                        ) : (
                          <Eye className="w-4 h-4" />
                        )}
                      </button>
                    </div>

                    {/* Password strength (register) */}
                    {mode === "register" && strength && (
                      <div className="mt-2">
                        <div className="flex gap-1 mb-1">
                          {Array.from({ length: 3 }).map((_, i) => (
                            <div
                              key={i}
                              className={`h-1 flex-1 rounded-full transition-all duration-300 ${
                                i < strength.bars
                                  ? strength.color
                                  : "bg-gray-200 dark:bg-gray-700"
                              }`}
                            />
                          ))}
                        </div>
                        <p className={`text-xs ${strength.text}`}>
                          {strength.label} password
                        </p>
                      </div>
                    )}
                  </div>

                  {/* Confirm password + health goals (register only) */}
                  {mode === "register" && (
                    <>
                      {/* Confirm password */}
                      <div>
                        <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                          Confirm Password
                        </label>
                        <div className="relative">
                          <Lock className="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
                          <input
                            type={showConfirmPwd ? "text" : "password"}
                            value={confirmPwd}
                            onChange={(e) => setConfirmPwd(e.target.value)}
                            placeholder="Repeat your password"
                            required
                            className={`w-full pl-10 pr-11 py-3 rounded-xl border bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 text-sm transition-all ${
                              pwdMismatch
                                ? "border-red-400 focus:ring-red-500/30 focus:border-red-500"
                                : pwdMatch
                                ? "border-green-400 focus:ring-green-500/30 focus:border-green-500"
                                : "border-gray-200 dark:border-gray-700 focus:ring-[#C62828]/30 focus:border-[#C62828]"
                            }`}
                          />
                          <button
                            type="button"
                            onClick={() => setShowConfirmPwd(!showConfirmPwd)}
                            className="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                          >
                            {showConfirmPwd ? (
                              <EyeOff className="w-4 h-4" />
                            ) : (
                              <Eye className="w-4 h-4" />
                            )}
                          </button>
                        </div>
                        <AnimatePresence>
                          {pwdMatch && (
                            <motion.p
                              initial={{ opacity: 0, height: 0 }}
                              animate={{ opacity: 1, height: "auto" }}
                              exit={{ opacity: 0, height: 0 }}
                              className="text-xs text-green-500 mt-1.5 flex items-center gap-1"
                            >
                              <Check className="w-3 h-3" /> Passwords match
                            </motion.p>
                          )}
                          {pwdMismatch && (
                            <motion.p
                              initial={{ opacity: 0, height: 0 }}
                              animate={{ opacity: 1, height: "auto" }}
                              exit={{ opacity: 0, height: 0 }}
                              className="text-xs text-red-500 mt-1.5"
                            >
                              Passwords don't match
                            </motion.p>
                          )}
                        </AnimatePresence>
                      </div>

                      {/* Health Goal */}
                      <div>
                        <label className="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2">
                          Health Goal{" "}
                          <span className="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <div className="grid grid-cols-2 gap-2">
                          {HEALTH_GOALS.map((g) => (
                            <button
                              key={g.id}
                              type="button"
                              onClick={() =>
                                setHealthGoal(healthGoal === g.id ? "" : g.id)
                              }
                              className={`flex items-center gap-2 px-3 py-2.5 rounded-xl border text-xs font-medium transition-all duration-150 ${
                                healthGoal === g.id
                                  ? "border-[#C62828] bg-[#C62828]/10 text-[#C62828] dark:text-red-300"
                                  : "border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50"
                              }`}
                            >
                              <span className="text-base">{g.emoji}</span>
                              {g.label}
                            </button>
                          ))}
                        </div>
                      </div>
                    </>
                  )}
                </motion.div>
              </AnimatePresence>

              {/* Submit button */}
              <motion.button
                type="submit"
                disabled={loading}
                whileTap={{ scale: 0.985 }}
                className="w-full flex items-center justify-center gap-2 py-3.5 bg-[#C62828] hover:bg-[#b71c1c] disabled:opacity-70 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-red-900/25 mt-5"
              >
                {loading ? (
                  <>
                    <Loader2 className="w-4 h-4 animate-spin" />
                    {mode === "login" ? "Signing in…" : "Creating account…"}
                  </>
                ) : mode === "login" ? (
                  "Sign In"
                ) : (
                  "Create Account"
                )}
              </motion.button>
            </form>

            {/* Demo credentials (login only) */}
            <AnimatePresence>
              {mode === "login" && (
                <motion.div
                  initial={{ opacity: 0, height: 0 }}
                  animate={{ opacity: 1, height: "auto" }}
                  exit={{ opacity: 0, height: 0 }}
                  transition={{ duration: 0.2 }}
                  className="mt-4 p-3.5 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-dashed border-gray-200 dark:border-gray-700"
                >
                  <p className="text-xs text-gray-400 dark:text-gray-500 font-medium mb-2.5 flex items-center gap-1.5">
                    <span className="w-1.5 h-1.5 rounded-full bg-green-400 inline-block" />
                    Quick Demo Access
                  </p>
                  <div className="flex gap-2">
                    <button
                      type="button"
                      onClick={() => {
                        setEmail("budi@example.com");
                        setPassword("password");
                      }}
                      className="flex-1 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors"
                    >
                      👤 Demo User
                    </button>
                    <button
                      type="button"
                      onClick={() => {
                        setEmail("admin@avenution.com");
                        setPassword("admin123");
                      }}
                      className="flex-1 py-1.5 text-xs font-semibold rounded-lg bg-[#C62828]/10 border border-[#C62828]/25 text-[#C62828] hover:bg-[#C62828]/15 transition-colors"
                    >
                      🔑 Demo Admin
                    </button>
                  </div>
                </motion.div>
              )}
            </AnimatePresence>

            {/* Switch mode */}
            <p className="mt-5 text-center text-sm text-gray-500 dark:text-gray-400">
              {mode === "login" ? (
                <>
                  Don't have an account?{" "}
                  <button
                    onClick={() => switchMode("register")}
                    className="text-[#C62828] font-semibold hover:underline"
                  >
                    Sign Up Free
                  </button>
                </>
              ) : (
                <>
                  Already have an account?{" "}
                  <button
                    onClick={() => switchMode("login")}
                    className="text-[#C62828] font-semibold hover:underline"
                  >
                    Sign In
                  </button>
                </>
              )}
            </p>

            {/* Guest link */}
            <div className="mt-4 text-center">
              <Link
                to="/guest"
                className="text-xs text-gray-400 dark:text-gray-500 hover:text-[#C62828] dark:hover:text-[#ef4444] transition-colors"
              >
                Continue without account →
              </Link>
            </div>

            {/* Terms notice (register only) */}
            <AnimatePresence>
              {mode === "register" && (
                <motion.p
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 1 }}
                  exit={{ opacity: 0 }}
                  className="mt-5 text-xs text-gray-400 dark:text-gray-500 text-center leading-relaxed"
                >
                  By creating an account, you agree to our{" "}
                  <span className="text-[#C62828] cursor-pointer hover:underline">
                    Terms of Service
                  </span>{" "}
                  and{" "}
                  <span className="text-[#C62828] cursor-pointer hover:underline">
                    Privacy Policy
                  </span>
                  .
                </motion.p>
              )}
            </AnimatePresence>
          </div>
        </div>
      </div>

      {/* ═══════════════════════════════════════════════════════════════════
          GOOGLE ACCOUNT PICKER MODAL
      ═══════════════════════════════════════════════════════════════════ */}
      <AnimatePresence>
        {showGooglePicker && (
          <>
            {/* Backdrop */}
            <motion.div
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => !googleLoadingId && setShowGooglePicker(false)}
              className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50"
            />

            {/* Modal */}
            <div className="fixed inset-0 flex items-center justify-center z-50 p-4 pointer-events-none">
              <motion.div
                initial={{ opacity: 0, scale: 0.88, y: 24 }}
                animate={{ opacity: 1, scale: 1, y: 0 }}
                exit={{ opacity: 0, scale: 0.88, y: 24 }}
                transition={{ type: "spring", damping: 22, stiffness: 320 }}
                className="bg-white dark:bg-[#1e2433] rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700/60 w-full max-w-[340px] overflow-hidden pointer-events-auto"
              >
                {/* Google header */}
                <div className="px-6 pt-6 pb-5 border-b border-gray-100 dark:border-gray-700/60">
                  <div className="flex items-start justify-between mb-3">
                    {/* Google wordmark */}
                    <svg
                      viewBox="0 0 74 24"
                      width="72"
                      height="24"
                      aria-label="Google"
                    >
                      <path
                        d="M9.24 8.19v2.46h5.88c-.18 1.38-.64 2.39-1.34 3.1-.86.86-2.2 1.8-4.54 1.8-3.62 0-6.45-2.92-6.45-6.54S5.62 2.47 9.24 2.47c1.95 0 3.38.77 4.43 1.76L15.4 2.5C13.94 1.08 11.98 0 9.24 0 4.28 0 .11 4.04.11 9s4.17 9 9.13 9c2.68 0 4.7-.88 6.28-2.52 1.62-1.62 2.13-3.91 2.13-5.75 0-.57-.04-1.1-.13-1.54H9.24z"
                        fill="#4285F4"
                      />
                      <path
                        d="M25 6.19c-3.21 0-5.83 2.44-5.83 5.81 0 3.34 2.62 5.81 5.83 5.81s5.83-2.46 5.83-5.81c0-3.37-2.62-5.81-5.83-5.81zm0 9.33c-1.76 0-3.28-1.45-3.28-3.52 0-2.09 1.52-3.52 3.28-3.52s3.28 1.43 3.28 3.52c0 2.07-1.52 3.52-3.28 3.52z"
                        fill="#EA4335"
                      />
                      <path
                        d="M53.58 7.49h-.09c-.57-.68-1.67-1.3-3.06-1.3C47.53 6.19 45 8.72 45 12c0 3.26 2.53 5.81 5.43 5.81 1.39 0 2.49-.62 3.06-1.32h.09v.83c0 2.22-1.19 3.41-3.1 3.41-1.56 0-2.53-1.12-2.93-2.07l-2.22.92c.64 1.54 2.33 3.43 5.15 3.43 2.99 0 5.52-1.76 5.52-6.05V6.49h-2.42v1zm-2.93 8.03c-1.76 0-3.1-1.5-3.1-3.52 0-2.05 1.34-3.52 3.1-3.52 1.74 0 3.1 1.5 3.1 3.54.01 2.03-1.36 3.5-3.1 3.5z"
                        fill="#4285F4"
                      />
                      <path
                        d="M38 6.19c-3.21 0-5.83 2.44-5.83 5.81 0 3.34 2.62 5.81 5.83 5.81s5.83-2.46 5.83-5.81c0-3.37-2.62-5.81-5.83-5.81zm0 9.33c-1.76 0-3.28-1.45-3.28-3.52 0-2.09 1.52-3.52 3.28-3.52s3.28 1.43 3.28 3.52c0 2.07-1.52 3.52-3.28 3.52z"
                        fill="#FBBC05"
                      />
                      <path
                        d="M58.93 1h2.42v16.57h-2.42z"
                        fill="#34A853"
                      />
                      <path
                        d="M63.93 11.77c-.09-2.3 1.79-5.58 5.14-5.58 3.01 0 4.7 2.26 4.7 5.71v.41l-7.37 3.05c.57 1.12 1.45 1.69 2.69 1.69 1.24 0 2.1-.61 2.73-1.54l1.88 1.25c-.86 1.25-2.43 2.23-4.61 2.23-3.28 0-5.65-2.56-5.16-7.22zm2.46-1.24 4.92-2.04c-.27-.68-1.08-1.16-2.04-1.16-1.22 0-2.92 1.08-2.88 3.2z"
                        fill="#EA4335"
                      />
                    </svg>
                    <button
                      onClick={() => !googleLoadingId && setShowGooglePicker(false)}
                      className="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    >
                      <X className="w-4 h-4" />
                    </button>
                  </div>
                  <p
                    className="text-gray-800 dark:text-gray-100"
                    style={{ fontWeight: 600, fontSize: "1rem" }}
                  >
                    Sign in to Avenution
                  </p>
                  <p className="text-gray-400 dark:text-gray-500 text-xs mt-0.5">
                    avenution.com
                  </p>
                </div>

                {/* Choose account */}
                <div className="py-1">
                  <p className="text-xs text-gray-500 dark:text-gray-400 px-6 py-2.5 font-medium">
                    Choose an account
                  </p>
                  {GOOGLE_ACCOUNTS.map((acc) => (
                    <button
                      key={acc.id}
                      onClick={() => handleGoogleSelect(acc)}
                      disabled={!!googleLoadingId}
                      className="w-full flex items-center gap-3.5 px-4 py-3.5 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors disabled:opacity-60 text-left"
                    >
                      {/* Avatar */}
                      <div
                        className={`w-10 h-10 rounded-full ${acc.bg} flex items-center justify-center text-white text-sm font-bold shrink-0`}
                      >
                        {googleLoadingId === acc.id ? (
                          <Loader2 className="w-4 h-4 animate-spin" />
                        ) : (
                          acc.initials
                        )}
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className="text-sm font-medium text-gray-900 dark:text-white truncate">
                          {acc.name}
                        </p>
                        <p className="text-xs text-gray-500 dark:text-gray-400 truncate">
                          {acc.email}
                        </p>
                      </div>
                      {googleLoadingId === acc.id && (
                        <span className="text-xs text-gray-400 shrink-0">
                          Signing in…
                        </span>
                      )}
                    </button>
                  ))}
                </div>

                {/* Footer */}
                <div className="px-6 py-4 border-t border-gray-100 dark:border-gray-700/60 bg-gray-50/50 dark:bg-gray-800/30">
                  <p className="text-xs text-gray-400 dark:text-gray-500 text-center leading-relaxed">
                    By continuing, you agree to Avenution's{" "}
                    <span className="text-blue-500 cursor-pointer hover:underline">
                      Terms
                    </span>{" "}
                    and{" "}
                    <span className="text-blue-500 cursor-pointer hover:underline">
                      Privacy Policy
                    </span>
                  </p>
                </div>
              </motion.div>
            </div>
          </>
        )}
      </AnimatePresence>
    </div>
  );
}
