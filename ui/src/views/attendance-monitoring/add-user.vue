<template>
  <div>
    <loading v-model="show_loading"></loading>
    <v-row justify="center">
      <v-col cols="12" xs="12" md="8" sm="12" lg="6">
        <v-card class="mb-3">
          <v-card-text class="pa-3">
            <v-container grid-list-lg>
              <v-layout row wrap>
                <v-flex xs4>
                  <v-text-field
                    label="First Name"
                    class="required"
                    v-validate="'required|max:50'"
                    :error-messages="errors.collect('first name')"
                    data-vv-name="first name"
                    v-model="form.fname"
                    hint="Max length of 50 characters only"
                    persistent-placeholder
                    persistent-hint
                    required
                  ></v-text-field>
                </v-flex>
                <v-flex xs4>
                  <v-text-field
                    label="Middle Name"
                    class="required"
                    v-validate="'required|max:50'"
                    :error-messages="errors.collect('middle name')"
                    data-vv-name="middle name"
                    v-model="form.mname"
                    hint="Max length of 50 characters only"
                    persistent-placeholder
                    persistent-hint
                    required
                  ></v-text-field>
                </v-flex>
                <v-flex xs4>
                  <v-text-field
                    label="Last Name"
                    class="required"
                    v-validate="'required|max:50'"
                    :error-messages="errors.collect('last name')"
                    data-vv-name="last name"
                    v-model="form.lname"
                    hint="Max length of 50 characters only"
                    persistent-placeholder
                    persistent-hint
                    required
                  ></v-text-field>
                </v-flex>

                <v-flex xs6>
                  <v-text-field
                    label="Contact No."
                    class="required"
                    v-validate="'required'"
                    :error-messages="errors.collect('contact number')"
                    data-vv-name="contact number"
                    v-model="form.contact_no"
                    persistent-placeholder
                    required
                  ></v-text-field>
                </v-flex>

                <v-flex xs6>
                  <v-text-field
                    label="Email"
                    class="required"
                    v-validate="'required'"
                    :error-messages="errors.collect('email')"
                    data-vv-name="email"
                    v-model="form.email"
                    persistent-placeholder
                    required
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text @click="cancel"> Cancel </v-btn>
            <v-btn color="primary" @click="save"> Save </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import loading from "@components/Loading.vue";

export default {
  components: {
    loading,
  },

  data: () => ({
    form: {},
    show_loading: false,
  }),

  methods: {
    async save() {
      const vm = this;
      const valid = await vm.$validator.validateAll();
      if (valid) {
        vm.show_loading = true;
        try {
          const { data } = await axios.post("/users", vm.form);
          if (data.status && data.status == "validation") {
            vm.$toast(data.message, "error");
            vm.show_loading = false;
            return;
          }
          vm.$toast("User successfully added!", "success");
          vm.cancel();
          vm.show_loading = false;
        } catch (error) {
          vm.$toast("Internal server error.", "error");
          vm.show_loading = false;
        }
      }
    },

    cancel() {
      this.$router.go(-1);
    },
  },
};
</script>
