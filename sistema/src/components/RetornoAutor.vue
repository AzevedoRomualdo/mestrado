<template>
  <v-content>
    <v-layout row wrap>
      <v-tooltip bottom>
        <template v-slot:activator="{ on }">
          <v-flex v-on="on" xs3 sm3 style="margin-top:4vh">
            <h1>Atividades Revisadas</h1>
          </v-flex>
        </template>
        <span>
          Nesta tela você encontra a lista de atividades a serem revisadas NESTA
          RODADA e respectivamente suas turmas e períodos em que estão
          associados.
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
      style="text-align: center; margin-top:30px; margin-left:30px; margin-right:30px"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.nometurma }}</td>
        <td>{{ props.item.periodo }}</td>
        <td>{{ props.item.nome }}</td>
        <td>
          <v-icon
            title="Revisar Atividade"
            style="color:black; cursor: pointer"
            class="mr-2"
            @click="revisarAtividade(props.item)"
          >check_circle_outline</v-icon>
        </td>
      </template>
    </v-data-table>
  </v-content>
</template>

<script>
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
      listarespostas: [],
      responder: false,
      itens: [],
      respostaAtividade: {
        id_usuario: "",
        id_atividade: "",
        diagrama: ""
      },
      headers: [
        { text: "Turma", align: "center;", sortable: false },
        { text: "Período", align: "center;", sortable: false },
        { text: "Nome", align: "center;", sortable: false },
        { text: "Ações", align: "center;", sortable: false }
      ],
      usuario: ""
    };
  },

  methods: {
    revisarAtividade: function(item) {
      //console.log(item);
      //console.log(item.id_usuario);
      // console.log(item.id_atv);
      let url = "/retornoTela/" + item.id_usuario + "/" + item.id_atv;
      this.$router.push(url);
    },
    carregar: function() {
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
      console.log(this.usuario.id);
      axios
        .get("/listarev/" + this.usuario[0].id)
        .then(response => {
          console.log(response);
          this.itens = response.data;
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
<style>
.theme--light.v-table thead th {
  background-color: #006db5 !important;
  color: white !important;
}
</style>
