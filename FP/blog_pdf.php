<?php 
include('config.php');
require('fpdf/fpdf.php');

class Blog_PDF extends FPDF{
    
    function MakeHeader($title, $author, $date, $tag){
        $this->SetFont('Arial','B',24);
        $this->Cell(0, 10, $title,0,1,'C');
        $this->SetFont('Arial','',14);
        $this->Cell(0,10,$author." | ".$date." | ".$tag,0,1,'C');
        $this->Cell(0,0,'',1);
        $this->Ln(5);
    }
    function Footer(){
        $this->SetY(-20);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    }
    function MakeContent($content){

        $this->SetFont('Arial','',12);
        $this->MultiCell(0,10, $content,0);
        
    }
}

$blog_id = $_GET['id'];

$sql = "SELECT * FROM blog WHERE id = '$blog_id'";
$result = mysqli_query($db, $sql);
$blog = mysqli_fetch_array($result);

$author_id = $blog['author_id'];
$sql = "SELECT * FROM blogger br JOIN blog b ON (br.id = b.author_id) WHERE br.id='$author_id'";
$result = mysqli_query($db, $sql);
$blogger = mysqli_fetch_array($result);

$pdf = new Blog_PDF('P','mm','A4');
$pdf->SetTitle($blog['title']);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->MakeHeader($blog['title'], $blogger['username'], $blog['posted_date'], $blog['tag']);
$pdf->MakeContent($blog['content']);
$pdf->Output();

?>