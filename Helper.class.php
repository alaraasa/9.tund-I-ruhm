<?php

class Helper {

function __construct(){
	
}

function cleanInput($input){
		
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
		
	return $input;
	
	}
}
?>