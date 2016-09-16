<?php
include('inc/application.php');

$FILTER = getFilter($_GET);
$FILTER['orderId'] = intval($FILTER['orderId']);
if($FILTER['orderId']<=0) redirect($_SERVER['HTTP_REFERER']);

require($_SERVER['DOCUMENT_ROOT'] . '/managers/fpdf.php');

class PDF extends FPDF
{
//Page header
	function Header()
	{
		if ($this->PageNo() == 1) {
	    //Logo
	    $this->Image('images/logo_invoice.jpg',10,8,40);
	    //Arial bold 15
	    $this->SetFont('Times','',15);
	    //Move to the right
	    $this->Cell(80);
	    //Title
	    $this->Cell(30,10,'СТОКОВА РАЗПИСКА',0,0,'L');
	    $this->Ln(10);
	    $this->Cell(188,10,'ОРИГИНАЛ',0,0,'C');
	    //Line break
	    $this->Ln(20);
	    } else {
	    	
	    }
	}
	
	//Page footer
	function Footer()
	{
	    //Position at 2 cm from bottom
	    $this->SetY(-20);
	    //Arial italic 8
	      $this->SetFont('Times','',12);
	      $this->Cell(30,10,'С уважение,',0,0,'L');
	      $this->Ln(5);
	      $this->Cell(30,10,'Екипът на Lingadore.bg',0,0,'L');
	      /*$this->Cell(128);
	      $this->Cell(30,10,'Стр.: '.$this->PageNo().' от {nb}',0,1,'R');*/
	}
}

$order = order::getDetails($FILTER['orderId']);
$FILTER['user'] = $mm->SelArr("SELECT id, CONCAT_WS(' ', fname, lname) as name, email, contact_phone phone, user_type_id AS wc_id, bul_subscr FROM users WHERE id={$order['user_id']}");
$FILTER['address'] = $mm->SelArr("SELECT id, street, city, phone, zip, notes FROM user_addresses WHERE user_id={$order['user_id']} AND id={$order['address_id']}");

$invoice_num = str_pad($FILTER['orderId'], 9, '0', STR_PAD_LEFT);
$invoice_date = date('d.m.Y', strtotime($order['created_at']));
//Instanciation of inherited class
$pdf=new PDF();
$pdf->AddFont('Times','','times.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(0,5,'Фактура No: 1'. $invoice_num,0,1);
$pdf->Cell(0,10,'Дата: ' . $invoice_date . 'г.',0,1);
// Receiver
$pdf->Cell(25,5,'Получател:',0,0);
$pdf->Cell(0,5,iconv('UTF-8', 'Windows-1251', $FILTER['user']['name']),0,1);
$pdf->Cell(25);
$pdf->Cell(0,5,iconv('UTF-8', 'Windows-1251', $FILTER['address']['street'] . ', ' . $FILTER['address']['city']),0,1);
$pdf->Cell(25);
$pdf->Cell(0,5,iconv('UTF-8', 'Windows-1251', $FILTER['user']['email']),0,1);
$pdf->Cell(25);
$pdf->Cell(0,5,iconv('UTF-8', 'Windows-1251', $FILTER['user']['phone']),0,1);
$pdf->Ln(10);
// Sender
$pdf->Cell(25,5,'Доставчик:',0,0);
$pdf->Cell(0,5,'Ъндъруеър ЕООД',0,1);
$pdf->Cell(25,5,'Адрес:',0,0);
$pdf->Cell(0,5,'София, с. Бусманци, ул. "Генерал Гурко" №8В',0,1);
$pdf->Cell(25,5,'Булстат:',0,0);
$pdf->Cell(0,5,'БГ 200994150',0,1);
$pdf->Cell(25,5,'МОЛ:',0,0);
$pdf->Cell(0,5,'Антонио Василев',0,1);
$pdf->Ln(10);

$cnt = 1;
$pdf->Cell(5,10,'','B',0);
$pdf->Cell(80,10,'Описание','B',0);
$pdf->Cell(25,10,'Количество','B',0,'C');
$pdf->Cell(40,10,'Ед. цена','B',0,'R');
$pdf->Cell(40,10,'Цена','B',1,'R');

$total = 0;
foreach ($order['details'] AS $item) {
    $item['price'] = number_format($item['price'], 2,'.', ' ');
    //$item['price'] = round_to_penny($item['price']/1.2);
    //$item['final_price'] = $item['final_price']/1.2;
    //$item['final_price'] = round_to_penny($item['final_price']/1.2);
    $pdf->Cell(5,10,$cnt,0,0);
    $pdf->Cell(80,10,$item['product_name'],0,0);
    $pdf->Cell(25,10,$item['quantity'],0,0,'R');
    $pdf->Cell(40,10,$item['price'] . ' лв.',0,0,'R');
    $final_price = $item['quantity']*$item['final_price'];
    $final_price = number_format($final_price, 2,'.', ' ');
    //$final_price = round_to_penny($final_price);

    $pdf->Cell(40,10,$final_price . ' лв.',0,1,'R');
    $cnt++;
    $total+=$final_price;
}
//$total = $order['total'];
if($order['delivery_price']) {
	$total = $total - $order['delivery_price'];
}
//$order['total_novat'] = number_format($total/1.2, 2,'.', ' ');
//$order['total_novat'] = $total;
//$order['vat'] = number_format($order['total_novat']*0.2, 2,'.', ' ');
$order['delivery_price'] = number_format($order['delivery_price'], 2,'.', ' ');
$pdf->Cell(85);
$pdf->Cell(105,2,'','T',1);
//$pdf->Cell(95);
//$pdf->Cell(55,10,'Сума без ДДС:',0,0);
//$pdf->Cell(40,10, $order['total_novat'] . ' лв.',0,1, 'R');
//$pdf->Cell(95);
//$pdf->Cell(55,10,'ДДС 20%:',0,0);
//$pdf->Cell(40,10, $order['vat'] . ' лв.',0,1, 'R');

if($order['delivery_price']!=0.0) {
	$pdf->Cell(95);
	$pdf->Cell(55,10,'Доставка:',0,0);
	$pdf->Cell(40,10, $order['delivery_price'] . ' лв.',0,1, 'R');
}
$pdf->Cell(95);
$pdf->Cell(55,10,'Общо:',0,0);
$pdf->Cell(40,10, $order['total'] . ' лв.',0,1, 'R');
$pdf->Cell(95);
$pdf->Cell(95,1,'('.iconv('UTF-8', 'Windows-1251', convertNumToMoneyStr($order['total'])).')',0,0, 'R');
$pdf->Output();
?>