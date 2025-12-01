import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import { resolve } from "path";

export default defineConfig({
  base: "./",
  plugins: [
    tailwindcss(),
  ],
  build: {
    rollupOptions: {
      input: {
        index: resolve(__dirname, "index.html"),

        about: resolve(__dirname, "src/about.html"),
        breadcrumb: resolve(__dirname, "src/breadcrumb.html"),
        contact: resolve(__dirname, "src/contact.html"),
        fooder: resolve(__dirname, "src/fooder.html"),
        header: resolve(__dirname, "src/header.html"),
        news: resolve(__dirname, "src/news.html"),
        newsDetail: resolve(__dirname, "src/news-detail.html"),
        project: resolve(__dirname, "src/project.html"),
        projectDetail: resolve(__dirname, "src/project-detail.html"),
        service: resolve(__dirname, "src/service.html"),
        serviceDetail: resolve(__dirname, "src/service-detail.html"),
      },
    },
  },
});
