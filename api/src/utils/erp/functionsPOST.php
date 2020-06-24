<?php
function postERP($servico, $json)
{
 set_time_limit(5000);
 $ch = curl_init(URL_ERP() . $servico);
 curl_setopt($ch, CURLOPT_HEADER, 0);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
 $result = curl_exec($ch);
 curl_close($ch);
 return $result;
}