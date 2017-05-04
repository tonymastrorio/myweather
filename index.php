<?php

	$weather = "";
	$error = "";

	if (array_key_exists('city', $_GET)) {

		$city = str_replace(' ', '', $_GET['city']);

		$file_headers = @get_headers("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");

		if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {

    		$error = "That city could not be found.";

		} else {

		$forecastPage = file_get_contents("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");

		$pageArray = explode('3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">', $forecastPage);

		if (sizeof ($pageArray) > 1) {

			$secondPageArray = explode('</span></span></span>', $pageArray[1]);

			if (sizeof ($secondPageArray) > 1) {

				$weather = $secondPageArray[0];

				} else {

					$error = "That city could not be found.";

				}

			} else {

				$error = "That city could not be found.";

			}

		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>MyWeather</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="myweather.css">
</head>
<body>

<div id="maincontainer">

<h1>What's the Weather?</h1>

<form>

	<div class="form-group">
	<label for="city">Enter the name of a city below:</label>
    <input type="city" class="form-control" id="city" name="city" placeholder="Eg. New York, London, Tokyo" value="<?php 

    	if (array_key_exists('city', $_GET)) {

			echo $_GET['city']; 

		} 

	?>">

  </div>

	<button type="submit" class="btn btn-primary">Submit</button>

	<div id="weather"><?php if ($weather) {

		echo '<div class="alert alert-success" role="alert">'.$weather.'</div>'; 


	} else if ($error) {

		echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';

	}

		?></div>

</form>

</div>

</body>
</html>