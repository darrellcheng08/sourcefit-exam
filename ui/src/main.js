import Vue from "vue";
window._ = require("lodash");

import _axios from "axios";

import VueCookie from "vue-cookie";
import vuetify from '@plugins/vuetify';
import * as VeeValidate from 'vee-validate';
import VueMoment from "vue-moment";

import ToastSnackBar from "@components/toast-snackbar";
import ViewImageDialog from '@components/view-image-dialog';

import { router, VueRouter } from "@js/routes";

Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(VueCookie);
Vue.use(VueMoment);

Vue.use(ViewImageDialog);
Vue.use(ToastSnackBar);

// let token = document.head.querySelector('meta[name="csrf-token"]');

try {
  window.$ = window.jQuery = require("jquery");
} catch (e) {}

window.axios = _axios.create({
  baseURL: "http://127.0.0.1:8001/api",
  headers: {
    "X-Requested-With": "XMLHttpRequest",
    "Accept": "application/json",
    // "X-CSRF-TOKEN": token.content,
  },
});

Vue.mixin({

  data() {
    return {
      api_url: "http://127.0.0.1:8001"
    };
  },

  methods: {

  }
});

(async function() {
  // if (!VueCookie.get("api_token")) {
  //   window.location = "/logout";
  //   return;
  // }
  // await axios.interceptors.request.use((config) => {
  //   if (VueCookie.get("api_token") == "undefined") {
  //     window.location = "/logout";
  //     return;
  //   }
  //   config.headers["Authorization"] = "Bearer " + VueCookie.get("api_token");
  //   return config;
  // });
  await axios.interceptors.response.use(
    (response) => {
      return response;
    },
    async (error) => {
      if (error.response.status === 401) {
        // await axios.get("/logout");
      } else if (error.response.status === 403) {
        // location.href = "/forbidden";
      } else if (error.response.status === 404) {
        router.replace("/not-found");
      }
    }
  );
})();

import App from "@pages/App.vue";

new Vue({
  vuetify : vuetify,
  router,
  render: h => h(App),
  el: "#app",
});