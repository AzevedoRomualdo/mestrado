<template>
  <section class="container-fluid-12">
    <v-layout row justify-center>
      <v-dialog v-model="dialog2" persistent max-width="290">
        <v-card>
          <v-card-title class="headline">Aviso</v-card-title>
          <v-card-text>Deseja realmente excluir esse Formulário</v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" flat @click="dialog2 = false"
              >Não</v-btn
            >
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
            <v-progress-linear
              indeterminate
              color="blue"
              class="mb-0"
            ></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>
    <v-dialog v-model="dialogServico" persistent width="350">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title
          >Aviso</v-card-title
        >

        <v-card-text>
          <span class="title mb-4">{{ msgServico }}</span>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="sucess" flat @click="dialogServico = false"
            >Entendi</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-default color-palette-box">
          <v-layout row wrap style="margin-left: 80px;">
            <v-flex xs3 sm11 style=" margin-top: 30px;margin-left:140vh">
              <v-btn color="#006DB5" fab dark>
                <v-icon
                  title="Cadastrar Formulário"
                  @click.prevent.stop="novaMeta"
                  >description</v-icon
                >
              </v-btn>
            </v-flex>

            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <v-flex v-on="on" xs3 sm3 style="margin-top:-6vh">
                  <h1>Lista de Formulários</h1>
                </v-flex>
              </template>
              <span v-if="usuario[0].tipo == 2">Atividade Aluno. </span>
              <span v-if="usuario[0].tipo == 1">
                Nesta tela você encontra os formulários cadastrados e pode
                associar a uma determinada atividade. Além disso, é possível
                visualizar, alterar e excluir os formulários.
              </span>
            </v-tooltip>
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
              <td>{{ props.item.nome }}</td>
              <td>{{ props.item.instrucoes }}</td>

              <td>
                <v-icon
                  title="Adicionar Aspectos"
                  style="color:black; "
                  class="mr-2"
                  @click="addaspectos(props.item)"
                  >note_add</v-icon
                >
                <v-icon
                  title="Visualizar Formulário"
                  style="color:black; "
                  class="mr-2"
                  @click="viewItem(props.item)"
                  >visibility</v-icon
                >
                <v-icon
                  title="Editar Formulário"
                  style="color:black; "
                  class="mr-2"
                  @click="editItem(props.item)"
                  >edit</v-icon
                >
                <v-icon
                  title="Deletar Formulário"
                  style="color:black;"
                  class="mr-2"
                  @click="deleta(props.item)"
                  >delete</v-icon
                >
              </td>
            </template>
          </v-data-table>
          <div class="text-xs-right pt-2" style="margin-right:30px">
            <v-pagination
              circle
              v-model="pagination.page"
              :length="pages"
              :total-visible="5"
            ></v-pagination>
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
      rowsperpageitems: [50],
      dialog2: false,
      dialogServico: false,
      msgServico: "",
      status: "",
      headers: [
        { text: "Nome", align: "center;", sortable: false },
        { text: "Instruções", align: "center;", sortable: false },

        { text: "Ações", align: "center;", sortable: false }
      ],

      loading: false,
      itens: [],

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
    novaMeta() {
      this.$router.push({ name: "addformulario" });
    },
    listaSolicitacao: function() {
      //console.log(event);
      let arrayReturn = [];
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      let idusuario = this.usuario[0].id;
      //console.log(idusuario);
      axios
        .get("/listaformulario/" + idusuario)
        .then(response => {
          this.itens = response.data;
          console.log(this.itens);
          for (let i = 0; i < this.itens.length; i++) {}
        })
        .catch(e => {});
    },
    viewItem(item) {
      //alert(JSON.stringify(item));
      console.log(item);
      let url = "/visualizaformulario/" + item.id_formulario;
      this.$router.push(url);
    },
    addaspectos(item) {
      //alert(JSON.stringify(item));
      console.log(item);
      let url = "/aspectos/" + item.id_formulario;
      this.$router.push(url);
    },
    editItem(item) {
      //alert(JSON.stringify(item));
      console.log(item);
      let url = "/editformulario/" + item.id_formulario;
      this.$router.push(url);
    },
    deleta(item) {
      console.log(item);
      this.idDelete = item.id_formulario;
      console.log(this.idDelete);
      //console.log(this.idDelete);
      this.dialog2 = true;
    },

    deleteSim() {
      axios
        .delete("/excluirformulario/" + this.idDelete)
        .then(response => {
          if (response.data == true) {
            this.dialog2 = false;
            this.dialogServico = true;
            this.msgServico = "Formulário excluído com sucesso";
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
