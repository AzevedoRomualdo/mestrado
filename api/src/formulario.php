<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/addformulario', function ($request, $response, $args) {

    $post = $request->getParsedBody();
    
        $str = $this->db->prepare("INSERT INTO formulario (nome, instrucoes, id_usuario) Values (:nome, :instrucoes, :id_usuario)");
                                      
        $str->bindParam("nome",              $post["nome"]);
        $str->bindParam("instrucoes",         $post["instrucoes"]);
        $str->bindParam("id_usuario",         $post["idusuario"]);

        $str->execute();

       $post = true;
      return $this->response->withJson($post);
   
  });

  $app->get('/listaformulario/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * from formulario where id_usuario = ".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});


$app->get('/formulario/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * from formulario where id_formulario = ".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});

$app->delete('/excluirformulario/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("DELETE  FROM formulario where id_formulario =".$args["id"]);
    $str -> execute();

    $ok = "true";
    return $this->response->withJson($ok);
});


$app->put('/editformulario/{id}', function ($request, $response, $args) {
    $post = $request->getParsedBody();
    print_r($post);
          $str = $this->db->prepare("UPDATE formulario set nome =:nome, instrucoes = :instrucoes, id_usuario = :id_usuario where id_formulario =:id_formulario" ); 
                                       
        $str->bindParam("nome",              $post["nome"]);
        $str->bindParam("instrucoes",         $post["instrucoes"]);
        $str->bindParam("id_usuario",         $post["idusuario"]);
        $str->bindParam("id_formulario",         $args["id"]);

        $str->execute();
   return $this->response->withJson($post);
   
  });
