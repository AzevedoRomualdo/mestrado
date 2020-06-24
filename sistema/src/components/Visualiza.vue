<template>
  <section class="content" data-app>
    <v-dialog v-model="dialogServico" persistent width="350">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Aviso</v-card-title>

        <v-card-text>
          <span class="title mb-4">{{msgServico}}</span>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="sucess" flat @click="dialogServico = false">Entendi</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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

    <v-stepper v-model="e1" style="margin-left:50px; margin-top:30px; margin-right:50px">
      <v-stepper-header>
        <v-stepper-step :complete="e1 > 1" color="blue" step="1">Passo 1</v-stepper-step>

        <v-divider></v-divider>

        <v-stepper-step :complete="e1 > 2" color="blue" step="2">Passo 2</v-stepper-step>

        <v-divider></v-divider>

        <v-stepper-step :complete="e1>3" color="blue" step="3">Passo 3</v-stepper-step>
        <v-divider></v-divider>

        <v-stepper-step step="4" color="blue">Passo 4</v-stepper-step>
      </v-stepper-header>

      <v-stepper-items>
        <!-- item1 -->
        <v-stepper-content step="1">
          <v-layout row wrap style="margin-left:6vh; ">
            <span style="color:black; font-size:36px; ">Definições da Atividade</span>
          </v-layout>

          <v-layout row wrap style="margin-top:2vh; ">
            <v-flex xs3 sm3>
              <label for="ge-text-input" style="margin-left:4vh;">
                <span style="font-size: 20px;">Nome da Atividade:</span>
              </label>
              <v-flex xs3 sm3>
                <input
                  v-model="atividade.nome"
                  style="margin-left:13vh; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 60vh;"
                  type="text"
                  readonly
                  class="form-control"
                />
              </v-flex>
            </v-flex>
          </v-layout>
          <v-layout row wrap style=" padding: 16px 0;">
            <v-flex xs3 sm3>
              <label for="ge-text-input" style="margin-left:8vh;">
                <span style="font-size: 20px;">Descrição da Atividade:</span>
              </label>
              <v-flex xs3 sm3>
                <input
                  v-model="atividade.descricao"
                  style="margin-left:13vh; border: 2px solid DimGray; border-radius: 5px;  height: 79px; width: 60vh;"
                  type="text"
                  readonly
                  class="form-control"
                />
              </v-flex>
            </v-flex>
          </v-layout>

          <v-btn color="#2154a0" style="margin-left:160vh; color:white" @click="passo1">Próximo</v-btn>
        </v-stepper-content>
        <!-- item2 -->
        <v-stepper-content step="2">
          <!-- aqui -->
          <v-layout row wrap style="margin-left:6vh; ">
            <span style="color:black; font-size:36px; ">Configurar Avaliação</span>
          </v-layout>

          <v-layout row wrap style=" padding: 16px 0;">
            <v-flex xs3 sm3>
              <label for="ge-text-input" style="margin-left:4vh;">
                <span style="font-size: 20px;">Instruções para Avaliação:</span>
              </label>

              <v-flex xs3 sm5>
                <input
                  v-model="atividade.instrucao"
                  style="margin-left:9vh;  border: 2px solid DimGray; border-radius: 5px;  height: 79px; width: 155vh;"
                  type="text"
                  readonly
                  class="form-control"
                />
              </v-flex>
            </v-flex>
          </v-layout>

          <v-layout row wrap style=" margin-left:7vh; padding: 16px 0;">
            <v-flex xs3 sm2>
              <label for="ge-text-input">
                <span style="font-size: 20px;">Número de Revisores:</span>
              </label>

              <v-flex xs3 sm3>
                <input
                  v-model="atividade.nrevisores"
                  style="margin-left:1vh;  border: 2px solid DimGray; border-radius: 5px;  height: 49px; width: 28vh;"
                  type="text"
                  readonly
                  class="form-control"
                />
              </v-flex>
            </v-flex>

            <v-flex xs3 sm2>
              <label for="ge-text-input">
                <span style="font-size: 20px;">Número de Rodadas:</span>
              </label>
              <v-flex xs3 sm3>
                <input
                  v-model="atividade.nrodadas"
                  style="margin-left:2vh;  border: 2px solid DimGray; border-radius: 5px;  height: 49px; width: 28vh;"
                  type="text"
                  readonly
                  class="form-control"
                />
              </v-flex>
            </v-flex>

            <v-flex xs3 sm3>
              <label for="ge-text-input" style="margin-left:4vh;">
                <span style="font-size: 20px;">Identificação dos Revisores:</span>
              </label>
              <v-flex xs3 sm4>
                <select
                  class="listteste"
                  v-model="atividade.idrevisores"
                  readonly
                  style="margin-left:7vh; cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 49px; width: 40vh;"
                >
                  <option value="1">Anônimos</option>
                  <option value="2">Conhecidos</option>
                </select>
              </v-flex>
            </v-flex>

            <v-flex xs3 sm4>
              <label for="ge-text-input">
                <span style="font-size: 20px;">O Sistema deve definir os revisores:</span>
              </label>

              <v-flex xs3 sm3>
                <select
                  class="listteste"
                  readonly
                  v-model="atividade.defrevisores"
                  style="margin-left:8vh; cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 49px; width: 45vh;"
                >
                  <option value="1">Sim</option>
                  <option value="2">Não</option>
                </select>
              </v-flex>
            </v-flex>
          </v-layout>

          <v-btn color="#2154a0" style="margin-left:160vh; color:white" @click="passo2">Próximo</v-btn>
        </v-stepper-content>
        <!-- item3 -->
        <v-stepper-content step="3">
          <v-layout row wrap style="margin-left:6vh; ">
            <span style="color:black; font-size:36px; ">Configurar Formulário de Avaliação</span>
          </v-layout>

          <v-layout row wrap style="margin-left: 77vh; margin-top: 7vh;">
            <v-flex xs3 sm3>
              <v-btn
                type="submit"
                style="height:5vh; width:40vh; border-radius: 5px;"
                @click.prevent.stop="formulario"
                color="#92b7ef"
              >Cadastrar Fomulário</v-btn>
            </v-flex>
          </v-layout>

          <v-btn
            color="#2154a0"
            style="margin-left:160vh; color:white; margin-top: 7vh;"
            @click="e1 = 4"
          >Próximo</v-btn>
        </v-stepper-content>
        <!-- item4 -->
        <v-stepper-content step="4">
          <v-layout row wrap style="margin-left:6vh; ">
            <span style="color:black; font-size:36px; ">Configurar Envio</span>
          </v-layout>

          <v-layout row wrap style="padding: 16px 0;">
            <v-flex xs3 sm4>
              <label for="ge-text-input">
                <span style="font-size: 20px;">Instruções para o envio:</span>
              </label>

              <v-flex xs3 sm3>
                <input
                  v-model="atividade.instenvio"
                  style="margin-left:16vh; cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 59px; width: 147vh;"
                  type="text"
                  readonly
                  class="form-control"
                />
              </v-flex>
            </v-flex>
          </v-layout>

          <v-layout row wrap style="margin-left:9vh;padding: 16px 0;">
            <v-flex xs3 sm3>
              <label for="ge-text-input">
                <span style="font-size: 20px;">Identificação dos Autores:</span>
              </label>

              <v-flex xs3 sm3>
                <select
                  class="listteste"
                  readonly
                  v-model="atividade.idautores"
                  style="margin-left:6vh; cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 30vh;"
                >
                  <option value="1">Anônimos</option>
                  <option value="2">Conhecidos</option>
                </select>
              </v-flex>
            </v-flex>
            <v-flex xs3 sm3>
              <label for="ge-text-input">
                <span style="font-size: 20px;">Número Máximo de Anexos:</span>
              </label>
              <v-flex xs3 sm3>
                <select
                  class="listteste"
                  readonly
                  v-model="atividade.numanexos"
                  style="margin-left:5vh; cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 35vh;"
                >
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                </select>
              </v-flex>
            </v-flex>
            <v-flex xs3 sm2>
              <label for="ge-text-input">
                <span style="font-size: 20px;">Limite de Upload:</span>
              </label>

              <v-flex xs3 sm2>
                <select
                  class="listteste"
                  readonly
                  v-model="atividade.limupload"
                  style="margin-left:4vh; cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 22vh;"
                >
                  <option value="1">8</option>
                  <option value="2">10</option>
                  <option value="3">12</option>
                  <option value="4">14</option>
                </select>
              </v-flex>
            </v-flex>
            <v-flex xs3 sm3>
              <label for="ge-text-input">
                <span style="font-size: 20px;">Aceitar Envios Atrasados:</span>
              </label>

              <v-flex xs3 sm3>
                <select
                  class="listteste"
                  readonly
                  v-model="atividade.AcEnvio"
                  style=" margin-left:6vh; cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 30vh;"
                >
                  <option value="1">Sim</option>
                  <option value="2">Não</option>
                </select>
              </v-flex>
            </v-flex>
          </v-layout>

          <v-layout row wrap style="padding: 16px 0;">
            <v-flex xs3 sm5>
              <label for="ge-text-input" style="margin-left:4vh">
                <span style="font-size: 20px;">Upload de arquivo com exemplo de envio:</span>
              </label>

              <v-flex xs3 sm3>
                <input
                  v-model="atividade.exenvio"
                  style="margin-left:15vh; cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 59px; width: 148vh;"
                  type="text"
                  readonly
                  class="form-control"
                />
              </v-flex>
            </v-flex>
          </v-layout>
         
        </v-stepper-content>
      </v-stepper-items>
    </v-stepper>

    <v-card style="margin-left: 30vh; margin-top: 15vh; margin-right: 30vh"></v-card>
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
      atividade: {
        nome: "",
        descricao: "",
        instrucao: "",
        nrevisores: "",
        nrodadas: "",
        idrevisores: "",
        defrevisores: "",
        instenvio: "",
        idautores: "",
        numanexos: "",
        limupload: "",
        AcEnvio: "",
        exenvio: "",
        idusuario: ""
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
        this.atividade.instrucao == "" ||
        this.atividade.nrevisores == "" ||
        this.atividade.nrodadas == "" ||
        this.atividade.idrevisores == "" ||
        this.atividade.defrevisores == ""
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
      if (this.atividade.nome == "" || this.atividade.descricao == "") {
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
        this.atividade.instenvio == "" ||
        this.atividade.idautores == "" ||
        this.atividade.numanexos == "" ||
        this.atividade.limupload == "" ||
        this.atividade.AcEnvio == "" ||
        this.atividade.exenvio == ""
      ) {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Preencha os campos obrigatorios";
        return;
      } else {
         
            axios
              .put("editatividade/" + this.id, this.atividade)
              .then(response => {
                this.msgServico = "Atividade alterada com sucesso";
                this.dialogServico = true;
                this.$router.push({name:"listasolicitacao"})
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
          .get("atividade/" + this.id)
          .then(response => {
            //console.log(response.data)
            this.atividade.nome = response.data[0].nome;
            this.atividade.descricao = response.data[0].descricao;
            this.atividade.instrucao = response.data[0].instrucoes;
            this.atividade.nrevisores = response.data[0].nrevisores;
            this.atividade.nrodadas = response.data[0].nrodadas;
            this.atividade.idrevisores = response.data[0].idenficacaorev;
            this.atividade.defrevisores = response.data[0].defrevisores;
            this.atividade.instenvio = response.data[0].instenvio;
            this.atividade.idautores = response.data[0].identificacaoautores;
            this.atividade.numanexos = response.data[0].nmaxanexos;
            this.atividade.limupload = response.data[0].limiteupload;
            this.atividade.AcEnvio = response.data[0].enviosatrasados;
            this.atividade.exenvio = "dihdihuhu";
            this.atividade.idusuario = response.data[0].id_usuario;
            
          })
          .catch(e => {});
      }
    },
    cadastrar: function() {
      this.atividade.descricao2 = "djhsjhhjds";
      if (
        this.atividade.instenvio == "" ||
        this.atividade.idautores == "" ||
        this.atividade.numanexos == "" ||
        this.atividade.limupload == "" ||
        this.atividade.AcEnvio == "" ||
        this.atividade.exenvio == ""
      ) {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Preencha os campos obrigatorios";
        return;
      } else {
        axios
          .post("/addatividade", this.atividade)
          .then(response => {
            if (response.data !== false) {
              this.cor = "green";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Usuário cadastrado com sucesso";
              this.$router.push({ name: "atividade" });
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
  },
  created: function() {
    this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));

    console.log(this.usuario);
    // if (!this.validacaoRequiredField()) {
    this.atividade.idusuario = this.usuario[0].id;
    this.carregar()
  }
};
</script>
<style scoped>
</style>