import Vue from "vue";
import Router from "vue-router";
import login from "@/components/login";
import AddUsuario from "@/components/AddUsuario";
import AddTurma from "@/components/AddTurma";
import CadastroAtividade from "@/components/CadastroAtividade";
import ListaSolicitacao from "@/components/ListaSolicitacao";
import ListaTurma from "@/components/ListaTurma";
import Visualiza from "@/components/Visualiza";
import VisualizaTurma from "@/components/VisualizaTurma";
import VisualizaFormulario from "@/components/VisualizaFormulario";
import AddFormulario from "@/components/AddFormulario";
import AddAspectos from "@/components/AddAspectos";
import ListaFormulario from "@/components/ListaFormulario";
import MinhasTurmas from "@/components/MinhasTurmas";
import VisualizaAtividade from "@/components/VisualizaAtividade";
import ListaRevisor from "@/components/ListaRevisor";
import RevisorSorteio from "@/components/RevisorSorteio";
import avaliacao from "@/components/avaliacao";
import Revisar from "@/components/revisar";
import RetornoAutor from "@/components/RetornoAutor";
import RetornoTela from "@/components/RetornoTela";
import testepaint from "@/components/testepaint";
import editusuario from "@/components/EditUser";

Vue.use(Router);

export default new Router({
  mode: "history",
  base: "/sistema/",
  routes: [
    {
      path: "/visualiza/:id",
      name: "visualiza",
      component: Visualiza
    },
    {
      path: "/testepaint",
      name: "testepaint",
      component: testepaint
    },
    {
      path: "/editusuario",
      name: "editusuario",
      component: editusuario
    },

    {
      path: "/revisar",
      name: "revisar",
      component: Revisar
    },
    {
      path: "/retornotela/:id/:user",
      name: "retornotela",
      component: RetornoTela
    },
    {
      path: "/retorno",
      name: "retorno",
      component: RetornoAutor
    },

    {
      path: "/addformulario",
      name: "addformulario",
      component: AddFormulario
    },

    {
      path: "/listaformulario",
      name: "formulario",
      component: ListaFormulario
    },

    {
      path: "/visualizaturma/:id",
      name: "visualizaturma",
      component: VisualizaTurma
    },

    {
      path: "/visualizaformulario/:id",
      name: "visualizaformulario",
      component: VisualizaFormulario
    },
    {
      path: "/sorteiorevisor/:id",
      name: "sorteiorevisor",
      component: RevisorSorteio
    },
    {
      path: "/avaliacao/:id",
      name: "avaliacao",
      component: avaliacao
    },
    {
      path: "/revisao/:id/:user",
      name: "listarevisor",
      component: ListaRevisor
    },

    {
      path: "/retorno/:id",
      name: "retorno",
      component: RetornoAutor
    },

    {
      path: "/",
      name: "listasolicitacao",
      component: ListaSolicitacao
    },

    {
      path: "/listaturma",
      name: "turma",
      component: ListaTurma
    },

    {
      path: "/atividade",
      name: "atividade",
      component: CadastroAtividade
    },
    {
      path: "/aspectos/:id",
      name: "aspectos",
      component: AddAspectos
    },
    {
      path: "/atividade/:id",
      name: "editatividade",
      component: CadastroAtividade
    },
    {
      path: "/minhasturmas",
      name: "minhasturmas",
      component: MinhasTurmas
    },
    {
      path: "/visualizaratividade/:id",
      name: "visualizaratividade",
      component: VisualizaAtividade
    },

    {
      path: "/login",
      name: "login",
      component: login
    },
    {
      path: "/addusuario",
      name: "addusuario",
      component: AddUsuario
    },
    {
      path: "/addturma",
      name: "addturma",
      component: AddTurma
    },

    {
      path: "/editturma/:id",
      name: "editturma",
      component: AddTurma
    },

    {
      path: "/editformulario/:id",
      name: "editformulario",
      component: AddFormulario
    }
  ]
});
