<?php

function login($db, $corpo)
{
    $json = json_encode($corpo);
    $retorno = postERP("LOGIN", $json);   
    $usuario = json_decode($retorno);
    $aRetorno = null;
    if($usuario->sucesso !==  "false"){
        $codigoUsuario = "003126";//explode("-",$usuario->erros[0]->descricaoErro)[0];
           
        $aux = json_decode(getERP("FUNCUSER/"   .   $codigoUsuario));
        //return $aux->funcionarios[0]->codCC;
        $str = $db->prepare("SELECT * from centroCusto where centroCusto = :cc");
        $str->bindParam("cc", $aux->funcionarios[0]->codCC);
        $str->execute();
        $post = $str->fetchAll();
        $post = $post[0];
        if($post["chefe"] == $aux->funcionarios[0]->matricula){
            $nivel = 1;
        }else if($post["gerente"] == $aux->funcionarios[0]->matricula){
            $nivel = 2;
        }else if($post["diretor"] == $aux->funcionarios[0]->matricula){
            $nivel = 3;
        }else if($post["chefeRh"] == $aux->funcionarios[0]->matricula){
            $nivel = 4;
        }else{
            $nivel = 0;
        }
        $aRetorno = array("sucesso"=>true,
            "mensagem"=>"Usuário OK",
            "usuario"=>$aux->funcionarios[0],
            "nivel"=> $nivel
        );
    }else{
        $aRetorno = array("sucesso"=>false,
            "mensagem"=>$usuario->erros[0]->descricaoErro,
        "usuario"=>array());
    }
    return $aRetorno;
}
