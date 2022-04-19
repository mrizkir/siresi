<template>
  <AdminLayout v-if="$store.getters['auth/DefaultRole'] == 'admin'">
    <ModuleHeader>
      <template v-slot:icon>
        mdi-credit-card-scan
      </template>
      <template v-slot:name>
        SCAN RESI [{{ waktu }}]
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
        <v-col xs="12" sm="6" md="4">
          <v-card
            class="mx-auto"            
          >
            <v-list-item two-line>
              <v-list-item-content>
                <v-list-item-title class="text-h5">
                  Jumlah Resi Hari ini :
                </v-list-item-title>
                <v-list-item-subtitle>{{jumlah_resi_hari_ini}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-card>
        </v-col>
        <v-col xs="12" sm="6" md="4">
          <v-card
            class="mx-auto"            
          >
            <v-list-item two-line>
              <v-list-item-content>
                <v-list-item-title class="text-h5">
                  Jumlah Resi yang lalu :
                </v-list-item-title>
                <v-list-item-subtitle>{{jumlah_resi_yang_lalu}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-card>
        </v-col>
      </v-row>
      <v-form ref="frmdata" v-model="form_valid" lazy-validation @submit.prevent="onSubmit">
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
                  :rules="rule_no_resi"
                  filled                  
                  autofocus
                >
                </v-text-field>
              </v-card-text>
              <v-card-actions>
                <v-btn
                  color="primary"                  
                  @click.stop="onSubmit"
                  :disabled="!form_valid || btnLoading"
                  x-large
                >
                  SIMPAN
                </v-btn>
              </v-card-actions>
            </v-card>          
          </v-col>
        </v-row>
      </v-form>
    </v-container>
  </AdminLayout>
</template>
  
<script>
  import AdminLayout from '@/views/layouts/AdminLayout'
  import ModuleHeader from '@/components/ModuleHeader'
  export default {
    name: 'TransaksiAdminScanResi',
    created() {
      if (this.$store.getters['auth/DefaultRole'] != 'admin') {
        this.$router.push('/dashboard/' + this.$store.getters['auth/Token'])
      }
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
          text: 'SCAN RESI',
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
			btnLoading: false,
      daftar_picker: [],
      waktu: null,
      jumlah_resi_hari_ini: 0,
      jumlah_resi_yang_lalu: 0,
      //form
      form_valid: true,
      picker_id: null,
      formdata: {
        no_resi: null,
      },
      error_no_resi_server_side: null,
      //form rules      
      rule_no_resi: [(value) => !!value || 'Mohon untuk di isi nomor resi !!!'],
    }),
    methods: {
      async initialize() {
        await this.$ajax
          .post(
            '/transaksi/picker',
            {},
            {
              headers: {
                Authorization: this.$store.getters['auth/Token'],
              },
            }
          )
          .then(({ data }) => {
            this.waktu = data.waktu
            this.daftar_picker = data.picker
            this.jumlah_resi_hari_ini = data.jumlah_resi_hari_ini
            this.jumlah_resi_yang_lalu = data.jumlah_resi_yang_lalu
          })
      },
      onSubmit() {        
        if (this.$refs.frmdata.validate()) {
          this.$ajax
            .post(
              '/transaksi/picker/store',
              {
                no_resi: this.formdata.no_resi,
                picker_id: this.picker_id,
              },
              {
                headers: {
                  Authorization: this.$store.getters['auth/Token'],
                },
              }
            )
            .then(() => {
              this.$router.go()
            })
            .catch(() => {
              this.picker_id = null
            })
        } else {
          this.$nextTick(() => {
            this.picker_id = null
          })
        }
      },
    },
    watch: {
      form_valid(val) {
        if (val == false) {
          this.picker_id = null
        }
      },
      error_no_resi_server_side(val) {
        console.log(val)
      },
    },
    components: {
      AdminLayout,
      ModuleHeader,
    },
  }
</script>
