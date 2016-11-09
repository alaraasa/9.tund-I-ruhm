<?php

	require("/home/alaraasa/config.php");

	$database = "if16_alaraasa";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);

	require("class/User.class.php");
	$User = new User($mysqli);

	require("class/Car.class.php");
	$Car = new Car($mysqli);

	require("class/Interest.class.php");
	$Interest = new Interest($mysqli);

	require("class/Helper.class.php");
	$Helper = new Helper();
	
	// see fail, peab olema kõigil lehtedel kus 
	// tahan kasutada SESSION muutujat
	session_start();
	
?>