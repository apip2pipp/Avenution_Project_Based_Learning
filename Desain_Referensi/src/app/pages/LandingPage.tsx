import { Link } from "react-router";
import { motion } from "motion/react";
import {
  Brain,
  Utensils,
  TrendingUp,
  ArrowRight,
  CheckCircle2,
  Zap,
  Shield,
  Activity,
  ChevronRight,
} from "lucide-react";
import { Navbar } from "../components/Navbar";

const heroImage = "https://images.unsplash.com/photo-1638328740227-1c4b1627614d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxoZWFsdGh5JTIwZm9vZCUyMG51dHJpdGlvbiUyMGNvbG9yZnVsJTIwdmVnZXRhYmxlc3xlbnwxfHx8fDE3NzI0NTg1NDl8MA&ixlib=rb-4.1.0&q=80&w=1080";
const mealImage = "https://images.unsplash.com/photo-1762631383815-784c04533802?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWFsJTIwcHJlcCUyMGJhbGFuY2VkJTIwZGlldCUyMHBsYXRlfGVufDF8fHx8MTc3MjQ1ODU1Mnww&ixlib=rb-4.1.0&q=80&w=1080";

const features = [
  {
    icon: Brain,
    title: "Body Condition Analysis",
    description:
      "Our AI analyzes your personal health metrics including age, weight, blood pressure, and more to understand your unique body condition.",
    color: "bg-rose-50 dark:bg-rose-950/30",
    iconColor: "text-[#C62828]",
    badge: "AI-Powered",
  },
  {
    icon: Utensils,
    title: "Personalized Menu Recommendation",
    description:
      "Get tailored food recommendations that match your body's nutritional needs, dietary restrictions, and health goals.",
    color: "bg-green-50 dark:bg-green-950/30",
    iconColor: "text-[#16A34A]",
    badge: "Smart Nutrition",
  },
  {
    icon: TrendingUp,
    title: "Progress Tracking",
    description:
      "Monitor your health journey over time with detailed charts and insights. Stay motivated with visual progress indicators.",
    color: "bg-blue-50 dark:bg-blue-950/30",
    iconColor: "text-blue-600",
    badge: "Track & Improve",
  },
];

const stats = [
  { value: "50K+", label: "Active Users" },
  { value: "98%", label: "Accuracy Rate" },
  { value: "200+", label: "Food Database" },
  { value: "4.9★", label: "User Rating" },
];

const techSteps = [
  { icon: Activity, title: "Input Your Data", desc: "Enter your body condition metrics securely." },
  { icon: Brain, title: "AI Analysis", desc: "Our model processes your data in seconds." },
  { icon: Utensils, title: "Get Recommendations", desc: "Receive personalized food plans instantly." },
  { icon: TrendingUp, title: "Track Progress", desc: "Monitor and improve your health over time." },
];

