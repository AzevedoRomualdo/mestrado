<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/addaspectos', function ($request, $response, $args) {

    $post = $request->getParsedBody();
  //  return $this->response->withJson( count($post)-1);
    for($i = 0; $i < count($post); $i++){
        $str = $this->db->prepare("INSERT INTO aspectos (item, id_formulario) Values (:item, :id_formulario)");                              
        $str->bindParam("item",              $post[$i]["descricao"]);
        $str->bindParam("id_formulario",         $post[$i]["id"]);
        $str->execute();
    }
    $post = true;
      return $this->response->withJson($post);
   
  });

  $app->post('/respostasatividade', function ($request, $response, $args) {

   // $str2 = $this->db->prepare("INSERT INTO resposta (id_usuario, id_atividade, diagrama) VALUES (:id_usuario, :id_atividade, :diagrama)");

    $post = $request->getParsedBody();
   //return $this->response->withJson( $post);
        $str = $this->db->prepare("INSERT INTO resposta (id_usuario, id_atividade, diagrama) VALUES (:id_usuario, :id_atividade, :diagrama)");                              
        $str->bindParam("id_usuario",              $post["id_usuario"]);
        $str->bindParam("id_atividade",         $post["id_atividade"]);
       // $str->bindParam("nome",         $post["nome"]);
        // $str->bindParam("descricao",         $post["descricao"]);
        $str->bindParam("diagrama",         $post["diagrama"]);
        $str->execute();
      return $this->response->withJson($post);
   
  });

  $app->get('/aspectos/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * from aspectos where id_formulario = ".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});


// $app->get('/formulario/{id}', function ($request, $response, $args) {
  
//     $str = $this->db->prepare("SELECT * from formulario where id_formulario = ".$args["id"]); 
//     $str -> execute();
//     $post = $str -> fetchAll();

//     return $this->response->withJson($post);
// });

// $app->delete('/excluirformulario/{id}', function ($request, $response, $args) {
  
//     $str = $this->db->prepare("DELETE  FROM formulario where id_formulario =".$args["id"]);
//     $str -> execute();

//     $ok = "true";
//     return $this->response->withJson($ok);
// });


 $app->put('/editaspectos/{id}', function ($request, $response, $args) {
     $post = $request->getParsedBody();
     //return $this->response->withJson($post);
           $str = $this->db->prepare("UPDATE aspectos set item =:item, id_formulario =:id_formulario where id_aspectos =:id_aspectos"); 
                                       
         $str->bindParam("item",              $post["item"]);
         $str->bindParam("id_aspectos",         $args["id"]);
         $str->bindParam("id_formulario",         $post["id_formulario"]);
         $str->execute();
         $post = true;
      return $this->response->withJson($post);
 });


  $app->delete('/excluiraspecto/{id}', function ($request, $response, $args) {
  
   $str = $this->db->prepare("DELETE FROM aspectos where id_aspectos =" .$args["id"]);
   $str -> execute();
  
   $ok = "true";
   return $this->response->withJson($ok);
 });

//         $str->execute();
//    return $this->response->withJson($post);
   
//   });
