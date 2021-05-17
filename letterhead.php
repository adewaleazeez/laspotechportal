<?php
	require('fpdf.php');

	class PDF extends FPDF{
		var $B;
		var $I;
		var $U;
		var $HREF;

		function PDF($orientation='P', $unit='mm', $size='A4'){
			// Call parent constructor
			$this->FPDF($orientation,$unit,$size);
			// Initialization
			$this->B = 0;
			$this->I = 0;
			$this->U = 0;
			$this->HREF = '';
		}
		// Page header
		function Header(){
			// Logo
			$this->Image('C:/immaculate_header.JPG',50,10,110,40);
		}

		// Page footer
		function Footer(){
			$this->Image('C:/immaculate_footer.JPG',0,277,210,20);
		}
	}
	// Instanciation of inherited class
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',10);
	$pdf->Ln(50);
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"The Registrar",0,1,'L');
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"The Federal Polytechnic Ilaro",0,1,'L');
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"P.M.B. 50, Ilaro",0,1,'L');
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"Ogun State.",0,1,'L');
	$pdf->Ln(5);
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"February 20th, 2012.",0,1,'L');
	$pdf->Ln(5);
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,10,"Sir,",0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(70,10,"",0,0,'L');
	$pdf->Cell(52,5,"TO WHOM IT MAY CONCERN","B",1,'C');
	$pdf->Ln(10);
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"I wish to confirm that I have known Mr. Ashiru Olanshile Ganiyu for about  8 years.",0,1,'L');
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"He eventualy  got married to  my sister a  few years  ago,  he has always been of good",0,1,'L');
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"characters, dilligent,  and honest;  he is a man of integrity,  he has a good sense of",0,1,'L');
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"reasoning, his sense of judgement is very reliable.",0,1,'L');
	$pdf->Ln(5);
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"I have known him to be a professional teacher for several years, I am sure he has been",0,1,'L');
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"saddled with several responsibilities in the course  of doing his job and he was never",0,1,'L');
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"found wanting.  I hereby wish  to implore you  to give him the opportunity to serve in",0,1,'L');
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(210,5,"your reputable instituton of learning, I am sure you will never be disappointed.",0,1,'L');
	$pdf->Ln(90);
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(30,5,"Yours Faithfully,","B",1,'L');
	$pdf->Ln(5);
	$pdf->Cell(20,5,"",0,0,'L');
	$pdf->Cell(15,10,"Adewale AZEEZ",0,1,'L');
	$pdf->Output();
?>

