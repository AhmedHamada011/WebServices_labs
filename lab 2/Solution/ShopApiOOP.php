<?php
require_once("config.php");
require_once("function.php");

require_once("MySQLHandler.php");


class ShopApi
{
    public $resource;
    public $table;
    public $db;

    public function __construct($resource, $table)
    {
        $this->resource = $resource;
        $this->table = $table;

        $this->connect_db();
    }

    public function connect_db()
    {
        $this->db = new MySQLHandler("products");

        try {
            $this->db->connect();
        } catch(\Exception $e) {
            error(500, "internal server error!");
        }
    }

    public function get($id, $statusCode=404, $msg="Resource dosn't exist")
    {
        $result = $this->db->get_record_by_id($id);
        if ($result) {
            echo json_encode($result);
        } else {
            error($statusCode, $msg);
        }
    }

    public function post($data)
    {
        header("Content-Type: application/json");


        $this->db->save($data);

        echo json_encode(["success" => "Product added successfully"]);
    }


    public function put($id,$data)
    {
        header("Content-Type: application/json");

        $this->db->update($data, $id);

        echo json_encode(["success" => "Product updated successfully"]);
    }

    public function delete($id){

      header ("Content-Type: application/json");
      $this->db->delete($id);
      echo json_encode(["success" => "Product Deleted successfully"]);

    }


}

$method = $_SERVER["REQUEST_METHOD"];

$url_piecies = explode("/",$_SERVER["REQUEST_URI"]);

$resource = $url_piecies[2];
$resource_id = $url_piecies[3];


$shop = new ShopApi("items","products");

$data = json_decode(file_get_contents("php://input"), true);




if($resource === "items"){

  switch($method){
  
    case "GET":

      $shop->get($resource_id);
      break;
      
    case "POST":

      $shop->post($data);
      break;

      case "PUT":

        $shop->post($resource_id,$data);
        break;

      case "DELETE":

        $shop->post($resource_id);
        break;

    default:
      error(405,"method not allowed!");
      break;
  
  }
}else{
  error(404,"Resource dosn't exist");
} 

