<template>
  <header>
    <v-card-title class="blue accent-4 white--text" color="#006db5">
      <v-menu offset-y>
        <template v-slot:activator="{ on }">
          <v-btn dark icon v-on="on">
            <v-icon style="color:white; font-size:35px;">dehaze</v-icon>
          </v-btn>
        </template>

        <v-list v-if="tipo == 1">
          <v-list-tile v-for="(item, i) in items" :key="i">
            <v-list-tile-title>
              <router-link
                :to="item.path"
                v-if="item.title != 'Sair'"
                style="color:black; text-decoration:none;"
              >{{ item.title }}</router-link>
              <span v-else-if="item.title == 'Sair'" @click="sair" style="cursor: pointer;">Sair</span>
            </v-list-tile-title>
          </v-list-tile>
        </v-list>
        <v-list v-else>
          <v-list-tile v-for="(item, i) in items2" :key="i">
            <v-list-tile-title>
              <router-link
                :to="item.path"
                v-if="item.title != 'Sair'"
                style="color:black; text-decoration:none;"
              >{{ item.title }}</router-link>
              <span v-else-if="item.title == 'Sair'" @click="sair" style="cursor: pointer;">Sair</span>
            </v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-menu>
      <span style=" font-weight: bold; margin-left:75vh" class="headline">Peer Review Edition</span>
      <span style="margin-left:70vh">
        <i id="iconUser" class="material-icons">account_circle</i>
      </span>
      <label>
        <p style="margin-top:13px;margin-left:3px; font-weight: bold;">Olá, {{usuario}}!</p>
      </label>
      <i
        class="material-icons"
        title="Sair"
        style="margin-left: 10px;  cursor: pointer;"
        @click="sair"
      >input</i>
    </v-card-title>
  </header>
</template>
<script>
export default {
  data() {
    return {
      items: [
        { title: "Atividades", path: "/" },
        { title: "Turmas", path: "/listaturma" },
        { title: "Formularios", path: "/listaformulario" },
        { title: "Sair", path: "" }
      ],
      items2: [
        //  { title: "Atividades", path: "/" },
        { title: "Minhas Turmas", path: "/minhasturmas" },
        { title: "Revisar Atividade", path: "/revisar" },
        { title: "Verificar Revisões", path: "/retorno" },
        { title: "Turmas", path: "/listaturma" },
        { title: "Sair", path: "" }
      ],
      usuario: "",
      tipo: ""
    };
  },
  methods: {
    sair: function() {
      this.$emit("saiu");
    }
  },

  created: function() {
    this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
    this.tipo = this.usuario[0].tipo;
    this.usuario = this.usuario[0].nome.split(" ");
    console.log(this.usuario);
    this.usuario = this.usuario[0];
  }
};
</script>

<style>
#iconInput {
  color: white;
  margin-top: 8px;
  margin-right: 20px;
}
#iconUser {
  color: white;
  margin-top: 3px;
}
#barraVertical {
  color: white;
  padding: 15px;
  font-size: 20px;
  margin-top: 13px;
}
</style>