
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
      $message=$result['message'];

      if ($message ==null) {
        echo("<h2>");
        echo(ucfirst($city));
        echo("</h2>");
        $length=count($result['list']);
        $minTemps = array ();
        $maxTemps = array ();
        for ($i=0;$i<8;$i++) {
          array_push($minTemps,$result['list'][$i]['main']['temp_min']);
          array_push($maxTemps,$result['list'][$i]['main']['temp_max']);
        }
        $icons= $result['list'][$i]['weather'][0]['icon'];
        echo("<div class=\"first-result-container\">");
        echo("<div class=\"first-result-1a\">");
        echo("<p>");
        echo(round($result['list'][0]['main']['temp'],1)."&deg");
        echo("</p>");
        echo("</div>");
        echo("<div class=\"first-result-1b\">");
        echo("<img src=http://openweathermap.org/img/w/".$icons.".png></img>");
        echo(ucfirst($result['list'][0]['weather'][0]['description'].' '));
        echo("</div>");
        echo("</div>");
        echo("<div class=\"first-result-2\">");
        echo("<p>");
        echo(round(max($maxTemps),1)."&deg"),"/",(round(min($minTemps),1)."&deg");
        echo("</p>");
        echo("<p>");
        echo("Humidity: ".$result['list'][0]['main']['humidity'].' ');
        echo("</p>");
        echo("<p>");
        echo("Windspeed: ".$result['list'][0]['wind']['speed'].' ');
        echo("</p>");
        echo("</div>");
        echo("<h3>");
        echo("Next four days:");
        echo("</h3>");
        for($i=8;$i<$length;$i+=8) {
        echo("<div class=\"results\">");
        echo("<p>");
        echo(round($result['list'][$i]['main']['temp'],1)."&deg");
        echo("</p>");
        echo("<p>");
        echo(ucfirst($result['list'][$i]['weather'][0]['description'].' '));
        echo("</p>");
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
    <title>Cloud weather app</title>
    <meta name="description" content="Cloud weather app, find your city's current temperature and 5 day forecast.">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200|Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
  <h1> Cloud app </h1>
  <div class="top-side-container">
    <div class="top-side-1">
      <form action="" method="POST">
        <input type="text" name="text" class="input_text">
        <input type="submit" name="submit" class="submit" value="Search">
      </form>
    </div>
  </div>
  <div class="container-app">
      <?php
      if (isset($_POST['submit'])) {
        getData();
      };
      ?>
  </div>
    <footer>
          <div class="copyright">
            <p>&copy; 2019 - Kosmonaut</p>
          </div>
  </footer>
</div>
</body>
</html> 