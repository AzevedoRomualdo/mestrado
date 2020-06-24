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
              <v-flex xs3 sm12>
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
                        title="Responder Atividade"
                        style="color:black; "
                        class="mr-2"
                        @click=" visualizarAtividade(props.item)"
                      >assignment</v-icon>
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
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-default color-palette-box">
          <v-layout row wrap>
            <v-flex xs3 sm3 style="margin-top:4vh">
              <h1>Revisão de atividade</h1>
            </v-flex>
            <!-- <v-flex xs12 sm8 style="margin-top:4vh">
              <v-btn
                v-if="testeaqui == []"
                color="#2154a0"
                style="margin-left:140vh; color:white; "
                @click="ratividade"
              >Salvar</v-btn>
              <v-btn
                v-else
                color="#2154a0"
                style="margin-left:140vh; color:white; "
                @click="edit"
              >Salvar Edição</v-btn>
            </v-flex>-->
          </v-layout>
          <v-layout row>
            <v-flex xs3 sm3 style="margin-top:5vh">
              <h3>Resposta Anexada</h3>
            </v-flex>
          </v-layout>
          <v-layout row style="margin-top:3vh">
            <v-flex xs3 sm4 v-for="item in itemsImagens" :key="item.imagem" style="margin-left:5vh">
              <img :src="item.imagem" width="60%" />
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs3 sm11 style=" margin-left:6vh; margin-top:3vh">
              <v-divider></v-divider>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs3 sm3 style=" margin-top:2vh">
              <h3>Formulário de Avaliação</h3>
            </v-flex>
          </v-layout>
          <v-layout
            v-for="item in listaaspectos"
            :key="item.id_aspectos"
            row
            wrap
            style="margin-left:4vh; margin-top:3vh"
          >
            <v-flex xs12 sm3>
              <label style="font-size: 18px; font-weight: bold">Aspectos:</label>
              <span style="font-size: 16px;">{{item.item}}?</span>
            </v-flex>
            <v-flex xs12 sm2 style=" margin-left:-220px; margin-top:3vh">
              <v-radio-group v-model="item.resp" readonly row>
                <v-radio label="Sim" value="1"></v-radio>
                <v-radio label="Não" value="2"></v-radio>
                <v-radio label="Não se Aplica" value="3"></v-radio>
              </v-radio-group>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs3 sm11 style=" margin-left:6vh; margin-top:3vh">
              <v-divider></v-divider>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs3 sm3 style=" margin-top:2vh;">
              <h3>Comentário</h3>
            </v-flex>
          </v-layout>
          <v-layout row style="margin-left:15vh">
            <v-flex xs3 sm10>
              <v-textarea
                style="margin-left:2vh;  border: 2px solid DimGray; border-radius: 5px;  height: 120px; width: 158vh;"
                outlined
                name="input-7-4"
                readonly
                v-model="comentgeral"
              ></v-textarea>
            </v-flex>
          </v-layout>
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
      tabrev: 0,
      respondido: 5,
      search: "",
      itemsImagens: [],
      asocTurma: "",
      geraldine: "",
      textoAlerta: "",
      comentgeral: "",
      nomeCampo: "",
      tooltipActive: {
        estilo: "",
        mensagem: "Lista de atividades"
      },
      atividadesLista: "",
      associarAtividade: false,
      rowsperpageitems: [50],
      dialog2: false,
      dialogServico: false,
      msgServico: "",
      status: "",
      headers2: [
        { text: "Nome", align: "center;", sortable: false },
        { text: "Descrição", align: "center;", sortable: false },
        { text: "Ações", align: "center;", sortable: false }
      ],
      headers: [
        { text: "Nome", align: "center;", sortable: false },
        { text: "Período", align: "center;", sortable: false },

        { text: "Ações", align: "center;", sortable: false }
      ],
      dadosAtividade: [],
      loading: false,
      itens: [],
      turma: "",
      associaTurma: {
        id_turma: "",
        id_usuario: ""
      },
      foda: {
        id_aspectos: "",
        id_asprev: "",
        comentario: "",
        id_tabrev: ""
      },
      aspresp: [],
      formulario: "",

      Atividade: {
        id_atividade: "",
        id_usuario: "",
        id_turma: ""
      },
      revisado: [],
      cor: "",
      atividadesLista: [],
      listaaspectos: [],
      listaAtividade: [],
      testeaqui: [],
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
    edit() {
      console.log("----- edit testte");
      console.log(this.listaaspectos);
      for (let r = 0; r < this.listaaspectos.length; r++) {
        this.aspresp.push({
          id_aspectos: this.listaaspectos[r].id_aspectos,
          id_asprev: this.listaaspectos[r].resp,
          id_tabrev: this.tabrev,
          id_resposta: this.listaaspectos[r].id_resposta,
          comentario: ""
        });
      }

      console.log("----- edit");
      console.log(this.aspresp);

      axios.put("/editresposta", this.aspresp).then(response => {
        if (response.data !== false) {
          this.cor = "green";
          this.snackbar = true;
          this.nomeCampo = "";
          this.textoAlerta = "Revisão Alterada com sucesso";
          //    this.$router.push({ name: "------0------" });
        } else {
          this.cor = "red";
          this.snackbar = true;
          this.nomeCampo = "";
          this.textoAlerta = "Sua edição deu erro";
          return;
        }
      });
    },

    ratividade() {
      console.log(this.listaaspectos);
      for (let r = 0; r < this.listaaspectos.length; r++) {
        this.aspresp.push({
          id_aspectos: this.listaaspectos[r].id_aspectos,
          id_asprev: this.listaaspectos[r].resp,

          id_tabrev: this.tabrev,
          comentario: ""
        });
      }
      console.log(this.aspresp);

      axios.put("/revisado/" + this.tabrev).then(response => {
        //this.revisado = response.data;
      });

      axios.post("/addresposta", this.aspresp).then(response => {
        if (response.data !== false) {
          this.cor = "green";
          this.snackbar = true;
          this.nomeCampo = "";
          this.textoAlerta = "Resposta Cadastrada com sucesso";
          this.$router.push({ name: "------0------" });
        } else {
          this.cor = "red";
          this.snackbar = true;
          this.nomeCampo = "";
          this.textoAlerta = "-----1--------";
          return;
        }
      });
    },

    visualizarAtividade(item) {
      console.log(item);
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
      this.id = this.$route.params.user;
      var idusuario = this.$route.params.id;
      let arrayReturn = [];
      //  this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      //   console.log(this.usuario.id);
      //console.log(idusuario);
      axios
        .get("/revisaotwo/" + this.id + "/" + idusuario)
        .then(response => {
          this.itens = response.data;
          this.tabrev = response.data[0].id_tabrevisores;
          console.log("------- ITEEEENS");
          console.log(this.itens);

          axios
            .get("/visualizaratividade/" + this.itens[0].id_atividade)
            .then(response => {
              this.dadosAtividade = response.data[0];

              console.log("------- vizualizaaaaar");
              console.log(this.dadosAtividade);

              axios
                .get("/aspectos/" + this.dadosAtividade.id_formulario)
                .then(response => {
                  console.log(this.dadosAtividade);
                  this.listaaspectos = response.data;
                  for (let i = 0; i < this.listaaspectos.length; i++) {
                    this.listaaspectos[i].resp = "";
                  }
                  console.log("---- aspectos");
                  console.log(this.listaaspectos);

                  axios
                    .get(
                      "/retresptwo/" +
                        idusuario +
                        "/" +
                        this.dadosAtividade.id_atv
                    )
                    .then(response => {
                      this.testeaqui = response.data;
                      console.log(this.testeaqui);
                      if (this.testeaqui.length != 0) {
                        for (let j = 0; j < this.testeaqui.length; j++) {
                          if (
                            this.listaaspectos[j].id_aspectos ==
                            this.testeaqui[j].id_aspectos
                          ) {
                            this.listaaspectos[j].resp = this.testeaqui[
                              j
                            ].id_asprev;
                            this.comentgeral = this.testeaqui[j].comentgeral;
                            this.listaaspectos[j].id_resposta = this.testeaqui[
                              j
                            ].xxx;
                          }
                        }
                        console.log("---- listaaaaaaspectos");
                        console.log(this.listaaspectos);
                        console.log(this.comentgeral);
                      }
                    });
                });
            });
          for (let i = 0; i < this.itens.length; i++) {
            this.itemsImagens.push({
              imagem: this.itens[0].diagrama
            });
          }
          console.log(this.itemsImagens);
        })
        .catch(e => {});
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

