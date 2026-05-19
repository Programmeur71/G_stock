<?php  
	$pdf-> Image('assets/images/a.png',$X+85,$Y+9,40,40);  

	$pdf->SetFont('Arial','b',12);

		$pdf-> setXY($X+10,$Y+8);
		$pdf-> Cell(40,8,'PHARMACIE DE BANSOA SARL','0','1','l');

		$pdf->SetFont('Arial','',10);

			$pdf-> setXY($X+10,$Y+13);
			$pdf-> Cell(40,8,"N contrib: M052116184423Y",'0','1','l');

		$pdf->SetFont('Arial','','10');

			$pdf-> setXY($X+10,$Y+18);
			$pdf-> Cell(40,8,"N RC: RC/DSC/2021/B/70",'0','1','l');

		$pdf->SetFont('Arial','b',12);

			$pdf-> setXY($X+10,$Y+26);
			$pdf-> Cell(40,8,'TEL  : 697852352','0','1','l'); 

		$pdf->SetFont('Arial','b',10);

			$pdf->SetFillColor(25,200,111);
	
			$pdf-> setXY($X+10,$Y+50);

			$pdf-> Cell(124,7,'DESIGNATION','1','0','C','green');
			$pdf-> Cell(23,7,'P.UNIT','1','0','C','green');
			$pdf-> Cell(15,7,'QTE','1','0','C','green');
			$pdf-> Cell(28,7,'MONTANT','1','1','C','green');

				$total = 0; $colis=0;

			foreach ($ok as $key) {
				$pdf-> setX($X=10);

				$long = strlen($key['nom']);

				if ($long > 53) {
					$nom = substr($key['nom'], 0,51)."...";
				} else {
					$nom = $key['nom'];
				}
				
				$pdf-> Cell(124,7,$nom ,'BL','0','l');
				$pdf-> Cell(23,7, number_format($key['prix'],0,' ',' '),'B','0','l');
				$pdf-> Cell(15,7, $key['qte'] ,'B','0','l');
				$pdf-> Cell(28,7, number_format($key['total'],0,' ',' '),'BR','1','L');

				$total += $key['total'];
				$colis += 1;
			}

			$b = 28;
			if ($colis <= $b) 
			{ 
				$a = 0;
				for ($a=0; $a <=($b-$colis); $a++) { 
				$pdf-> Cell(124,7,'','L','0','l');
				$pdf-> Cell(23,7,'','','0','l');
				$pdf-> Cell(15,7,'','','0','l');
				$pdf-> Cell(28,7,'','R','1','L');
				}
			}

	$pdf->SetFont('Arial','b','10');

		$pdf-> Cell(190,11,'','1','1','L');
		$aaa = $pdf-> GetY();
		$pdf-> setXY($X+110,$aaa-12);
		$pdf-> Cell(50,7,'TOTAL . T.C.C . . . . . . . . . . . . . . . . . . '.number_format($total,0,' ',' '),'0','0','L');

		$pdf-> setXY($X+110,$aaa-6);
		$pdf-> Cell(50,7,'N E T   A   P A Y E R . . . . . . . . . . . . . '.number_format($total,0,' ',' '),'0','0','L');

		$pdf-> setXY($X+0,$aaa-6);
		$pdf-> Cell(55,7,''.number_format($total,0,' ',' '). ' Francs CFA','0','0','L');

		$pdf-> setXY($X+0,$aaa+2);
		$pdf-> Cell(190,5,'BONNE GUERISON !','0','0','C');


	$pdf-> setXY($X+140,$Y+20);
		$pdf->SetFont('Arial','b','15');
		$pdf-> Cell(50,7,$quoi[1],'1','1','C','couleur');

	$pdf->SetFillColor(210,200,10);
	$pdf-> setXY($X+0,$Y+35);
		$pdf->SetFont('Arial','b','15');
		$pdf-> Cell(50,7,"livree",'1','1','C','couleur');
		// $pdf-> Cell(50,7,$key['livree']==0?"non livree":"livree",'1','1','C','couleur');

		$pdf-> setXY($X+140,$Y+8);
		$pdf->SetFont('Arial','i','10');
			$pdf-> Cell(50,5,date( 'j M Y H:i', strtotime($key['dates']??date('Y-m-d H:i:s'))),'0','0','L');

		$pdf-> setXY($X+140,$Y+14);
			$pdf-> Cell(50,5,'VENDEUR : '.substr($key['vendeur']??"pharmacie", 0,10),'0','0','l');

		$pdf->SetFont('Arial','b','12');
			$pdf-> setXY($X+140,$Y+30);
			$pdf-> Cell(50,10,$key['client']??'',1,'0','C');

		$pdf->SetFont('Arial','i','10');

		$pdf-> setXY($X+140,$Y+35);
		$pdf-> Cell(50,20,'NOMBRE DE COLIS : '.$colis,'0','0','l');

	$pdf->Output('I',"Facture ".$quoi[1]."");	
?>