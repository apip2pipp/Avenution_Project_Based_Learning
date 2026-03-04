import { createContext, useContext, useState } from "react";

interface User {
  id: string;
  name: string;
  email: string;
  role: "user" | "admin";
  avatar?: string;
  provider?: "email" | "google";
  healthGoal?: string;
}

interface AuthContextType {
  user: User | null;
  login: (email: string, password: string) => boolean;
  register: (name: string, email: string, password: string, healthGoal?: string) => boolean;
  loginWithGoogle: (googleUser: { name: string; email: string; avatar?: string }) => void;
  logout: () => void;
  isAuthenticated: boolean;
}

const AuthContext = createContext<AuthContextType>({
  user: null,
  login: () => false,
  register: () => false,
  loginWithGoogle: () => {},
  logout: () => {},
  isAuthenticated: false,
});

const MOCK_USERS = [
  {
    id: "1",
    name: "Budi Santoso",
    email: "budi@example.com",
    password: "password",
    role: "user" as const,
  },
  {
    id: "2",
    name: "Admin Avenution",
    email: "admin@avenution.com",
    password: "admin123",
    role: "admin" as const,
  },
];

const STORAGE_KEY = "avenution_session";
const REGISTERED_KEY = "avenution_registered";

const saveSession = (user: User | null) => {
  try {
    if (user) localStorage.setItem(STORAGE_KEY, JSON.stringify(user));
    else localStorage.removeItem(STORAGE_KEY);
  } catch {}
};

const loadSession = (): User | null => {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    return raw ? JSON.parse(raw) : null;
  } catch {
    return null;
  }
};

const getRegistered = (): Array<{
  id: string;
  name: string;
  email: string;
  password: string;
  healthGoal?: string;
}> => {
  try {
    return JSON.parse(localStorage.getItem(REGISTERED_KEY) || "[]");
  } catch {
    return [];
  }
};

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [user, setUser] = useState<User | null>(() => loadSession());

  const setAndSave = (u: User | null) => {
    setUser(u);
    saveSession(u);
  };

  const login = (email: string, password: string): boolean => {
    // Check built-in mock users
    const found = MOCK_USERS.find(
      (u) => u.email === email && u.password === password
    );
    if (found) {
      setAndSave({
        id: found.id,
        name: found.name,
        email: found.email,
        role: found.role,
        provider: "email",
      });
      return true;
    }

    // Check locally registered users
    const registered = getRegistered();
    const foundReg = registered.find(
      (u) => u.email === email && u.password === password
    );
    if (foundReg) {
      setAndSave({
        id: foundReg.id,
        name: foundReg.name,
        email: foundReg.email,
        role: "user",
        provider: "email",
        healthGoal: foundReg.healthGoal,
      });
      return true;
    }

    return false;
  };

  const register = (
    name: string,
    email: string,
    password: string,
    healthGoal?: string
  ): boolean => {
    // Check if email already exists
    const allEmails = [
      ...MOCK_USERS.map((u) => u.email),
      ...getRegistered().map((u) => u.email),
    ];
    if (allEmails.includes(email)) return false;

    try {
      const registered = getRegistered();
      const newUser = {
        id: `u_${Date.now()}`,
        name,
        email,
        password,
        healthGoal,
      };
      localStorage.setItem(
        REGISTERED_KEY,
        JSON.stringify([...registered, newUser])
      );
      setAndSave({
        id: newUser.id,
        name,
        email,
        role: "user",
        provider: "email",
        healthGoal,
      });
      return true;
    } catch {
      return false;
    }
  };

  const loginWithGoogle = (googleUser: {
    name: string;
    email: string;
    avatar?: string;
  }) => {
    const newUser: User = {
      id: `g_${Date.now()}`,
      name: googleUser.name,
      email: googleUser.email,
      role: "user",
      avatar: googleUser.avatar,
      provider: "google",
    };
    setAndSave(newUser);
  };

  const logout = () => setAndSave(null);

  return (
    <AuthContext.Provider
      value={{
        user,
        login,
        register,
        loginWithGoogle,
        logout,
        isAuthenticated: !!user,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
}

export const useAuth = () => useContext(AuthContext);
