<?php

class Car {
	private $connection;

	function __construct($this->connection){
		$this->connection = $this->connection;
	}


	function get() {
		$stmt = $this->connection->prepare("
			SELECT id, plate, color
			FROM cars_and_colors
			WHERE deleted IS NULL
			");
		echo $this->connection->error;
		
		$stmt->bind_result($id, $plate, $color);
		$stmt->execute();
		
		
	//tekitan massiivi
		$result = array();
		
	// tee seda seni, kuni on rida andmeid
	// mis vastab select lausele
		while ($stmt->fetch()) {
			
		//tekitan objekti
			$car = new StdClass();
			
			$car->id = $id;
			$car->plate = $plate;
			$car->carColor = $color;
			
		//echo $plate."<br>";
		// iga kord massiivi lisan juurde nr märgi
			array_push($result, $car);
		}
		
		$stmt->close();		
		return $result;
	}

	function save($plate, $color){
		$stmt = $this->connection->prepare("INSERT INTO cars_and_colors (plate, color) VALUES (?, ?)");
		
		echo $this->connection->error;
		
		$stmt->bind_param("ss", $plate, $color);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
	}

	function getSingle($edit_id){
		$stmt = $this->connection->prepare("SELECT plate, color FROM cars_and_colors WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($plate, $color);
		$stmt->execute();
		
	//tekitan objekti
		$car = new Stdclass();
		
	//saime ühe rea andmeid
		if($stmt->fetch()){
		// saan siin alles kasutada bind_result muutujaid
			$car->plate = $plate;
			$car->color = $color;
			
			
		}else{
		// ei saanud rida andmeid kätte
		// sellist id'd ei ole olemas
		// see rida võib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		
		return $car;
	}

	function update($id, $plate, $color){

		$stmt = $mysqli->prepare("UPDATE cars_and_colors SET plate=?, color=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("ssi",$plate, $color, $id);
		
	// kas õnnestus salvestada
		if($stmt->execute()){
	// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
	}

	function delete($id){
		$database = "if16_alaraasa";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		$stmt = $mysqli->prepare("UPDATE cars_and_colors SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $id);


		if($stmt->execute()){
		// õnnestus
			echo "Kustutamine õnnestus!";
		}
		
		$stmt->close();
	}
}
?>