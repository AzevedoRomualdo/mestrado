<template>
  <section class="content" data-app>
    <v-snackbar
      v-model="snackbar"
      :bottom="y === 'bottom'"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      :timeout="4000"
      :top="y === 'top'"
      :vertical="mode === 'vertical (mobile)'"
      :color="this.cor"
    >
      {{ textoAlerta }}
      &nbsp;
      <b>{{ nomeCampo }}</b>

      <v-btn color="white" flat @click="snackbar = false">Ok!</v-btn>
    </v-snackbar>
    <v-card style="margin-left: 30vh; margin-top: 15vh; margin-right: 30vh">
      <v-layout row wrap style="margin-left:46vh; ">
        <span style="color:black; font-size:46px; ">Cadastro de Usuário</span>
      </v-layout>
      <v-layout row wrap style="margin-left: 40vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Tipo:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <select
            class="listteste"
            v-model="usuario.tipo"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
          >
            <option value="1">Professor</option>
            <option value="2">Aluno</option>
          </select>
        </v-flex>
      </v-layout>
      <v-layout row wrap style="margin-left: 40vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Nome:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="usuario.nome"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="text"
            class="form-control"
          />
        </v-flex>
        <v-spacer></v-spacer>
      </v-layout>
      <v-layout row wrap style="margin-left: 40vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh;">
          <label>Siape ou Matricula:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="usuario.matricula"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="text"
            class="form-control"
          />
        </v-flex>
        <v-spacer></v-spacer>
      </v-layout>

<v-layout row wrap style="margin-left: 40vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh;">
          <label>E-mail</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="usuario.email"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="text"
            class="form-control"
          />
        </v-flex>
        <v-spacer></v-spacer>
      </v-layout>

      <v-layout row wrap style="margin-left: 40vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Universidade:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <select
            v-model="usuario.universidade"
            class="listteste"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
          >
            <option value="Universidade Federal do Amazonas">Universidade Federal do Amazonas</option>
          </select>
        </v-flex>
      </v-layout>
      <v-layout row wrap style="margin-left: 40vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Senha:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="usuario.senha"
            style="border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="password"
            class="form-control"
            placeholder="Senha"
          />
        </v-flex>
      </v-layout>
      <v-layout row wrap style="margin-left: 57vh;">
        <v-flex xs3 sm3>
          <v-btn
            type="submit"
            style="height:5vh; width:40vh; border-radius: 5px;"
            @click.prevent.stop="cadastrar"
            color="#92b7ef"
          >Cadastrar usuário</v-btn>
        </v-flex>
      </v-layout>
    </v-card>
  </section>
</template>
<script>
import axios from "../axios/client.js";
import Vue from "vue";

export default {
  data() {
    return {
      view: 0,
      dialog: false,
      dialog2: false,
      visible: false,
      enabledSave: true,
      items: [],
      model: null,

      show: false,
      event: null,
      id: "",
      snackbar: false,
      color: "",
      mode: "",
      y: "",
      x: "",
      textoAlerta: "",
      nomeCampo: "",
      cor: "",
      usuario: {
        tipo: "",
        nome: "",
        matricula: "",
        email: "",
        universidade: "",
        senha: ""
      }
    };
  },

  methods: {
    validacaoRequiredField: function() {
      if (this.usuario.tipo === null || this.usuario.tipo === "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }

      if (this.usuario.nome === null || this.usuario.nome === "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }

      if (this.usuario.matricula === null || this.usuario.matricula === "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }

if (this.usuario.email === null || this.usuario.email === "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }

      if (
        this.usuario.universidade === null ||
        this.usuario.universidade === ""
      ) {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }
      if (this.usuario.senha === null || this.usuario.senha === "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }
    },
    cadastrar: function() {
      if (!this.validacaoRequiredField()) {
        axios
          .post("/usuario", this.usuario)
          .then(response => {
            if (response.data !== false) {
              this.cor = "green";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Usuário cadastrado com sucesso";
              this.$router.push({ name: "login" });
            } else {
              this.cor = "red";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Esse Usuário já existe";
              return;
            }
          })

          .catch(e => {
            console.log(e);
          });
      }
    }
  }
};
</script>
<style scoped>
</style>


