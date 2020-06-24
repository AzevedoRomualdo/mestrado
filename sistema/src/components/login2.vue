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
      <v-content fluid grid-list-xl>
        <v-layout row wrap style="margin-left:96vh; margin-top:320px">
          <span style="color:black; font-size:46px; ">Login</span>
        </v-layout>
        <v-layout row wrap style="margin-left: 85vh; padding: 16px 0;">
          <v-flex xs3 sm3>
            <input
              :disabled="logando"
              v-model="login"
              style="border: 2px solid DimGray; border-radius: 5px;  height: 49px; width: 40vh;"
              type="text"
              class="form-control"
              placeholder="Usuário"
            />
          </v-flex>
        </v-layout>
        <v-layout row wrap style="margin-left: 85vh; padding: 16px 0;">
          <v-flex xs3 sm3>
            <input
              :disabled="logando"
              v-model="senha"
              style="border: 2px solid DimGray; border-radius: 5px;  height: 49px; width: 40vh;"
              type="password"
              class="form-control"
              placeholder="Senha"
            />
          </v-flex>
        </v-layout>

        <v-layout row wrap style="margin-left: 84vh;">
          <v-flex xs3 sm3>
            <v-btn
              :disabled="logando"
              type="submit"
              style="height:5vh; width:40vh; border-radius: 5px;"
              @click.prevent.stop="funcLogin"
              color="#92b7ef"
            >Entrar</v-btn>
          </v-flex>
        </v-layout>
        <v-layout row wrap style="margin-left: 84vh;">
          <v-flex xs3 sm3>
            <v-btn
              type="submit"
              style="height:5vh; width:40vh; border-radius: 5px;"
              @click.prevent.stop="cadastrar"
              color="#2154a0"
            >Cadastrar-se Agora</v-btn>
          </v-flex>
        </v-layout>
        <!-- <v-layout row wrap style="margin-left: 84vh;">
          <v-flex xs3 sm3>
            <v-btn
              type="submit"
              style="height:5vh; width:40vh; border-radius: 5px;"
              @click.prevent.stop="turna"
              color="#2154a0"
            >Turma</v-btn>
          </v-flex>
        </v-layout>-->
      </v-content>
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
        this.usuario.senha = this.senha;
        this.usuario.login = this.login;
        //console.log(this.usuario.senha);
        console.log(this.usuario);

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
  background-image: url(/static/FUNDO.png);
  background-size: cover;
}
#inspire {
  background: none;
  height: 60%;
}
</style>
