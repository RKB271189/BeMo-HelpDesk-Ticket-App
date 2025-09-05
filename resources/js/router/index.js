import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Tickets from "../views/Tickets.vue";
const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/tickets",
        name: "Ticket",
        component: Tickets,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
