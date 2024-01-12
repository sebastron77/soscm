<?php
require_once('includes/load.php');

page_require_level(1);
?>
<?php
$e_user = find_by_id('osc', (int)$_GET['id'], 'id_osc');
$user = current_user();
$inactivate_id = activate_by_id('osc', (int)$_GET['id'], 'estatus', 'id_osc');
insertAccion($user['id_user'], '"' . $user['username'] . '" activó la OSC: ' . $e_user['nombre'] . '.', 3);
if ($inactivate_id) {
    $session->msg("s", "OSC activada");
    redirect('osc.php');
} else {
    $session->msg("d", "Se ha producido un error en la activación de la OSC");
    redirect('osc.php');
}
?>
