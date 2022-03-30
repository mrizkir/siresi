<template>
  <div>
    <v-system-bar app dark class="black lighten-2 white--text">
      <v-spacer></v-spacer>
      <strong>Hak Akses Sebagai:</strong> {{ DEFAULT_ROLE }}			
    </v-system-bar>
    <v-app-bar
      elevation="0"
      app
      class="purple darken-4 green--text font-weight-bold"
    >
      <v-app-bar-nav-icon
        @click.stop="drawer = !drawer"
        class="grey--text"
      >
      </v-app-bar-nav-icon>
      <v-toolbar-title
        class="headline clickable"
        @click.stop="
          $router
            .push('/dashboard/' + $store.getters['auth/AccessToken'])
            .catch(err => {})
        "
      >
        <span class="hidden-sm-and-down">
          SIRESIv1
        </span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-divider class="mx-4" inset vertical></v-divider>
      <v-menu
        :close-on-content-click="true"
        origin="center center"
        transition="scale-transition"
        :offset-y="true"
        bottom
        left
      >
        <template v-slot:activator="{ on }">
          <v-avatar size="30">
            <v-img :src="photoUser" v-on="on" />
          </v-avatar>
        </template>
        <v-list>
          <v-list-item>
            <v-list-item-avatar>
              <v-img :src="photoUser"></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title class="title">
                {{ ATTRIBUTE_USER("username") }}
              </v-list-item-title>
              <v-list-item-subtitle>
                [{{ DEFAULT_ROLE }}]
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider />
          <v-list-item to="/system-users/profil">
            <v-list-item-icon class="mr-2">
              <v-icon>mdi-account</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Profil</v-list-item-title>
          </v-list-item>
          <v-divider />
          <v-list-item @click.prevent="logout">
            <v-list-item-icon class="mr-2">
              <v-icon>mdi-power</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <v-app-bar-nav-icon @click.stop="drawerRight = !drawerRight">
        <v-icon color="white">mdi-menu-open</v-icon>
      </v-app-bar-nav-icon>
    </v-app-bar>
    <v-navigation-drawer
      v-model="drawer"
      width="300"
      dark
      class="purple darken-3"
      :temporary="temporaryleftsidebar"
      app
    >
      <v-list-item>
        <v-list-item-avatar>
          <v-img :src="photoUser" @click.stop="toProfile"></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title class="title white--text">
            {{ ATTRIBUTE_USER("username") }}
          </v-list-item-title>
          <v-list-item-subtitle class="white--text">
            [{{ DEFAULT_ROLE }}]
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        :to="{ path: '/dashboard/' + ACCESS_TOKEN }"
        v-if="CAN_ACCESS('DASHBOARD_SHOW')"
        link
        active-class="purple accent-1"
        color="purple"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-monitor-multiple</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>DASHBOARD</v-list-item-title>
        </v-list-item-content>
      </v-list-item>						
      <v-subheader class="purple accent-5 white--text" v-if="CAN_ACCESS('TRANSAKSI-GROUP')">TRANSAKSI</v-subheader>
      <v-list-item
        to="/transaksi/admin/scanresi"
        v-if="CAN_ACCESS('TRANSAKSI-ADMIN-SCAN-RESI_BROWSE') && DEFAULT_ROLE == 'admin'"
        link
        active-class="purple accent-1"
        color="purple"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-credit-card-scan</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>SCAN RESI</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        to="/transaksi/checker/scanresi"
        v-else-if="CAN_ACCESS('TRANSAKSI-CHECKER-SCAN-RESI_BROWSE') && DEFAULT_ROLE == 'checker'"
        link
        active-class="purple accent-1"
        color="purple"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-credit-card-scan</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>SCAN RESI</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        to="/transaksi/handoffer/scanresi"
        v-else-if="CAN_ACCESS('TRANSAKSI-HANDOFFER-SCAN-RESI_BROWSE') && DEFAULT_ROLE == 'handoffer'"
        link
        active-class="purple accent-1"
        color="purple"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-credit-card-scan</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>SCAN RESI</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-subheader class="purple accent-5 white--text" v-if="CAN_ACCESS('SETTING-GROUP')">SETTING</v-subheader>
      <v-list-item
        link
        v-if="CAN_ACCESS('SETTING-PENGGUNA-PERMISSIONS_BROWSE')"
        to="/setting/pengguna/permissions"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-arrow-collapse-right</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>
            PERMISSIONS
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        link
        v-if="CAN_ACCESS('SETTING-PENGGUNA-ROLES')"
        to="/setting/pengguna/roles"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-arrow-collapse-right</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>
            ROLES
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-divider color="yellow" />
      <v-list-item
        link
        to="/setting/pengguna/admin"
        active-class="purple darken-3 white--text"
        color="purple"
        v-if="CAN_ACCESS('SETTING-PENGGUNA-ADMIN_BROWSE')"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-arrow-collapse-right</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>
            ADMIN
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        link
        to="/setting/pengguna/picker"
        active-class="purple darken-3 white--text"
        color="purple"
        v-if="CAN_ACCESS('SETTING-PENGGUNA-PICKER_BROWSE')"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-arrow-collapse-right</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>
            PICKER
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        link
        to="/setting/pengguna/checker"
        active-class="purple darken-3 white--text"
        color="purple"
        v-if="CAN_ACCESS('SETTING-PENGGUNA-CHECKER_BROWSE')"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-arrow-collapse-right</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>
            CHECKER
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        link
        to="/setting/pengguna/handoffer"
        active-class="purple darken-3 white--text"
        color="purple"
        v-if="CAN_ACCESS('SETTING-PENGGUNA-HANDOFFER_BROWSE')"
      >
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-arrow-collapse-right</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>
            HANDOFFER
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-navigation-drawer>
    <v-navigation-drawer
      v-model="drawerRight"
      width="300"
      app
      fixed
      right
      temporary
      v-if="showrightsidebar"
    >
      <v-list dense>
        <v-list-item>
          <v-list-item-icon class="mr-2">
            <v-icon>mdi-menu-open</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="title">
              OPTIONS
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item class="purple darken-3 white--text">
          <v-list-item-icon class="mr-2">
            <v-icon>mdi-filter</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>FILTER</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <slot name="filtersidebar" />
      </v-list>
    </v-navigation-drawer>
    <v-main class="mx-4 mb-4">
      <slot />
    </v-main>
    <v-footer app padless fixed dark>
      <v-card class="flex" flat tile>
        <v-divider></v-divider>
        <v-card-text class="py-2 white--text text-center">
          <strong>
            SIRESIv1
          </strong>
          dikembangkan oleh Team IT — <strong> Beverra</strong>
          <v-btn dark icon href="#">
            <v-icon>mdi-github</v-icon>
          </v-btn>
        </v-card-text>
      </v-card>
    </v-footer>
  </div>
