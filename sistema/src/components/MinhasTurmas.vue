<template>
  <section class="content" data-app>
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
      </v-layout>

    <v-layout row justify-center>
      <v-dialog v-model="asocTurma" persistent max-width="390">
        <v-card>
          <v-card-title class="headline">Aviso</v-card-title>
          <v-card-text>Deseja realmente se associar a essa Turma?</v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" flat @click="asocTurma = false">Não</v-btn>
            <v-btn color="green darken-1" flat @click="addSim">Sim</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
    <v-layout row justify-center>
      <v-dialog v-model="associarAtividade" persistent max-width="1100">
        <v-card>
          <v-card-title class="headline">Lista de atividades</v-card-title>
          <v-card-text>
            <v-layout class="row">
              <v-flex  xs3 sm12>
                      <v-data-table
              :headers="headers2"
              hide-details
              :items="atividadesLista"
              class="elevation-1"
              hide-actions
              
              style="text-align: center; margin-top:30px; margin-left:30px; margin-right:30px"
            >
              <template slot="items" slot-scope="props">
                <td>{{props.item.nome}}</td>
                <td>{{props.item.descricao}}</td>
                <td>
                  <v-icon
                    title = "Responder Atividade"
                    style="color:black; "
                    class="mr-2"
                    @click=" visualizarAtividade(props.item)"
                  >assignment</v-icon>
                    <v-icon
                    title = "Revisar Atividade"
                    style="color:black; "
                    class="mr-2"
                    @click=" revisar(props.item)"
                  >assignment_turned_in</v-icon>
                </td>
              </template>
            </v-data-table>
              </v-flex>
            </v-layout>

          </v-card-text>
            <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="sucess" flat @click="associarAtividade = false">Fechar</v-btn>
        </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
    <v-layout row justify-center>
      <v-dialog v-model="dialog2" persistent max-width="290">
        <v-card>
          <v-card-title class="headline">Aviso</v-card-title>
          <v-card-text>Deseja realmente excluir essa Turma?</v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" flat @click="dialog2 = false">Não</v-btn>
            <v-btn color="green darken-1" flat @click="deleteSim">Sim</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
    <div class="text-xs-center">
      <v-dialog v-model="loading" hide-overlay persistent width="300">
        <v-card color="sucess">
          <v-card-text>
            Desbloqueando Títulos
            <v-progress-linear indeterminate color="blue" class="mb-0"></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>
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
    <div class="row" >
      <div class="col-sm-12" >
        <div
          class="box box-default color-palette-box"
         
        >
            <v-layout row wrap >

               <v-tooltip bottom>
               <template v-slot:activator="{ on }">
             <v-flex v-on="on" xs3 sm3 style="margin-top:4vh">
                  
                <h1>Minhas Turmas</h1>
              </v-flex>
      </template>
      <span>Nesta tela você encontra
              as turmas em que está associado. Se você deseja se associar em alguma turma
              vá até o menu e clique em TURMAS, 
              mas se você deseja visualizar as atividades repassadas
              as turmas em que você está cadastrado clique em ATIVIDADES.</span>
    </v-tooltip>

            

                
             
            
           
              
               
              <v-flex v-if="usuario[0].tipo==1" xs3 sm9 style="margin-left:130vh">
                <v-btn color="#006DB5" fab dark>
                  <v-icon @click.prevent.stop="novaMeta">description</v-icon>
                </v-btn>
              </v-flex>

            </v-layout>
            
            <!--  -->
            <v-data-table
              :headers="headers"
              hide-details
              :items="itens"
              class="elevation-1"
              hide-actions
              :search="search"
              :pagination.sync="pagination"
              :rows-per-page-items="[tamanho]"
              style="text-align: center; margin-top:30px; margin-left:30px; margin-right:30px"
            >
              <template slot="items" slot-scope="props">


                <td>{{props.item.nome}}</td>
                <td>{{props.item.periodo}}</td>
        
        
                <td>
                      <!-- <v-tooltip top> -->
                  <v-icon
                  title = "Visualizar Atividades"
                    style="color:black; "
                    class="mr-2"
                    @click=" associar(props.item)"
                  >font_download</v-icon>
                  <!-- <span>teste -->
                  <!-- </span> -->
                   <!-- </v-tooltip> -->
                  <!-- <md-tooltip md-direction="top" :style="tooltipActive.estilo">{{tooltipActive.mensagem}}</md-tooltip> -->
                </td>

               
              </template>
            </v-data-table>
            <div class="text-xs-right pt-2" style="margin-right:30px">
              <v-pagination circle v-model="pagination.page" :length="pages" :total-visible="5"></v-pagination>
            </div>  

           
        </div>
      </div>
    </div>
  </section>
