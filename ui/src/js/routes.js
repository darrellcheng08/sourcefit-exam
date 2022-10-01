import VueRouter from "vue-router";

// articles
import AttendanceIndex from "@pages/attendance-monitoring/index";
import AddUser from "@pages/attendance-monitoring/add-user";
import Error404 from "@pages/error-404";

const router = new VueRouter({
  mode: "history",
  routes: [
    {
      name: "Attendance Logs",
      path: "/",
      component: AttendanceIndex,
      meta: {
        breadcrumb: "Logs"
      },
    },
    {
        name: "Attendance Logs",
        path: "/attendance",
        component: AttendanceIndex,
        meta: {
          breadcrumb: "Logs"
        },
    },
    {
        name: "User - Create",
        path: "/attendance/create-user",
        component: AddUser,
        meta: {
          breadcrumb: "Create"
        },
    },
    {
      name: "Error 404 Page",
      path: "*",
      component: Error404,
    }
  ],
});

export { router, VueRouter };