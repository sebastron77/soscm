<?php
$page_title = 'Solicitudes de Información';
require_once('includes/load.php');
?>
<?php
$all_solicitudes = find_all('solicitudes_informacion');

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];
$title_status="Sin Dato";
$image_status="duda.png";
$fechaActual = date('Y-m-d');

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user == 10) {
    page_require_level_exacto(10);
}

if ($nivel_user > 3 && $nivel_user < 7) :
    redirect('home.php');
	
endif;if ($nivel_user > 7 && $nivel_user < 10) :
    redirect('home.php');
endif;
if ($nivel_user > 10) :
    redirect('home.php');
endif;


?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>



<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Solicitude de Información</span>
                </strong>
                <?php if (($nivel_user <= 2) || ($nivel_user == 3) ) : ?>
                    <a href="add_solicitud_ut.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Solicitud</a>
                <?php endif; ?>

            </div>
        </div>

        <div class="panel-body">
            <table class="datatable table table-bordered table-striped">
                <thead class="thead-purple">
                    <tr>
                        <th style="width: 1%;">Status</th>
                        <th style="width: 6%;">Folio</th>
                        <th style="width: 1%;">Fecha Presentacion</th>
                        <th style="width: 1%;">Fecha Tentativa de Respuesta</th>
                        <th style="width: 1%;">Fecha de Respuesta</th>
                        <th style="width: 1%;">Nombre Solicitante</th>
                        <th style="width: 5%;">Género Solicitante</th>
                        <th style="width: 2%;">Medio de Presentación</th>
                        <th style="width: 2%;">Tipo Solicitud</th>
                        
                        <?php if ($nivel_user <= 2 || ($nivel_user == 3) || ($nivel_user == 7)) : ?>
                            <th style="width: 1%;" class="text-center">Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                   <?php foreach ($all_solicitudes as $datos) : 
				   $genero =find_campo_id('cat_genero', $datos['id_cat_gen'], 'id_cat_gen','descripcion');
				   $presentacion =find_campo_id('cat_medio_pres_ut', $datos['id_cat_med_pres_ut'], 'id_cat_med_pres_ut','descripcion');
				   $tipo_solicitud =find_campo_id('cat_tipo_solicitud', $datos['id_cat_tipo_solicitud'], 'id_cat_tipo_solicitud','descripcion');
				   $dia_vencimiento = sumasdiasemana($datos['fecha_presentacion'],20);
				   $fecha_proxima =sumasdiasemana($datos['fecha_presentacion'],15);
				   $fecha_respuesta = ($datos['fecha_respuesta']==NULL?'':date("d-m-Y", strtotime(remove_junk(ucwords($datos['fecha_respuesta'])))));
				   
					if($datos['fecha_respuesta'] === NULL){
						if(strtotime($fechaActual,time()) > strtotime($dia_vencimiento) ){
							$image_status ="red.png";
							$title_status = "Vencida";
						}else if(strtotime($fechaActual,time()) > strtotime($fecha_proxima) && strtotime($fechaActual,time()) < strtotime($dia_vencimiento)){
							$image_status ="orange.png";
							$title_status = "Proxima a vencer";
						}else if(strtotime($dfechaActual,time()) <  strtotime($dia_vencimiento)){
							$image_status ="green.png";
							$title_status ="En tiempo";
						}
					}else{
						if(strtotime($datos['fecha_respuesta'],time()) > strtotime($dia_vencimiento) ){
							$image_status ="roja.png";
							$title_status ="Respuesta a destiempo";
						}else{
							$image_status ="verde.png";
							$title_status ="Respuesta a tiempo";
						}
					}
				   
				   ?> 
                        <tr>
                            <td class="text-center">							
								<img src="medios/<?php echo $image_status; ?>" style="width: 21px; height: 20.5px; " title="<?php echo $title_status; ?>">
							</td>
                            <td><?php echo remove_junk(ucwords($datos['folio_solicitud'])) ?></td>
							<td><?php echo date("d-m-Y", strtotime(remove_junk(ucwords($datos['fecha_presentacion'])))) ?></td>
							<td><?php echo date("d-m-Y", strtotime($dia_vencimiento)) ?></td>
							<td><?php echo  "".$fecha_respuesta. ""?></td>
                            <td><?php echo remove_junk((ucwords($datos['nombre_solicitante']))) ?></td>
                            <td><?php echo remove_junk((ucwords($genero['descripcion']))) ?></td>
                            <td><?php echo remove_junk((ucwords($presentacion['descripcion']))) ?></td>
                            <td><?php echo remove_junk((ucwords($tipo_solicitud['descripcion']))) ?></td>
                            
                            <?php if (($nivel_user <= 2) || ($nivel_user == 7) || ($nivel_user == 10)) : ?>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_solicitud_info.php?id=<?php echo (int)$datos['id_solicitudes_informacion']; ?>" data-toggle="tooltip" title="Ver información completa">
                                            <img src="medios/ver_info.png" style="width: 31px; height: 30.5px; border-radius: 15%; margin-right: -2px;">
                                        </a>&nbsp;
										<?php if (($nivel_user < 10) ) : ?>
											<a href="edit_solicitudes_ut.php?id=<?php echo (int)$datos['id_solicitudes_informacion']; ?>"  title="Editar" data-toggle="tooltip">
												<img src="medios/editar2.png" style="width: 31px; height: 30.5px; border-radius: 15%; margin-right: -2px;">                                            
											</a>&nbsp;
										<?php endif; ?>
										<?php if (($nivel_user < 10) ) : 
												if($fecha_respuesta === ''):
										?>
											<a href="respuesta_solicitud.php?id=<?php echo (int)$datos['id_solicitudes_informacion']; ?>"  title="Respuesta" data-toggle="tooltip">
												<img src="medios/resolucion2.png" style="width: 31px; height: 30.5px; border-radius: 15%; ">                                        
											</a>
										<?php endif; 
										endif; ?>
                                    </div>
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