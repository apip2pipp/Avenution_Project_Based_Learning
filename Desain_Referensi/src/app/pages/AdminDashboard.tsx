import { useState } from "react";
import { useLocation } from "react-router";
import { motion } from "motion/react";
import {
  Users,
  Activity,
  Brain,
  TrendingUp,
  TrendingDown,
  Search,
  Filter,
  MoreHorizontal,
  CheckCircle2,
  Clock,
  XCircle,
  Download,
  RefreshCw,
} from "lucide-react";
import { Sidebar } from "../components/Sidebar";
import { useTheme } from "../context/ThemeContext";
import { Moon, Sun } from "lucide-react";
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  LineChart,
  Line,
  PieChart,
  Pie,
  Cell,
} from "recharts";

const users = [
  { id: 1, name: "Budi Santoso", email: "budi@example.com", joined: "Jan 15, 2026", checks: 12, status: "active", goal: "Weight Loss" },
  { id: 2, name: "Siti Rahayu", email: "siti@example.com", joined: "Jan 22, 2026", checks: 8, status: "active", goal: "Heart Health" },
  { id: 3, name: "Ahmad Fauzi", email: "ahmad@example.com", joined: "Feb 1, 2026", checks: 5, status: "inactive", goal: "Muscle Gain" },
  { id: 4, name: "Dewi Kusuma", email: "dewi@example.com", joined: "Feb 5, 2026", checks: 20, status: "active", goal: "Balanced Health" },
  { id: 5, name: "Rizky Pratama", email: "rizky@example.com", joined: "Feb 10, 2026", checks: 3, status: "pending", goal: "Diabetes Control" },
  { id: 6, name: "Andi Wijaya", email: "andi@example.com", joined: "Feb 14, 2026", checks: 7, status: "active", goal: "Weight Loss" },
  { id: 7, name: "Nanda Putri", email: "nanda@example.com", joined: "Feb 20, 2026", checks: 15, status: "active", goal: "Heart Health" },
  { id: 8, name: "Doni Harahap", email: "doni@example.com", joined: "Feb 25, 2026", checks: 2, status: "inactive", goal: "Muscle Gain" },
];

const monthlyData = [
  { month: "Sep", users: 120, checks: 380 },
  { month: "Oct", users: 180, checks: 520 },
  { month: "Nov", users: 240, checks: 700 },
  { month: "Dec", users: 320, checks: 950 },
  { month: "Jan", users: 410, checks: 1200 },
  { month: "Feb", checks: 1580, users: 520 },
];

const goalDist = [
  { name: "Weight Loss", value: 35, color: "#C62828" },
  { name: "Heart Health", value: 25, color: "#16A34A" },
  { name: "Balanced", value: 20, color: "#2563EB" },
  { name: "Muscle Gain", value: 12, color: "#D97706" },
  { name: "Diabetes", value: 8, color: "#7C3AED" },
];

const activityData = [
  { day: "Mon", checks: 45 },
  { day: "Tue", checks: 62 },
  { day: "Wed", checks: 58 },
  { day: "Thu", checks: 71 },
  { day: "Fri", checks: 83 },
  { day: "Sat", checks: 55 },
  { day: "Sun", checks: 38 },
];

