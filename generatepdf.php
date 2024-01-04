<?php 
    @include 'dbh.php';
	require('FPDF/fpdf.php');

    class PDF_Sector extends FPDF {
        function Sector($xc, $yc, $r, $a, $b, $style='FD', $cw=true, $o=90)
        {
            $d0 = $a - $b;
            if($cw){
                $d = $b;
                $b = $o - $a;
                $a = $o - $d;
            }else{
                $b += $o;
                $a += $o;
            }
            while($a<0)
                $a += 360;
            while($a>360)
                $a -= 360;
            while($b<0)
                $b += 360;
            while($b>360)
                $b -= 360;
            if ($a > $b)
                $b += 360;
            $b = $b/360*2*M_PI;
            $a = $a/360*2*M_PI;
            $d = $b - $a;
            if ($d == 0 && $d0 != 0)
                $d = 2*M_PI;
            $k = $this->k;
            $hp = $this->h;
            if (sin($d/2))
                $MyArc = 4/3*(1-cos($d/2))/sin($d/2)*$r;
            else
                $MyArc = 0;
            //first put the center
            $this->_out(sprintf('%.2F %.2F m',($xc)*$k,($hp-$yc)*$k));
            //put the first point
            $this->_out(sprintf('%.2F %.2F l',($xc+$r*cos($a))*$k,(($hp-($yc-$r*sin($a)))*$k)));
            //draw the arc
            if ($d < M_PI/2){
                $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                            $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                            $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                            $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                            $xc+$r*cos($b),
                            $yc-$r*sin($b)
                            );
            }else{
                $b = $a + $d/4;
                $MyArc = 4/3*(1-cos($d/8))/sin($d/8)*$r;
                $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                            $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                            $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                            $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                            $xc+$r*cos($b),
                            $yc-$r*sin($b)
                            );
                $a = $b;
                $b = $a + $d/4;
                $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                            $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                            $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                            $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                            $xc+$r*cos($b),
                            $yc-$r*sin($b)
                            );
                $a = $b;
                $b = $a + $d/4;
                $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                            $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                            $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                            $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                            $xc+$r*cos($b),
                            $yc-$r*sin($b)
                            );
                $a = $b;
                $b = $a + $d/4;
                $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                            $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                            $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                            $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                            $xc+$r*cos($b),
                            $yc-$r*sin($b)
                            );
            }
            //terminate drawing
            if($style=='F')
                $op='f';
            elseif($style=='FD' || $style=='DF')
                $op='b';
            else
                $op='s';
            $this->_out($op);
        }
    
        function _Arc($x1, $y1, $x2, $y2, $x3, $y3 )
        {
            $h = $this->h;
            $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
                $x1*$this->k,
                ($h-$y1)*$this->k,
                $x2*$this->k,
                ($h-$y2)*$this->k,
                $x3*$this->k,
                ($h-$y3)*$this->k));
        }
    }
    
    class PDF_Diag extends PDF_Sector {
        var $legends;
        var $wLegend;
        var $sum;
        var $NbVal;
    
        function PieChart($w, $h, $data, $format, $colors=null){
            $this->SetFont('Times', '', 12);
            $this->SetLegends($data,$format);
    
            $XPage = $this->GetX();
            $YPage = $this->GetY();
            $margin = 2;
            $hLegend = 5;
            $radius = min($w - $margin * 4 - $hLegend - $this->wLegend, $h - $margin * 2);
            $radius = floor($radius / 2);
            $XDiag = $XPage + $margin + $radius;
            $YDiag = $YPage + $margin + $radius;
            if($colors == null) {
                for($i = 0; $i < $this->NbVal; $i++) {
                    $gray = $i * intval(255 / $this->NbVal);
                    $colors[$i] = array($gray,$gray,$gray);
                }
            }
    
            //Sectors
            $this->SetLineWidth(0.2);
            $angleStart = 0;
            $angleEnd = 0;
            $i = 0;
            foreach($data as $val) {
                $angle = ($val * 360) / doubleval($this->sum);
                if ($angle != 0) {
                    $angleEnd = $angleStart + $angle;
                    $this->SetFillColor($colors[$i][0],$colors[$i][1],$colors[$i][2]);
                    $this->Sector($XDiag, $YDiag, $radius, $angleStart, $angleEnd);
                    $angleStart += $angle;
                }
                $i++;
            }
    
            //Legends
            $this->SetFont('Times', '', 12);
            $x1 = $XPage + 2 * $radius + 4 * $margin;
            $x2 = $x1 + $hLegend + $margin;
            $y1 = $YDiag - $radius + (2 * $radius - $this->NbVal*($hLegend + $margin)) / 2;
            for($i=0; $i<$this->NbVal; $i++) {
                $this->SetFillColor($colors[$i][0],$colors[$i][1],$colors[$i][2]);
                $this->Rect($x1, $y1, $hLegend, $hLegend, 'DF');
                $this->SetXY($x2,$y1);
                $this->Cell(0,$hLegend,$this->legends[$i]);
                $y1+=$hLegend + $margin;
            }
        }
    
        function SetLegends($data, $format){
            $this->legends=array();
            $this->wLegend=0;
            $this->sum=array_sum($data);
            $this->NbVal=count($data);
            foreach($data as $l=>$val)
            {
                $p=sprintf('%.2f',$val/$this->sum*100).'%';
                $legend=str_replace(array('%l','%v','%p'),array($l,$val,$p),$format);
                $this->legends[]=$legend;
                $this->wLegend=max($this->GetStringWidth($legend),$this->wLegend);
            }
        }
    }
    
    class PDF_Rotate extends PDF_Diag{
        var $angle=0;
    
        function Rotate($angle,$x=-1,$y=-1)
        {
            if($x==-1)
                $x=$this->x;
            if($y==-1)
                $y=$this->y;
            if($this->angle!=0)
                $this->_out('Q');
            $this->angle=$angle;
            if($angle!=0)
            {
                $angle*=M_PI/180;
                $c=cos($angle);
                $s=sin($angle);
                $cx=$x*$this->k;
                $cy=($this->h-$y)*$this->k;
                $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
            }
        }
    
        function _endpage()
        {
            if($this->angle!=0)
            {
                $this->angle=0;
                $this->_out('Q');
            }
            parent::_endpage();
        }
    }
	
