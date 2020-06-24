<?php

use Slim\Http\Request;
use Slim\Http\Response;
require 'dao.php';
 $app->get("/centrodeCustos", function($request, $response){
    $retorno = getCentrodeCusto();
    return $this->response->withJson($retorno);
 });

 $app->get("/departamento", function($request, $response){
    $retorno = getDepartamento();
    return $this->response->withJson($retorno);
 });

 $app->get("/funcionario", function($request, $response){
    $retorno = getFuncionario();
    return $this->response->withJson($retorno);
 });
 
 $app->get("/funcionario/{centrodeCusto}/{datainicio}/{datafim}", function($request, $response, $args){
    $retorno = getFunciCentroCusto($this->dbERP, $args['centrodeCusto'], $args['datainicio'], $args['datafim']);
    return $this->response->withJson($retorno);
 });
 
 $app->get("/lisfuncionario/{centrodeCusto}", function($request, $response, $args){
   $retorno = getFunciCentro($this->dbERP, $args['centrodeCusto']);
   return $this->response->withJson($retorno);
});

 