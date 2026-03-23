<?php
// reporte.php
require('../pdf/fpdf.php');
session_start();

// Verificar sesión
if (empty($_SESSION['id'])) {
    die('No hay sesión iniciada.');
}

$id_cliente = (int) $_SESSION['id'];

// Incluye tu conexión (debe setear $conexion como mysqli)
require '../config/conexion.php';

// Asegurar charset
$conexion->set_charset('utf8');

// Preparar y ejecutar procedimiento
$sql = "CALL ConsultarComprasDetalle(?)";
$stmt = $conexion->prepare($sql);
if (!$stmt) {
    die("Error en prepare: " . $conexion->error);
}
$stmt->bind_param('i', $id_cliente);
if (!$stmt->execute()) {
    die("Error al ejecutar: " . $stmt->error);
}
$result = $stmt->get_result();

// Clase PDF
class PDF extends FPDF
{
    function Header()
    {
        // Logo (opcional) - descomenta y ajusta si lo necesitas
        // $this->Image('logo.png',10,8,20);
        $this->SetFont('Arial','B',14);
        $this->Cell(0,8,'REPORTE DETALLADO DE COMPRAS',0,1,'C');
        $this->Ln(2);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Crear PDF
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

// Anchos de columnas
$w = [
    'factura' => 28,
    'fecha'   => 30,
    'producto'=> 60,
    'cantidad'=> 20,
    'precio'  => 28,
    'subtotal'=> 28
];

// Encabezados
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['factura'],8,'NÂ° Factura',1,0,'C');
$pdf->Cell($w['fecha'],8,'Fecha',1,0,'C');
$pdf->Cell($w['producto'],8,'Producto',1,0,'C');
$pdf->Cell($w['cantidad'],8,'Cant.',1,0,'C');
$pdf->Cell($w['precio'],8,'Precio',1,0,'C');
$pdf->Cell($w['subtotal'],8,'Subtotal',1,1,'C');

$pdf->SetFont('Arial','',10);

$total_general = 0.0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Datos (si vienen en utf8, FPDF usa ISO-8859-1 -> utf8_decode)
        $numeroFactura = isset($row['numeroFactura']) ? $row['numeroFactura'] : '';
        $fechaVenta = isset($row['fechaVenta']) ? $row['fechaVenta'] : '';
        $producto = isset($row['producto']) ? utf8_decode($row['producto']) : '';
        $cantidad = isset($row['cantidad']) ? $row['cantidad'] : 0;
        $precio_unitario = isset($row['precio_unitario']) ? (float)$row['precio_unitario'] : 0;
        $subtotal = isset($row['subtotal']) ? (float)$row['subtotal'] : ($cantidad * $precio_unitario);

        $total_general += $subtotal;

        // Guardamos posición
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Celda factura y fecha
        $pdf->Cell($w['factura'], 8, $numeroFactura, 1, 0, 'C');
        $pdf->Cell($w['fecha'], 8, $fechaVenta, 1, 0, 'C');

        // Para producto usamos MultiCell (puede ocupar varias líneas)
        // Primero, crear una celda en blanco de ancho producto y bordes superiores/inferiores manejados por MultiCell
        $currentX = $pdf->GetX();
        $currentY = $pdf->GetY();

        // Dibujamos producto con MultiCell (alto de línea 4)
        $pdf->MultiCell($w['producto'], 4, $producto, 1, 'L');

        // Después de MultiCell, la posición X vuelve al margen izquierdo; calculamos nueva Y
        $afterMultiY = $pdf->GetY();

        // Necesitamos colocar las siguientes celdas (cantidad, precio, subtotal) en la misma "fila" que la altura usada por MultiCell.
        // Calculamos altura usada por el producto:
        $multiHeight = $afterMultiY - $currentY;

        // Posicionar X en la columna siguiente (factura + fecha + producto)
        $pdf->SetXY($currentX + $w['producto'], $currentY);

        // Si el producto ocupó más de una línea, usamos la misma altura (multiHeight), sino 8
        $cellHeight = max(8, $multiHeight);

        $pdf->Cell($w['cantidad'], $cellHeight, $cantidad, 1, 0, 'C');
        $pdf->Cell($w['precio'], $cellHeight, '$' . number_format($precio_unitario, 2, ',', '.'), 1, 0, 'R');
        $pdf->Cell($w['subtotal'], $cellHeight, '$' . number_format($subtotal, 2, ',', '.'), 1, 1, 'R');

        // Si MultiCell fue mayor, la línea ya avanzó; si no, forzamos el avance:
        // (ya usamos 1 en la última cell para saltar línea)
    }

    // Línea separadora y total
    $pdf->Ln(4);
    $pdf->SetFont('Arial','B',11);
    // ancho total de la tabla
    $width_total = array_sum($w);
    $pdf->Cell($width_total - $w['subtotal'], 8, 'TOTAL GENERAL', 1, 0, 'R');
    $pdf->Cell($w['subtotal'], 8, '$' . number_format($total_general, 2, ',', '.'), 1, 1, 'R');

} else {
    // No hay registros
    $pdf->Cell(array_sum($w), 10, 'No se encontraron compras para este usuario.', 1, 1, 'C');
}

// Liberar y cerrar
if ($result) $result->free();
$stmt->close();
// Si tu procedimiento devuelve múltiples resultsets, podrías necesitar:
// while ($conexion->more_results() && $conexion->next_result()) { /* vacía */ }
$conexion->close();

// Salida del PDF (I = ver en navegador, D = descargar)
$pdf->Output('I', 'reporte_detallado_compras.pdf');
exit;
?>





