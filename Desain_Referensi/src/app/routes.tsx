import { createBrowserRouter } from "react-router";
import LandingPage from "./pages/LandingPage";
import GuestPage from "./pages/GuestPage";
import AuthPage from "./pages/AuthPage";
import UserDashboard from "./pages/UserDashboard";
import AdminDashboard from "./pages/AdminDashboard";

export const router = createBrowserRouter([
  {
    path: "/",
    Component: LandingPage,
  },
  {
    path: "/guest",
    Component: GuestPage,
  },
  {
    path: "/login",
    Component: AuthPage,
  },
  {
    path: "/register",
    Component: AuthPage,
  },
  {
    path: "/dashboard",
    Component: UserDashboard,
  },
  {
    path: "/dashboard/history",
    Component: UserDashboard,
  },
  {
    path: "/dashboard/profile",
    Component: UserDashboard,
  },
  {
    path: "/admin",
    Component: AdminDashboard,
  },
  {
    path: "/admin/users",
    Component: AdminDashboard,
  },
  {
    path: "/admin/analytics",
    Component: AdminDashboard,
  },
  {
    path: "/admin/system",
    Component: AdminDashboard,
  },
]);
