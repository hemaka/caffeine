import Vue from 'vue'
import VueRouter from "vue-router";


Vue.use(VueRouter);

export const router = new VueRouter({
    base: "",
    linkActiveClass: "active",
    mode: 'history',
    routes: [
        {
            path: "/",
            name: "Dashboard",
            component: () => import('./views/dashboard'),
            meta: {
                title: "Dashboard"
            }
        },
        {
            path: "/drinks",
            name: "Drinks",
            component: () => import('./views/drinks'),
            meta: {
                title: "Drinks"
            }
        },
        {
            path: "/login",
            name: "Login",
            component: () => import('./views/login'),
            meta: {
                title: "Login"
            }
        },
    ]
});

export default router;