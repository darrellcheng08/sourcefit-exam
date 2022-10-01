<template>
  <div>
    <loading v-model="show_loading"></loading>

    <v-row>
      <v-col cols="12" class="pb-2">
        <v-btn
          class="float-right"
          color="info"
          @click="time_entry_dialog = true"
        >
          <v-icon left>mdi-clock</v-icon>
          Timekeeper Entry
        </v-btn>
        <v-btn
          class="float-right mr-2"
          color="primary"
          @click="$router.push('/attendance/create-user')"
        >
          <v-icon left>mdi-account</v-icon>
          Create User
        </v-btn>
      </v-col>

      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="attendance"
          :options.sync="options"
          :server-items-length="totalItems"
          :footer-props="footer_props"
          class="elevation-1"
        >
          <template v-slot:item.title="{ item }">
            <a @click="editItem(item.id)">
              {{ item.title }}
            </a>
          </template>

          <template v-slot:item.url_path="{ item }">
            <a @click="viewArticle(item)">
              {{ item.url_path.split("/").pop() }}
            </a>
          </template>

          <template v-slot:item.created_at="{ item }">
            <span>{{ item.created_at | moment("MM-DD-YYYY") }} </span>
          </template>

          <template v-slot:item.time_in="{ item }">
            <span>{{ item.time_in | moment("h:mm A") }} </span>
          </template>

          <template v-slot:item.time_out="{ item }">
            <span>{{ item.time_out | moment("h:mm A") }} </span>
          </template>
        </v-data-table>
      </v-col>
    </v-row>

    <v-dialog v-model="time_entry_dialog" max-width="550">
      <v-card>
        <v-toolbar color="warning" dark>
          <v-icon large>mdi-clock</v-icon>
          <div class="pl-3 text-h5">Timekeeper Entry</div>
          <v-spacer></v-spacer>
          <v-btn text @click="time_entry_dialog = false">Cancel</v-btn>
        </v-toolbar>

        <v-card-text class="pa-4">
          <v-container grid-list-lg>
            <v-layout row wrap>
              <v-flex xs12>
                <v-select
                  v-model="form.user"
                  :items="users"
                  class="required"
                  item-text="name"
                  item-value="id"
                  label="Select user to Time-In/Time-Out"
                  v-validate="'required'"
                  :error-messages="errors.collect('user')"
                  data-vv-name="user"
                  persistent-placeholder
                  return-object
                  clearable
                >
                </v-select>
              </v-flex>

              <v-flex v-if="form.user && form.user.active_attendance_id" xs12>
                <div class="title">
                  Total hours worked for this user:
                  {{ form.user.total_hrs_worked }} hours
                </div>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions class="justify-end">
          <v-btn
            v-if="form.user && !form.user.active_attendance_id"
            class="theme--dark"
            color="orange"
            @click="timeIn"
            ><v-icon>mdi-clock-in</v-icon> Time-In
          </v-btn>
          <v-btn
            v-if="form.user && form.user.active_attendance_id"
            class="theme--dark"
            color="pink"
            @click="timeOut"
            ><v-icon>mdi-clock-out</v-icon> Time-Out
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import loading from "../../components/Loading.vue";

export default {
  components: { loading },

  data() {
    return {
      headers: [
        { text: "Name", value: "user_name" },
        { text: "Date", sortable: false, value: "created_at" },
        { text: "Time In", value: "time_in" },
        { text: "Time Out", value: "time_out" },
        { text: "Hrs Worked", value: "hrs_worked" },
        { text: "Hrs Late", value: "hrs_late" },
        { text: "Hrs Undertime", value: "hrs_undertime" },
        { text: "Hrs Overtime", value: "hrs_overtime" },
      ],
      show_loading: false,
      time_entry_dialog: false,
      form: {},
      filters: {},
      attendance: [],
      users: [],
      totalItems: 1,
      footer_props: {
        itemsPerPageOptions: [10, 25, 50, 100],
      },
      options: {
        itemsPerPage: 10,
        sortBy: ["created_at"],
        sortDesc: [true],
      },
    };
  },

  watch: {
    options: {
      deep: true,
      handler: "optionsFetch",
    },
  },

  async created() {
    await this.getUser();
  },

  methods: {
    async optionsFetch(extraOptions) {
      let vm = this;
      vm.show_loading = true;
      let currentPage = vm.$route.query.page;
      let page = extraOptions.page;

      let opts = Object.assign(_.clone(extraOptions));
      await vm.getAttendance(opts);

      if (currentPage != page) {
        let path = vm.$route.path + "?page=" + page;
        vm.$router.push({
          path: path,
          replace: true,
        });
      }
      vm.show_loading = false;
    },

    async getAttendance(opts) {
      let vm = this;
      let params = {
        params: {
          ...opts,
        },
      };
      const { data } = await axios.get(`/attendance`, params);
      vm.attendance = data.data;
      vm.totalItems = data.total;
    },

    async getUser() {
      let vm = this;
      const { data } = await axios.get(`/users`);
      vm.users = data;
    },

    async timeIn() {
      const vm = this;
      const valid = await vm.$validator.validateAll();
      if (valid) {
        vm.show_loading = true;
        vm.form.user_id = vm.form.user ? vm.form.user.id : "";
        const { data } = await axios.post("/attendance/time-in", vm.form);
        if (data.status && data.status == "error") {
          vm.$toast(data.message, "error");
          vm.show_loading = false;
          return;
        }
        vm.$toast("User successfully time-in", "success");
        await vm.optionsFetch(vm.options);
        vm.cancel();
        vm.show_loading = false;
      }
    },
    async timeOut() {
      const vm = this;
      const valid = await vm.$validator.validateAll();
      if (valid) {
        vm.show_loading = true;
        vm.form.user_id = vm.form.user ? vm.form.user.id : "";
        const { data } = await axios.post("/attendance/time-out", vm.form);
        if (data.status && data.status == "validation") {
          vm.$toast(data.message, "error");
          vm.show_loading = false;
          return;
        }
        vm.$toast("User successfully time-out", "success");
        await vm.optionsFetch(vm.options);
        vm.cancel();
        vm.show_loading = false;
      }
    },
  },
};
</script>
