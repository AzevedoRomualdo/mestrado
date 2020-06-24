<template>
  <v-app>
    <section class="container-fluid-12">
      <v-dialog v-model="dialogServico" persistent width="350">
        <v-card>
          <v-card-title class="headline grey lighten-2" primary-title>Aviso</v-card-title>

          <v-card-text>
            <span class="title mb-4">{{ msgServico }}</span>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="sucess" flat @click="dialogServico = false">Entendi</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-layout row wrap>
        <v-flex xs1 sm12>
          <v-btn
            color="#2154a0"
            style="margin-left:155vh; color:white; margin-top: 2vh;"
            @click="numero_aleatorio"
          >Sortear</v-btn>
        </v-flex>
      </v-layout>

      <v-layout row wrap style="margin-top: 7vh;">
        <table>
          <tr>
            <th>Aluno</th>
            <th>Revisor</th>
          </tr>
          <tr v-show="teste1" v-for="item in items" :key="item.id">
            <td>{{ item.nome }}</td>
            <td>
              <v-select v-model="item.revisao" :items="listarevi" item-text="nome" item-value="id" />
            </td>
          </tr>
          <tr v-show="teste" v-for="item in items" :key="item.id">
            <td>{{ item.nome }}</td>

            <td>
              <v-text-field v-model="item.nomeRevisor"></v-text-field>
            </td>
          </tr>
        </table>
      </v-layout>

      <v-layout row wrap>
        <v-flex xs1 sm12>
          <v-btn
            color="#2154a0"
            style="margin-left:160vh; color:white; margin-top: 7vh;"
            v-if="cont < nrodadas"
            @click="proximo"
          >Próximo</v-btn>

          <v-btn
            color="#2154a0"
            style=" color:white; margin-left:140vh; margin-top: 2vh;"
            v-else
            @click="proximo"
          >Salvar</v-btn>
        </v-flex>
      </v-layout>
    </section>
  </v-app>
</template>
<script>
import axios from "../axios/client.js";
import Vue from "vue";

export default {
  data() {
    return {
      k: 0,
      ooo: 0,
      yyy: 0,
      usuario: "",
      cont: 1,
      tela: 0,
      id: "",
      nrodadas: 0,
      nrevisores: "",
      teste: false,
      teste1: true,
      items: [],
      itemsk: [],
      items2: [],
      revisores: [],
      prev: [],
      rod: [{ id: 0, revisão: "" }],
      dialogServico: false,
      msgServico: "",
      listarevi: [],
      numeros: [],
      ListaSoteio: []
    };
  },

  methods: {
    carregar: function() {
      this.id = this.$route.params.id;
      axios.get("/listarevisao/" + this.id).then(response => {
        this.items = response.data;

        for (let i = 0; i < this.items.length; i++) {
          this.itemsk.push(response.data[i]);
          this.items[i].revisao = "";
          this.items[i].nomeRevisor = "";
        }
        this.listarevi = this.items;
        axios.get("/rodadasrev/" + this.id).then(response => {
          // console.log(response.data);

          this.nrodadas = response.data[0].nrodadas;
          this.nrevisores = response.data[0].nrevisores;

          // for (let t = 0; t <= this.nrodadas; t++) {
          //   this.rod[t].id = this.k + 1;
          // }

          this.nrodadas = parseInt(this.nrodadas);
          var numero = 1;
        });
        //console.log(this.items);
      });
    },

    proximo: function() {
      this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));

      console.log(this.cont);
      console.log(this.prev);
      //console.log(this.items);

      for (let j = 0; j < this.prev.length; j++) {
        console.log("HHHHHHHHHHHHHHHHHH");
        console.log(this.prev[j].revisao);
      }

      for (let j = 0; j < this.items.length; j++) {
        const clone = Object.assign({}, this.items[j]);
        this.prev.push(clone);

        this.prev[this.yyy].id_professor = this.usuario[0].id;
        this.prev[this.yyy].rodada = this.cont;

        this.yyy = this.yyy + 1;

        console.log("============");
      }

      for (let j = 0; j < this.prev.length; j++) {
        console.log("JJJJJJJJJJJJJJJJJJJJJ");
        console.log(this.prev[j].revisao);
      }

      if (this.cont == this.nrodadas) {
        axios.post("/revisores", this.prev).then(response => {
          if (response.data !== false) {
            this.cor = "green";
            this.snackbar = true;
            this.nomeCampo = "";
            this.textoAlerta = "Revisores cadastrados com sucesso";
            //this.$router.push({ name: "listasolicitacao" });
          } else {
            this.cor = "red";
            this.snackbar = true;
            this.nomeCampo = "";
            this.textoAlerta = "Revisores não cadastrados";
            return;
          }

          console.log(response);
        });
      }

      this.cont++;
    },

    salvar: function() {
      // for (let j = 0; j < this.items.length; j++) {
      //   this.prev.push(this.items[j]);
      //   this.items[j].revisão = "";
      //   this.prev[this.yyy].id_professor = this.usuario[0].id;
      //   this.prev[this.yyy].rodada = this.cont;
      //   this.yyy++;
      // }
    },
    numero_aleatorio: function() {
      var j = 0;

      var numero = Math.round(Math.random() * (this.items.length - 1));

      if (numero != j) {
        console.log(numero);

        for (var i = numero; i < this.items.length; i++) {
          this.ListaSoteio[j] = this.items[i];
          j++;
        }

        for (var i = 0; i < numero; i++) {
          this.ListaSoteio[j] = this.items[i];
          j++;
        }
      } else {
        numero = 0;
        console.log(numero);
        for (var i = 1; i < this.items.length; i++) {
          this.ListaSoteio[j] = this.items[i];
          j++;
        }
        this.ListaSoteio[j + 1] = this.items[0];
      }
      this.teste = true;
      this.teste1 = false;
      for (let z = 0; z < this.items.length; z++) {
        this.items[z].revisao = this.ListaSoteio[z].id;
        this.items[z].nomeRevisor = this.ListaSoteio[z].nome;
      }
      console.log(this.ListaSoteio);
      console.log(this.items);
      //   }
    }
  },
  created: function() {
    this.carregar();
  }
};
</script>
<style>
table {
  display: table;
  width: 85%;
}
</style>
