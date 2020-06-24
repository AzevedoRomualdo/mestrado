<template>
  <div class="Fundo">
    <v-dialog v-model="logando" hide-overlay persistent width="300">
      <v-card color="sucess">
        <v-card-text>
          Entrando...
          <v-progress-linear indeterminate color="blue" class="mb-0"></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialog" max-width="290">
      <v-card>
        <v-card-title class="headline">Erro</v-card-title>

        <v-card-text>{{msg}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat="flat" @click="dialog = false">OK</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-app id="inspire">
      <v-card
        class="mx-auto"
        color="#032A4F"
        style="margin-top:180px; border-radius: 5px; height: 55%; width:30%"
      >
        <v-layout row wrap>
          <span
            style="color:white; margin-left:43px; font-size:40px; margin-top:20px;"
          >Peer Review Edition</span>
        </v-layout>
        <v-layout row wrap>
          <v-flex xs3 sm3>
            <v-text-field
              :disabled="logando"
              label="Login"
              style="margin-left:60px; margin-top:20px; width: 44vh;"
              v-model="login"
              solo
            ></v-text-field>
            <!-- <input
              
              v-model="login"
              style="border: 2px solid DimGray; border-radius: 5px;  height: 49px; width: 40vh;"
              type="text"
              class="form-control"
              placeholder="Usuário"
            />-->
          </v-flex>
        </v-layout>
        <v-layout row wrap>
          <v-flex xs3 sm3>
            <v-text-field
              :disabled="logando"
              type="password"
              label="Password"
              style="margin-left:60px; width: 44vh;"
              v-model="senha"
              solo
            ></v-text-field>
            <!-- <input
              :disabled="logando"
              v-model="senha"
              style="border: 2px solid DimGray; border-radius: 5px;  height: 49px; width: 40vh;"
              type="password"
              class="form-control"
              placeholder="Senha"
            />-->
          </v-flex>
        </v-layout>

        <v-layout row wrap>
          <v-flex xs3 sm3>
            <v-btn
              :disabled="logando"
              type="submit"
              style="margin-left:60px;height:6vh; width:44vh; border-radius: 2px;"
              @click.prevent.stop="funcLogin"
              color="#92b7ef"
            >Entrar</v-btn>
          </v-flex>
        </v-layout>
        <v-layout row wrap>
          <v-flex xs3 sm3>
            <v-btn
              type="submit"
              style="margin-left:60px; height:6vh; width:44vh; border-radius: 2px;"
              @click.prevent.stop="cadastrar"
              color="#2154a0"
            >Cadastrar-se Agora</v-btn>
          </v-flex>
        </v-layout>
      </v-card>
    </v-app>
  </div>
</template>

<script>
import axios from "../axios/client.js";
export default {
  data() {
    return {
      dialog: false,
      msg: "",
      senha: "",
      login: "",
      usuario: {},
      logando: false
    };
  },
  methods: {
    turna: function() {
      this.$router.push({ name: "addturma" });
    },
    cadastrar: function() {
      this.$router.push({ name: "addusuario" });
    },
    funcLogin: function() {
      this.logando = true;
      this.dialog = false;
      //console.log(this.usuario);
      if (this.login == "") {
        this.logando = false;
        this.msg = "Dados de usuário e senha estão incorretos!";
        this.dialog = true;
        this.senha = "";
      } else if (this.senha == "") {
        this.logando = false;
        this.msg = "Dados de usuário e senha estão incorretos!";
        this.dialog = true;
        this.senha = "";
      } else {
        // console.log(this.login);
        this.usuario.senha = this.senha;
        this.usuario.login = this.login;
        //console.log(this.usuario.senha);
        // console.log(this.usuario);

        axios
          .post("/login", this.usuario)
          .then(response => {
            console.log(response);
            if (response.data.length !== 0) {
              sessionStorage.setItem("contas_logado", "true");
              sessionStorage.setItem(
                "contas_login",
                JSON.stringify(response.data)
              );
              this.logando = false;
              this.$emit("funcaoLogin");
            } else {
              this.logando = false;
              // this.msg = response.data;
              this.msg = "Usuário e senha inválidos";
              this.dialog = true;
              this.usuario.senha = "";
            }
          })
          .catch(e => {
            this.logando = false;
            this.msg = "Sem conexão com o servidor, tente novamente.";
            this.dialog = true;
            this.usuario.usuario = "";
            this.usuario.senha = "";
          });
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.Fundo {
  background-image: url(/static/fundo3.jpg);
  background-size: cover;
}
#inspire {
  background: none;
  height: 60%;
}
</style>
