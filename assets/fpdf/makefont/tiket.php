<?php 
	// gauche
	$pdf->SetFont('Arial','b',11);
	$pdf-> setXY($X+2,$Y+3);
	$pdf-> Cell(40,5,'PHARMACIE DE BANSOA SARL');
	$pdf->SetFont('Arial','i',11);
	$pdf-> setXY($X+2,$Y+8);
	$pdf-> Cell(105,5,'Face Campost Penka-Michel','0','1','L');

	$pdf-> setXY($X+2,$Y+13);
	$pdf-> Cell(40,5,'TEL  : 697852352','0','1','l');

	$pdf->SetFont('Arial','bi',10);

	$pdf-> setXY($X+0,$Y+27);
		$pdf-> Cell(65,5,' Produit','0','0','l');
		$pdf-> Cell(14,5,'P.U','0','0','C');
		$pdf-> Cell(10,5,'Qte','0','0','l');
		$pdf-> Cell(16,5,'Total','0','0','C');

	$pdf-> setXY($X+2.5,$Y+32);

	$pdf-> setX($X+0);
	$pdf-> Cell(105,0,'','1','1','1');

	$pdf->SetFont('Arial','i',10);

		$total = 0; $colis=0;
	foreach ($ok as $key) {
		$pdf-> setX($X=1);

		$long = strlen($key['nom']);

		if ($long > 28) {
			$nom = substr($key['nom'], 0,26)."...";
		} else {
			$nom = $key['nom'];
		}
		
		
		$pdf-> Cell(65,7, $nom ,'0','0','l');
		$pdf-> Cell(14,7, $key['prix'] ,'0','0','l');
		$pdf-> Cell(10,7, $key['qte'] ,'0','0','l');
		$pdf-> Cell(16,7, $key['total'] ,'0','1','L');

		$total +=$key['total'];
		$colis +=1;
	}

	$pdf-> setX($X=0);  $pdf-> Cell(105,0,'','1','1','1');

	$positionY = $pdf-> GetY();  $pdf-> setY($positionY+2);

		$pdf->SetFont('Arial','b','10');
				$pdf-> setX($X+60);
				$pdf-> Cell(35,4,'NET A PAYER: '.number_format($total,0,',',' ').' F','0','1','l');	

		$pdf-> setXY($X+0,$positionY+5);
			if (isset($key['recu']) && $key['recu'] - $total > 0) {

				$pdf->SetFont('Arial','',10);
				$pdf-> setX($X+0);
				$pdf-> Cell(50,4,'PAYER EN ESPECE '.$key['recu'].' F','0','1','L');
				$pdf-> setX($X+0);
				$pdf-> Cell(32,4,'MONTANT RENDU '.($key['recu'] - $total).' F','0','1','L');
			}

		$pdf->SetFont('Arial','i','11');
			$positionY = $pdf-> GetY();
			$pdf-> setXY($X+0,$positionY+5);
			$pdf-> Cell(105,5,"BONNE GUERISON  !",'0','0','C');

		////////////////////////////////////////////////////
		$pdf-> setXY($X+79,$Y+18);
		$pdf-> Cell(25,7,$quoi[1],'1','0','C');

		$pdf->SetFont('Arial','i',9);	

		$pdf-> setXY($X+78,$Y+3);
		$pdf-> Cell(9,4,date( 'j-m-Y H:i', strtotime($key['dates']??date('Y-m-d H:i:s'))),'0','1','l');

		$pdf-> setXY($X+2,$Y+19);
		$pdf-> Cell(16,4,'vendeur : '.substr($key['vendeur']??"pharmacie", 0,10),'0','0','l');


		$pdf->SetFont('Arial','i','9');

		$pdf-> setXY($X+78,$Y+8);
		$pdf-> Cell(25,4,$colis.' COLIS','0','0','l');

		$pdf-> setXY($X+77,$Y+12);
		// $pdf-> Cell(25,4,$key['livree']==0?"non livree":"livree",'0','0','l');
		$pdf-> Cell(25,4,"livree",'0','0','l');

		$pdf->SetFont('Arial','b','12');

	////////////////////////////////////////////////////

		$positionY = $pdf-> GetY();

		$pdf-> setXY($X-1,$positionY+130);
		$pdf-> Cell(1,1,'.','0','0','L');

	$pdf->Output('I',"tiket ".$quoi[1]."");

?>