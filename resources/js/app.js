require('./bootstrap');

import Vue from "vue";

import router from "./router";

import BootstrapVue from "bootstrap-vue";
Vue.use(BootstrapVue);

import "../scss/app.scss";

import Vuelidate from "vuelidate";
Vue.use(Vuelidate);

import VueResource from "vue-resource";
Vue.use(VueResource);

Vue.http.headers.common["X-CSRF-TOKEN"] = document.head.querySelector(
  'meta[name="csrf-token"]'
).content;
Vue.http.headers.common["Accept"] = "application/json";
Vue.http.headers.common["CLIENT"] = "jimhe.us";
Vue.http.interceptor.before = function(request) {
  request.url = "/api" + request.url;
};

Vue.http.interceptors.push(function(request) {
  return function(response) {
    if (response.data.message == "Unauthenticated.") {
      window.location = "/login";
    }
  };
});

Vue.component("Topbar", require("./views/topbar").default);


const app = new Vue({
    el: "#app",
    data: {
      isLoading: false,
      user: window.user,
    },
    router,
    mounted() {
    },
    created() {
      if (window.token == null || window.user == null) {
        if (window.location.pathname != "/login") {
          this.$router.replace("/login");
        }
      }
      console.log("load app");
    },
    methods: {
    },
  });