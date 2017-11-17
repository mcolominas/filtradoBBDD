<!DOCTYPE html>
<html>
<head>
	<title>BBDD- Filtrado con world</title>
	<style>
		table,td, th {
 			border: 1px solid black;
 			border-spacing: 0px;
 		}
 		td, th{
 			padding: 2px;

 		}
	</style>
</head>
<body>
	<?php
		define("HOST", "localhost");
		define("USER", "root");
		define("PASSWORD", "1234");
		define("BBDD", "world");

 		$conn = mysqli_connect(HOST,USER,PASSWORD);
 		mysqli_select_db($conn, BBDD);
		$conn->set_charset("utf8");

		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
			$consulta = "SELECT Name, District, Population FROM `city` WHERE CountryCode = '".$_POST['id']."' ORDER BY Name, District";
			$consultaNombrePais = "SELECT Name FROM `country` WHERE Code = '".$_POST['id']."'";

			$resultat = mysqli_query($conn, $consulta);
			$resultatNombrePais = mysqli_query($conn, $consultaNombrePais);

			$registre = mysqli_fetch_assoc($resultatNombrePais);
			$nombrePais = $registre['Name']; ?>

			<table>
 				<thead>
 					<tr><td colspan="3" align="center" bgcolor="cyan">Llistat de ciutats de <?php echo $nombrePais ?></td></tr>
 					<tr><th>Name</th><th>District</th><th>Population</th></tr>
 				</thead>
	 			<?php while($registre = mysqli_fetch_assoc($resultat)){ ?>
		 			<tr>
			 			<td><?php echo $registre["Name"] ?></td>
			 			<td><?php echo $registre["District"] ?></td>
			 			<td><?php echo $registre["Population"] ?></td>
		 			</tr>
		 		<?php } ?>
			</table>

		<?php }else{
			$consulta = "SELECT DISTINCT(Name), Code FROM `country` ORDER BY Name;";
			$resultat = mysqli_query($conn, $consulta);

			if ($resultat){ ?>
				<form action="index.php" method="post">
					<select name="id">
						<?php while( $registre = mysqli_fetch_assoc($resultat)){ ?>
							<option value="<?php echo $registre["Code"]; ?> "><?php echo $registre["Name"] ?></option>";
						<?php } ?>
					</select>
					<input type="submit" name="enviar" value="enviar">
				</form>
			<?php }else{
				echo "<h1>No se ha podido realizar la consulta.</h1>";
			}
		} 
	?>
</body>
</html>