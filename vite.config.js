import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
    root: "resources",
    plugins: [vue()],
    server: {
        port: 5173,
        strictPort: true,
        proxy: {
            "/api": "http://php.test",
        },
    },
    build: {
        outDir: path.resolve(__dirname, "public/build"),
        emptyOutDir: true,
        rollupOptions: {
            input: "resources/js/main.js",
        },
    },
});