function OverviewPage() {
  return (
    <div className="p-6 lg:p-8 space-y-6">
      {/* Header */}
      <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
        <h1 className="text-gray-900 dark:text-white" style={{ fontSize: "1.5rem", fontWeight: 700 }}>
          Admin Overview
        </h1>
        <p className="text-gray-500 dark:text-gray-400 mt-1 text-sm">Platform performance and user insights — Monday, March 2, 2026</p>
      </motion.div>

      {/* Summary Cards */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {[
          { label: "Total Users", value: "520", change: "+14%", up: true, icon: Users, bg: "bg-rose-50 dark:bg-rose-950/30", iconColor: "text-[#C62828]" },
          { label: "Health Checks", value: "1,580", change: "+31%", up: true, icon: Brain, bg: "bg-blue-50 dark:bg-blue-950/30", iconColor: "text-blue-600" },
          { label: "Active Users", value: "412", change: "+9%", up: true, icon: Activity, bg: "bg-green-50 dark:bg-green-950/30", iconColor: "text-[#16A34A]" },
          { label: "Avg. Match Score", value: "93.2%", change: "-1.2%", up: false, icon: TrendingUp, bg: "bg-purple-50 dark:bg-purple-950/30", iconColor: "text-purple-600" },
        ].map((card, i) => (
          <motion.div
            key={card.label}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: i * 0.08 }}
            className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4 shadow-sm"
          >
            <div className={`w-9 h-9 rounded-xl ${card.bg} flex items-center justify-center mb-3`}>
              <card.icon className={`w-4 h-4 ${card.iconColor}`} />
            </div>
            <p className="text-2xl font-bold text-gray-900 dark:text-white">{card.value}</p>
            <div className="flex items-center gap-1.5 mt-1">
              {card.up ? (
                <TrendingUp className="w-3 h-3 text-[#16A34A]" />
              ) : (
                <TrendingDown className="w-3 h-3 text-[#C62828]" />
              )}
              <span className={`text-xs font-semibold ${card.up ? "text-[#16A34A]" : "text-[#C62828]"}`}>
                {card.change}
              </span>
              <span className="text-xs text-gray-400">vs last month</span>
            </div>
            <p className="text-xs font-medium text-gray-600 dark:text-gray-300 mt-1">{card.label}</p>
          </motion.div>
        ))}
      </div>

      {/* Charts Row */}
      <div className="grid lg:grid-cols-3 gap-6">
        {/* Growth Chart */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.2 }}
          className="lg:col-span-2 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm"
        >
          <div className="flex items-center justify-between mb-4">
            <div>
              <h3 className="font-semibold text-gray-900 dark:text-white">Growth Overview</h3>
              <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Users & health checks per month</p>
            </div>
            <button className="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 px-3 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
              <Download className="w-3.5 h-3.5" /> Export
            </button>
          </div>
          <ResponsiveContainer width="100%" height={180}>
            <BarChart data={monthlyData} barGap={4}>
              <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" className="dark:stroke-gray-700" />
              <XAxis dataKey="month" tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
              <YAxis tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
              <Tooltip
                contentStyle={{
                  background: "white",
                  border: "1px solid #e5e7eb",
                  borderRadius: "10px",
                  fontSize: "12px",
                }}
              />
              <Bar dataKey="users" fill="#C62828" radius={[4, 4, 0, 0]} name="Users" />
              <Bar dataKey="checks" fill="#16A34A" radius={[4, 4, 0, 0]} name="Checks" />
            </BarChart>
          </ResponsiveContainer>
          <div className="flex items-center gap-4 mt-2">
            <div className="flex items-center gap-1.5 text-xs text-gray-500">
              <div className="w-3 h-3 rounded-sm bg-[#C62828]" />Users
            </div>
            <div className="flex items-center gap-1.5 text-xs text-gray-500">
              <div className="w-3 h-3 rounded-sm bg-[#16A34A]" />Checks
            </div>
          </div>
        </motion.div>

        {/* Goal Distribution */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.25 }}
          className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm"
        >
          <h3 className="font-semibold text-gray-900 dark:text-white mb-1">Goal Distribution</h3>
          <p className="text-xs text-gray-500 dark:text-gray-400 mb-4">User health goals breakdown</p>
          <ResponsiveContainer width="100%" height={120}>
            <PieChart>
              <Pie data={goalDist} cx="50%" cy="50%" innerRadius={35} outerRadius={55} paddingAngle={3} dataKey="value">
                {goalDist.map((entry, i) => (
                  <Cell key={i} fill={entry.color} />
                ))}
              </Pie>
              <Tooltip formatter={(v) => [`${v}%`, "Share"]} contentStyle={{ fontSize: "11px", borderRadius: "8px" }} />
            </PieChart>
          </ResponsiveContainer>
          <div className="space-y-1.5 mt-3">
            {goalDist.map((g) => (
              <div key={g.name} className="flex items-center justify-between text-xs">
                <div className="flex items-center gap-1.5">
                  <div className="w-2.5 h-2.5 rounded-full" style={{ backgroundColor: g.color }} />
                  <span className="text-gray-600 dark:text-gray-400">{g.name}</span>
                </div>
                <span className="font-semibold text-gray-900 dark:text-white">{g.value}%</span>
              </div>
            ))}
          </div>
        </motion.div>
      </div>

      {/* Weekly Activity */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 0.3 }}
        className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm"
      >
        <div className="flex items-center justify-between mb-4">
          <div>
            <h3 className="font-semibold text-gray-900 dark:text-white">Weekly Check Activity</h3>
            <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Number of health checks per day this week</p>
          </div>
        </div>
        <ResponsiveContainer width="100%" height={120}>
          <LineChart data={activityData}>
            <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" className="dark:stroke-gray-700" />
            <XAxis dataKey="day" tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
            <YAxis tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
            <Tooltip contentStyle={{ fontSize: "12px", borderRadius: "10px", border: "1px solid #e5e7eb" }} />
            <Line type="monotone" dataKey="checks" stroke="#C62828" strokeWidth={2.5} dot={{ fill: "#C62828", r: 4 }} name="Checks" />
          </LineChart>
        </ResponsiveContainer>
      </motion.div>
    </div>
  );
}

