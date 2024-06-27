<template>
    <v-app>
      <user-menu :isAuthenticated="isAuthenticated" :userName="userName"/>
      <router-view></router-view>
    </v-app>
  </template>
<script>
import UserMenu from './components/UserMenu.vue';

export default {
  components: {
    UserMenu
  },
  data() {
    return {
      isAuthenticated: false,
      userName: ''
    };
  },
  mounted() {
    this.isAuthenticated = window.__IS_AUTHENTICATED__;
    this.userName = window.__USER_NAME__;
  }
};
</script>

<style>
/* Add any global styles for your app here */
</style>
