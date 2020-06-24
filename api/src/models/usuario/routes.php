<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes
$app->post('/login', function ($request, $response, $args) {
    $corpo = $request->getParsedBody();
    
    $logado = login($this->db, $corpo);
    return $this->response->withJson($logado);
});

