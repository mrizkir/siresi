<template>
  <div>    
    <v-main>
      <slot />
    </v-main>    
    <v-footer app absolute padless class="mt-0">
      <v-card flat tile class="flex">
        <v-card-text class="indigo darken-3 white--text text-center pa-5 hidden-sm-and-down" v-if="$route.name!='FrontPMB'">
          <v-btn
            v-for="icon in icons"
            :key="icon"
            class="mx-8 white--text"
            icon
          >
            <v-icon size="45px">
              {{ icon }}
            </v-icon>
          </v-btn>
        </v-card-text>
        <v-card-text class="indigo darken-3 white--text text-center pa-2 hidden-lg-and-up" v-if="$route.name!='FrontPMB'">
          <v-btn
            v-for="icon in icons"
            :key="icon"
            class="mx-4 white--text"
            icon
          >
            <v-icon size="30px">{{ icon }}</v-icon>
          </v-btn>
        </v-card-text>
        <v-card-text class="indigo darken-4 py-2 white--text text-center">          
          Team IT Beverra — <strong>SIRESI (Sistem Informasi Pelacakana Resi)</strong>
        </v-card-text>
      </v-card>
    </v-footer>  
  </div>
</template>
<script>
  export default {
    name: 'FrontLayout',
    data: () => ({
      icons: [
        'mdi-github',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ],
    }),
  }
</script>