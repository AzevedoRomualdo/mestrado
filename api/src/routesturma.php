<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/addturma', function ($request, $response, $args) {

    $post = $request->getParsedBody();
    
        $str = $this->db->prepare("INSERT INTO turma (nome, periodo, id_usuario) Values (:nome, :periodo, :id_usuario)");
                                       
        $str->bindParam("nome",              $post["nome"]);
        $str->bindParam("periodo",         $post["periodo"]);
        $str->bindParam("id_usuario",         $post["idusuario"]);

        $str->execute();

       $post = true;
      return $this->response->withJson($post);
   
  });
  

  $app->get('/minhasturmas/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * FROM turmausuario tu INNER JOIN turma t ON tu.id_turma = t.id_turma WHERE tu.id_usuario = ".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});

$app->get('/atividadeTurma/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * FROM turmaatividade ta INNER JOIN atividade atv ON ta.id_atividade = atv.id_atv WHERE id_turma = ".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});


$app->get('/revisao/{id_atv}/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT RESP.id_usuario, RESP.id_atividade, RESP.id_resposta, RESP.diagrama, REV.id_tabrevisores FROM resposta RESP 
	                            INNER JOIN revisores REV ON RESP.id_resposta = REV.id_resposta
 	                            INNER JOIN rodadas ROD ON RESP.id_atividade = ROD.id_atv
	                            WHERE REV.rodada = ROD.rodadaatual AND REV.id_revisor = ".$args["id"]." AND RESP.id_atividade = ".$args["id_atv"]);
    $str->execute();
    $post = $str->fetchAll();
    return $this->response->withJson($post);
});

$app->get('/revisaotwo/{id_atv}/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT RESP.id_usuario, RESP.id_atividade, RESP.id_resposta, RESP.diagrama, REV.id_tabrevisores FROM resposta RESP 
    INNER JOIN revisores REV ON RESP.id_resposta = REV.id_resposta
     INNER JOIN rodadas ROD ON RESP.id_atividade = ROD.id_atv
    WHERE REV.rodada = ROD.rodadaatual AND REV.id_autor = ".$args["id"]."  AND RESP.id_atividade =".$args["id_atv"]);
    $str->execute();
    $post = $str->fetchAll();
    return $this->response->withJson($post);
});

$app->get('/visualizaratividade/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT atv.nome as natividade, atv.id_atv, atv.descricao, c.instrucoes, 
                        c.nrevisores, c.nrodadas, ce.instenvio, ce.enviosatrasados, ce.dtinicio, ce.dtfim, 
                        f.nome, f.id_formulario, f.instrucoes as fintruces, asp.id_aspectos, asp.nota, asp.item FROM atividade atv 
                        inner join configaval c on atv.id_atv = c.id_atv 
                        INNER JOIN configenvio ce on atv.id_atv = ce.id_atv 
                        INNER JOIN formulario f ON c.id_formulario = f.id_formulario 
                        inner JOIN aspectos asp on f.id_formulario = asp.id_formulario where atv.id_atv =".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});



  $app->post('/associar', function ($request, $response, $args) {

    $post = $request->getParsedBody();
    //return $this->response->withJson($post);
        $str = $this->db->prepare("INSERT INTO turmausuario (id_turma, id_usuario) Values ( :id_turma, :id_usuario)");
        $str->bindParam("id_turma",         $post["id_turma"]);
        $str->bindParam("id_usuario",         $post["id_usuario"]);

        $str->execute();

       $post = true;
      return $this->response->withJson($post);
   
  });


  $app->get('/listaturma/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * from turma where id_usuario = ".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});


$app->get('/listarevisao/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * FROM resposta res INNER JOIN usuario u on res.id_usuario = u.id WHERE id_atividade = ".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});


$app->get('/listaturma', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * from turma"); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});

$app->get('/turma/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * from turma where id_turma = ".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});

$app->delete('/excluirturma/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("DELETE  FROM turma where id_turma =".$args["id"]);
    $str -> execute();

    $ok = "true";
    return $this->response->withJson($ok);
});


$app->put('/editturma/{id}', function ($request, $response, $args) {
    $post = $request->getParsedBody();
    print_r($post);
          $str = $this->db->prepare("UPDATE turma set nome =:nome, periodo = :periodo, id_usuario = :id_usuario where id_turma =:id_turma" ); 
                                       
        $str->bindParam("nome",              $post["nome"]);
        $str->bindParam("periodo",         $post["periodo"]);
        $str->bindParam("id_usuario",         $post["idusuario"]);
        $str->bindParam("id_turma",         $args["id"]);

        $str->execute();
   return $this->response->withJson($post);
   
  });
