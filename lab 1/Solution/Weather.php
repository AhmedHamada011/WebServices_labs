<?php

use \JsonMachine\Items;
class Weather {
  private $cities;
  private $cityId;


  public function __construct($file="city.list.josn")
  {
    $this->cities = Items::fromFile($file);
    
  }

  public function getCities(){

    return $this->cities;
  }

  public function setCity($cityId){
    $this->cityId = $cityId;
  }


  public function getCityWeatherWithCurl(){

    $url = "https://api.openweathermap.org/data/2.5/weather?id=" . $this->cityId. "&appid=453a29cd4f2dd9dcd3c7dc07a477d04c&units=metric";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
  
    $response = curl_exec($ch);
  
    curl_close($ch);
  
    $data = json_decode($response);
  
    return $this->ConvertToArray($data);
  
  }

  public function getCityWeatherWithGuzzle(){
    $url = "https://api.openweathermap.org/data/2.5/weather?id=" . $this->cityId. "&appid=453a29cd4f2dd9dcd3c7dc07a477d04c&units=metric";

    $client =  new \GuzzleHttp\Client();;
    $response = $client->get($url);

    $data = json_decode($response->getBody());
  
    return $this->ConvertToArray($data);

  }

  private function ConvertToArray($data){
    $cityWeathInfo = [];
    $cityWeathInfo["name"] = $data->name;
    $cityWeathInfo["time"] = date("l H:m a", $data->dt);
    $cityWeathInfo["date"] = date("jS F, Y",$data->dt);
    $cityWeathInfo["status"] = $data->weather[0]->description;
    $cityWeathInfo["icon"] = "https://openweathermap.org/img/wn/" . $data->weather[0]->icon . "@2x.png";
    $cityWeathInfo["max_temp"] = $data->main->temp_max;
    $cityWeathInfo["min_temp"] = $data->main->temp_min;
    $cityWeathInfo["humadity"] = $data->main->humidity;
    $cityWeathInfo["wind_speed"] = $data->wind->speed;

    return $cityWeathInfo;

  }


}

$weather = new Weather("city.list.json");

$egyptCities = $weather->getCities();



if(isset($_POST["city"])){

  $weather->setCity($_POST["city"]);
  $cityWeather = $weather->getCityWeatherWithGuzzle();

}

require_once("views/Weather.view.php");