class PDF extends PDF_Rotate
{
// Page header
function Header()
{
    // Logo
    $this->Image('assets/logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Times','B',15);
    // Move to the right
    $this->Cell(90);
    // Title
    $this->Cell(15,10,'OCEANS OF KNOWLEDGE', 0, 1, "C");
    $this->SetFont('Times','B',12);
    $this->Cell(90);
    $this->Cell(15,5,'Science City of Munoz, Nueva Ecija, Philippines 3120', 0, 0, "C");
    $this->Line(10, 45, 210-10, 45);
    // Line break
    $this->Ln(30);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    date_default_timezone_set('Asia/Manila');

    $date = date("F d Y");

    $this->Cell(0,10, "(".$date.")",0,0,"L");
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
}
}

// Instanciation of inherited class
$countSql = "SELECT count(*) FROM vaccinationrecord";
$res =  mysqli_query($conn, $countSql);

$count;
$role_ = "";
$grade_ = "";
$gender_ = "";
$section_ = "";
$manufacturer_ = "";
$dose_ = "";
$sql = "SELECT DISTINCT * FROM login INNER JOIN vaccinationrecord ON vaccinationrecord.givenName=login.givenName WHERE vaccinationrecord.givenName IS NOT NULL";
$filter = "";



if($res){
    while($row=mysqli_fetch_assoc($res)){
        $total = $row["count(*)"];
    }
}

if($_GET['count'] !="undefined"){
    $count = $_GET['count'];
}else{
    $count = "";
}

if($_GET['role'] !="undefined"){
    $roleSql = $_GET['role'];
    $role_ .= " ".$roleSql. " ";
    $filter .= " ".$roleSql. " ";
    
    $sql .= " AND role = '$roleSql' ";
 
}else{
    $role_ = "students and faculty staff of the Oceans of Knowledge High School";
}

if($_GET['grade'] !="undefined"){
    $gradeSql = $_GET['grade'];
    $grade_ .= " ".$gradeSql. " ";
    $filter .= " ".$gradeSql. " ";
    
    $sql .= " AND gradeLevel = '$gradeSql'";
 
}else{
    $grade_ = "all grade levels of the Oceans of Knowledge High School";
}

if($_GET['section'] !="undefined"){
    $sectionSql = $_GET['section'];
    $section_ .= "of ".$sectionSql;
    $filter .= " ".$sectionSql;

    $sql .= " AND section = '$sectionSql'";
}else{
    $section_ = "all sections";
}

if($_GET['gender'] !="undefined"){
    $genderSql = $_GET['gender'];
    $gender_ .= "" .$genderSql;
    $filter .= " " .$genderSql;

    $sql .= " AND sex = '$genderSql'";
}else{
    $gender_ = "both male and female";
}

if($_GET['status'] !="undefined"){
    $doseSql = $_GET['status'];
    $filter .= " ".$doseSql;
}

if($_GET['manufacturer'] !="undefined"){
    $manufacturerSql = $_GET['manufacturer'];
    $manufacturer_ .= " ".$manufacturerSql;
    $filter .= " ".$manufacturerSql;
} else{

    $result = mysqli_query($conn,$sql);

    $numResults = mysqli_num_rows($result);

    // $resultCount = mysqli_num_rows($result);
    $counter = 0;

    if($result){
        while($row = mysqli_fetch_assoc($result)){
            
            if( ++$counter == $numResults){
                $manufacturer_ .= " ".$row['firstDoseBrand'];
            }else {
                $manufacturer_ .= " ".$row['firstDoseBrand'].", ";
            }
            
        }
    }

}

$data = array($filter => $count, "The Rest of the Population" => $total - $count);
$percent = ($count/$total) * 100;
$percent = round($percent, 2);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,"          Faculty and students in Section 1 and Section 2 of Grades 7 to 12 who received one of the four vaccines (Astrazeneca, Moderna, Pfizer and Johnsons & Johnsons Janssen) were surveyed by the Oceans of Knowledge Vaccination Management System. Data collection is carried out as part of state or municipal programs to ascertain the status of each student's and faculty's immunization status. Additionally, it assists in recognizing high vaccination rates and during an epidemic response, allowing those students and/or faculty members who are most at risk of contracting a disease to be protected and immunized.",'J');
$pdf->Ln(25);

$pdf->SetFont('Times', 'BIU', 14);
$pdf->Cell(0, 5, 'Graphical Representation', 0, 1);
$pdf->Ln(8);
$valX = $pdf->GetX();
$valY = $pdf->GetY();

$pdf->SetXY(55, $valY);
$col1=array(58,159,226);
$col2=array(58,69,226);
$pdf->PieChart(150, 45, $data, '%l (%p)', array($col1,$col2));
$pdf->SetXY($valX, $valY + 40);
$pdf->Ln(25);

$pdf->MultiCell(0,10,"          Based on the gathered data from Oceans of Knowledge's Vaccination Management System Database and the filters selected, there is/are ".$percent."% of ".$gender_." ".$role_."(s) in ".$section_." of ".$grade_." who got vaccinated with ".$manufacturer_.".",'J');

$pdf->Output();

?>