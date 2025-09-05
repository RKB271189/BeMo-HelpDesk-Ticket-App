import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Tickets from "../views/Tickets.vue";
import Create from "../views/Create.vue";
const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/tickets",
        name: "Ticket - List",
        component: Tickets,
    },
    {
        path: "/ticket/new",
        name: "Ticket - Create",
        component: Create,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
