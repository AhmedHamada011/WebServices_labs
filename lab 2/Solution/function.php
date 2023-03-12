<?php

function error($code, $msg){
  header ("Content-Type: application/json");
  http_response_code($code);

  $result["error"] = $msg;
  
  echo json_encode($result);

}