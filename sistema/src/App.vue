<template>
  <div id="app">
    <div class="wrapper">
      <va-navibar v-if="login!=''" @saiu="saiu"></va-navibar>
      <router-view @funcaoLogin="funcaoLogin"></router-view>
    </div>
  </div>
</template>

<script>
import VANaviBar from "@/components/NaviBar";

export default {
  name: "App",
  data() {
    return {
      usuario: {},
      login: ""
    };
  },
  components: {
    "va-navibar": VANaviBar
  },
  methods: {
    funcaoLogin: function() {
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      console.log(this.usuario)
      if (this.usuario != null && this.usuario != undefined) {
        this.login = this.usuario.nome;
      if(this.usuario[0].tipo == 2){
          this.$router.push("/minhasturmas");
          document.getElementById("wrapper").classList.remove("wrapper");
          document.getElementById("wrapper").classList.add("wrapper");
      }else{
        this.$router.push("/");
        document.getElementById("wrapper").classList.remove("wrapper");
        document.getElementById("wrapper").classList.add("wrapper");
      
      }
      }
    },
    saiu: function() {
      sessionStorage.setItem("contas_logado", "false");
      sessionStorage.setItem("contas_login", "");
      sessionStorage.setItem("contas_menu", "[]");
      this.usuario = {};
      this.login = "";
      this.$router.push("/login");
    },
    verificarLogado() {
      if (
        sessionStorage.getItem("contas_logado") &&
        sessionStorage.getItem("contas_login")
      ) {
        this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
        this.login = this.usuario.nome;
        // document.getElementById("wrapper").classList.remove("wrapper");
        //document
        /// .getElementsByClassName("content-wrapper")
        // .classList.remove("content-wrapper");
      } else {
        sessionStorage.setItem("contas_logado", "false");
        sessionStorage.setItem("contas_login", "");
        sessionStorage.setItem("contas_menu", "[]");
        this.login = "";
        this.usuario = {};
        this.$router.push("/login");
        //document.getElementById("wrapper").classList.remove("wrapper");
      }
    }
  },
  mounted: function() {
    if (
      sessionStorage.getItem("contas_login") != "" &&
      sessionStorage.getItem("contas_login") != undefined
    ) {
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      this.login = this.usuario.nome;
      //document.getElementById("wrapper").classList.add("wrapper");
    } else {
      this.login = "";
      this.usuario = {};
      this.$router.push("/login");
      //document.getElementById("wrapper").classList.remove("wrapper");
    }
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
