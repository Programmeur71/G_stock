 <?php
	include('config.php');
if(!(isset($_SESSION['Pharmacie'])))
{ 
	if (($_SESSION['Pharmacie']) == []) 
	{
		 header("location:index.php");
	}

}


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
							$show = 'date';
				echo '<script type="text/javascript"> location.replace("index.php?rqt='.$show.'"); </script>';
			} else {

			if ($test > $date_pub) {

					$ins = "DELETE FROM `user_licence` WHERE 1";
					$ok = mysqli_query($conn,$ins);
			$show = 'expire';
					echo '<script type="text/javascript"> location.replace("index.php?rqt='.$show.'"); </script>';
			} 
			else 
			{
				$ins = "UPDATE  user_licence SET test = '$now'";
					$ok = mysqli_query($conn,$ins);

							/*include('pages/base/droit_capitale/php/date.php');*/
			}
			}
				


			} 
			else 
			{
			$show = 'vole';
					echo '<script type="text/javascript"> location.replace("index.php?rqt='.$show.'"); </script>';
			}
		}	


	}
	else
	{
		$show = 'expire';
		echo '<script type="text/javascript"> location.replace("index.php?rqt='.$show.'"); </script>';
	}


?>
