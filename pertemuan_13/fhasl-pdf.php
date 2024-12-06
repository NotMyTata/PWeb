<?php 
include('config.php');
require('../fpdf/fpdf.php');

class FHASL_PDF extends FPDF{
    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max(strlen($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }
    
    function Header(){
        $this->SetFont('Arial','B',24);
        $this->Cell(0, 10, 'Fuzzy High',0,1,'C');
        $this->SetFont('Arial','',14    );
        $this->Cell(0,10,'Active Students List',0,1,'C');
        $this->Cell(0,0,'',1);
        $this->Ln(5);
    }
    function Footer(){
        $this->SetY(-20);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    }
    function MakeStudentList($db){
        $sql = 'SELECT * FROM student';
        $result = mysqli_query($db, $sql);

        $w_id = 10;
        $w_g  = 20;
        $w_sm = $w_fn = 50;
        $w_pn = $w_b = 40;

        // Center the table
        $this->SetLeftMargin(($this->GetPageWidth() - ($w_id+$w_fn+$w_g+$w_b+$w_sm+$w_pn)) / 2);

        // Header
        $this->SetFont('Arial','B',12);
        $this->SetDrawColor(255, 255,255);
        $this->CellFitScale($w_id,10,'ID',1,0,'C');
        $this->CellFitScale($w_fn,10,'Full Name',1,0,'C');
        $this->CellFitScale($w_g,10,'Gender',1,0,'C');
        $this->CellFitScale($w_b,10,'Date of Birth',1,0,'C');
        $this->CellFitScale($w_sm,10,'Student Email',1,0,'C');
        $this->CellFitScale($w_pn,10,'Phone Number',1,1,'C');

        // Content
        $this->SetFont('Arial','',11);
        $fill = true;
        while($student = mysqli_fetch_array($result)){
            if($fill)
            {
                $this->SetFillColor(255,255,255);
                $this->SetDrawColor(255, 255,255);
            }
            else
            {
                $this->SetFillColor(222, 226, 230);
                $this->SetDrawColor(222, 226, 230);
            }
            $fill = !$fill;

            $this->CellFitScale($w_id,10,$student['sid'],1,0,'C',$fill);
            $this->CellFitScale($w_fn,10,$student['fname'],1,0,'L',$fill);
            $this->CellFitScale($w_g,10,$student['gender'],1,0,'C',$fill);
            $this->CellFitScale($w_b,10,$student['dob'],1,0,'C',$fill);
            $this->CellFitScale($w_sm,10,$student['smail'],1,0,'L',$fill);
            $this->CellFitScale($w_pn,10,$student['pnum'],1,1,'C',$fill);

        }
    }
}

$pdf = new FHASL_PDF('L','mm','A4');
$pdf->SetTitle('FH Active Students List');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->MakeStudentList($db);
$pdf->Output();

?>