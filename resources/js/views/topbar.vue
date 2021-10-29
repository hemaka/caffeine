<template>
  <header id="page-topbar">
    <div class="navbar-header">
      <div class="d-flex">
          <ul class="list-group list-group-horizontal">
                <li class="list-group-item d-flex justify-content-between align-items-start border-0">
                    Hi, {{user.name}}
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start border-0">
                    <router-link to="/">
                        <i class="ri-user-line align-middle mr-1"></i>
                        Dashboard
                    </router-link>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start border-0">
                    <router-link to="/drinks">
                        <i class="ri-user-line align-middle mr-1"></i>
                        Drinks
                    </router-link>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start border-0">
                    <a href="/logout">Logout</a>
                </li>
                
          </ul>
      </div>
    </div>
  </header>
</template>

<script>

export default {
  data() {
    return {
      user: window.user,
    }
  },
  components: {  },
  methods: {
    
  }
};
</script>
<style type="text/css">
</style>