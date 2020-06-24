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
    
    <v-card style="margin-left: 20vh; margin-top: 15vh; margin-right: 20vh">
      <v-layout row wrap style="margin-left:6vh; ">
        <span style="color:black; font-size:36px; ">Cadastro de Turmas</span>
      </v-layout>

      <v-layout row wrap style="margin-left: 5vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Nome da Turma:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="turma.nome"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="text"
            class="form-control"
          />
        </v-flex>

        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Periodo:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="turma.periodo"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="text"
            class="form-control"
          />
        </v-flex>
        <v-flex xs3 sm3 style="margin-left:60vh">
                <h1>Lista de Turmas</h1>
              </v-flex>
      </v-layout>

      <v-layout row wrap style="margin-left: 117vh;">
        <v-flex xs3 sm3>
          <!-- <v-btn
            type="submit"
            style="height:5vh; width:40vh; color:black; border-radius: 5px;"
            @click.prevent.stop="cadastrar"
            color="#92b7ef"
          >Cadastrar Turma</v-btn> -->

           <v-btn
          v-if="id == ''"
            color="#2154a0"
            style="margin-left:160vh; color:white; margin-top: 7vh;"
            @click="cadastrar"
          >Salvar</v-btn>
          <v-btn
          v-else
            color="#2154a0"
            style="margin-left:160vh; color:white; margin-top: 7vh;"
            @click="alterar"
          >Alterar</v-btn>
        </v-flex>
      </v-layout>

       <v-btn
          v-if="id == ''"
            color="#2154a0"
            style="margin-left:160vh; color:white; margin-top: 7vh;"
            @click="cadastrar"
          >Salvar</v-btn>
          <v-btn
          v-else
            color="#2154a0"
            style="margin-left:160vh; color:white; margin-top: 7vh;"
            @click="alterar"
          >Alterar</v-btn>
    </v-card>
  </section>
</template>
<script>
import axios from "../axios/client.js";
import Vue from "vue";

export default {
  data() {
    return {
      e1: 0,
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
      dialogServico:false,
      msgServico:"",
      turma: {
        nome: "",
        periodo: "",
      },
      usuario: ""
    };
  },

  methods: {
    formulario: function() {
      this.$router.push({ name: "formulario" });
    },

    passo2: function() {
      if (
        this.turma.nome == "" ||
        this.turma.periodo == "" 
      ) {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Preencha os campos obrigatorios";
        return;
      } else {
        this.e1 = 3;
      }
    },
    passo1: function() {
      if (this.turma.nome == "" || this.turma.periodo == "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Preencha os campos obrigatorios";
        return;
      } else {
        this.e1 = 2;
      }
    },

alterar: function() {
      if (this.$route.params.id) {
        this.id = this.$route.params.id;
        ("");
       if (
        this.turma.nome == "" ||
        this.turma.periodo == ""
      ) {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Preencha os campos obrigatorios";
        return;
      } else {
         
            axios
              .put("editturma/" + this.id, this.turma)
              .then(response => {
                this.msgServico = "Turma alterada com sucesso";
                this.dialogServico = true;
                this.$router.push({name:"turma"})
              })
              .catch(e => {
                console.log(e);
              });
          
        }
      }
    },
    carregar() {
      if (this.$route.params.id) {
        this.id = this.$route.params.id;
        axios
          .get("turma/" + this.id)
          .then(response => {
            console.log(response.data)
            this.turma.nome = response.data[0].nome;
            this.turma.periodo = response.data[0].periodo;
            this.turma.idusuario = response.data[0].id_usuario;
            
          })
          .catch(e => {});
      }
    },
   
    cadastrar: function() {

      if (this.turma.nome == "" || this.turma.periodo == "")
       {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Preencha os campos obrigatorios";
        return;
      } else {
        axios
          .post("/addturma", this.turma)
          .then(response => {
            //console.log(response)
            if (response.data !== false) {
              this.cor = "green";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Turma Cadastrada com sucesso";
              this.$router.push({ name: "turma" });
            } else {
              this.cor = "red";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Essa turma já existe";
              return;
            }
          })

          .catch(e => {
            console.log(e);
          });
      }
    }
  },
  created: function() {
    this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));

    console.log(this.usuario);
    // if (!this.validacaoRequiredField()) {
      
    this.turma.idusuario = this.usuario[0].id;
   this.carregar();
  }
};
</script>
<style scoped>
</style>