</template>


<script>
import axios from "../axios/client.js";
import Vue from "vue";

export default {
  data() {
    return {
      pagination: {},
      tamanho: 5,
      search: "",
      asocTurma:"",
      tooltipActive:{
estilo:"",
mensagem:"Lista de atividades"
      },
      atividadesLista:"",
      associarAtividade: false,
      rowsperpageitems: [50],
      dialog2: false,
      dialogServico: false,
      msgServico: "",
      status: "",
      headers2:[
        { text: "Nome", align: "center;", sortable: false },
        { text: "Descrição", align: "center;", sortable: false },
         { text: "Ações", align: "center;", sortable: false }
      ],
      headers: [
        { text: "Nome", align: "center;", sortable: false },
        { text: "Período", align: "center;", sortable: false },
        
        { text: "Ações", align: "center;", sortable: false }
      ],

      loading: false,
      itens: [],
      turma:"",
      associaTurma:{
          id_turma:"",
          id_usuario:""
      },
      formulario: "",

      Atividade:{
          id_atividade:"",
          id_usuario:"",
          id_turma: ""
      },
      atividadesLista:[],
      listaAtividade:[],
      checkAll: false,
      idDelete: "",
      usuario: "",
      snackbar: false,
      y: "right",
      x: "right",
      mode: "",
      timeout: 2000
    };
  },
  computed: {
    pages() {
      if (
        this.pagination.rowsPerPage == null ||
        this.pagination.totalItems == null
      )
        return 0;

      if (this.search === "")
        return Math.ceil(this.itens.length / this.tamanho);

      return Math.ceil(
        this.pagination.totalItems / this.pagination.rowsPerPage
      );
    }
  },

  methods: {
    revisar(item){
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      console.log(this.usuario)
      var user = this.usuario[0].id;
      let url = "/revisao/" + item.id_atv +"/"+user;
      this.$router.push(url);
    },
    visualizarAtividade(item){
       console.log(item)
      let url = "/visualizaratividade/" + item.id_atv;
      this.$router.push(url);
    },
    novaMeta() {
      this.$router.push({ name: "addturma" });
    },
    formulario: function() {
      this.$router.push({ name: "addformulario" });
    },
    
    listaSolicitacao: function() {
      //console.log(event);
      let arrayReturn = [];
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      let idusuario = this.usuario[0].id;
      //console.log(idusuario); 
        axios
          .get("/minhasturmas/"+idusuario)
          .then(response => {
            this.itens = response.data;
            console.log(this.itens);
            for (let i = 0; i < this.itens.length; i++) {
            
            }
          })
          .catch(e => {});
    },
    associar(item){
      
       this.turma = item.id_turma
         axios
          .get("/atividadeTurma/"+ this.turma)
          .then(response => {   
                this.associarAtividade = true;
                this.atividadesLista = response.data;
            console.log(response);         
          })
          .catch(e => {});   
    },

  
    viewItem(item) {
      //alert(JSON.stringify(item));
      console.log(item)
      let url = "/visualizaturma/" + item.id_turma;
      this.$router.push(url);
    },
    editItem(item) {
      //alert(JSON.stringify(item));
       console.log(item)
      let url = "/editturma/" + item.id_turma;
      this.$router.push(url);
    },
    deleta(item) {
      console.log(item);
      this.idDelete = item.id_turma;
       console.log(this.idDelete);
      //console.log(this.idDelete);
      this.dialog2 = true;
    },

    
    deleteSim() {
      axios
        .delete("/excluirturma/" + this.idDelete)
        .then(response => {
          if (response.data == true) {
            this.dialog2 = false;
            this.dialogServico = true;
            this.msgServico = "Atividade excluída com sucesso";
            this.listaSolicitacao();
            this.PreencheCabechalho();
          }
        })
        .catch(e => {
          this.msgErro = "Erro ao carregar";
        });
    },
    PreencheCabechalho: function() {
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      this.usuario.nome = this.usuario.usuario.nome;
      this.usuario.matricula = this.usuario.usuario.matricula;
      this.usuario.funcao = this.usuario.usuario.funcao;
    }
  },
  created: function() {
  //   this.CarregarAtividade();
    this.listaSolicitacao();
    this.PreencheCabechalho();
   
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

