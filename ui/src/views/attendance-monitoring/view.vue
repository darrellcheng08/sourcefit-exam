<template>
  <v-card :loading="loading" class="mx-auto my-12" max-width="374">
    <template slot="progress">
      <v-progress-linear
        color="deep-purple"
        height="10"
        indeterminate
      ></v-progress-linear>
    </template>

    <v-img height="250" :src="getImage()" contain></v-img>

    <v-card-title>{{ form.title }}</v-card-title>

    <v-card-text>
      <div>
        {{ form.content }}
      </div>
    </v-card-text>

    <v-divider class="mx-4"></v-divider>

    <div v-if="form.tags && form.tags.length > 0">
      <div class="ml-3 mt-3">Tags:</div>
      <v-chip
        class="ma-1 mb-2"
        v-for="(item, index) in form.tags"
        :key="`key-${index}`"
      >
        {{ item.name }}
      </v-chip>
    </div>

    <v-divider></v-divider>

    <v-card-actions>
      <v-btn color="deep-purple lighten-2" text @click="$router.go(-1)">
        Back
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    form: {},
    loading: false,
  }),

  async created() {
    let vm = this;
    vm.loading = true;
    let id = vm.$route.params.id;
    const { data } = await axios.get(`/articles/${id}`);
    if (data.status && data.status == "error") {
      return;
    }
    vm.form = data;
    vm.loading = false;
  },

  methods: {
    getImage() {
      return this.api_url + this.form.url_path;
    },

    reserve() {
      const vm = this;
      vm.loading = true;

      setTimeout(() => (vm.loading = false), 2000);
    },
  },
};
</script>
