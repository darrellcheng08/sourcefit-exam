<template>
  <v-app>
    <!-- Must have the app property -->
    <v-app-bar app>
      <v-toolbar-title>
        {{ router_text }}
      </v-toolbar-title>
    </v-app-bar>

    <!-- CONTAINER -->
    <v-main>
      <v-container class="pa-6" fluid>
        <router-view></router-view>
      </v-container>
    </v-main>

    <v-footer app :inset="true">
      <span class="px-2 caption ma-auto"
        >&copy; {{ new Date().getFullYear() }} - Sourcefit Exam</span
      >
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    matched: "",
    router: [],
    router_text: "Attendance Monitoring",
  }),

  created() {
    this.breadCrumbs();
  },

  watch: {
    $route(to, from) {
      this.breadCrumbs();
    },
  },

  methods: {
    breadCrumbs() {
      let vm = this;
      let path = this.$route.path;
      let split = path.split("/");
      let string = "";
      vm.router = [];
      for (var i = 0; i < split.length; i++) {
        if (split[i]) {
          string += "/" + split[i];
          vm.matched = string;
          if (vm.$router.match(vm.matched).name) {
            vm.router_text = vm.$router.match(vm.matched).name;
          }
        }
      }
    },
  },
};
</script>

<style>
.required .v-label:before {
  content: "* ";
  color: red;
  font-size: 1.5rem;
}
</style>
