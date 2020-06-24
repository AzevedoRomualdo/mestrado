<template>
  <v-content>
    <v-layout row justify-center>
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

        <v-btn color="white" flat @click="snackbar = false"></v-btn>
      </v-snackbar>

      <v-dialog v-model="responder" persistent max-width="1100">
        <v-card>
          <v-card-title class="headline">Responder Atividade</v-card-title>

          <v-card-text>
            <input
              type="file"
              id="exemplo"
              title="Selecione um arquivo"
              @change="uploadFile"
              ref="files"
            />
            <!-- <v-layout class="row">
               <v-flex xs12 sm6>
        <v-text-field
        label = "Nome"
        v-model="respostaAtividade.nome"
         style="width: 56vh;">
        </v-text-field>
    </v-flex>
   <v-flex xs12 sm6>
        <v-text-field
         v-model="respostaAtividade.descricao"
        label = "Descrição"
         style="width: 56vh;">
        </v-text-field>
    </v-flex>
            </v-layout>-->
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="sucess" flat @click="responder = false">Cancelar</v-btn>
            <v-btn color="blue" flat @click="salvaResposta">Salvar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>

    <v-layout row wrap style="margin-left:2vh; margin-top:5vh">
      <v-flex xs12 sm1>
        <h2>Revisar</h2>
      </v-flex>

      <!-- <v-flex xs12 sm8>
    <v-btn
            color="#2154a0"
            style="margin-left:1020px; color:white; "
            @click="ratividade"
          >Responder Atividade</v-btn>
      </v-flex>-->
    </v-layout>
    <v-card style="margin-left:26px; margin-right:26px">
      <v-layout row wrap style=" margin-top:6vh">
        <v-flex xs2 sm3 style="margin-left:6px">
          <label style="font-size: 18px;font-weight: bold">Nome:</label>
          <span style="font-size: 16px;">{{dadosAtividade.natividade}}</span>
          <!-- <v-text-field
        readonly
        label = "Nome"
        v-model="dadosAtividade.natividade"
         style="width: 96vh;">
          </v-text-field>-->
        </v-flex>
        <v-flex xs2 sm7 style="margin-left: 200px">
          <label style="font-size: 18px; font-weight: bold;">Descrição:</label>
          <span style=" font-size: 16px;">{{dadosAtividade.descricao}}</span>
          <!-- <v-text-field
        readonly
         v-model="dadosAtividade.descricao"
        label = "Descrição"
         style="width: 96vh;">
          </v-text-field>-->
        </v-flex>
      </v-layout>
      <v-layout row wrap style="margin-top:8vh;">
        <v-flex xs2 sm4 style="margin-left:28px">
          <label style="font-size: 18px; font-weight: bold">Instruções:</label>
          <span style="font-size: 16px;">{{dadosAtividade.instrucoes}}</span>
          <!-- <v-text-field
        readonly
        label = "Instruções"
         v-model="dadosAtividade.instrucoes"
         style="width: 96vh;">
          </v-text-field>-->
        </v-flex>
      </v-layout>
      <v-layout row wrap style="margin-top:8vh;">
        <v-flex xs12 sm6>
          <label style="font-size: 18px; font-weight: bold">Instruções de Envio:</label>
          <span style="font-size: 16px;">{{dadosAtividade.instenvio}}</span>
          <!-- <v-text-field
        readonly
        label = "Instruções de envio"
        v-model="dadosAtividade.instenvio"
         style="width: 95vh;">
          </v-text-field>-->
        </v-flex>
        <v-flex xs12 sm2 style="margin-left: 6px">
          <label style=" font-size: 18px; font-weight: bold">Data início:</label>
          <span style="font-size: 18px;">{{dadosAtividade.dtinicio}}</span>
          <!-- <v-text-field
        readonly
        label = "Data inicio"
        v-model="dadosAtividade.dtinicio"
         style="width: 30vh;">
          </v-text-field>-->
        </v-flex>
        <v-flex xs12 sm2>
          <label style="font-size: 18px; font-weight: bold">Data fim:</label>
          <span style="font-size: 18px;">{{dadosAtividade.dtfim}}</span>
          <!-- <v-text-field
        readonly
        label = "Data fim"
        v-model="dadosAtividade.dtfim"
         style="width: 30vh;">
          </v-text-field>-->
        </v-flex>
        <!-- <v-flex xs12 sm2>
       <label style = " font-size: 18px; font-weight: bold">Envio Atrasados:</label>
        <span style="font-size: 18px;">{{dadosAtividade.enviosatrasadas}}</span>-->
        <!-- <v-text-field
        readonly
        label = "Envio Atrasados"
        v-model="dadosAtividade.enviosatrasados"
         style="width: 28vh;">
        </v-text-field>-->
        <!-- </v-flex> -->
      </v-layout>
    </v-card>

    <v-layout row wrap style="margin-left:2vh; margin-top:5vh">
      <v-flex xs12 sm1>
        <h2>Formulário</h2>
      </v-flex>
    </v-layout>

    <v-layout row wrap style="margin-left:9vh; margin-top:3vh">
      <v-flex xs12 sm6>
        <v-text-field readonly label="Nome" v-model="dadosAtividade.nome" style="width: 96vh;"></v-text-field>
      </v-flex>
      <v-flex xs12 sm6>
        <v-text-field
          readonly
          label="Instruções"
          v-model="dadosAtividade.fintruces"
          style="width: 96vh;"
        ></v-text-field>
      </v-flex>
    </v-layout>
    <v-layout row wrap style="margin-left:2vh; margin-top:5vh">
      <v-flex xs12 sm1>
        <h4>Aspectos</h4>
      </v-flex>
    </v-layout>

    <v-layout
      v-for="item in listaaspectos"
      :key="item.id_aspectos"
      row
      wrap
      style="margin-left:9vh; margin-top:3vh"
    >
      <v-flex xs12 sm6>
        <v-text-field readonly label="Descrição" v-model="item.item" style="width: 96vh;"></v-text-field>
      </v-flex>
      <v-flex xs12 sm4>
        <v-text-field readonly label="Nota" v-model="item.nota" style="width: 96vh;"></v-text-field>
      </v-flex>
    </v-layout>
  </v-content>
