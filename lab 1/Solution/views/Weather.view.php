<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php if(isset($_POST["city"])):?>
    <h1><?php echo $cityWeather["name"]?> Weather Status</h1>
    <p><?php echo $cityWeather["time"]?></p>
    <p><?php echo $cityWeather["date"]?></p>
    <p><?php echo $cityWeather["status"]?></p>
    <img src="<?php echo $cityWeather["icon"]?>" alt="">
    <p>max temp: <?php echo $cityWeather["max_temp"]?>C, min temp: <?php echo $cityWeather["min_temp"]?>C</p>
    <p>Humadity: <?php echo $cityWeather["humadity"]?>%</p>
    <p>Humadity: <?php echo $cityWeather["wind_speed"]?> km/h</p>

  <?php endif ?>
<form action="index.php" method="post">
  <select name="city" id="city">
    <?php foreach($egyptCities as $city):?>
    <?php if($city->country == "EG"):?>
      <option value="<?php echo $city->id?>">EG >> <?php echo $city->name ?></option>
    <?php endif?>
    <?php endforeach?>
  </select>
  <input type="submit" value="GetWeather">
</form>
</body>
</html>