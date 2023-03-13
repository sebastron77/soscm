<?php
$page_title = 'Agregar expediente';
require_once('includes/load.php');
$areas = find_all('area');
//page_require_level(1);
?>
<?php
if (isset($_POST['add'])) {

    if (empty($errors)) {
        $area_responsable = remove_junk($db->escape($_POST['area_responsable']));
        $no_expediente = remove_junk($db->escape($_POST['no_expediente']));

        $query  = "INSERT INTO expedientes (";
        $query .= "area_responsable, no_expediente";
        $query .= ") VALUES (";
        $query .= " '{$area_responsable}', '{$no_expediente}'";
        $query .= ")";
        if ($db->query($query)) {
            //sucess
            $session->msg('s', "Expediente creado. ");
            ?>
			<script language="javascript">
                    window.opener.location.reload();
                    window.close();
                </script>
				<?php
            //redirect('add_expediente.php', false);
        } else {
            //failed
            $session->msg('d', 'Lamentablemente no se pudo crear el expediente');
            redirect('add_expediente.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_expediente.php', false);
    }
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
  <link rel="stylesheet" href="libs/css/main.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://harvesthq.github.io/chosen/chosen.css" rel="stylesheet" />
<style>
    .login-page2 {
        width: 350px;
        height: 340px;
        margin: 7% auto;
        padding: 0 20px;
        background-color: #282A2F;
        border: 1px solid #000000;
        border-radius: 15px;
        box-shadow: 6px 20px 10px rgba(0, 0, 0, 0.082);
        margin-top: 30px;
    }

    .login-page2 .text-center {
        margin-bottom: 10px;
    }
</style>

<?php //include_once('layouts/header.php'); ?>
<div class="login-page2">
    <div class="text-center">
        <h3 style="margin-top: 10%;color:white">Agregar nuevo expediente</h3>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="add_expediente.php" class="clearfix">
        <div class="form-group" style="margin-top: 10px;">
            <label for="area_responsable" >Área Responsable</label>
            <select class="form-control" name="area_responsable">
                <?php foreach ($areas as $area) : ?>
                    <option value="<?php echo $area['id']; ?>"><?php echo ucwords($area['nombre_area']); ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label for="no_expediente" class="control-label">Número de expediente</label>
            <input type="name" class="form-control" name="no_expediente" required>
        </div>
        <div class="form-group clearfix" style="margin-top: 10%;">
            <!--
			<a href="acuerdos_res.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                Cancelar
            </a>
			-->
			<button type="button"  class="btn btn-md btn-success" onclick="javascript:window.close();">Cancelar</button>&nbsp;&nbsp;
            <button type="submit" name="add" class="btn btn-info">Guardar</button>
        </div>
    </form>
</div>
<?php //include_once('layouts/footer.php'); ?>