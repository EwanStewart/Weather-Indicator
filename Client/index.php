<!DOCTYPE html>
<html lang="en">

   <head>
      <meta charset="utf-8">
      <title>CMP408</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
   </head>


   <body class="bg-secondary">

      <nav class="navbar navbar-expand-sm bg-warning">
         <div class="navbar-brand">
            <a>
               <h3 style="font-weight:bold;"> CMP408 IoT and Cloud Secure Development - 2022-23 </h3>
               <br> Ewan Stewart - 1900598
            </a>
         </div>
      </nav>
          <br><br>
      <div class="container-fluid">



         <div class="container bg-light">

            <?php

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            $uapp = "./piiotest writepin ";

            ?>

            <br><br>

            <h1>Weather Station</h1>
            <p> Below is the current weather and the weather forcasted for the next 6 hours.</p>
            <p> This information is both represented on this interface and the connected Raspberry PI through LEDs.</p>
            <br>
                        <?php

                                $command = escapeshellcmd('python get-data-from-api.py');
                                $current = shell_exec($command);
                                $current = trim($current, "(");
                                $current = trim($current, ")");
                                $current = explode(",",$current);




                        echo '<div class = "row">';

                    echo '<div class="col-sm-6">';
                        echo '<div class="card">';
                            echo '<div class="card-header">';
                                echo 'Current Weather';
                            echo '</div>';
                            echo '<div class="card-body">';


                                echo 'The current temperature is: ' . $current[0] . '&#8451;';
                                echo "<br><br>";


                                $val_r = 0;
                                if ($current[2] == 1) {
                                    $val_r = 1;
                                    echo 'It is forcasted to be currently raining.';
                                } else {
                                    $val_r = 0;
                                    echo 'It is not forcasted to be currently raining.';
                                }


                                $cmd = $uapp . 14 . " " . $val_r . '';
                                $output = shell_exec($cmd);
                                $output;


                            echo '</div>';
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="col-sm-6">';
                        echo '<div class="card">';
                            echo '<div class="card-header">';
                                echo 'Future Weather';
                            echo '</div>';
                            echo '<div class="card-body">';

                                echo 'The temperature on average over the next 6 hours is: ' . $current[1] . '&#8451;';
                                echo "<br><br>";
                                if ($current[3] == 1) {
                                    echo 'It is forcasted to be raining over the next 6 hours.';
                                    $val_r = 1;
                                } else {
                                    $val_r = 0;
                                    echo 'It is not forcasted to be raining over the next 6 hours.';
                                }

                                $cmd = $uapp . 15 . " " .  $val_r  . '';
                                $output = shell_exec($cmd);
                                $output;

                            echo '</div>';
                        echo '</div>';
                    echo '</div>';

                echo '</div>';


                if ($current[1] < $current[0]) {
                    $cmd = $uapp . 18 . " " . 1 . '';
                    $output = shell_exec($cmd);
                    $output;
                }

                                ?>
                <br><br>
         </div>
      </div>

   </body>
</html>