</template>

<script>
var fileUpload;
var file;
import axios from "../axios/client.js";
import Vue from "vue";
export default {
  data() {
    return {
      cor: "",
      snackbar: false,
      nomeCampo: "",
      textoAlerta: "",
      id: "",
      dadosAtividade: {},
      listaaspectos: [],
      responder: false,
      respostaAtividade: {
        id_usuario: "",
        id_atividade: "",
        diagrama: ""
      },
      usuario: ""
    };
  },
  methods: {
    getBase64: function() {
      var reader = new FileReader();
      reader.readAsDataURL(fileUpload);
      reader.onload = function() {
        file = reader.result;
      };
      reader.onerror = function(error) {
        console.log("Error: ", error);
        this.msgAviso = "Erro ao importar arquivo!";
        this.dialogAviso = true;
        return;
      };
    },
    uploadFile: function() {
      fileUpload = this.$refs.files.files[0];

      // console.log(fileUpload.type);
      // if (
      //   fileUpload.type !=
      //    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" &&
      //   fileUpload.type != "application/vnd.ms-excel"
      // ) {
      //   fileUpload = null;
      //   this.msgAviso = "Arquivo inválido";
      //   this.dialogAviso = true;
      //   document.getElementById("fileUpload").value = "";
      //   return;
      // }
      this.getBase64();
    },

    salvaResposta: function() {
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      console.log(this.usuario);
      this.respostaAtividade.id_usuario = parseInt(this.usuario[0].id);
      this.respostaAtividade.id_atividade = parseInt(this.id);
      this.respostaAtividade.diagrama = file;
      axios
        .post("/respostasatividade", this.respostaAtividade)
        .then(response => {
          if (response.data !== false) {
            this.cor = "green";
            this.snackbar = true;
            this.nomeCampo = "";
            this.textoAlerta = "Resposta submetida com sucesso";
            //this.$router.push({ name: "listasolicitacao" });
          } else {
            this.cor = "red";
            this.snackbar = true;
            this.nomeCampo = "";
            this.textoAlerta = "ERRO, resposta não cadastrada";
            return;
          }
          console.log(Response);
          this.responder = false;
        });
    },
    ratividade: function() {
      this.responder = true;
    },
    carregar: function() {
      this.id = this.$route.params.id;

    //  this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
     // console.log(this.id);
      axios
        .get("/visualizaratividade/" + this.id)
        .then(response => {
          this.dadosAtividade = response.data[0];

          axios
            .get("/aspectos/" + this.dadosAtividade.id_formulario)
            .then(response => {
              console.log(this.dadosAtividade);
              this.listaaspectos = response.data;
            });
          if (this.dadosAtividade.enviosatrasados == 1) {
            this.dadosAtividade.enviosatrasados = "Sim";
          } else {
            this.dadosAtividade.enviosatrasados = "Não";
          }
        })
        .catch(e => {});
    }
  },
  created: function() {
    //   this.CarregarAtividade();
    this.carregar();
  }
};
</script>
<style scoped>
</style>