function UsersPage() {
  const [search, setSearch] = useState("");
  const [filter, setFilter] = useState("all");

  const filtered = users.filter((u) => {
    const matchSearch = u.name.toLowerCase().includes(search.toLowerCase()) || u.email.toLowerCase().includes(search.toLowerCase());
    const matchFilter = filter === "all" || u.status === filter;
    return matchSearch && matchFilter;
  });

  const statusBadge = (status: string) => {
    if (status === "active") return "bg-[#16A34A]/10 text-[#16A34A]";
    if (status === "inactive") return "bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400";
    return "bg-yellow-100 dark:bg-yellow-950/30 text-yellow-700 dark:text-yellow-400";
  };

  const statusIcon = (status: string) => {
    if (status === "active") return <CheckCircle2 className="w-3 h-3" />;
    if (status === "inactive") return <XCircle className="w-3 h-3" />;
    return <Clock className="w-3 h-3" />;
  };

  return (
    <div className="p-6 lg:p-8 space-y-6">
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 className="text-gray-900 dark:text-white" style={{ fontSize: "1.4rem", fontWeight: 700 }}>
            User Management
          </h1>
          <p className="text-gray-500 dark:text-gray-400 mt-1 text-sm">{users.length} registered users</p>
        </div>
        <div className="flex items-center gap-2">
          <button className="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 text-xs font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <RefreshCw className="w-3.5 h-3.5" /> Refresh
          </button>
          <button className="flex items-center gap-1.5 px-3 py-2 rounded-lg bg-[#C62828] text-white text-xs font-semibold hover:bg-[#b71c1c] transition-colors shadow-sm">
            <Download className="w-3.5 h-3.5" /> Export CSV
          </button>
        </div>
      </div>

      {/* Filters */}
      <div className="flex flex-col sm:flex-row gap-3">
        <div className="relative flex-1">
          <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
          <input
            type="text"
            placeholder="Search users..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
          />
        </div>
        <div className="flex items-center gap-2">
          <Filter className="w-4 h-4 text-gray-400" />
          {["all", "active", "inactive", "pending"].map((f) => (
            <button
              key={f}
              onClick={() => setFilter(f)}
              className={`px-3 py-2 rounded-lg text-xs font-semibold capitalize transition-all ${
                filter === f
                  ? "bg-[#C62828] text-white shadow-sm"
                  : "bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400"
              }`}
            >
              {f}
            </button>
          ))}
        </div>
      </div>

      {/* Table */}
      <div className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 shadow-sm overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="border-b border-gray-200 dark:border-gray-700">
                <th className="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                <th className="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Joined</th>
                <th className="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Health Goal</th>
                <th className="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Checks</th>
                <th className="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                <th className="px-5 py-3.5"></th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100 dark:divide-gray-700/50">
              {filtered.map((user, i) => (
                <motion.tr
                  key={user.id}
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 1 }}
                  transition={{ delay: i * 0.04 }}
                  className="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors"
                >
                  <td className="px-5 py-4">
                    <div className="flex items-center gap-3">
                      <div className="w-8 h-8 rounded-full bg-gradient-to-br from-[#C62828] to-rose-400 flex items-center justify-center text-white text-xs font-semibold shrink-0">
                        {user.name.charAt(0)}
                      </div>
                      <div>
                        <p className="text-sm font-semibold text-gray-900 dark:text-white">{user.name}</p>
                        <p className="text-xs text-gray-500 dark:text-gray-400">{user.email}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">{user.joined}</td>
                  <td className="px-5 py-4">
                    <span className="px-2 py-1 bg-[#C62828]/10 text-[#C62828] text-xs font-semibold rounded-full">{user.goal}</span>
                  </td>
                  <td className="px-5 py-4 text-sm font-semibold text-gray-900 dark:text-white">{user.checks}</td>
                  <td className="px-5 py-4">
                    <span className={`inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold capitalize ${statusBadge(user.status)}`}>
                      {statusIcon(user.status)}
                      {user.status}
                    </span>
                  </td>
                  <td className="px-5 py-4">
                    <button className="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                      <MoreHorizontal className="w-4 h-4" />
                    </button>
                  </td>
                </motion.tr>
              ))}
            </tbody>
          </table>
        </div>
        <div className="px-5 py-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
          <p className="text-xs text-gray-500 dark:text-gray-400">Showing {filtered.length} of {users.length} users</p>
          <div className="flex items-center gap-1">
            {[1, 2, 3].map((p) => (
              <button key={p} className={`w-7 h-7 rounded-lg text-xs font-semibold transition-colors ${p === 1 ? "bg-[#C62828] text-white" : "text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700"}`}>
                {p}
              </button>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}

function AnalyticsPage() {
  return (
    <div className="p-6 lg:p-8 space-y-6">
      <div>
        <h1 className="text-gray-900 dark:text-white" style={{ fontSize: "1.4rem", fontWeight: 700 }}>Analytics</h1>
        <p className="text-gray-500 dark:text-gray-400 mt-1 text-sm">Deep insights into platform usage and user behavior.</p>
      </div>

      <div className="grid lg:grid-cols-2 gap-6">
        <div className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm">
          <h3 className="font-semibold text-gray-900 dark:text-white mb-4">Monthly User Growth</h3>
          <ResponsiveContainer width="100%" height={200}>
            <LineChart data={monthlyData}>
              <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
              <XAxis dataKey="month" tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
              <YAxis tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
              <Tooltip contentStyle={{ fontSize: "12px", borderRadius: "10px" }} />
              <Line type="monotone" dataKey="users" stroke="#C62828" strokeWidth={2.5} dot={{ fill: "#C62828", r: 4 }} name="Users" />
            </LineChart>
          </ResponsiveContainer>
        </div>

        <div className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 shadow-sm">
          <h3 className="font-semibold text-gray-900 dark:text-white mb-4">Monthly Health Checks</h3>
          <ResponsiveContainer width="100%" height={200}>
            <BarChart data={monthlyData}>
              <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
              <XAxis dataKey="month" tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
              <YAxis tick={{ fontSize: 11 }} tickLine={false} axisLine={false} />
              <Tooltip contentStyle={{ fontSize: "12px", borderRadius: "10px" }} />
              <Bar dataKey="checks" fill="#16A34A" radius={[4, 4, 0, 0]} name="Checks" />
            </BarChart>
          </ResponsiveContainer>
        </div>
      </div>

      {/* Metrics Grid */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {[
          { label: "Avg. Session Duration", value: "4m 32s", icon: Clock },
          { label: "Recommendation CTR", value: "78.4%", icon: TrendingUp },
          { label: "User Retention Rate", value: "64.2%", icon: Users },
          { label: "Daily Active Users", value: "186", icon: Activity },
        ].map((m, i) => (
          <div key={m.label} className="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4 shadow-sm">
            <m.icon className="w-5 h-5 text-[#C62828] mb-2" />
            <p className="text-xl font-bold text-gray-900 dark:text-white">{m.value}</p>
            <p className="text-xs text-gray-500 dark:text-gray-400 mt-1">{m.label}</p>
          </div>
        ))}
      </div>
    </div>
  );
}

export default function AdminDashboard() {
  const location = useLocation();
  const { theme, toggleTheme } = useTheme();

  const renderContent = () => {
    if (location.pathname === "/admin/users") return <UsersPage />;
    if (location.pathname === "/admin/analytics") return <AnalyticsPage />;
    return <OverviewPage />;
  };

  const titles: Record<string, string> = {
    "/admin": "Admin Dashboard",
    "/admin/users": "User Management",
    "/admin/analytics": "Analytics",
    "/admin/system": "System Settings",
  };

  return (
    <div className="flex h-screen bg-[#F9FAFB] dark:bg-[#0F172A]" style={{ fontFamily: "Poppins, sans-serif" }}>
      <Sidebar role="admin" />
      <main className="flex-1 overflow-auto">
        <div className="sticky top-0 z-10 h-14 bg-white/80 dark:bg-[#0F172A]/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-6">
          <div className="flex items-center gap-2">
            <span className="px-2 py-0.5 bg-[#C62828]/10 text-[#C62828] text-xs font-semibold rounded-full">Admin</span>
            <span className="text-sm text-gray-500 dark:text-gray-400">
              {titles[location.pathname] || "Admin"}
            </span>
          </div>
          <button
            onClick={toggleTheme}
            className="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
          >
            {theme === "dark" ? <Sun className="w-4 h-4" /> : <Moon className="w-4 h-4" />}
          </button>
        </div>
        {renderContent()}
      </main>
    </div>
  );
}
