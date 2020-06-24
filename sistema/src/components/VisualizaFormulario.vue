<template>
  <section class="content" data-app>
     <v-layout row justify-center>
      <v-dialog v-model="dialog2" persistent max-width="590">
        <v-card>
          <v-card-title class="headline">Editar aspecto</v-card-title>
          <v-card-text>
          <v-layout row wrap style="margin-left: 5vh; padding: 16px 0;">
              <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
                <label>Item:</label>
              </v-flex>
              <v-flex xs3 sm3>
                <input
                  v-model="dadosaspecto.item"
                  style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
                  
                  type="text"
                  class="form-control"
                />
              </v-flex>
          </v-layout>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" flat @click="dialog2 = false">Não</v-btn>
            <v-btn color="green darken-1" flat @click="editSim">Sim</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

    <v-dialog v-model="dialog3" persistent max-width="590">
        <v-card>
          <v-card-title class="headline">Aviso</v-card-title>
          <v-card-text>Deseja realmente excluir esse Aspecto</v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" flat @click="dialog3 = false">Não</v-btn>
            <v-btn color="green darken-1" flat @click="deleteSim">Sim</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

    </v-layout>
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
        <span style="color:black; font-size:24px; margin-top:10px ">Formulário de Avaliação</span>
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
      <v-layout  style="margin-left:30px; margin-right:30px; margin-top:30px ">
        <v-divider>
        </v-divider>
      </v-layout>
      <v-layout row wrap style="margin-left:6vh; ">
        <span style="color:black; font-size:24px; margin-top:10px ">Lista de Aspectos</span>
      </v-layout>
      <v-layout row wrap>
         <v-flex xs3 sm12 >
          <v-data-table
                :headers="headers"
                hide-details
                :items="listaAspectos"
                class="elevation-1"
                hide-actions
                style="text-align: center; margin-top:30px; margin-left:30px; margin-right:30px"
              >
                <template slot="items" slot-scope="props">
                
                  <td>{{props.item.item}}</td>
                  <td>
                  <v-icon
                    style="color:black; "
                    class="mr-2"
                    @click="editItem(props.item)"
                  >edit</v-icon>
                  <v-icon
                    style="color:black;"
                    class="mr-2"
                    @click="deletItem(props.item)"
                  >delete</v-icon>
                 
                </td>
                </template>
              </v-data-table>
             </v-flex>
      </v-layout>
      <v-layout  style=" margin-top:30px; ">
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
      e1: 0,
      view: 0,
      dialog: false,
      dialog2: false,
      dialog3: false,
      visible: false,
      enabledSave: true,
      items: [],
      model: null,
      listaAspectos:[],
      show: false,
      event: null,
      dadosaspecto:[],
      id: "",
      snackbar: false,
      color: "",
      mode: "",
      y: "",
      x: "",
      textoAlerta: "",
       headers: [
        { text: "Item", align: "center;", sortable: false },
        { text: "Ações", align: "center;", sortable: false },
      ],
      nomeCampo: "",
      cor: "",
      dialogServico:false,
      msgServico:"",
      formulario: {
        nome: "",
        instrucoes: "",
      },
      usuario: ""
    };
  },

   methods: {

 editItem(item) {
      //alert(JSON.stringify(item));
      this.dadosaspecto = item
     this.dialog2 = true
    },

    editSim() {
      console.log( this.dadosaspecto)
       axios
              .put("editaspectos/" + this.dadosaspecto.id_aspectos, this.dadosaspecto)
              .then(response => {
                  
                if (response.data !== false) {
              this.cor = "green";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Aspecto alterado com sucesso";
              this.dialog2 = false
              this.dadosaspecto = [];
            } 
              })
              .catch(e => {
                console.log(e);
              });


    },

    deletItem(item) {
      //alert(JSON.stringify(item));
      this.dadosaspecto = item
     this.dialog3 = true
    },

    deleteSim() {
      axios
        .delete("/excluiraspecto/" + this.dadosaspecto.id_aspectos)
        .then(response => {
          if (response.data == true) {

            this.cor = "green";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Aspecto excluído com sucesso";
              this.dialog3 = false
              this.carregar();

            //this.dialog3 = false;
           // this.dialogServico = true;
            //this.msgServico = "Aspecto excluído com sucesso";
            //this.dadosaspecto();
            //this.PreencheCabechalho();
          }
        })
        .catch(e => {
          this.msgErro = "Erro ao carregar";
        });
    },

alterar: function() {
      if (this.$route.params.id) {
        this.id = this.$route.params.id;
        ("");
       if (
        this.formulario.nome == "" ||
        this.formulario.instrucoes == ""
      ) {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Preencha os campos obrigatóris";
        return;
      } else {
         
            axios
              .put("editformulario/" + this.id, this.formulario)
              .then(response => {
                this.msgServico = "Turma alterada com sucesso";
                this.dialogServico = true;
                this.$router.push({name:"formulario"})
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
            console.log(response.data)
            this.formulario.nome = response.data[0].nome;
            this.formulario.instrucoes = response.data[0].instrucoes;
            this.formulario.idusuario = response.data[0].id_usuario;
            this.formulario.id_formulario = response.data[0].id_formulario;
            
          })
          .catch(e => {});

           axios
          .get("aspectos/" + this.id)
          .then(response => {
            console.log(response.data)
            this.listaAspectos = response.data;
            
          })
          .catch(e => {});
      }
    },
    
    form(formulario) {
      //alert(JSON.stringify(item));
      console.log(formulario)
      let url = "/aspectos/" + this.formulario.id_formulario;
      this.$router.push(url);
    },
   
    cadastrar: function() {

      if (this.formulario.nome == "" || this.formulario.instrucoes == "")
       {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Preencha os campos obrigatorios";
        return;
      } else {
        axios
          .post("/addformulario", this.formulario)
          .then(response => {
            console.log(response)
            if (response.data !== false) {
              this.cor = "green";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Formulário cadastrado com sucesso";
              this.$router.push({ name: "formulario" });
            } else {
              this.cor = "red";
              this.snackbar = true;
              this.nomeCampo = "";
              this.textoAlerta = "Esse formulário já existe";
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
      
    this.formulario.idusuario = this.usuario[0].id;
   this.carregar();
  }
};
</script>
<style>
.theme--light.v-table thead th {
  background-color: #006db5 !important;
  color: white !important;
}
</style>