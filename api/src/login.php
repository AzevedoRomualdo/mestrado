<?php

use Slim\Http\Request;
use Slim\Http\Response;
$app->post('/login', function ($request, $response, $args) {
    $post = $request->getParsedBody();
    $str = $this->db->prepare("SELECT * from usuario where email=:email and senha = :senha");
    $str->bindParam("email",              $post["login"]);
     $str->bindParam("senha",              $post["senha"]);
    $str->execute();
    $post = $str->fetchAll();
   
    return $this->response->withJson($post);

  });