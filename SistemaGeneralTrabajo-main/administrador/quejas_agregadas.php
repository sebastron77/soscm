<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de quejas agregadas';

require_once('includes/load.php');

// page_require_level(1);
// page_require_level(5);
$quejas_libro = find_all_quejas();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
  page_require_level(2);
}
if ($nivel_user == 5) {
  page_require_level_exacto(5);
}
if ($nivel_user == 7) {
  page_require_level_exacto(7);
}

if ($nivel_user > 2 && $nivel_user < 5) :
  redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
  redirect('home.php');
endif;
if ($nivel_user > 7  && $nivel_user < 19) :
  redirect('home.php');
endif;

$conexion = mysqli_connect("localhost", "root", "");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "probar_antes_server");
$sql = "SELECT * FROM quejas";
$resultado = mysqli_query($conexion, $sql) or die;
$quejas = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
  $quejas[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
  if (!empty($quejas)) {
    header('Content-Encoding: UTF-8');
    header('Content-type: application/vnd.ms-excel;charset=UTF-8');
    header("Content-Disposition: attachment; filename=quejas.xls");
    $filename = "quejas.xls";
    $mostrar_columnas = false;

    foreach ($quejas as $resolucion) {
      if (!$mostrar_columnas) {
        echo implode("\t", array_keys($resolucion)) . "\n";
        $mostrar_columnas = true;
      }
      echo implode("\t", array_values($resolucion)) . "\n";
    }
  } else {
    echo 'No hay datos a exportar';
  }
  exit;
}

?>
<?php include_once('layouts/header.php'); ?>
<a href="quejas.php" class="btn btn-success">Regresar</a><br><br>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<?php
require_once('includes/sql2.php');
$quejas = quejas();
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Quejas Agregadas</span>
        </strong>
        <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
          <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
        </form>
      </div>
    </div>
    <div class="panel-body">
      <table class="datatable table table-dark table-bordered table-striped">
        <thead>
          <tr class="table-info">
            <th class="text-center" style="width: 2%;">Folio Queja</th>
            <th style="width: 1%;">Última Actualización</th>
            <th style="width: 3%;">Autoridad Responsable</th>
            <th style="width: 3%;">Agraviado</th>
            <th style="width: 1%;">Estatus</th>
            <th style="width: 3%;">Asignado a</th>
            <?php if (($nivel <= 2) || ($nivel == 5) || ($nivel == 19)) : ?>
              <th class="text-center" style="width: 25%;">Acciones</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($quejas_libro as $queja) : ?>
            <tr>
              <td class="text-center"> <?php echo remove_junk(ucwords($queja['folio_queja'])); ?></td>
              <td class="text-center"> <?php echo remove_junk(ucwords($queja['ultima_actualizacion'])); ?></td>
              <td> <?php echo remove_junk(($queja['autoridad_responsable'])); ?></td>
              <td> <?php echo remove_junk(($queja['creada_por'])); ?></td>
              <td class="text-center"> <?php echo remove_junk(($queja['estatus_queja'])); ?> </td>
              <td> <?php echo remove_junk($queja['asignada_a']); ?></td>
              <?php if (($nivel <= 2) || ($nivel == 5) || ($nivel == 19)) : ?>
                <td class="text-center">
                  <a href="add_acuerdo_no_violacion.php?id=<?php echo (int)$queja['id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Agregar un Acuerdo de No Violación">
                    Acuerdo
                  </a>
                  <a href="add_recomendacion.php?id=<?php echo (int)$queja['id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Agregar una Recomendación">
                    Recomendación
                  </a>
                  <a target="_blank" href="http://177.229.209.29/quejas/upload/scp/tickets.php?id=<?php echo (int)$queja['ticket_id']; ?>" class="btn btn-queja btn-md" data-toggle="tooltip" title="Ver en Sistema de Quejas">
                    Ver Queja
                  </a>
                  <div class="btn-group">
                    <a href="edit_queja.php?id=<?php echo (int)$queja['id']; ?>" style="color: black" class="btn btn-warning btn-md" title="Editar en Libro Electrónico" data-toggle="tooltip">
                      Editar
                    </a>
                  </div>
                  <?php if ($nivel == 1) : ?>
                    <a href="delete_queja.php?id=<?php echo (int)$queja['id']; ?>" class="btn btn-sm btn-delete" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta queja?');">
                      <i class="glyphicon glyphicon-trash"></i>
                    </a>
                  <?php endif; ?>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<?php include_once('layouts/footer.php'); ?>