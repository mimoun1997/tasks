<template>
  <v-card dark color="#9de1fe" flat v-show="hasPermission == undefined">
    <v-layout align-center row class="text-xs-left pl-2">
      <v-flex xs3 >
        <v-avatar size="54" color="white">
          <v-icon color="#9de1fe" size="28">notifications_off</v-icon>
        </v-avatar>
      </v-flex>
      <v-flex xs9>
        <v-card-text class="grey--text text--darken-2">
        <p class="title font-weight-light">Recibe notificaciones de mensajes nuevos</p> 
          <p class="body pointer" @click="requestPermission"><span class="underline">Activar notificacions d'escriptori</span> ></p>
          <p></p>
        </v-card-text>
      </v-flex>
    </v-layout>
    <notifications-full-screen ref="notificationFull"></notifications-full-screen>
  </v-card>
</template>

<script>
import NotificationsFullScreen from './NotificationsFullScreen.vue'

export default {
  name: "NotificationsActivateButton",
  components: {
    'notifications-full-screen': NotificationsFullScreen
  },
  data() {
    return {
      hasPermission: undefined,
    };
  },
  methods: {
    requestPermission: function() {
        this.$refs.notificationFull.requestPermission();
    }
  },
  created() {
    this.hasPermission = this.$refs.notificationFull.hasPermission()
  },
};
</script>

<style scoped>
.pointer {
  cursor: pointer;
}
.underline {
    text-decoration: underline
}
</style>
//style="background-color: green;"