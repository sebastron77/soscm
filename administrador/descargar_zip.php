<?php
// Include and initialize ZipArchive class
require_once('includes/load.php');
require_once 'ZipArchiver.class.php';
$zipper = new ZipArchiver;
get_current_user();
$user = current_user();
$detalle = $user['id_user'];
$username = get_current_user();
$id = (int) $_GET['id'];
$tipo = $_GET['t'];

$e_detalleQ = find_by_id_queja($id);
$folio_editarQ = $e_detalleQ['folio_queja'];
$resultadoQ = str_replace("/", "-", $folio_editarQ);

$e_detalleO = find_by_id_orientacion($id);
$folio_editarO = $e_detalleO['folio'];
$resultadoO = str_replace("/", "-", $folio_editarO);

$e_detalleC = find_by_id_canalizacion($id);
$folio_editarC = $e_detalleC['folio'];
$resultadoC = str_replace("/", "-", $folio_editarC);

$e_detalleAC = find_by_id_actuacion($id);
$folio_editarAC = $e_detalleAC['folio_actuacion'];
$resultadoAC = str_replace("/", "-", $folio_editarAC);

//! Ruta que se guardará en el ZIP
if ($tipo == 'q') {
    $dirPath = 'uploads/quejas/' . $resultadoQ . '/imagenes';

    //! Ruta donde se guardará el ZIP
    $zipPath = '/Users/' . $username . '/Downloads/' . $resultadoQ . ' - Imagenes.zip';
}
if ($tipo == 'o') {
    $dirPath = 'uploads/orientacioncanalizacion/orientacion/' . $resultadoO . '/imagenes';

    //! Ruta donde se guardará el ZIP
    $zipPath = '/Users/' . $username . '/Downloads/' . $resultadoO . ' - Imagenes.zip';
}
if ($tipo == 'c') {
    $dirPath = 'uploads/orientacioncanalizacion/canalizacion/' . $resultadoC . '/imagenes';

    //! Ruta donde se guardará el ZIP
    $zipPath = '/Users/' . $username . '/Downloads/' . $resultadoC . ' - Imagenes.zip';
}

if ($tipo == 'ac') {
    $dirPath = 'uploads/actuaciones/' . $resultadoAC . '/imagenes';

    //! Ruta donde se guardará el ZIP
    $zipPath = '/Users/' . $username . '/Downloads/' . $resultadoAC . ' - Imagenes.zip';
}

// Create zip archive
$zip = $zipper->zipDir($dirPath, $zipPath);

if ($zip) {
    // echo 'Carpeta comprimida creada con éxito.';
    $session->msg('s', "*** Archivo comprimido con éxito. Revisa la carpeta de Descargas en tu computadora. ***");
    if ($tipo == 'q') {
        insertAccion($user['id_user'], '"' . $user['username'] . '" descargó imágenes de Queja, Folio: ' . $folio_editarQ . '.', 1);
        redirect('quejas.php', false);
    }
    if ($tipo == 'o') {
        insertAccion($user['id_user'], '"' . $user['username'] . '" descargó imágenes de Orientación, Folio: ' . $folio_editarO . '.', 1);
        redirect('orientaciones.php', false);
    }
    if ($tipo == 'c') {
        insertAccion($user['id_user'], '"' . $user['username'] . '" descargó imágenes de Canalización, Folio: ' . $folio_editarC . '.', 1);
        redirect('canalizaciones.php', false);
    }
    if ($tipo == 'ac') {
        insertAccion($user['id_user'], '"' . $user['username'] . '" descargó imágenes de Act, Folio: ' . $folio_editarAC . '.', 1);
        redirect('actuaciones.php', false);
    }
    redirect('quejas.php', false);
} else {
    echo 'Error al crear comprimido.';
}
