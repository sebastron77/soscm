<?php
require_once('includes/load.php');

page_require_level(1);
?>
<?php
$e_user = find_by_id('osc', (int)$_GET['id'], 'id_osc');
$user = current_user();
$inactivate_id = inactivate_by_id('osc', (int) $_GET['id'], 'estatus', 'id_osc');
insertAccion($user['id_user'], '"' . $user['username'] . '" inactivó la OSC: ' . $e_user['nombre'] . '.', 4);
if ($inactivate_id) {
    $session->msg("s", "OSC desactivada");
    redirect('osc.php');
} else {
    $session->msg("d", "Se ha producido un error en la desactivación de la OSC");
    redirect('osc.php');
}
?>