<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Reporteador';
require_once('includes/load.php');

$user = current_user();
$nivel = $user['user_level'];
if ($nivel == 1) {
    page_require_level_exacto(1);
}
if ($nivel == 5) {
    page_require_level_exacto(5);
}
if ($nivel == 50) {
    page_require_level_exacto(50);
}
?>

<?php header('Content-type: text/html; charset=utf-8');
include_once('layouts/header.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#tipo_solicitud").change(function(){
	
	var pagina="";
    
	if($(this).val() == 'q'){
		pagina = "busquedaquejas.php";		
	}else{
		if($(this).val() == 'o'){
			pagina = "busquedaorientaciones.php";
		}else{
			if($(this).val() == 'c'){
				pagina = "busquedacanalizaciones.php";
			}else{
				if($(this).val() == 'a'){
					pagina = "busquedactuaciones.php";
				}else{
					if($(this).val() == 't'){
						pagina = "busquedglobal.php";
					}else{
						pagina = "";
					}
				}
			}
		}
	}
		$("#acctionURL").attr("src",pagina);
		
  });
});
</script>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Reporteador General</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_quejoso.php">
                <h1>Datos búsqueda</h1>
                <div class="row" style="margin-top: 2%">
					<div class="col-md-2">
                        <div class="form-group">
                            <label for="nombreQ">Tipo Solicitud</label>
							<select class="form-control" name="tipo_solicitud" id="tipo_solicitud">
                                <option value="0">Escoge una opción</option>                                
                                    <option value="q">Quejas</option>
                                    <option value="o">Orientaciones</option>
                                    <option value="c">Canalizaciones</option>
                                    <!--<option value="a">Otras Actuaciones</option>
                                    <option value="t">Todo</option> -->
                            </select>
                        </div>
                    </div>
				</div>
                <div class="row" style="margin-top: 2%">
                    <iframe id="acctionURL" src=""   style="position:absoluta; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:750px; border:none; margin:0; padding:0; overflow:hidden;"> </iframe>


                </div>
            </form>

               
        </div>
    </div>
</div>


<?php include_once('layouts/footer.php'); ?>