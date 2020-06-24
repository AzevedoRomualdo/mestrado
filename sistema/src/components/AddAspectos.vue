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
    
    <v-card style="margin-left: 20vh; margin-right: 20vh">
      <v-layout row wrap >
         <v-flex xs3 sm3 style="margin-top:3vh ">
           <span style="color:black; font-size:22px; ">Dados do Formulário</span>
         </v-flex>
      </v-layout>


       <v-layout row wrap style="margin-left: 5vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Nome do formulário:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="formulario.nome"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            readonly
            type="text"
            class="form-control"
          />
        </v-flex>

         <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Instruções:</label>
        </v-flex>
        
        <v-flex xs3 sm3>
          <input
            v-model="formulario.instrucoes"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
           readonly
            type="text"
            class="form-control"
          />
        </v-flex>
       </v-layout>
        <v-layout class="row">
          <v-flex xs3 sm12 style="margin-left: 5vh;margin-right: 5vh; margin-top:3vh">
            <v-divider></v-divider>
          </v-flex>
        </v-layout>
         <v-layout class="row" >
         <v-flex xs3 sm3 style="margin-top:3vh; margin-left:-5vh ">
           <span style="color:black; font-size:22px; ">Novo Aspecto</span>
         </v-flex>
      </v-layout>
      <v-layout row wrap style="margin-left: 5vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Item:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="listaspectos.descricao"
            style=" border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="text"
            class="form-control"
          />
        </v-flex>
        <v-flex xs3 sm1 style="margin-top:-1vh" >
          <v-btn class="mx-2" fab dark small color="#006db5" @click="addaspecto">
            <v-icon dark>add</v-icon>
          </v-btn>
        </v-flex>
       
      </v-layout>

      <v-layout row wrap>
         <v-flex xs3 sm12 >
          <v-data-table
                :headers="headers"
                hide-details
                :items="listadd"
                class="elevation-1"
                hide-actions
                style="text-align: center; margin-top:30px; margin-left:30px; margin-right:30px"
              >
                <template slot="items" slot-scope="props">
                  <td>{{props.item.id}}</td>
                  <td>{{props.item.descricao}}</td>
                </template>
              </v-data-table>
             </v-flex>
      </v-layout>

       <v-btn
            color="#2154a0"
            style="margin-left:160vh; color:white; margin-top: 7vh;"
            @click="cadastrar"
          >Salvar</v-btn>
        
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
      listadd: [],
      model: null,
      headers: [
        { text: "Id_Formulário", align: "center;", sortable: false },
        { text: "Item", align: "center;", sortable: false },
      ],
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
      listaspectos:{
        id:"",
        descricao:""
      },
      aspectos: {
        item: [],
        id_usuario:"",
        id_formulario:""
        
      },
       formulario: {
        nome: "",
        instrucoes: "",
      },
      usuario: ""
    };
  },

  methods: {
    formulario: function() {
      this.$router.push({ name: "formulario" });
    },
    addaspecto: function(){
      this.listaspectos.id = this.id
        this.listadd.push(this.listaspectos);
        this.listaspectos = {};
        console.log(this.listadd)
    },
   

    alterar: function() {
      if (this.$route.params.id) {
        this.id = this.$route.params.id;
       if (
        this.aspectos.item == "" 
      ) {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Preencha os campos obrigatórios";
        return;
      } else {
         
            axios
              .put("editaspectos/" + this.id, this.aspectos)
              .then(response => {
                this.msgServico = "Turma alterada com sucesso";
                this.dialogServico = true;
                this.$router.push({name:"aspectos"})
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
          .get("formulario/" + this.id)
          .then(response => {
            this.formulario.nome = response.data[0].nome;
            this.formulario.instrucoes = response.data[0].instrucoes;
            
            
          })
          .catch(e => {});
      }
    },
   
    cadastrar: function() {
      if (this.listaspectos == [])
       {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "informe pelo menos um aspecto";
        return;
      } else {
        axios
          .post("/addaspectos", this.listadd)
          .then(response => {
            //console.log(response)
            if (response.data !== false) {
              this.cor = "green";
              this.snackbar = true;
              this.nomeCampo = "";
              this.listadd = [];
              this.textoAlerta = "Aspecto Cadastrado com sucesso";
              this.$router.push({ name: "aspectos" });
            } else {
              this.cor = "red";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Esse Aspecto já existe";
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
    this.aspectos.id_formulario = this.$route.params.id;    
    this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
    //console.log(this.usuario);
    // if (!this.validacaoRequiredField()) {  
    this.aspectos.id_usuario = this.usuario[0].id;
     // console.log(this.aspectos);
   this.carregar();
  }
};
</script>
<style>
.theme--light.v-table thead th {
  background-color: #006db5 !important;
  color: white !important;
}

.test {
  text-align: left !important;
  font-weight: bold !important;
}
.theme--light.v-pagination .v-pagination__item {
  background: #fff !important;
  color: #006db5 !important;
  width: auto !important;
  min-width: 34px !important;
  padding: 0 5px !important;
}
.theme--light.v-pagination .v-pagination__item--active {
  background: #006db5 !important;
  color: #fff !important;
}
</style>