<?php 

require("../functions.php");

	//kui ei ole kasutaja id'd
if (!isset($_SESSION["userId"])){
	
		//suunan sisselogimise lehele
	header("Location: login.php");
	exit();
}


	//kui on ?logout aadressireal siis login välja
if (isset($_GET["logout"])) {
	session_destroy();
	header("Location: login.php");
	exit();
}

$msg = "";
if(isset($_SESSION["message"])){
	$msg = $_SESSION["message"];
	
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
	unset($_SESSION["message"]);
}


if ( isset($_POST["plate"]) && 
	isset($_POST["plate"]) && 
	!empty($_POST["color"]) && 
	!empty($_POST["color"])
	) {
	
	$Car->save($Helper->cleanInput($_POST["plate"]), $Helper->cleanInput($_POST["color"]));

}

if (isset($_GET["q"])){
	$q = $_GET["q"];
} else {
	$q = "";
}

if (isset($_GET["sort"]) && isset($_GET["order"])){
	$sort = $_GET["sort"];
	$order = $_GET["order"];
} else {
	$_GET["sort"] = "";
	$_GET["order"] = "";
}

$carData = $Car->get($q, $_GET["sort"], $_GET["order"]);	

?>
<?php require("../header.php");?>
<h1>Data</h1>
<?=$msg;?>
<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?>!</a>
	<a href="?logout=1">Logi välja</a>
</p>


<h2>Salvesta auto</h2>
<form method="POST">
	
	<label>Auto nr</label><br>
	<input name="plate" type="text">
	<br><br>
	
	<label>Auto värv</label><br>
	<input type="color" name="color" >
	<br><br>
	
	<input type="submit" value="Salvesta">
	
	
</form>

<h2>Autod</h2>

<form method="GET">
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">
</form>

<?php 

$html = "<table class='table table-striped'>";

$order = "ASC";
$idArrow = "&darr;";
$pArrow = "&darr;";
$cArrow = "&darr;";

if(isset($_GET["order"]) && $_GET["order"] == "ASC"){
	$order = "DESC";
}

if(isset($_GET["sort"]) && $_GET["sort"] == "id"){
	$idArrow = "&uarr;";
}

if(isset($_GET["sort"]) && $_GET["sort"] == "plate"){
	$pArrow = "&uarr;";
}

if(isset($_GET["sort"]) && $_GET["sort"] == "color"){
	$cArrow = "&uarr;";
}




$html .= "<tr>";
$html .= "<th>
<a href='?q=".$q."&sort=id&order=".$order."'>
	id ".$idArrow."
</a>
</th>";
$html .= "<th><a href='?q=".$q."&sort=plate&order=".$order."'>
plate " . $pArrow . "
</a></th>";
$html .= "<th><a href='?q=".$q."&sort=color&order=".$order."'>
color " . $cArrow . "
</a></th>";
$html .= "</tr>";

	//iga liikme kohta massiivis
foreach($carData as $c){
		// iga auto on $c
		//echo $c->plate."<br>";
	
	$html .= "<tr>";
	$html .= "<td>".$c->id."</td>";
	$html .= "<td>".$c->plate."</td>";
	$html .= "<td style='background-color:".$c->carColor."'>".$c->carColor."</td>";
	$html .= "<td><a class='bbtn btn-default btn-sm' href='edit.php?id=".$c->id."'><span class='glyphicon glyphicon-pencil'/> Muuda</a></td>";

	$html .= "</tr>";
}

$html .= "</table>";

echo $html;


$listHtml = "<br><br>";

foreach($carData as $c){
	
	
	$listHtml .= "<h1 style='color:".$c->carColor."'>".$c->plate."</h1>";
	$listHtml .= "<p>color = ".$c->carColor."</p>";
}

echo $listHtml;




?>

<br>
<br>
<br>
<br>
<br>
<?php require("../footer.php");?>

