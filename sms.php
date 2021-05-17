<?php
  $gatewayURL  =   'http://localhost:9333/ozeki?'; 
  $request = 'login=admin'; 
  $request .= '&password=abc123'; 
  $request .= '&action=sendMessage'; 
  $request .= '&messageType=SMS:TEXT'; 
  $request .= '&recepient='.urlencode('+2348023130565'); 
  $request .= '&messageData='.urlencode("Hello Wale"); 

  $url =  $gatewayURL . $request;  

  //Open the URL to send the message 
   file($url); 
?>