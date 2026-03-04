import { useState } from "react";
import { Link, useNavigate } from "react-router";
import { Moon, Sun, Menu, X, HeartPulse } from "lucide-react";
import { useTheme } from "../context/ThemeContext";
import { useAuth } from "../context/AuthContext";

export function Navbar() {
  const { theme, toggleTheme } = useTheme();
  const { isAuthenticated, user, logout } = useAuth();
  const navigate = useNavigate();
  const [mobileOpen, setMobileOpen] = useState(false);

  const handleLogout = () => {
    logout();
    navigate("/");
  };

  return (
    <nav className="sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-[#0F172A]/80 backdrop-blur-md">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <Link to="/" className="flex items-center gap-2">
            <div className="w-8 h-8 rounded-lg bg-[#C62828] flex items-center justify-center">
              <HeartPulse className="w-4 h-4 text-white" />
            </div>
            <span className="text-gray-900 dark:text-white" style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "1.2rem" }}>
              Avenution
            </span>
          </Link>

          {/* Desktop Nav */}
          <div className="hidden md:flex items-center gap-8">
            <Link to="/#features" className="text-gray-600 dark:text-gray-300 hover:text-[#C62828] dark:hover:text-[#ef4444] transition-colors text-sm font-medium">
              Features
            </Link>
            <Link to="/#technology" className="text-gray-600 dark:text-gray-300 hover:text-[#C62828] dark:hover:text-[#ef4444] transition-colors text-sm font-medium">
              Technology
            </Link>
            {isAuthenticated ? (
              <>
                <Link
                  to={user?.role === "admin" ? "/admin" : "/dashboard"}
                  className="text-gray-600 dark:text-gray-300 hover:text-[#C62828] transition-colors text-sm font-medium"
                >
                  Dashboard
                </Link>
                <button
                  onClick={handleLogout}
                  className="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-sm font-medium"
                >
                  Logout
                </button>
              </>
            ) : (
              <Link
                to="/login"
                className="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-sm font-medium"
              >
                Login
              </Link>
            )}
          </div>

          {/* Right side */}
          <div className="flex items-center gap-3">
            <button
              onClick={toggleTheme}
              className="w-9 h-9 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            >
              {theme === "dark" ? <Sun className="w-4 h-4" /> : <Moon className="w-4 h-4" />}
            </button>
            <button
              className="md:hidden w-9 h-9 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
              onClick={() => setMobileOpen(!mobileOpen)}
            >
              {mobileOpen ? <X className="w-4 h-4" /> : <Menu className="w-4 h-4" />}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile Menu */}
      {mobileOpen && (
        <div className="md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0F172A] px-4 py-3 space-y-2">
          <Link to="/#features" className="block py-2 text-gray-600 dark:text-gray-300 text-sm font-medium">Features</Link>
          <Link to="/#technology" className="block py-2 text-gray-600 dark:text-gray-300 text-sm font-medium">Technology</Link>
          {isAuthenticated ? (
            <>
              <Link to={user?.role === "admin" ? "/admin" : "/dashboard"} className="block py-2 text-gray-600 dark:text-gray-300 text-sm font-medium">Dashboard</Link>
              <button onClick={handleLogout} className="block py-2 text-[#C62828] text-sm font-medium">Logout</button>
            </>
          ) : (
            <Link to="/login" className="block py-2 text-gray-600 dark:text-gray-300 text-sm font-medium">Login</Link>
          )}
        </div>
      )}
    </nav>
  );
}
