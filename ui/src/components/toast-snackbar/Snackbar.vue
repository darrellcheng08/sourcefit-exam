<template>
  <v-app style="position: absolute">
    <v-snackbar
      v-model="show"
      :timeout="-1"
      :color="item.color"
      top
      @click="next"
    >
      {{ item.message }}
      <template v-slot:action="{ attrs }">
        <v-chip v-if="queues.length" disabled small class="ml-2 pa-0 px-2"
          >{{ queues.length || "" }}+ more</v-chip
        >
        <v-btn v-bind="attrs" icon @click="next" class="float-right pa-0 ma-0">
          <v-icon small>mdi-close-circle</v-icon>
        </v-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      show: true,
      queues: [],
      timer: null,
      item: {
        message: "",
        color: "",
        timeout: 5000,
      },
    };
  },
  methods: {
    queue(option) {
      this.queues.push(option);
      if (!this.timer) this.next();
    },
    next() {
      let vm = this;
      clearTimeout(vm.timer);
      if (!vm.queues.length) {
        vm.show = false;
      } else {
        const opt = vm.queues.shift();
        opt.timeout = opt.timeout || 5000;

        vm.item = opt;

        vm.timer = setTimeout(() => {
          vm.next();
        }, vm.item.timeout);
      }
    },
  },
  watch: {
    show(val) {
      if (!val) {
        setTimeout(() => {
          this.$destroy();
        }, 500);
      }
    },
  },
};
</script>
