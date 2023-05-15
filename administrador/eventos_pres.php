<?php
$page_title = 'Eventos';
require_once('includes/load.php');
?>
<?php

$all_eventos = find_all('eventos_presidencia');
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 5) {
    redirect('home.php');
}
if ($nivel_user == 7) {
    page_require_level(7);
}
if ($nivel_user == 21) {
    page_require_level_exacto(21);
}
if ($nivel_user == 19) {
    redirect('home.php');
}
if ($nivel_user > 2 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;
if ($nivel_user > 19 && $nivel_user < 21) :
    redirect('home.php');
endif;


$conexion = mysqli_connect("localhost", "suigcedh", "9DvkVuZ915H!");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "suigcedh");
$sql = "SELECT * FROM eventos_presidencia";
$resultado = mysqli_query($conexion, $sql) or die;
$eventos = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
    $eventos[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($eventos)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=eventos.xls");
        $filename = "eventos.xls";
        $mostrar_columnas = false;

        foreach ($eventos as $resolucion) {
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

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<a href="solicitudes_presidencia.php" class="btn btn-success">Regresar</a><br><br>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lista de Eventos</span>
                </strong>

                <a href="add_evento_pres.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar evento</a>

                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
        </div>

        <div class="panel-body">
            <table class="datatable table table-bordered table-striped">
                <thead class="thead-purple">
                    <tr style="height: 10px;">
                        <th style="width: 10%;">Folio</th>
                        <th style="width: 10%;">Evento</th>
                        <th style="width: 10%;">Tipo Evento</th>
                        <th style="width: 10%;">Ámbito Evento</th>
                        <th style="width: 7%;">Fecha</th>
                        <th style="width: 5%;">Hora</th>
                        <th style="width: 5%;">Lugar</th>
                        <th style="width: 5%;">Depto./Org.</th>
                        <th style="width: 5%;">Modalidad</th>
                        <!-- <th style="width: 3%;">Constancia</th> -->
                        <!--  -->
                        <th style="width: 3%;" class="text-center">Acciones</th>
                        <!--  -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_eventos as $a_evento) : ?>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_evento['folio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_evento['nombre_evento'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_evento['tipo_evento'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_evento['ambito_evento'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_evento['fecha'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_evento['hora'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_evento['lugar'])) ?></td>
                            <td><?php echo remove_junk((ucwords($a_evento['depto_org']))) ?></td>
                            <td><?php echo remove_junk((ucwords($a_evento['modalidad']))) ?></td>
                            <?php
                            $folio_editar = $a_evento['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>

                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_evento_pres.php?id=<?php echo (int)$a_evento['id_eventos_presidencia']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                </div>
                            </td>


                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php include_once('layouts/footer.php'); ?>