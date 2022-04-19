<template>
  <AdminLayout v-if="$store.getters['auth/DefaultRole'] == 'admin'">
    <ModuleHeader>
      <template v-slot:icon>
        mdi-credit-card-scan
      </template>
      <template v-slot:name>
        PILIH PICKER [{{ waktu }}]
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
          digunakan untuk memilih picker yang akan mengambil resi
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
      <v-form ref="frmdata" v-model="form_valid" lazy-validation>
        <v-row>          
          <v-col cols="12">          
            <v-card>
              <v-card-title>
                <span class="headline">Pilih Picker</span>
              </v-card-title>
              <v-card-text>
                <v-select
                  v-model="formdata.picker_id"
                  :items="daftar_picker"
                  item-text="name"
                  item-value="id"
                  outlined
                  :rules="rule_picker"
                >
                </v-select>
                <v-text-field
                  v-model="formdata.jumlah_resi"
                  outlined
                  :rules="rule_jumlah_resi"
                />                
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
    name: 'TransaksiAdminPilihPicker',
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
          text: 'PILIH PICKER',
          disabled: true,
          href: '#',
        },
      ]
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
      formdata: {
        picker_id: null,
        jumlah_resi: 0,
      },      
      //form rules
      rule_picker: [
        (value) => !!value || 'Mohon untuk di isi jumlah resi !!!',
      ],
      rule_jumlah_resi: [
        (value) => !!value || 'Mohon untuk di isi jumlah resi !!!',
        (value) =>
          /^[0-9]+$/.test(value) || "Jumlah resi hanya boleh angka",        
      ],
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
            '/transaksi/picker/storeresipicker',
            {
              jumlah_resi: this.formdata.jumlah_resi,
              picker_id: this.formdata.picker_id,
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
        }
      },
    },    
    components: {
      AdminLayout,
      ModuleHeader,
    },
  }
</script>
