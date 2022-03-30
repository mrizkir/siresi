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
      <v-form ref="frmdata" v-model="form_valid" lazy-validation>
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
                  :error-messages="error_no_resi_server_side"
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
                <v-radio-group
                  v-model="picker_id"
                  @change="onSubmit"                
                >
                  <v-radio
                    v-for="(item,index) in daftar_picker"
                    :key="index"
                    :label="`${item.name} (${item.jumlah})`"
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
      ];
    },
    mounted() {
      this.initialize()
    },
    data: () => ({
			btnLoading: false,
      daftar_picker: [],
      waktu: null,
      //form
      form_valid: true,      
      picker_id: null,
      formdata: {        
        no_resi: null,
      },
      error_no_resi_server_side: null,
      //form rules      
      rule_no_resi: [value => !!value || 'Mohon untuk di isi nomor resi !!!'],      
    }),
    methods: {
      initialize: async function() {
        this.datatableLoading = true;
        await this.$ajax
          .post('/transaksi/picker', 
          {

          },
          {
            headers: {
              Authorization: this.$store.getters['auth/Token'],
            },
          })
          .then(({ data }) => {
            this.waktu = data.waktu
            this.daftar_picker = data.picker       
          });
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
            this.picker_id = null;
          });
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
