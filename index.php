
<?php
    include 'ChromePhp.php';
    function getData(){
      $key = '2bb393aebb088dea340a936c4e15a222';
      $curl = curl_init();
      $city= $_POST['text'];

      curl_setopt_array($curl, array(

        CURLOPT_URL => "https://api.openweathermap.org/data/2.5/forecast/?q=".$city."&appid=".$key."&units=metric",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      $result =json_decode($response, true);
      ChromePhp::log($result);

      $message=$result['message'];

      if ($message ==null) {
        $length=count($result['list']);
        ChromePhp::log($length);
        ChromePhp::log($result['list'][0]['main']['temp']);
        $minTemps = array ();
        $maxTemps = array ();
        for ($i=0;$i<8;$i++) {
          array_push($minTemps,$result['list'][$i]['main']['temp_min']);
          array_push($maxTemps,$result['list'][$i]['main']['temp_max']);
        }
        ChromePhp::log($minTemps);
        ChromePhp::log($maxTemps);
        $icons= $result['list'][$i]['weather'][0]['icon'];
        // div 1
        echo("<div class=\"first-result-container\">");
        echo("<div class=\"first-result-1a\">");
        echo($result['list'][0]['main']['temp']);
        echo("</div>");
        echo("<div class=\"first-result-1b\">");
        echo("<img src=http://openweathermap.org/img/w/".$icons.".png></img>");
        echo($result['list'][0]['weather'][0]['description'].' ');
        echo("</div>");
        echo("</div>");
        // einde div 1
        echo("<div class=\"first-result-2\">");
        echo(max($maxTemps));
        echo(min($minTemps));
        echo($result['list'][0]['main']['humidity'].' ');
        echo($result['list'][0]['wind']['speed'].' ');
        echo("</div>");
        for($i=8;$i<$length;$i+=8) {
        echo("<div class=\"results\">");
        echo($result['list'][$i]['main']['temp'].' ');
        echo($result['list'][$i]['main']['temp_min']);
        echo($result['list'][$i]['main']['temp_max']);
        echo($result['list'][$i]['weather'][0]['description'].' ');
        $icons= $result['list'][$i]['weather'][0]['icon'];
        echo("<img src=http://openweathermap.org/img/w/".$icons.".png></img>");
        echo("</div>");
        }
      } else { 
        echo("<div class=\"results\">");
        echo("City not found");}
        echo("</div>");
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="container">
  <div class="top-side-container">
    <div class="top-side">
      <form action="" method="POST">
        <input type="text" name="text">
        <input type="submit" name="submit">
      </form>
    </div>
    <div class="top-side-2">
    <h2>Gent</h2>
    </div>
  </div>
      <?php
      if (isset($_POST['submit'])) {
        getData();
      };
      ?>
</div>
</body>
</html> 