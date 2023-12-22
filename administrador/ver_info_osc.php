<?php
$page_title = 'Datos trabajadores';
require_once('includes/load.php');
?>
<?php
header('Content-Type: text/html; charset=UTF-8');
page_require_level(1);
$v_osc = osc_by_id((int) $_GET['id']);
$user = current_user();
$nivel = $user['user_level'];
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<style>
    .img-gallery {
        width: 50%;
        margin: 1px 1px 11px 1px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 30px;
        margin-left: 5px;
    }

    .img-gallery img {
        width: 100%;
        cursor: pointer;
        transition: 1s;
    }

    .img-gallery img:hover {
        transform: scale(1.2);
    }

    .ful-img {
        width: 70%;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.9);
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99;
    }

    .ful-img span {
        position: absolute;
        top: 5%;
        right: 5%;
        font-size: 40px;
        color: #EA2518;
        cursor: pointer;
    }

    .ful-img img {
        width: 55%;
        max-width: 100%;
    }

    @media screen and (max-width:400px) {
        h1 {
            text-decoration: underline;
        }

        h1::before {
            display: none;
        }

        h1 span {
            padding: 0;
        }
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Información completa de
                        <?php echo remove_junk(ucwords($v_osc['nombre'])) ?>
                    </span>
                </strong>
            </div>

            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th class="text-center" style="width: 15%;">Nombre OSC</th>
                            <th class="text-center" style="width: 1%;">Siglas</th>
                            <th class="text-center" style="width: 1%;">Logo</th>
                            <th class="text-center" style="width: 8%;">Ámbito</th>
                            <th class="text-center" style="width: 15%;">Objetivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo remove_junk($v_osc['nombre']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['siglas']) ?>
                            </td>
                            <td>
                                <?php if ($v_osc['logo'] != '') : ?>
                                    <?php
                                    $liga = "uploads/logos_osc/" . $v_osc['siglas'];
                                    $borrar = filter_input(INPUT_GET, 'borrar');
                                    if (!empty($borrar)) {
                                        unlink("uploads/logos_osc/" . $elemento . $borrar);
                                        echo $carpeta;
                                        echo '<script> window.history.back() </script>';
                                    }

                                    $imagenes2 = scandir($liga);
                                    for ($i = 2; $i < count($imagenes2); $i++) { ?>
                                        <div class="ful-img" id="fulImgBox">
                                            <img src="uploads/logos_osc/<?php echo $v_osc['siglas'] . '/' . $imagenes2[$i] ?>" id="fulImg" alt="">
                                            <span onclick="closeImg()">X</span>
                                        </div>
                                        <div class="img-gallery">
                                            <img style="width: 40px; height: 50px; margin-left: 30px;" src="uploads/logos_osc/<?php echo $v_osc['siglas'] . '/' . $imagenes2[$i] ?>" onclick="openFulImg(this.src)" alt="">
                                        </div>
                                    <?php } ?>
                                <?php endif; ?>
                                <?php if ($v_osc['logo'] == '') echo 'Sin imágen'; ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['ambito_dv']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['objetivo']) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th class="text-center" style="width: 3%;">Fig. Jurídica</th>
                            <th class="text-center" style="width: 1%;">Fecha Constitución</th>
                            <th class="text-center" style="width: 10%;">Datos de Escritura de Constitución</th>
                            <th class="text-center" style="width: 10%;">Nombre de Responsable</th>
                            <th class="text-center" style="width: 10%;">Calle y Num.</th>
                            <th class="text-center" style="width: 10%;">Colonia</th>
                            <th class="text-center" style="width: 1%;">C.P.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo remove_junk($v_osc['figura_juridica']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['fecha_constitucion']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['datos_escritura_const']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['nombre_responsable']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['objetivo']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['colonia']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['cp']) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th class="text-center" style="width: 3%;">Teléfono</th>
                            <th class="text-center" style="width: 7%;">Web Oficial</th>
                            <th class="text-center" style="width: 7%;">X</th>
                            <th class="text-center" style="width: 7%;">Facebook</th>
                            <th class="text-center" style="width: 7%;">Instagram</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo remove_junk($v_osc['telefono']) ?>
                            </td>
                            <td>
                                <a href="<?php echo remove_junk($v_osc['web_oficial']) ?>" target="_blank"><?php echo remove_junk($v_osc['web_oficial']) ?></a>
                            </td>
                            <td>
                                <a href="<?php echo remove_junk($v_osc['x']) ?>" target="_blank"><?php echo remove_junk($v_osc['x']) ?></a>
                            </td>
                            <td>
                                <a href="<?php echo remove_junk($v_osc['facebook']) ?>" target="_blank"><?php echo remove_junk($v_osc['facebook']) ?></a>
                            </td>
                            <td>
                                <a href="<?php echo remove_junk($v_osc['instagram']) ?>" target="_blank"><?php echo remove_junk($v_osc['instagram']) ?></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th class="text-center" style="width: 10%;">Youtube</th>
                            <th class="text-center" style="width: 10%;">Tiktok</th>
                            <th class="text-center" style="width: 10%;">Correo Oficial</th>
                            <th class="text-center" style="width: 1%;">Convenio CEDH</th>
                            <th class="text-center" style="width: 10%;">Región</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="<?php echo remove_junk($v_osc['youtube']) ?>" target="_blank"><?php echo remove_junk($v_osc['youtube']) ?></a>
                            </td>
                            <td>
                                <a href="<?php echo remove_junk($v_osc['tiktok']) ?>" target="_blank"><?php echo remove_junk($v_osc['tiktok']) ?></a>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['correo_oficial']) ?>
                            </td>
                            <td>
                                <?php
                                if ($v_osc['convenio_cedh'] == 1) {
                                    echo 'Sí';
                                } else {
                                    echo 'No';
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo remove_junk($v_osc['region_a']) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-11">
                        <a href="osc.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                            Regresar
                        </a>
                    </div>
                    <div class="col-md-1">
                        <a href="edit_osc.php?id=<?php echo (int) $v_osc['id_osc']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="img.js"></script>
<?php include_once('layouts/footer.php'); ?>