export default function LandingPage() {
  return (
    <div className="min-h-screen bg-[#F9FAFB] dark:bg-[#0F172A]" style={{ fontFamily: "Poppins, sans-serif" }}>
      <Navbar />

      {/* Hero Section */}
      <section className="relative overflow-hidden pt-16 pb-24 lg:pt-24 lg:pb-32">
        {/* Background gradient */}
        <div className="absolute inset-0 pointer-events-none">
          <div className="absolute top-0 left-1/4 w-96 h-96 bg-[#C62828]/5 rounded-full blur-3xl" />
          <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-[#16A34A]/5 rounded-full blur-3xl" />
        </div>

        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            {/* Left */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
            >
              <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#C62828]/10 text-[#C62828] text-xs font-semibold mb-6">
                <Zap className="w-3 h-3" />
                AI-Powered Health Tech Platform
              </div>
              <h1 className="text-gray-900 dark:text-white mb-6" style={{ fontSize: "clamp(2rem, 4vw, 3.2rem)", fontWeight: 800, lineHeight: 1.15 }}>
                Smart Food<br />
                Recommendations<br />
                <span className="text-[#C62828]">Based on Your</span><br />
                Body Condition
              </h1>
              <p className="text-gray-600 dark:text-gray-400 text-lg mb-8 leading-relaxed max-w-lg">
                Avenution uses advanced AI to analyze your health metrics and deliver personalized nutrition plans tailored specifically to your body's needs.
              </p>
              <div className="flex flex-wrap gap-4">
                <Link
                  to="/guest"
                  className="inline-flex items-center gap-2 px-6 py-3 bg-[#C62828] hover:bg-[#b71c1c] text-white rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-red-900/20 hover:shadow-red-900/30 hover:scale-105"
                >
                  Try Now <ArrowRight className="w-4 h-4" />
                </Link>
                <Link
                  to="/login"
                  className="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200"
                >
                  Login <ChevronRight className="w-4 h-4" />
                </Link>
              </div>

              {/* Trust badges */}
              <div className="mt-8 flex flex-wrap items-center gap-5">
                {["HIPAA Compliant", "256-bit Encryption", "ISO 27001"].map((badge) => (
                  <div key={badge} className="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                    <CheckCircle2 className="w-3.5 h-3.5 text-[#16A34A]" />
                    {badge}
                  </div>
                ))}
              </div>
            </motion.div>

            {/* Right - Hero Image */}
            <motion.div
              initial={{ opacity: 0, scale: 0.9 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 0.7, delay: 0.2 }}
              className="relative"
            >
              <div className="relative rounded-2xl overflow-hidden shadow-2xl shadow-gray-900/20">
                <img
                  src={heroImage}
                  alt="Healthy food"
                  className="w-full h-80 lg:h-[480px] object-cover"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-gray-900/40 via-transparent to-transparent" />

                {/* Floating card */}
                <div className="absolute bottom-4 left-4 right-4 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm rounded-xl p-4 shadow-lg">
                  <div className="flex items-center justify-between">
                    <div>
                      <p className="text-xs text-gray-500 dark:text-gray-400 font-medium">Today's Recommendation</p>
                      <p className="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">Mediterranean Diet Plan</p>
                    </div>
                    <div className="text-right">
                      <p className="text-xs text-gray-500 dark:text-gray-400">Match Score</p>
                      <p className="text-lg font-bold text-[#16A34A]">96%</p>
                    </div>
                  </div>
                  <div className="mt-3 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                    <div className="bg-[#16A34A] h-1.5 rounded-full" style={{ width: "96%" }} />
                  </div>
                </div>
              </div>

              {/* Stats floating */}
              <div className="absolute -top-4 -right-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-3 border border-gray-100 dark:border-gray-700">
                <p className="text-xs text-gray-500 dark:text-gray-400">Accuracy</p>
                <p className="text-2xl font-bold text-[#C62828]">98%</p>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="py-12 bg-white dark:bg-[#0F172A]/60 border-y border-gray-200 dark:border-gray-800">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
            {stats.map((stat, i) => (
              <motion.div
                key={stat.label}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.4, delay: i * 0.1 }}
                viewport={{ once: true }}
                className="text-center"
              >
                <p className="text-3xl font-bold text-[#C62828]">{stat.value}</p>
                <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">{stat.label}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section id="features" className="py-20 lg:py-28">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
            viewport={{ once: true }}
            className="text-center mb-14"
          >
            <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#16A34A]/10 text-[#16A34A] text-xs font-semibold mb-4">
              <Shield className="w-3 h-3" />
              Core Features
            </div>
            <h2 className="text-gray-900 dark:text-white mb-4" style={{ fontSize: "clamp(1.6rem, 3vw, 2.5rem)", fontWeight: 700 }}>
              Everything you need for<br />smarter nutrition
            </h2>
            <p className="text-gray-600 dark:text-gray-400 max-w-xl mx-auto">
              Our AI-driven platform combines medical insights with nutritional science to provide recommendations that truly work for your body.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-3 gap-6">
            {features.map((f, i) => (
              <motion.div
                key={f.title}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5, delay: i * 0.15 }}
                viewport={{ once: true }}
                className="group bg-white dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-200 dark:border-gray-700/50 hover:border-[#C62828]/30 dark:hover:border-[#C62828]/30 hover:shadow-xl transition-all duration-300"
              >
                <div className={`w-12 h-12 rounded-xl ${f.color} flex items-center justify-center mb-4`}>
                  <f.icon className={`w-6 h-6 ${f.iconColor}`} />
                </div>
                <div className="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs font-medium mb-3">
                  {f.badge}
                </div>
                <h3 className="text-gray-900 dark:text-white font-semibold mb-2">{f.title}</h3>
                <p className="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{f.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* How It Works / Technology */}
      <section id="technology" className="py-20 bg-gray-50 dark:bg-gray-900/40">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-16 items-center">
            <motion.div
              initial={{ opacity: 0, x: -30 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#C62828]/10 text-[#C62828] text-xs font-semibold mb-4">
                <Zap className="w-3 h-3" />
                How It Works
              </div>
              <h2 className="text-gray-900 dark:text-white mb-4" style={{ fontSize: "clamp(1.6rem, 3vw, 2.2rem)", fontWeight: 700 }}>
                Powered by Advanced<br />Health AI Technology
              </h2>
              <p className="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                Our proprietary AI model is trained on thousands of clinical nutrition studies and health datasets, ensuring recommendations that are both safe and effective.
              </p>

              <div className="space-y-5">
                {techSteps.map((step, i) => (
                  <motion.div
                    key={step.title}
                    initial={{ opacity: 0, x: -20 }}
                    whileInView={{ opacity: 1, x: 0 }}
                    transition={{ duration: 0.4, delay: i * 0.1 }}
                    viewport={{ once: true }}
                    className="flex items-start gap-4"
                  >
                    <div className="w-10 h-10 rounded-xl bg-[#C62828] flex items-center justify-center shrink-0 shadow-lg shadow-red-900/20">
                      <step.icon className="w-5 h-5 text-white" />
                    </div>
                    <div>
                      <h4 className="text-gray-900 dark:text-white font-semibold mb-0.5">{step.title}</h4>
                      <p className="text-gray-600 dark:text-gray-400 text-sm">{step.desc}</p>
                    </div>
                  </motion.div>
                ))}
              </div>

              <Link
                to="/guest"
                className="inline-flex items-center gap-2 mt-8 px-6 py-3 bg-[#C62828] hover:bg-[#b71c1c] text-white rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-red-900/20"
              >
                Start Your Analysis <ArrowRight className="w-4 h-4" />
              </Link>
            </motion.div>

            <motion.div
              initial={{ opacity: 0, x: 30 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <img
                src={mealImage}
                alt="Balanced meal"
                className="w-full rounded-2xl shadow-2xl shadow-gray-900/20 object-cover h-[420px]"
              />
            </motion.div>
          </div>
        </div>
      </section>

      {/* CTA Banner */}
      <section className="py-20">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="bg-gradient-to-br from-[#C62828] to-[#8B0000] rounded-3xl p-12 shadow-2xl shadow-red-900/30"
          >
            <h2 className="text-white mb-4" style={{ fontSize: "clamp(1.6rem, 3vw, 2.2rem)", fontWeight: 700 }}>
              Ready to Transform<br />Your Nutrition?
            </h2>
            <p className="text-red-100 mb-8 max-w-md mx-auto">
              Join thousands of users who have already improved their health with personalized AI nutrition recommendations.
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              <Link
                to="/guest"
                className="inline-flex items-center gap-2 px-6 py-3 bg-white text-[#C62828] rounded-xl font-semibold hover:bg-red-50 transition-all duration-200"
              >
                Try for Free <ArrowRight className="w-4 h-4" />
              </Link>
              <Link
                to="/register"
                className="inline-flex items-center gap-2 px-6 py-3 bg-white/10 border border-white/30 text-white rounded-xl font-semibold hover:bg-white/20 transition-all duration-200"
              >
                Create Account
              </Link>
            </div>
          </motion.div>
        </div>
      </section>

      {/* Footer */}
      <footer className="border-t border-gray-200 dark:border-gray-800 py-10 bg-white dark:bg-[#0F172A]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex flex-col md:flex-row items-center justify-between gap-4">
            <div className="flex items-center gap-2">
              <div className="w-7 h-7 rounded-lg bg-[#C62828] flex items-center justify-center">
                <Activity className="w-3.5 h-3.5 text-white" />
              </div>
              <span className="font-bold text-gray-900 dark:text-white">Avenution</span>
            </div>
            <p className="text-sm text-gray-500 dark:text-gray-400">
              © 2026 Avenution. Smart Food Recommendations Powered by AI.
            </p>
            <div className="flex items-center gap-5">
              {["Privacy", "Terms", "Contact"].map((link) => (
                <a key={link} href="#" className="text-sm text-gray-500 dark:text-gray-400 hover:text-[#C62828] transition-colors">
                  {link}
                </a>
              ))}
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}