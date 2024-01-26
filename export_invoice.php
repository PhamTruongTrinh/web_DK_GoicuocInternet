require_once('TCPDF/tcpdf.php');

// Tạo một đối tượng TCPDF
$pdf = new TCPDF();

// Thêm nội dung vào file PDF, sử dụng thông tin hóa đơn
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->AddPage();
$pdf->Cell(0, 10, "Thông tin hóa đơn", 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, $invoiceData);

// Xuất file PDF
$pdf->Output('invoice.pdf', 'D');