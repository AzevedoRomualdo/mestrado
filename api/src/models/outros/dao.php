<?php
function getCentrodeCusto(){
    $centroCusto = json_decode(utf8_encode(getERP("CENTROCC")));
    return $centroCusto->Centro;
}

function getDepartamento(){
    $departamento = json_decode(utf8_encode(getERP("DEP")));
    return $departamento->Depto;
}

function getFuncionario(){
    $funcionario = json_decode(utf8_encode(getERP("FUNC")));
    return $funcionario->funcionarios;
}
function getFunciCentro($dbERP, $centrodeCusto){
    $funciCusto = json_decode(utf8_encode(getERP("FUNC/". $centrodeCusto)));
    return $funciCusto;
}

function getFunciCentroCusto($dbERP, $centrodeCusto, $datainicio, $datafim){
    $funciCusto = json_decode(utf8_encode(getERP("FUNC/". $centrodeCusto)));

    foreach($funciCusto->funcionarios as $aux){
        $saldo = 0;
        $sth = $dbERP->prepare(" Declare @cMat    Varchar (6)
        Declare @DataIni Varchar (8)
        Declare @DataFim Varchar (8)
        
            set @cMat    = :matricula
            set @DataIni = :datainicio
            set @DataFim = :datafim
        
        SELECT PC_MAT MAT, SUM(PC_QUANTC) 'QTD.CALC', SUM(PC_QUANTI) 'QTD.INF'  
          FROM SPC010 SPC 
         WHERE D_E_L_E_T_  = '' 
           AND PC_TIPOHE  <> ''
           AND PC_MAT      = @cMat
           AND PC_DATA BETWEEN @DataIni AND @DataFim   
         GROUP BY PC_MAT");
         $sth->bindParam("matricula",            $aux->matricula);
         $sth->bindParam("datainicio",            $datainicio);
         $sth->bindParam("datafim",                $datafim);
         $sth->execute(); 
         $total = $sth->fetchAll();
        if(count($total)> 0){
            $saldo = floatval($total[0]["QTD.INF"]);
        }else{
            $saldo =0;
        }
        $aux->saldo = $saldo;
    }
    return $funciCusto;
}