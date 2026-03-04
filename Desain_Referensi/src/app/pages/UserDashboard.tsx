import { useState } from "react";
import { Link, Outlet, useLocation } from "react-router";
import { motion } from "motion/react";
import {
  Brain,
  TrendingUp,
  CheckCircle2,
  ArrowRight,
  Flame,
  Leaf,
  Clock,
  Activity,
  ChevronRight,
  BarChart3,
  Calendar,
  Star,
  Target,
} from "lucide-react";
import { useAuth } from "../context/AuthContext";
import { Sidebar } from "../components/Sidebar";
import { useTheme } from "../context/ThemeContext";
import { Moon, Sun } from "lucide-react";
import { AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from "recharts";

const historyData = [
  { id: 1, date: "Feb 28, 2026", goal: "Weight Loss", plan: "Mediterranean Diet", score: 96, items: 4 },
  { id: 2, date: "Feb 24, 2026", goal: "Heart Health", plan: "DASH Diet Plan", score: 92, items: 3 },
  { id: 3, date: "Feb 20, 2026", goal: "Balanced Health", plan: "Plant-Based Boost", score: 89, items: 5 },
  { id: 4, date: "Feb 15, 2026", goal: "Muscle Gain", plan: "High-Protein Plan", score: 94, items: 4 },
  { id: 5, date: "Feb 10, 2026", goal: "Diabetes Control", plan: "Low-GI Diet", score: 91, items: 3 },
];

const progressData = [
  { week: "W1", score: 82 },
  { week: "W2", score: 85 },
  { week: "W3", score: 89 },
  { week: "W4", score: 91 },
  { week: "W5", score: 93 },
  { week: "W6", score: 96 },
];

const todayPlan = [
  { emoji: "🥣", meal: "Breakfast", name: "Oatmeal with Berries", calories: 320, time: "07:00", done: true },
  { emoji: "🥗", meal: "Snack", name: "Greek Yogurt & Almonds", calories: 180, time: "10:30", done: true },
  { emoji: "🐟", meal: "Lunch", name: "Grilled Salmon & Quinoa", calories: 480, time: "13:00", done: false },
  { emoji: "🍎", meal: "Snack", name: "Apple with Peanut Butter", calories: 150, time: "16:00", done: false },
  { emoji: "🥦", meal: "Dinner", name: "Vegetable Stir-fry", calories: 380, time: "19:00", done: false },
];

function DashboardHome() {
  const { user } = useAuth();
  const [completedMeals, setCompletedMeals] = useState([0, 1]);

  const totalCalories = todayPlan.reduce((a, m) => a + m.calories, 0);
  const consumedCalories = todayPlan
    .filter((_, i) => completedMeals.includes(i))
    .reduce((a, m) => a + m.calories, 0);

  return (
    <div className="p-6 lg:p-8 space-y-6">
      {/* Greeting */}
      <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
        <h1 className="text-gray-900 dark:text-white" style={{ fontSize: "1.5rem", fontWeight: 700 }}>
          Good morning, {user?.name?.split(" ")[0]}! 👋
        </h1>
        <p className="text-gray-500 dark:text-gray-400 mt-1 text-sm">
          Here's your nutrition overview for today, Monday March 2, 2026
        </p>
      </motion.div>

      {/* Stats row */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {[
          { label: "Today's Calories", value: `${consumedCalories}`, unit: `/ ${totalCalories} kcal`, icon: Flame, color: "text-[#C62828]", bg: "bg-rose-50 dark:bg-rose-950/30" },
          { label: "Match Score", value: "96%", unit: "this week", icon: Star, color: "text-yellow-500", bg: "bg-yellow-50 dark:bg-yellow-950/30" },
          { label: "Streak", value: "12", unit: "days active", icon: Activity, color: "text-[#16A34A]", bg: "bg-green-50 dark:bg-green-950/30" },
          { label: "Checks Done", value: "5", unit: "this month", icon: CheckCircle2, color: "text-blue-600", bg: "bg-blue-50 dark:bg-blue-950/30" },
        ].map((stat, i) => (
          <motion.div
            key={stat.label}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: i * 0.08 }}
            className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4 shadow-sm"
          >
            <div className={`w-9 h-9 rounded-xl ${stat.bg} flex items-center justify-center mb-3`}>
              <stat.icon className={`w-4 h-4 ${stat.color}`} />
            </div>
            <p className="text-2xl font-bold text-gray-900 dark:text-white">{stat.value}</p>
            <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{stat.unit}</p>
            <p className="text-xs font-medium text-gray-600 dark:text-gray-300 mt-1">{stat.label}</p>
          </motion.div>
        ))}
      </div>

      <div className="grid lg:grid-cols-3 gap-6">
        {/* Quick Check Card */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.2 }}
          className="bg-gradient-to-br from-[#C62828] to-[#8B0000] rounded-2xl p-6 text-white shadow-lg shadow-red-900/20"
        >
          <Brain className="w-8 h-8 mb-4 opacity-90" />
          <h3 className="font-bold text-lg mb-2">Quick Health Check</h3>
          <p className="text-red-100 text-sm mb-5 leading-relaxed">
            Get fresh food recommendations based on your current body condition.
          </p>
          <Link
            to="/guest"
            className="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-[#C62828] rounded-xl text-sm font-semibold hover:bg-red-50 transition-colors"
          >
            Start Analysis <ArrowRight className="w-3.5 h-3.5" />
          </Link>
        </motion.div>

        {/* Progress Chart */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.25 }}
          className="lg:col-span-2 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm"
        >
          <div className="flex items-center justify-between mb-4">
            <div>
              <h3 className="font-semibold text-gray-900 dark:text-white">Match Score Trend</h3>
              <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Last 6 weeks</p>
            </div>
            <div className="flex items-center gap-1 text-[#16A34A] text-sm font-semibold">
              <TrendingUp className="w-4 h-4" />
              +17%
            </div>
          </div>
          <ResponsiveContainer width="100%" height={140}>
            <AreaChart data={progressData}>
              <defs>
                <linearGradient id="scoreGrad" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="5%" stopColor="#C62828" stopOpacity={0.2} />
                  <stop offset="95%" stopColor="#C62828" stopOpacity={0} />
                </linearGradient>
              </defs>
              <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" className="dark:stroke-gray-700" />
              <XAxis dataKey="week" tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
              <YAxis domain={[70, 100]} tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
              <Tooltip
                contentStyle={{
                  background: "white",
                  border: "1px solid #e5e7eb",
                  borderRadius: "10px",
                  boxShadow: "0 4px 6px -1px rgba(0,0,0,0.1)",
                  fontSize: "12px",
                }}
              />
              <Area type="monotone" dataKey="score" stroke="#C62828" strokeWidth={2.5} fill="url(#scoreGrad)" dot={{ fill: "#C62828", r: 3 }} />
            </AreaChart>
          </ResponsiveContainer>
        </motion.div>
      </div>

      {/* Today's Plan */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 0.3 }}
        className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm"
      >
        <div className="flex items-center justify-between mb-4">
          <div>
            <h3 className="font-semibold text-gray-900 dark:text-white">Today's Meal Plan</h3>
            <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Mediterranean Diet · {consumedCalories}/{totalCalories} kcal</p>
          </div>
          <div className="w-24 h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
            <div
              className="h-full bg-[#16A34A] rounded-full transition-all"
              style={{ width: `${(consumedCalories / totalCalories) * 100}%` }}
            />
          </div>
        </div>

        <div className="space-y-2">
          {todayPlan.map((meal, i) => (
            <div
              key={i}
              className={`flex items-center gap-3 p-3 rounded-xl transition-all ${
                completedMeals.includes(i)
                  ? "bg-[#16A34A]/5 border border-[#16A34A]/20"
                  : "bg-gray-50 dark:bg-gray-700/40 border border-transparent"
              }`}
            >
              <span className="text-xl">{meal.emoji}</span>
              <div className="flex-1 min-w-0">
                <div className="flex items-center gap-2">
                  <span className="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">{meal.meal}</span>
                  <span className="text-xs text-gray-400">·</span>
                  <span className="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                    <Clock className="w-2.5 h-2.5" />{meal.time}
                  </span>
                </div>
                <p className="text-sm font-medium text-gray-900 dark:text-white truncate">{meal.name}</p>
              </div>
              <div className="flex items-center gap-2 shrink-0">
                <span className="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                  <Flame className="w-3 h-3 text-[#C62828]" />{meal.calories}
                </span>
                <button
                  onClick={() =>
                    setCompletedMeals((prev) =>
                      prev.includes(i) ? prev.filter((x) => x !== i) : [...prev, i]
                    )
                  }
                  className={`w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all ${
                    completedMeals.includes(i)
                      ? "bg-[#16A34A] border-[#16A34A] text-white"
                      : "border-gray-300 dark:border-gray-600"
                  }`}
                >
                  {completedMeals.includes(i) && <CheckCircle2 className="w-3 h-3" />}
                </button>
              </div>
            </div>
          ))}
        </div>
      </motion.div>

      {/* Recent History */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 0.35 }}
        className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm"
      >
        <div className="flex items-center justify-between mb-4">
          <h3 className="font-semibold text-gray-900 dark:text-white">Recent History</h3>
          <Link to="/dashboard/history" className="text-xs font-semibold text-[#C62828] hover:underline flex items-center gap-1">
            View All <ChevronRight className="w-3 h-3" />
          </Link>
        </div>
        <div className="space-y-3">
          {historyData.slice(0, 3).map((h) => (
            <div key={h.id} className="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/40 hover:bg-gray-100 dark:hover:bg-gray-700/60 transition-colors cursor-pointer">
              <div className="w-9 h-9 rounded-xl bg-[#C62828]/10 flex items-center justify-center shrink-0">
                <Brain className="w-4 h-4 text-[#C62828]" />
              </div>
              <div className="flex-1 min-w-0">
                <p className="text-sm font-semibold text-gray-900 dark:text-white truncate">{h.plan}</p>
                <p className="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-0.5">
                  <Calendar className="w-3 h-3" />{h.date}
                  <span className="px-1.5 py-0.5 bg-gray-200 dark:bg-gray-600 rounded-full">{h.goal}</span>
                </p>
              </div>
              <div className="text-right shrink-0">
                <p className="text-sm font-bold text-[#16A34A]">{h.score}%</p>
                <p className="text-xs text-gray-400">{h.items} meals</p>
              </div>
            </div>
          ))}
        </div>
      </motion.div>
    </div>
  );
}

