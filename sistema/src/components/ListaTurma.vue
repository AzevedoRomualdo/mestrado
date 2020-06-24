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
            <v-btn color="green darken-1" flat @click="asocTurma = false"
              >Não</v-btn
            >
            <v-btn color="green darken-1" flat @click="addSim">Sim</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
    <v-layout row justify-center>
      <v-dialog v-model="associarAtividade" persistent max-width="590">
        <v-card>
          <v-card-title class="headline">Aviso</v-card-title>
          <v-card-text>
            <v-layout class="row">
              <v-flex xs3 sm11>
                <v-select
                  :items="listaAtividade"
                  item-text="nome"
                  item-value="id_atv"
                  label="atividade"
                  v-model="Atividade.id_atividade"
                  outlined
                ></v-select>
              </v-flex>
            </v-layout>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="green darken-1"
              flat
              @click="associarAtividade = false"
              >Não</v-btn
            >
            <v-btn color="green darken-1" flat @click="addAtivSim">Sim</v-btn>
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
          <v-layout row wrap>
            <v-flex
              v-if="usuario[0].tipo == 1"
              xs3
              sm9
              style=" margin-top: 30px;margin-left:140vh"
            >
              <v-btn color="#006DB5" fab dark>
                <v-icon title="Cadastrar Turma" @click.prevent.stop="novaMeta"
                  >description</v-icon
                >
              </v-btn>
            </v-flex>
            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <v-flex v-on="on" xs3 sm3 style="margin-top:-6vh">
                  <h1>Lista de Turmas</h1>
                </v-flex>
              </template>
              <span v-if="usuario[0].tipo == 2"
                >Nesta tela você encontra a lista de turmas em que podes se
                associar para participar das atividades de modelagem de
                sistemas. Nas ações você encontra as opções de visualizar turma
                e associar-se a ela.
              </span>
              <span v-if="usuario[0].tipo == 1">
                Nesta tela você encontra a lista de turmas que cadastrou e podes
                associar uma atividade de modelagem de sistemas. Nas ações você
                encontra as opções de visualizar, editar e turma e deletar a
                turma cadastrada.
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
              <td>{{ props.item.periodo }}</td>

              <td>
                <v-icon
                  v-if="usuario[0].tipo == 1"
                  title="Visualizar Turma"
                  style="color:black; "
                  class="mr-2"
                  @click="viewItem(props.item)"
                  >visibility</v-icon
                >

                <v-icon
                  v-if="usuario[0].tipo == 1"
                  title="Associar Atividade"
                  style="color:black; "
                  class="mr-2"
                  @click="assocAtiv(props.item)"
                  >how_to_reg</v-icon
                >

                <v-icon
                  v-if="usuario[0].tipo == 1"
                  title="Editar Turma"
                  style="color:black; "
                  class="mr-2"
                  @click="editItem(props.item)"
                  >edit</v-icon
                >

                <v-icon
                  v-if="usuario[0].tipo == 1"
                  title="Deletar Turma"
                  style="color:black;"
                  class="mr-2"
                  @click="deleta(props.item)"
                  >delete</v-icon
                >

                <v-icon
                  v-if="usuario[0].tipo == 2"
                  title="Visualizar Turma"
                  style="color:black; "
                  class="mr-2"
                  @click="viewItem(props.item)"
                  >visibility</v-icon
                >
                <v-icon
                  v-if="usuario[0].tipo == 2"
                  title="Se associar a turma"
                  style="color:black; "
                  class="mr-2"
                  @click="associar(props.item)"
                  >how_to_reg</v-icon
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
      asocTurma: "",
      associarAtividade: false,
      rowsperpageitems: [50],
      dialog2: false,
      dialogServico: false,
      msgServico: "",
      status: "",
      headers: [
        { text: "Nome", align: "center;", sortable: false },
        { text: "Período", align: "center;", sortable: false },

        { text: "Ações", align: "center;", sortable: false }
      ],

      loading: false,
      itens: [],
      turma: "",
      associaTurma: {
        id_turma: "",
        id_usuario: ""
      },
      formulario: "",

      Atividade: {
        id_atividade: "",
        id_usuario: "",
        id_turma: ""
      },
      listaAtividade: [],
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
      if (this.usuario[0].tipo == 2) {
        axios
          .get("/listaturma")
          .then(response => {
            this.itens = response.data;
            console.log(this.itens);
            for (let i = 0; i < this.itens.length; i++) {}
          })
          .catch(e => {});
      } else {
        axios
          .get("/listaturma/" + idusuario)
          .then(response => {
            this.itens = response.data;
            console.log(this.itens);
            for (let i = 0; i < this.itens.length; i++) {}
          })
          .catch(e => {});
      }
    },
    associar(item) {
      this.asocTurma = true;
      this.turma = item.id_turma;
    },

    assocAtiv(item) {
      this.associarAtividade = true;
      this.turma = item.id_turma;
    },
    CarregarAtividade() {
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      let idusuario = this.usuario[0].id;
      axios
        .get("/listaatividade/" + idusuario)
        .then(response => {
          this.listaAtividade = response.data;
          console.log(this.listaAtividade);
        })
        .catch(e => {});
    },

    addAtivSim() {
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      this.Atividade.id_usuario = this.usuario[0].id;
      this.Atividade.id_turma = this.turma;

      axios
        .post("/associarativ", this.Atividade)
        .then(response => {
          if (response.data !== false) {
            this.cor = "green";
            this.snackbar = true;
            this.nomeCampo = "";
            this.textoAlerta = "Atividade Associada com sucesso";
            console.log(response);
            this.associarAtividade = false;
          }
        })
        .catch(e => {});
    },

    addSim() {
      this.associaTurma.id_usuario = this.usuario[0].id;
      this.associaTurma.id_turma = this.turma;
      axios
        .post("/associar", this.associaTurma)
        .then(response => {
          if (response.data !== false) {
            this.cor = "green";
            this.snackbar = true;
            this.nomeCampo = "";
            this.textoAlerta = "Associado com sucesso à Turma";
            console.log(response);
            this.asocTurma = false;
          }
        })
        .catch(e => {});
    },
    viewItem(item) {
      //alert(JSON.stringify(item));
      console.log(item);
      let url = "/visualizaturma/" + item.id_turma;
      this.$router.push(url);
    },
    editItem(item) {
      //alert(JSON.stringify(item));
      console.log(item);
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
    this.CarregarAtividade();
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
