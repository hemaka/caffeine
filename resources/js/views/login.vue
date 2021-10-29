<template>
    <div class="row no-gutters mt-5">
        <div class="text-center">
            <a href="/" class="logo">
                <img src="/logo.png" height="100" alt="logo" />
            </a>

            <h4 class="font-size-18 mt-4">Welcome</h4>
            <p class="text-muted">Sign in to continue to Coffenine project.</p>
        </div>
        <div class="p-2 mt-5 text-center">
            <a href="/auth/login/google" class="text-sm text-gray-700 underline">User Google Login</a>
        </div>

        <div class="p-2 mt-2 text-center">
            <a href="/auth/login/demo" class="text-sm text-gray-700 underline">User Demo Login</a>
        </div>
        <div class="text-center invalid-feedback d-block" v-if="msg!=''">{{msg}}</div>
        <div class="mt-5 text-center">
            <p>
                © 2021 Caffeine by Jim.
            </p>
        </div>
    </div>
</template>
<script>

export default {
  data() {
    return {
      msg: window.msg,
      user: window.user,
    };
  },
  computed: {
    notification() {
      return null;
    }
  },
  mounted(){

  },
  created() {
    if(this.user != null){
      this.$router.push("/")
    }
  },
  methods: {
    
  }
};
</script>