function HistoryPage() {
  return (
    <div className="p-6 lg:p-8 space-y-6">
      <div>
        <h1 className="text-gray-900 dark:text-white" style={{ fontSize: "1.4rem", fontWeight: 700 }}>
          Recommendation History
        </h1>
        <p className="text-gray-500 dark:text-gray-400 mt-1 text-sm">All your previous body checks and food plans.</p>
      </div>

      <div className="space-y-4">
        {historyData.map((h, i) => (
          <motion.div
            key={h.id}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: i * 0.07 }}
            className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm hover:shadow-md transition-all"
          >
            <div className="flex items-start justify-between gap-4">
              <div className="flex items-start gap-4">
                <div className="w-12 h-12 rounded-xl bg-[#C62828]/10 flex items-center justify-center shrink-0">
                  <Brain className="w-6 h-6 text-[#C62828]" />
                </div>
                <div>
                  <h3 className="font-semibold text-gray-900 dark:text-white">{h.plan}</h3>
                  <div className="flex flex-wrap items-center gap-2 mt-1">
                    <span className="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                      <Calendar className="w-3 h-3" />{h.date}
                    </span>
                    <span className="px-2 py-0.5 bg-[#C62828]/10 text-[#C62828] text-xs font-semibold rounded-full">{h.goal}</span>
                    <span className="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs rounded-full">{h.items} food items</span>
                  </div>
                </div>
              </div>
              <div className="text-right shrink-0">
                <p className="text-2xl font-bold text-[#16A34A]">{h.score}%</p>
                <p className="text-xs text-gray-400">match</p>
              </div>
            </div>
            <div className="mt-3">
              <div className="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                <div className="h-1.5 rounded-full bg-gradient-to-r from-[#16A34A] to-emerald-400" style={{ width: `${h.score}%` }} />
              </div>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
}

function ProfilePage() {
  const { user } = useAuth();
  return (
    <div className="p-6 lg:p-8 space-y-6">
      <div>
        <h1 className="text-gray-900 dark:text-white" style={{ fontSize: "1.4rem", fontWeight: 700 }}>
          My Profile
        </h1>
        <p className="text-gray-500 dark:text-gray-400 mt-1 text-sm">Manage your account and health profile.</p>
      </div>

      <div className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6 shadow-sm">
        <div className="flex items-center gap-5">
          <div className="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#C62828] to-rose-400 flex items-center justify-center text-white text-2xl font-bold shrink-0">
            {user?.name?.charAt(0)}
          </div>
          <div>
            <h2 className="text-gray-900 dark:text-white font-bold text-xl">{user?.name}</h2>
            <p className="text-gray-500 dark:text-gray-400 text-sm">{user?.email}</p>
            <span className="inline-flex items-center mt-1.5 px-2 py-0.5 bg-[#16A34A]/10 text-[#16A34A] text-xs font-semibold rounded-full">
              Active Member
            </span>
          </div>
        </div>

        <div className="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
          {[
            { label: "Full Name", value: user?.name || "" },
            { label: "Email", value: user?.email || "" },
            { label: "Member Since", value: "January 2026" },
            { label: "Plan", value: "Free Plan" },
          ].map(({ label, value }) => (
            <div key={label}>
              <label className="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1.5">{label}</label>
              <input
                type="text"
                defaultValue={value}
                readOnly
                className="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white text-sm"
              />
            </div>
          ))}
        </div>

        <button className="mt-5 px-5 py-2.5 bg-[#C62828] hover:bg-[#b71c1c] text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
          Save Changes
        </button>
      </div>
    </div>
  );
}

export default function UserDashboard() {
  const location = useLocation();
  const { theme, toggleTheme } = useTheme();
  const { user } = useAuth();

  const renderContent = () => {
    if (location.pathname === "/dashboard/history") return <HistoryPage />;
    if (location.pathname === "/dashboard/profile") return <ProfilePage />;
    return <DashboardHome />;
  };

  return (
    <div className="flex h-screen bg-[#F9FAFB] dark:bg-[#0F172A]" style={{ fontFamily: "Poppins, sans-serif" }}>
      <Sidebar role="user" />
      <main className="flex-1 overflow-auto">
        {/* Top Header */}
        <div className="sticky top-0 z-10 h-14 bg-white/80 dark:bg-[#0F172A]/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-6">
          <div className="text-sm text-gray-500 dark:text-gray-400">
            {location.pathname === "/dashboard" && "Dashboard"}
            {location.pathname === "/dashboard/history" && "Recommendation History"}
            {location.pathname === "/dashboard/profile" && "Profile Settings"}
          </div>
          <div className="flex items-center gap-3">
            <button
              onClick={toggleTheme}
              className="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            >
              {theme === "dark" ? <Sun className="w-4 h-4" /> : <Moon className="w-4 h-4" />}
            </button>
            <div className="w-8 h-8 rounded-full bg-gradient-to-br from-[#C62828] to-rose-400 flex items-center justify-center text-white text-xs font-semibold">
              {user?.name?.charAt(0)}
            </div>
          </div>
        </div>
        {renderContent()}
      </main>
    </div>
  );
}
