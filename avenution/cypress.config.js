import { defineConfig } from "cypress";
import dotenv from "dotenv";

dotenv.config();

export default defineConfig({
  e2e: {
    baseUrl: 'http://localhost:8000',
    setupNodeEvents(on, config) {
      config.env.adminUsername = process.env.ADMIN_USERNAME || 'admin';
      config.env.adminPassword = process.env.ADMIN_PASSWORD || 'password';
      return config;
    },
  },
});
