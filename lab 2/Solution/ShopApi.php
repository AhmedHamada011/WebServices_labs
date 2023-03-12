<?php
require_once("config.php");
require_once("function.php");

require_once("MySQLHandler.php");



$method = $_SERVER["REQUEST_METHOD"];

$url_piecies = explode("/",$_SERVER["REQUEST_URI"]);

$resource = $url_piecies[2];
$resource_id = $url_piecies[3];


$mysql = new MySQLHandler("products");

try {
    $mysql->connect();
}
catch(\Exception $e){

  error(500,"internal server error!");
  exit();
}

if($resource === "items"){

  switch($method){
  
    case "GET":
      
        $result = $mysql->get_record_by_id($resource_id);
        if($result)
          echo json_encode($result);
        else
          error(404,"Resource dosn't exist");
      break;
    case "POST":
      header ("Content-Type: application/json");

      $data = json_decode(file_get_contents("php://input"),true);

      $mysql->save($data);

      echo json_encode(["success" => "Product added successfully"]);

      break;


      case "PUT":

        header ("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"),true);
  
        $mysql->update($data,$resource_id);

        echo json_encode(["success" => "Product updated successfully"]);

  
        break;
      case "DELETE":
        header ("Content-Type: application/json");
        $mysql->delete($resource_id);
        echo json_encode(["success" => "Product Deleted successfully"]);
        break;

    default:
      error(405,"method not allowed!");
      break;
  
  }
}else{
  error(404,"Resource dosn't exist");
} 

