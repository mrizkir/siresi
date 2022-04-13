<template>
  <AdminLayout>
    <ModuleHeader>
      <template v-slot:icon>
        mdi-email-variant
      </template>
      <template v-slot:name>
        TRANSAKSI RESI PICKER
      </template>
      <template v-slot:breadcrumbs>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0">
          <template v-slot:divider>
            <v-icon>mdi-chevron-right</v-icon>
          </template>
        </v-breadcrumbs>
      </template>
      <template v-slot:desc>
        <v-alert color="cyan" border="left" colored-border type="info">
          Daftar resi dari picker
        </v-alert>
      </template>
    </ModuleHeader>
    <v-container fluid>
      <v-row class="mb-4" no-gutters>
        <v-col xs="12" sm="12" md="12">
          <v-data-table
            :headers="headers"
            :items="datatable"
            :search="search"
            item-key="id"
            sort-by="name"
            show-expand
            :expanded.sync="expanded"
            :single-expand="true"
            class="elevation-1"
            :loading="datatableLoading"
            loading-text="Loading... Please wait"
            @click:row="dataTableRowClicked"
          >
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
  </AdminLayout>
</template>
<script>
  import AdminLayout from "@/views/layouts/AdminLayout";
  import ModuleHeader from "@/components/ModuleHeader";
  export default {
    name: "TransaksiResiPicker",
    created() {    
      this.breadcrumbs = [
        {
          text: 'HOME',
          disabled: false,
          href: '/dashboard/' + this.$store.getters['auth/Token'],
        },
        {
          text: 'TRANSAKSI',
          disabled: true,
          href: '#',
        },
        {
          text: 'RESI PICKER',
          disabled: true,
          href: '#',
        },
      ]
    },
    mounted() {
      this.initialize()
    },
    data: () => ({
      breadcrumbs: [],
    }),
    methods: {
      initialize: async function() {

      },
    },
    components: {
      AdminLayout,
      ModuleHeader,
    },
  }
</script>
