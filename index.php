
<?php
    include 'ChromePhp.php';
    function getData(){
      $key = '2bb393aebb088dea340a936c4e15a222';
      $curl = curl_init();
      $city= $_POST['text'];

      curl_setopt_array($curl, array(

        CURLOPT_URL => "https://api.openweathermap.org/data/2.5/forecast/?q=".$city."&appid=".$key,
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

      if ($message ==null && $message ==0) {
        $length=count($result['list']);
        ChromePhp::log($length);
        ChromePhp::log($result['list'][0]['main']['temp']);
        for($i=0;$i<$length;$i+=8) {
          echo("<div class=\"results\">");
          echo($result['list'][$i]['main']['temp'].' ');
          echo($result['list'][$i]['main']['temp_min'].' ');
          echo($result['list'][$i]['main']['temp_max'].' ');
          echo($result['list'][$i]['main']['humidity'].' ');
          echo($result['list'][$i]['weather'][0]['icon'].' ');
          echo($result['list'][$i]['weather'][0]['description'].' ');
          echo($result['list'][$i]['wind']['speed'].' ');
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <form action="" method="POST">
    <input type="text" name="text">
    <input type="submit" name="submit">
  </form>
  <div id="wrapper">
    <?php
    if (isset($_POST['submit'])) {
      getData();
    };
    ?>
  </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>