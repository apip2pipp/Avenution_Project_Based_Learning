import { Link, useLocation, useNavigate } from "react-router";
import {
  LayoutDashboard,
  History,
  User,
  LogOut,
  HeartPulse,
  Users,
  BarChart3,
  ShieldCheck,
  Menu,
  X,
} from "lucide-react";
import { useAuth } from "../context/AuthContext";
import { useState } from "react";

interface SidebarProps {
  role?: "user" | "admin";
}

export function Sidebar({ role = "user" }: SidebarProps) {
  const location = useLocation();
  const navigate = useNavigate();
  const { logout, user } = useAuth();
  const [collapsed, setCollapsed] = useState(false);

  const handleLogout = () => {
    logout();
    navigate("/");
  };

  const userLinks = [
    { icon: LayoutDashboard, label: "Dashboard", path: "/dashboard" },
    { icon: History, label: "History", path: "/dashboard/history" },
    { icon: User, label: "Profile", path: "/dashboard/profile" },
  ];

  const adminLinks = [
    { icon: LayoutDashboard, label: "Overview", path: "/admin" },
    { icon: Users, label: "Users", path: "/admin/users" },
    { icon: BarChart3, label: "Analytics", path: "/admin/analytics" },
    { icon: ShieldCheck, label: "System", path: "/admin/system" },
  ];

  const links = role === "admin" ? adminLinks : userLinks;

  return (
    <aside
      className={`h-screen sticky top-0 flex flex-col border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0F172A] transition-all duration-300 ${
        collapsed ? "w-16" : "w-64"
      }`}
    >
      {/* Header */}
      <div className={`flex items-center h-16 px-4 border-b border-gray-200 dark:border-gray-800 ${collapsed ? "justify-center" : "justify-between"}`}>
        {!collapsed && (
          <Link to="/" className="flex items-center gap-2">
            <div className="w-8 h-8 rounded-lg bg-[#C62828] flex items-center justify-center shrink-0">
              <HeartPulse className="w-4 h-4 text-white" />
            </div>
            <span className="text-gray-900 dark:text-white" style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "1.1rem" }}>
              Avenution
            </span>
          </Link>
        )}
        {collapsed && (
          <div className="w-8 h-8 rounded-lg bg-[#C62828] flex items-center justify-center">
            <HeartPulse className="w-4 h-4 text-white" />
          </div>
        )}
        <button
          onClick={() => setCollapsed(!collapsed)}
          className={`w-7 h-7 rounded-md flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors ${collapsed ? "hidden" : ""}`}
        >
          <Menu className="w-4 h-4" />
        </button>
      </div>

      {/* Collapse toggle when collapsed */}
      {collapsed && (
        <button
          onClick={() => setCollapsed(false)}
          className="mx-auto mt-2 w-7 h-7 rounded-md flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
        >
          <X className="w-4 h-4" />
        </button>
      )}

      {/* User info */}
      {!collapsed && (
        <div className="px-4 py-4 border-b border-gray-200 dark:border-gray-800">
          <div className="flex items-center gap-3">
            <div className="w-9 h-9 rounded-full bg-gradient-to-br from-[#C62828] to-rose-400 flex items-center justify-center text-white text-sm font-semibold shrink-0">
              {user?.name?.charAt(0) || "U"}
            </div>
            <div className="overflow-hidden">
              <p className="text-sm font-semibold text-gray-900 dark:text-white truncate">{user?.name}</p>
              <p className="text-xs text-gray-500 dark:text-gray-400 truncate">{user?.email}</p>
            </div>
          </div>
        </div>
      )}

      {/* Nav Links */}
      <nav className="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
        {links.map(({ icon: Icon, label, path }) => {
          const isActive = location.pathname === path;
          return (
            <Link
              key={path}
              to={path}
              className={`flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 group ${
                isActive
                  ? "bg-[#C62828] text-white shadow-sm"
                  : "text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white"
              } ${collapsed ? "justify-center" : ""}`}
              title={collapsed ? label : undefined}
            >
              <Icon className="w-4 h-4 shrink-0" />
              {!collapsed && <span className="text-sm font-medium">{label}</span>}
            </Link>
          );
        })}
      </nav>

      {/* Logout */}
      <div className="px-2 py-4 border-t border-gray-200 dark:border-gray-800">
        <button
          onClick={handleLogout}
          className={`w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-950/30 hover:text-[#C62828] transition-colors ${
            collapsed ? "justify-center" : ""
          }`}
          title={collapsed ? "Logout" : undefined}
        >
          <LogOut className="w-4 h-4 shrink-0" />
          {!collapsed && <span className="text-sm font-medium">Logout</span>}
        </button>
      </div>
    </aside>
  );
}
