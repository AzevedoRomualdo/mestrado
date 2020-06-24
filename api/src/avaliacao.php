<?php

use Slim\Http\Request;
use Slim\Http\Response;

    

$app->get('/teste/{id}', function ($request, $response, $args){

     $str = $this->db->prepare("SELECT ATV.id_usuario AS idUser, TU.nome AS nometurma, TU.periodo, RESP.id_usuario, ATV.id_atv, ATV.nome, REV.id_revisor,
     ROD.rodadaatual, REV.rodada
     
          FROM revisores REV 
          INNER JOIN resposta RESP ON REV.id_resposta = RESP.id_resposta
          INNER JOIN atividade ATV ON RESP.id_atividade = ATV.id_atv 
          INNER JOIN turmaatividade TA ON ATV.id_atv = TA.id_atividade
          INNER JOIN turma TU ON TA.id_turma = TU.id_turma
          INNER JOIN rodadas ROD ON TA.id_atividade = ROD.id_atv
          
          where REV.rodada = ROD.rodadaatual AND  id_revisor = ".$args["id"]);
     $str->execute();
     $post = $str -> fetchAll();
    return $this->response->withJson($post);
});

$app->get('/listarev/{id}', function ($request, $response, $args){
    $dado = 1;
    $str = $this->db->prepare("SELECT ATV.id_usuario AS idUser, TU.nome AS nometurma, TU.periodo, RESP.id_usuario, ATV.id_atv, ATV.nome, REV.id_revisor,
    ROD.rodadaatual, REV.rodada
    
         FROM revisores REV 
         INNER JOIN resposta RESP ON REV.id_resposta = RESP.id_resposta
         INNER JOIN atividade ATV ON RESP.id_atividade = ATV.id_atv 
         INNER JOIN turmaatividade TA ON ATV.id_atv = TA.id_atividade
         INNER JOIN turma TU ON TA.id_turma = TU.id_turma
         INNER JOIN rodadas ROD ON TA.id_atividade = ROD.id_atv
         
         where REV.rodada = ROD.rodadaatual AND  REV.id_autor = ".$args["id"]." AND REV.respondido = $dado");
   
    $str->execute();
    $post = $str -> fetchAll();
   return $this->response->withJson($post);
});

$app->get('/rodadasrev/{id}', function ($request, $response, $args){

    $str = $this->db->prepare("SELECT CONFA.nrodadas, CONFA.nrevisores FROM atividade ATV 
    INNER JOIN configaval CONFA ON ATV.id_atv = CONFA.id_atv WHERE ATV.id_aTV =".$args["id"]);
    $str->execute();
    $post = $str -> fetchAll();
   return $this->response->withJson($post);
});

$app->post('/revisores', function ($request, $response, $args) {

    $post = $request->getParsedBody();
    
    for ($x=0; $x<count($post); $x++)
    {
        $str = $this->db->prepare("INSERT INTO revisores (id_atv, id_autor, id_resposta, id_usuario, id_revisor, rodada) Values (:id_atv, :id_autor, :id_resposta, :id_usuario, :id_revisor, :rodada)");
                                      
        $str->bindParam("id_atv",              $post[$x]["id_atividade"]);
        $str->bindParam("id_autor",            $post[$x]["id_usuario"]);
        $str->bindParam("id_resposta",         $post[$x]["id_resposta"]);
        $str->bindParam("id_usuario",          $post[$x]["id_professor"]);
        $str->bindParam("id_revisor",          $post[$x]["revisao"]);
        $str->bindParam("rodada",              $post[$x]["rodada"]);

        $str->execute();
    }
        

       $post = true;
       
      return $this->response->withJson($post);
   
  });

  $app->post('/addresposta', function ($request, $response, $args) {

    $post = $request->getParsedBody();
    
    for ($x=0; $x<count($post); $x++)
    {
        
        $str = $this->db->prepare("INSERT INTO respostaaspectos (id_aspectos, id_asprev, comentario, id_tabrevisores) Values (:id_aspectos, :id_asprev, :comentario, :id_tabrevisores)");
                                      
        $str->bindParam("id_aspectos",              $post[$x]["id_aspectos"]);
        $str->bindParam("id_asprev",                $post[$x]["id_asprev"]);
        $str->bindParam("comentario",               $post[$x]["comentario"]);
        $str->bindParam("id_tabrevisores",          $post[$x]["id_tabrev"]);
       

        $str->execute();
    }
        

        $post = true;
        return $this->response->withJson($post);
   
  });
  $app->put('/editcoment/{id}', function ($request, $response, $args) {
    $post = $request->getParsedBody();
  // return $this->response->withJson($post);
   $str3 = $this->db->prepare("UPDATE revisores SET comentario = :comentario  WHERE id_tabrevisores = :id_tabrevisores");
   
   $str3->bindParam("comentario",              $post["comentgeral"]);
   $str3->bindParam("id_tabrevisores",          $args["id"]);

   $str3->execute();

    $post = true ;

   return $this->response->withJson($post);


});

  $app->put('/editresposta', function ($request, $response, $args) {

    $post = $request->getParsedBody();
   // return $this->response->withJson($post);
  

    for ($x=0; $x<count($post); $x++)
    {
        
        $str = $this->db->prepare("UPDATE respostaaspectos SET id_aspectos = :id_aspectos, id_asprev = :id_asprev, id_tabrevisores = :id_tabrevisores, comentario = :comentario WHERE id_resposta = :id_resposta");
                                      
        $str->bindParam("id_aspectos",              $post[$x]["id_aspectos"]);
        $str->bindParam("id_asprev",                $post[$x]["id_asprev"]);
        $str->bindParam("comentario",               $post[$x]["comentario"]);
        $str->bindParam("id_resposta",               $post[$x]["id_resposta"]);
        $str->bindParam("id_tabrevisores",          $post[$x]["id_tabrev"]);
       

        $str->execute();
    }
        

        $post = true;
        return $this->response->withJson($post);
   
  });

  $app->get('/retornoautor/{id}{id_atv}', function ($request, $response, $args){

    $str = $this->db->prepare("SELECT RESP.diagrama, REV.comentario AS comentgeral, REV.id_revisor, RA.id_aspectos, RA.id_asprev, RA.comentario, ASP.item 

    FROM resposta RESP
    
    INNER JOIN rodadas ROD ON RESP.id_atividade = ROD.id_atv
    INNER JOIN revisores REV ON ROD.rodadaatual = REV.rodada
    INNER JOIN respostaaspectos RA ON REV.id_tabrevisores = RA.id_tabrevisores
    INNER JOIN aspectos ASP ON RA.id_aspectos = ASP.id_aspectos
    
    WHERE RESP.id_usuario = ".$args["id"]." AND RESP.id_atividade =".$args["id_atv"]);
    $str->execute();
    $post = $str -> fetchAll();
   return $this->response->withJson($post);
});

$app->put('/revisado/{id}', function ($request, $response, $args) {
    $post = $request->getParsedBody();
    print_r($post);
    $dado = 1;
          $str = $this->db->prepare("UPDATE revisores set respondido = :respondido where id_tabrevisores =".$args["id"]); 
                                       
        $str->bindParam("respondido",              $dado);

        $str->execute();
   return $this->response->withJson($post);
   
  });

  $app->get('/retresp/{id}/{id_atv}', function ($request, $response, $args){

    $str = $this->db->prepare("SELECT  RA.id_aspectos, RA.id_asprev, RA.id_resposta AS xxx, RA.comentario, RA.id_tabrevisores, REV.id_atv, REV.id_autor, REV.id_resposta, REV.id_revisor, REV.rodada, REV.comentario AS comentgeral, REV.respondido
    
     FROM respostaaspectos RA

    INNER JOIN revisores REV ON RA.id_tabrevisores = REV.id_tabrevisores
    
    WHERE REV.id_revisor = ".$args["id"]." AND REV.id_atv = ".$args["id_atv"]." AND REV.respondido = 1");
    
    $str->execute();
    $post = $str -> fetchAll();
   return $this->response->withJson($post);
});

$app->get('/retresptwo/{id}/{id_atv}', function ($request, $response, $args){

    $str = $this->db->prepare("SELECT  RA.id_aspectos, RA.id_asprev, RA.id_resposta AS xxx, RA.comentario, RA.id_tabrevisores, REV.id_atv, REV.id_autor, REV.id_resposta, REV.id_revisor, REV.rodada, REV.comentario AS comentgeral, REV.respondido
    
     FROM respostaaspectos RA

    INNER JOIN revisores REV ON RA.id_tabrevisores = REV.id_tabrevisores
    
    WHERE REV.id_autor = ".$args["id"]." AND REV.id_atv = ".$args["id_atv"]." AND REV.respondido = 1");
    
    $str->execute();
    $post = $str -> fetchAll();
   return $this->response->withJson($post);
});

