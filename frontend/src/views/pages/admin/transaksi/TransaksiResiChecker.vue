<template>
  <AdminLayout>
    <ModuleHeader>
      <template v-slot:icon>mdi-email-variant</template>
      <template v-slot:name>
        TRANSAKSI RESI CHECKER
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
          Daftar resi yang sudah diperiksa oleh Checker
        </v-alert>
      </template>
    </ModuleHeader>
    <v-container fluid>
      <v-row class="mb-4" no-gutters>
        <v-col cols="12">
          <v-card>
            <v-card-text>
              <v-text-field
                v-model="search"
                append-icon="mdi-database-search"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
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
            loading-text="Loading... Please wait"
            @click:row="dataTableRowClicked"
          >
            <template v-slot:top>
              <v-toolbar flat color="white">
                <v-toolbar-title>DAFTAR RESI CHECKER</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
              </v-toolbar>
            </template>
            <template v-slot:item.foto="{ item }">
              <v-avatar size="30">
                <v-img :src="$backend.url + '/' + item.foto" />
              </v-avatar>
            </template>
            <template v-slot:item.created_at="{ item }">
              {{ $date(item.created_at).format("DD/MM/YYYY HH:mm") }}
            </template>
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
    name: "TransaksiResiChecker",
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
          text: 'RESI CHECKER',
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
      //tables
      expanded: [],
      search: null,
      datatable: [],
      headers: [
        { text: '', value: 'foto' },
        { text: 'NAME', value: 'name', sortable: true },
        { text: 'NOMOR HP', value: 'nomor_hp', sortable: true },
        { text: 'NOMOR RESI', value: 'no_resi', sortable: true },
        { text: 'TANGGAL SCAN', value: 'created_at', sortable: true },
      ],
    }),
    methods: {
      async initialize() {
        await this.$ajax
          .get('/transaksi/resichecker', {
            headers: {
              Authorization: this.$store.getters['auth/Token'],
            },
          })
          .then(({ data }) => {
            this.datatable = data.resi            
          })
      },
      dataTableRowClicked(item) {
        if (item === this.expanded[0]) {
          this.expanded = []
        } else {
          this.expanded = [item]
        }
      },
    },
    components: {
      AdminLayout,
      ModuleHeader,
    },
  }
</script>
