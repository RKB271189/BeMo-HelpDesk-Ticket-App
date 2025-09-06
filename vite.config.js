import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
    root: "resources",
    base: "/build/",
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
            input: path.resolve(__dirname, "resources/index.html"),
        },
    },
});
