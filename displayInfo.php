<?php

include 'header.php';
include 'getContent.php';

    $result = $_POST['userStopId'];
    $result_explode = explode('|', $result);
    $stopId = $result_explode[0];
    $routeTag = $result_explode[1];
    $stopLat = $result_explode[2];
    $stopLon = $result_explode[3];
    
    //display next bus route and stop name

	$url1 = 'http://webservices.nextbus.com/service/publicXMLFeed?command=predictions&a=ttc&stopId='. $stopId .'&routeTag=' . $routeTag;
    $arr1 = get_content($url1);

	$p1 = xml_parser_create();
	$vals1 = NULL;
	$index1 = NULL;
	xml_parse_into_struct($p1, $arr1, $vals1, $index1);
	xml_parser_free($p1);

?>

<div class='row'>

<div class='col l4' id='basicInfoCol1'>

	<h2 style='margin-left:10%;'>Next Bus Arrivals</h2>

	<br/>
	<br/>

<?php
	foreach ($vals1 as $val)
	{
		if (isset($val['attributes']['ROUTETITLE']))
		{
			$routeTitle = $val['attributes']['ROUTETITLE'];
			$stopName = $val['attributes']['STOPTITLE'];
			echo "<div style='margin-left:10%;'>Route " . $routeTitle . "<br/>";
			echo "Stopping at: " . $stopName . "</div>";
		}
	}

?>
<br/>
		<br/>
		<div style='margin-left:10%;'>
		<a href='index.php'>Do you need to check another route?</a>
		</div>

		<br/>


	</div> <!--end div col4-->

	<div class='col l4' id='arrivalsCol2'>

	<h2>Arrivals</h2>

	<?php

	//get nextbus arrival minutes and vehicle #

    $url = 'http://webservices.nextbus.com/service/publicXMLFeed?command=predictions&a=ttc&stopId='. $stopId .'&routeTag=' . $routeTag;
    $arr = get_content($url);

	$p = xml_parser_create();
	$vals = NULL;
	$index = NULL;
	xml_parse_into_struct($p, $arr, $vals, $index);
	xml_parser_free($p);

	$increment = 1;

?>



 <?php
	foreach ($vals as $val)
	{
		if (isset($val['attributes']['EPOCHTIME']))
		{
			$stopMinutes = $val['attributes']['MINUTES'];
			$stopVehicle = $val['attributes']['VEHICLE'];
			echo "<br/><h3>Arrival For Vehicle # " . $increment . " </h3>";
			echo "Minutes until arrival: " . $stopMinutes . "<br/>";
			echo "Vehicle: " . $stopVehicle . "<br/>";
			$increment++;
			if($increment==6)
			{
				break;
			}
		}
	}
?>
	</div> <!--end div col l3-->

	<div class='col l4' id='weatherCol3'>

<?php



	$wAPIKey = '8038dd4903994383afb76053bac8ed0a';
	$urlW1 = 'http://api.openweathermap.org/data/2.5/weather?lat=' . $stopLat . '&lon=' . $stopLon . '&mode=xml&APPid=' . $wAPIKey;
	$arrW1 = get_content($urlW1);

	$pW1 = xml_parser_create();
	$valsW1 = NULL;
	$indexW1 = NULL;
	xml_parse_into_struct($pW1, $arrW1, $valsW1, $indexW1);
	xml_parser_free($pW1);
?>


	<h2>Current Weather</h2>
<?php
	$currentTempKelvin = $valsW1[6]['attributes']['VALUE'];
	$currentTemp = $currentTempKelvin - 273.15;
	$currentHumidity = $valsW1[7]['attributes']['VALUE'] . "%"; 
	$currentWind = $valsW1[10]['attributes']['NAME'];
	$currentClouds = $valsW1[14]['attributes']['NAME'];
	$currentRain = $valsW1[16]['attributes']['MODE'];
	$currentWeather = $valsW1[17]['attributes']['VALUE'];
			
	echo "Overall: " . $currentWeather . "<br/>";
	echo "Temperature: " . $currentTemp . " &degC <br/>";
	echo "Humidity: " . $currentHumidity . "<br/>";
	echo "Wind: " . $currentWind . "<br/>";
	echo "Clouds: " . $currentClouds . "<br/>";
	echo "Rain: " . $currentRain . "<br/>";
?>


<br/>
<br/>


<div>
<?php

if ($currentHumidity > 60)
{
	?>
		<div>Remember your rainboots!</div>
		<br/>
		<img src='images/rainy.jpg' class='weatherPics' alt='Image of rainy weather'>
	<?php
}
else if ($currentClouds > 40)
{
	?>
		<div>Dreary today, but it could be worse.</div>
		<br/>
		<img src='images/cloudy.jpg' class='weatherPics' alt='Image of cloudy weather'>
	<?php
}
else if ($currentTemp > 20)
{
	?>
		<div>Make sure you keep drinking water!</div>
		<br/>
		<img src='images/sun.jpg' class='weatherPics' alt='Image of sunny weather'>	<?php
}
else if ($currentTemp < -10)
{
	?>
		<div>Good luck in this cold weather, hope you make your bus.</div>
		<br/>
		<img src='images/cold.jpg' class='weatherPics' alt='Image of cold weather'>
	<?php
}
else
{
	?>
		<div>Have a lovely day!</div>
		<br/>
		<img src='images/logo.jpg' class='weatherPics' alt='Image of logo'>
	<?php
}

?>

</div><!--end col4 current weather-->

</div><!--end row-->


    




</div>
</body>
</html>