</template>
<script>
  import { mapGetters } from 'vuex';
  export default {
    name: 'AdminLayout',    
    props: {
      showrightsidebar: {
        type: Boolean,
        default: true,
      },
      temporaryleftsidebar: {
        type: Boolean,
        default: false,
      },
    },
    data: () => ({
      loginTime: 0,
      drawer: null,
      drawerRight: null,
    }),
    methods: {
      logout() {
        this.loginTime = 0;
        this.$ajax
          .post(
            '/auth/logout',
            {},
            {
              headers: {
                Authorization: 'Bearer ' + this.TOKEN,
              },
            }
          )
          .then(() => {
            this.$store.dispatch('auth/logout');
            this.$router.push('/');
          })
          .catch(() => {
            this.$store.dispatch('auth/logout');
            this.$router.push('/');
          });
      },
    },
    computed: {
      ...mapGetters('auth', {
        DEFAULT_ROLE: 'DefaultRole',
        ACCESS_TOKEN: 'AccessToken',
        ROLE: 'Role',
        CAN_ACCESS: 'can',
        ATTRIBUTE_USER: 'AttributeUser',
      }),
      photoUser() {
        let img = this.ATTRIBUTE_USER('foto');
        var photo;
        if (img == '') {
          photo = this.$backend.storageURL + '/images/users/no_photo.png';
        } else {
          photo = this.$backend.url + '/' + img;
        }
        return photo;
      },
    },
  };
</script>