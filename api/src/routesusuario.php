<?php

use Slim\Http\Request;
use Slim\Http\Response;
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// //Load Composer's autoloader
// require '../vendor/autoload.php';


$app->get('/listaalunos', function ($request, $response, $args) {
  $str = $this->db->prepare("SELECT id, nome, matricula from usuario where tipo = 2");
  $str->execute();
  $post = $str->fetchAll();
 
  return $this->response->withJson($post);
});


$app->post('/usuario', function ($request, $response, $args) {
  // $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
  // // try {
  // //Server settings
  //     $mail->SMTPDebug = 0;                                 // Enable verbose debug output
  //     $mail->isSMTP();                                      // Set mailer to use SMTP
  //     $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
  //     $mail->SMTPAuth = true;                               // Enable SMTP authentication
  //     $mail->Username = 'eranio.leite@kodigos.com.br';                 // SMTP username
  //     $mail->Password = 'Esl21202839';                           // SMTP password
  //     $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
  //     $mail->Port = 587;                                    // TCP port to connect to


  //     $mail->CharSet = 'UTF-8';
      
  // //Recipients
  //     $mail->SetFrom('eranio.leite@kodigos.com.br', 'Eranio da Kodigos');


  //     $mail->addAddress('eranioleite@gmail.com', 'Eranio du Gmail');   

  // //Content
  //     $mail->isHTML(true);                                  // Set email format to HTML
  //     $mail->Subject = 'teste';
  //     $mail->Body = 'body';

  //     if(!$mail->send()) {
  //       echo $mail->ErrorInfo;
  //     } else {
  //       echo "email enviado";
  //     }


  // } catch (Exception $e) {
  //     echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
  // }
    $post = $request->getParsedBody();
    $sqls = "SELECT  COUNT(*) as quantidade  from usuario where upper(matricula) like upper('".$post["matricula"]."')";                         
    $sth = $this->db->prepare($sqls);
    $sth->execute();
    $lanca = $sth->fetchAll();
    $quat = $lanca[0]['quantidade'];

    if($quat == 0){ 
          $str = $this->db->prepare("INSERT INTO usuario (nome, tipo, matricula, email, universidade, senha) Values (:nome, :tipo, :matricula, :email, :universidade, :senha)"); 
                                       
        $str->bindParam("nome",              $post["nome"]);
        $str->bindParam("tipo",              $post["tipo"]);
        $str->bindParam("matricula",              $post["matricula"]);
        $str->bindParam("email",              $post["email"]);
        $str->bindParam("universidade",                 $post["universidade"]);
        $str->bindParam("senha",                 $post["senha"]);
        $str->execute();    
       $post = true;
      
        
        return $this->response->withJson($post);
    }else{
      $post = "false";
      return $this->response->withJson($post);
  }
  });

  $app->get('/usuarioedit/{id}', function ($request, $response, $args) {
  
    $str = $this->db->prepare("SELECT * from usuario where id = ".$args["id"]); 
    $str -> execute();
    $post = $str -> fetchAll();

    return $this->response->withJson($post);
});

  $app->put('/editusuario/{id}', function ($request, $response, $args) {
    $post = $request->getParsedBody();
    //return $this->response->withJson($post);
          $str = $this->db->prepare("UPDATE usuario SET nome =:nome, tipo=:tipo, matricula=:matricula, email=:email, universidade=:universidade, senha=:senha WHERE id =:id_usuario"); 
                                      
        $str->bindParam("nome",              $post["nome"]);
      //  $str->bindParam("tipo",         $args["id"]);
        $str->bindParam("matricula",         $post["matricula"]);
        $str->bindParam("email",         $args["email"]);
        $str->bindParam("universidade",         $args["universidade"]);
        $str->bindParam("senha",         $args["senha"]);
        $str->execute();
        $post = true;
     return $this->response->withJson($post);
});

  
  