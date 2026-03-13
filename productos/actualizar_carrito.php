<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: procesar_pago.php');
    exit;
}

$codigo = $_POST['codigo'] ?? '';
$action = $_POST['action'] ?? '';

if (!$codigo || !isset($_SESSION['carrito'][$codigo])) {
    header('Location: procesar_pago.php');
    exit;
}

switch ($action) {
    case 'inc':
        $_SESSION['carrito'][$codigo]['cantidad'] = max(1, (int)($_SESSION['carrito'][$codigo]['cantidad'] ?? 1) + 1);
        break;
    case 'dec':
        $_SESSION['carrito'][$codigo]['cantidad'] = max(1, (int)($_SESSION['carrito'][$codigo]['cantidad'] ?? 1) - 1);
        break;
    case 'remove':
        unset($_SESSION['carrito'][$codigo]);
        break;
    default:
        break;
}

header('Location: procesar_pago.php');
exit;
