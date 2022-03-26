<template>
  <AdminLayout :showrightsidebar="false" :temporaryleftsidebar="true">
    
  </AdminLayout>
</template>
<script>
import AdminLayout from "@/views/layouts/AdminLayout"
import { mapGetters } from "vuex"
export default {
  name: "DashboardAdmin",
  created() {
    this.TOKEN = this.$route.params.token
    this.initialize()
  },
  data: () => ({
    TOKEN: null,
    dashboard: null,
  }),
  methods: {
    initialize: async function () {
      await this.$ajax
        .get("/auth/me", {
          headers: {
            Authorization: "Bearer " + this.TOKEN,
          },
        })
        .then(({ data }) => {
          this.dashboard = data.role[0]          
          this.$store.dispatch("uiadmin/changeDashboard", this.dashboard)
        })
        .catch((error) => {
          if (error.response.status == 401) {
            this.$router.push("/")
          }
        })      
    },
    logout() {      
      this.$ajax
        .post(
          "/auth/logout",
          {},
          {
            headers: {
              Authorization: "Bearer " + this.TOKEN,
            },
          }
        )
        .then(() => {
          this.$store.dispatch("auth/logout")
          this.$router.push("/")
        })
        .catch(() => {
          this.$store.dispatch("auth/logout")
          this.$router.push("/")
        })
    },
  },
  computed: {
    ...mapGetters("auth", {
      DEFAULT_ROLE: "DefaultRole",
      ROLE: "Role",
      CAN_ACCESS: "can",
      ATTRIBUTE_USER: "AttributeUser",
    }),
    photoUser() {
      let img = this.ATTRIBUTE_USER("foto")
      var photo
      if (img == "") {
        photo = this.$backend.storageURL + "/images/users/no_photo.png"
      } else {
        photo = this.$backend.url + "/" + img
      }
      return photo
    },
  },
  components: {
    AdminLayout,
  },
}
</script>
