/**
 * First we will load all of this project"s JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "./bootstrap";

import Vue from "vue";
import VueRouter from "vue-router";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from "./components/App";
import Spinner from "./components/Spinner";
import routes from "./routes";
import store from "./store";

Vue.use(VueRouter);
Vue.component("App", App);
Vue.component("Spinner", Spinner);

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

const app = new Vue({
    el: "#app",
    router,
    store,
});
