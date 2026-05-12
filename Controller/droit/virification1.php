 <?php

	include('config.php');
$verif = "select * from user_licence where statut = 'ACTIF'";
	$ok = mysqli_query($conn,$verif);

		if ($vue = mysqli_fetch_assoc($ok)) {

			$date_pub = $vue['dure'];
			$test = $vue['test'];
			$now = time();


			$verifs = "select * from absence";
	$ok1 = mysqli_query($conn,$verifs);

		if ($vues = mysqli_fetch_assoc($ok1)) {

			$lc_date = $vues['lc_date'];

			if ($lc_date == $date_pub) 
			{
				
						if ($now < $test) {
									echo "votre ordinateur n'est pas à l'heure";
								} else {

								if ($test > $date_pub) {

							$ins = "DELETE FROM `user_licence` WHERE 1";
							$ok = mysqli_query($conn,$ins);

							echo "<h3 style='color:red'><b>VOUS N'AVEZ PLUS DE LICENCE ACTIVE</b></h3>";
					} 
					else 
					{
						$ins = "UPDATE user_licence SET test = '$now'";
							$ok = mysqli_query($conn,$ins);

									include('Controller/droit/date.php');
					}
					}

			} 
			else 
			{
				echo "Vole detecter systeme bloquer";
			}
		}	


	}
	else
	{
		echo "<h3 style='color:red'><b>VOUS N'AVEZ PLUS DE LICENCE ACTIVE</b></h3>";
	}

?>