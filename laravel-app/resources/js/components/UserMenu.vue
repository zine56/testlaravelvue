  <template>
    <v-app-bar app color="primary" dark>
      <v-toolbar-title>{{ appName }}</v-toolbar-title>
      <v-spacer></v-spacer>
      <template v-if="isAuthenticated">
        <span class="pr-5">{{ userName }}</span>
        <div class="dropdown">
            <button @click="toggleDropdown" class="dropdown-button">
            <v-avatar>
                <img :src="userAvatar" alt="User Avatar">
            </v-avatar>
            </button>
            <div v-show="isDropdownOpen" class="dropdown-content">
            <a href="javascript:void(0)" @click="logout">Logout</a>
            </div>
        </div>  
      </template>
      <template v-else>
        <v-btn text href="{{ route('login') }}">Login</v-btn>
        <v-btn text href="{{ route('register') }}">Register</v-btn>
      </template>
    </v-app-bar>
  </template>
  
  <script>
  export default {
    name: "UserMenu",
    props: {
      isAuthenticated: {
        type: Boolean,
        required: true
      },
      userName: {
        type: String,
        required: false,
        default: ""
      }
    },
    data() {
      return {
        appName: 'Prueba Técnica Position',
        userAvatar: 'https://i.pravatar.cc/150', // Replace this with actual user avatar
        isDropdownOpen: false
      };
    },
    methods: {
      toggleDropdown() {
        this.isDropdownOpen = !this.isDropdownOpen;
      },
      logout() {
        document.getElementById('logout-form').submit();
      }
    }
  };
  </script>
  
  <style scoped>
  .dropdown {
    position: relative;
    display: inline-block;
  }
  
  .dropdown-button {
    background: none;
    border: none;
    cursor: pointer;
  }
  
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }
  
  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }
  
  .dropdown-content a:hover {
    background-color: #f1f1f1;
  }
  
  .dropdown-content {
    display: block;
    position: fixed;
    right: 0px;
  }
  </style>
  