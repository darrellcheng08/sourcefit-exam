<template>
  <v-dialog
    max-width="900"
    width="auto"
    v-model="value"
    @keydown.esc="choose(false)"
    content-class="no-elevation"
  >
    <v-card style="background: transparent; overflow: hidden">
      <div v-if="typeof images == 'string'" style="margin: auto">
        <div class="text-right">
          <v-btn @click="choose(false)" icon dark>
            <v-icon x-large>mdi-close</v-icon>
          </v-btn>
        </div>
        <!-- <zoom-on-hover
          contain
          :scale="1.5"
          :img-normal="images"
        ></zoom-on-hover> -->
        <v-img :src="images" alt="View Image" max-height="600" contain />
      </div>

      <!-- Multiple Images -->
      <v-carousel v-else height="auto">
        <v-carousel-item
          v-for="(item, i) in images"
          :src="item.hasOwnProperty('img_url') ? item.img_url : item"
          class="grey lighten-2"
          contain
          :key="i"
        ></v-carousel-item>
      </v-carousel>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    images: {
      type: undefined,
    },
    icon: {
      type: String,
      default: "mdi-alert",
    },
    title: {
      type: String,
      default: "Warning",
    },
    postiveText: {
      type: String,
      default: "Yes",
    },
    negativeText: {
      type: String,
      default: "No",
    },
    color: {
      type: String,
      default: "warning",
    },
    message: {
      type: String,
    },
    noNegative: {
      type: Boolean,
      default: false,
    },
    persistent: {
      type: Boolean,
      default: true,
    },
    width: {
      type: Number,
      default: 350,
    },
    onStop: {
      default: undefined,
    },
  },

  data() {
    return {
      value: true,
      stop: false,
      // colors: ["primary", "secondary", "yellow darken-2", "red", "orange"],
    };
  },

  methods: {
    choose(value) {
      this.value = value;
      if (this.stop) this.onStop();
      this.$destroy();
    },
  },
};
</script>

<style>
.absolute {
  position: absolute;
}
.no-elevation {
  box-shadow: none !important;
}
</style>

<style scoped>
.v-sheet.v-toolbar:not(.v-sheet--outlined) {
  box-shadow: none !important;
}
</style>
