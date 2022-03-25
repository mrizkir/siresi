<template>
  <AdminLayout>
    <ModuleHeader>
      <template v-slot:icon>
        mdi-credit-card-scan
      </template>
      <template v-slot:name>
        SCAN RESI
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
          digunakan untuk melakukan scan resi
        </v-alert>
      </template>
    </ModuleHeader>
    <v-container fluid>
      <v-row>
				<v-col cols="12">
          <v-card>
            <v-card-title>
              <span class="headline">Masukan Nomor Resi Invoice</span>
            </v-card-title>
            <v-card-text>
              <v-text-field
                v-model="formdata.no_resi"
                label="Nomor Resi"
                outlined
                :rules="rule_user_name"
                filled
              >
              </v-text-field>
            </v-card-text>
          </v-card>          
        </v-col>
        <v-col cols="12">
          <v-card>
            <v-card-title>
              <span class="headline">Pilih Picker</span>
            </v-card-title>
            <v-card-text>
              <v-radio-group v-model="formdata.picker_id">
                <v-radio
                  v-for="(item,index) in daftar_picker"
                  :key="index"
                  :label="`${item.name} (0)`"
                  :value="item.id"
                />
              </v-radio-group>
              <v-alert
                dense
                border="left"
                type="warning"
                v-if="!(daftar_picker.length > 0)"
              >
                belum ada picker !!!
              </v-alert>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </AdminLayout>
</template>
  
<script>
  import AdminLayout from '@/views/layouts/AdminLayout'
  import ModuleHeader from '@/components/ModuleHeader'
  export default {
    name: 'TransaksiScanResi',
    created() {
      this.breadcrumbs = [
        {
          text: "HOME",
          disabled: false,
          href: "/dashboard/" + this.ACCESS_TOKEN,
        },
        {
          text: "TRANSAKSI",
          disabled: true,
          href: "#",
        },
        {
          text: "SCAN RESI",
          disabled: true,
          href: "#",
        },
      ];
    },
    mounted() {
      this.initialize()
    },
    data: () => ({
			btnLoading: false,
      daftar_picker: [],
      formdata: {
        no_resi: null,
        picker_id: null,
      },
    }),
    methods: {
      initialize: async function() {
        this.datatableLoading = true;
        await this.$ajax
          .post('/transaksi/resi/picker', 
          {

          },
          {
            headers: {
              Authorization: this.$store.getters['auth/Token'],
            },
          })
          .then(({ data }) => {
            this.daftar_picker = data.picker;           
          });
      },
    },
    components: {
      AdminLayout,
      ModuleHeader,
    },
  }
</script>
