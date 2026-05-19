<?php  
	//$pdf-> Image('assets/images/a.png',$X+85,$Y+9,40,40);  

	$pdf->SetFont('Arial','b',12);

$total = 0;$total2 = 0; $colis=0;
foreach ($ok as $key) {$total +=$key->qte;$colis +=1;$total2 +=$key->prix_v*$key->qte;}

	$pdf->SetFillColor(210,200,10);
	$pdf-> setXY($X+85,$Y+5);
		$pdf->SetFont('Arial','b','15');
		$pdf-> Cell(50,7,'stock','1','1','C','couleur');


		$pdf->SetFont('Arial','b',10);

			$pdf->SetFillColor(25,200,111);
	
			$pdf-> setXY($X+10,$Y+15);

			$pdf-> Cell(124,7,'DESIGNATION','1','0','L','green');
			$pdf-> Cell(23,7,'prix','1','0','L','green');
			$pdf-> Cell(15,7,'QTE','1','0','L','green');
			$pdf-> Cell(28,7,'MONTANT','1','1','L','green');

            // $ok = $stockdb->getStock();

				

			foreach ($ok as $key) {
				$pdf-> setX($X=10);

				$long = strlen($key->produit);

				if ($long > 53) {
					$produit = substr($key->produit, 0,51)."...";
				} else {
					$produit = $key->produit;
				}
				
				$pdf-> Cell(124,7,$produit ,'BL','0','l');
				$pdf-> Cell(23,7, number_format($key->prix_v,0,' ',' '),'B','0','l');
				$pdf-> Cell(15,7, $key->qte ,'B','0','l');
				$pdf-> Cell(28,7, number_format($key->prix_v*$key->qte,0,' ',' '),'BR','1','L');

			}

	$pdf->SetFont('Arial','b','10');

		$pdf-> Cell(190,11,'','1','1','L');
		$aaa = $pdf-> GetY();
		$pdf-> setXY($X+110,$aaa-12);
		$pdf-> Cell(50,7,'TOTAL  . . . . . . '.number_format($total,0,' ',' ').'. . . . . .'.number_format($total2,0,' ',' '),'0','0','L');

	$pdf->Output('I',"List stock");	
?>