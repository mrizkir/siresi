<template>
  <AdminLayout v-if="$store.getters['auth/DefaultRole'] == 'handoffer'">
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
        <v-col cols="12">
          <v-card outlined>
            <v-list-item three-line>
              <v-list-item-content>
                <div class="overline mb-1">
                  Masukan Nomor Resi Invoice
                </div>
                <v-list-item-subtitle>
                  <v-autocomplete
                    v-model="data_resi"
                    :items="daftar_resi"
                    :loading="isLoading"
                    :search-input.sync="search"
                    cache-items                                        
                    dense                                                                                        
                    item-text="no_resi"
                    item-value="id"  
                    hide-no-data                                 
                    hide-details                                                                              
                    prepend-icon="mdi-database-search"
                    return-object
                    ref="ref_data_resi"
                  ></v-autocomplete>
                </v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-avatar
                tile
                size="80"
                color="green"
              >
                <v-icon>mdi-credit-card-scan</v-icon>
              </v-list-item-avatar>
            </v-list-item>
            <v-divider></v-divider>            
            <v-expand-transition>              
              <v-list v-if="data_resi">
                <template v-for="(field, i) in fields">
                <v-list-item :key="i">
                  <v-list-item-content>
                    <v-list-item-title>
                      {{field.value}}
                    </v-list-item-title>
                    <v-list-item-subtitle>
                      <strong>{{field_alias(field.key)}}</strong>
                    </v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
                </template>
              </v-list>
            </v-expand-transition>  
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                :disabled="!data_resi"
                @click="onSubmit"
              >
                SIMPAN
                <v-icon right>
                  mdi-forward
                </v-icon>
              </v-btn>
              <v-btn
                :disabled="!data_resi"
                @click="clearDataResi"
              >
                Clear
                <v-icon right>
                  mdi-close-circle
                </v-icon>
              </v-btn>
            </v-card-actions>
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
    name: 'TransaksiHandofferScanResi',
    created() {
      if (this.$store.getters['auth/DefaultRole'] != 'handoffer') {
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
			daftar_resi: [],
      isLoading: false,
      data_resi: null,
      search: null,

      waktu: null,
    }),
    methods: {
      async initialize() {
        this.datatableLoading = true
        await this.$ajax
          .post(
            '/transaksi/handoffer',
            {},
            {
              headers: {
                Authorization: this.$store.getters['auth/Token'],
              },
            }
          )
          .then(({ data }) => {
            this.waktu = data.waktu
          })
      },
      field_alias(atr) {
        var alias
        switch (atr) {
          case 'id':
            alias = 'RESI ID'
            break
          case 'no_resi':
            alias = 'NOMOR RESI'
            break
          case 'name':
            alias = 'NAMA CHECKER'
            break
        }
        return alias
      },
      onSubmit() {
        this.$ajax
          .post(
            '/transaksi/handoffer/store',
            {
              resi_id: this.data_resi.id,
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
      },
      clearDataResi() {
        this.data_resi = null
        this.$refs.ref_data_resi.cachedItems = []
      },
    },
    watch: {
      search(val) {
        if (this.isLoading) return
        if (val && val !== this.data_resi && val.length > 1) {
          setTimeout(async () => {
            this.isLoading = true
            await this.$ajax
              .post(
                '/transaksi/handoffer/search',
                {
                  search: val,
                },
                {
                  headers: {
                    Authorization: this.$store.getters['auth/Token'],
                  },
                }
              )
              .then(({ data }) => {
                const { jumlah, daftar_resi } = data
                this.count = jumlah
                this.daftar_resi = daftar_resi
                this.isLoading = false
              })
              .catch(() => {
                this.isLoading = false
              })
          }, 1000)
        }
      },
    },
    computed: {
      fields() {
        if (!this.data_resi) return []
        return Object.keys(this.data_resi).map((key) => {
          return {
            key,
            value: this.data_resi[key] || 'n/a',
          }
        })
      },
    },
    components: {
      AdminLayout,
      ModuleHeader,
    },
  }
</script>
