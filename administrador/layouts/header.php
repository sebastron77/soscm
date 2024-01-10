<?php $user = current_user(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <link rel="icon" type="image/png" sizes="16x16" href="medios/favicon-16x16.png">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">
  <meta charset="UTF-8">
  <title>
    <?php
    if (!empty($page_title))
      echo remove_junk($page_title);
    elseif (!empty($user))
      echo ucfirst($user['username']);
    else echo "SOSCDHM";
    ?>
  </title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
  <link rel="stylesheet" href="libs/css/main.css" />
  <link rel="stylesheet" href="libs/css/organigrama.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
  <script src="html2pdf.bundle.min.js"></script>
  <script src="script.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

  <link href="https://harvesthq.github.io/chosen/chosen.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
  <link href="MyFont1.otf" rel="stylesheet">

  <script language="javascript">
    function myFunction() {
      var popup = document.getElementById("myPopup");
      popup.classList.toggle("show");
    }

    function myFunction2() {
      var popup2 = document.getElementById("myPopup2");
      popup2.classList.toggle("show");
    }

    function myFunction3() {
      var popup3 = document.getElementById("myPopup3");
      popup3.classList.toggle("show");
    }

    function myFunction4() {
      var popup4 = document.getElementById("myPopup4");
      popup4.classList.toggle("show");
    }

    function myFunction5() {
      var popup5 = document.getElementById("myPopup5");
      popup5.classList.toggle("show");
    }

    function myFunction6() {
      var popup6 = document.getElementById("myPopup6");
      popup6.classList.toggle("show");
    }

    function myFunction7() {
      var popup7 = document.getElementById("myPopup7");
      popup7.classList.toggle("show");
    }

    $(document).ready(function() {
      $("#se_turna_a_area").change(function() {
        $("#se_turna_a_area option:selected").each(function() {
          nombre_area = $(this).val();
          $.post("buscar.php", {
            nombre_area: nombre_area
          }, function(data) {
            $("#se_turna_a_trabajador").html(data);
          })
        })
      })
    });

    $(document).ready(function() {
      $("#area_responsable").change(function() {
        $("#area_responsable option:selected").each(function() {
          nombre_area = $(this).val();
          $.post("buscar.php", {
            nombre_area: nombre_area
          }, function(data) {
            $("#responsable").html(data);
          })
        })

      })
    });

    $(document).ready(function() {
      $("#id_area_asignada").change(function() {
        $("#id_area_asignada option:selected").each(function() {
          id_area = $(this).val();
          $.post("buscarQ.php", {
            id_area: id_area
          }, function(data) {
            $("#id_user_asignado").html(data);
          })
        })

      })
    });

    $(document).ready(function() {
      $("#area_supervisor").change(function() {
        $("#area_supervisor option:selected").each(function() {
          nombre_area = $(this).val();
          $.post("buscar.php", {
            nombre_area: nombre_area
          }, function(data) {
            $("#supervisor").html(data);
          })
        })

      })
    });

    $(document).ready(function() {
      $("#se_turna_a_area").change(function() {
        $("#se_turna_a_area option:selected").each(function() {
          nombre_area2 = $(this).val();
          $.post("buscar2.php", {
            nombre_area2: nombre_area2
          }, function(data) {
            $("#se_turna_a_trabajador_editar").html(data);
          })
        })

      })
    });
    $(document).ready(function() {
      $("#area_responsable").change(function() {
        $("#area_responsable option:selected").each(function() {
          nombre_area3 = $(this).val();
          $.post("buscar3.php", {
            nombre_area3: nombre_area3
          }, function(data) {
            $("#responsable_editar").html(data);
          })
        })

      })
    });
    $(document).ready(function() {
      $("#area_supervisor").change(function() {
        $("#area_supervisor option:selected").each(function() {
          nombre_area2 = $(this).val();
          $.post("buscar2.php", {
            nombre_area2: nombre_area2
          }, function(data) {
            $("#supervisor_editar").html(data);
          })
        })

      })
    });
    $(document).ready(function() {
      $("#id_cat_municipios").change(function() {

        $("#id_cat_municipios option:selected").each(function() {
          id_cat_municipios = $(this).val();
          $.post("buscar5.php", {
            id_cat_municipios: id_cat_municipios
          }, function(data) {
            $("#localidad").html(data);
          })
        })

      })
    });
  </script>
</head>

<style>
  .titulo {
    font-size: 72px;
    background: -webkit-linear-gradient(left, #081859, #1a95cb);
    background: linear-gradient(to right, #081859, #1a95cb);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
</style>

<body style="background-color: #E3E3E3; color: white;">
  <?php if ($session->isUserLoggedIn(true)) : ?>
    <header id="header">
      <div class="logo pull-left"><img border="0" src="medios/Imagen4.png" width="33px" title="CEDH" alt="" style="margin-top: 7%; margin-left: -75%;" />
        <div>
          <h1 class="titulo" style="margin-top: -13.5%; margin-left: 3%; font-size:34px; font-weight:bold;">SOSCDH<h2 style="font-family: My Font; font-size: 48px; color:#1573ac; margin-top:-52px; margin-left: 198px;">M</h2>
          </h1>
        </div>
      </div>
      <div class="header-content">
        <div class="pull-right clearfix">
          <ul class="info-menu list-inline list-unstyled">
            <li class="profile">
              <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
                <?php if ($user['imagen'] === 'no_image.jpg') : ?>
                  <i class="glyphicon glyphicon-user"></i>
                <?php else : ?>
                  <img src="uploads/users/<?php echo $user['imagen']; ?>" alt="" class="img-circle img-inline">
                <?php endif; ?>
                <span><?php echo remove_junk(ucfirst($user['username'])); ?> <i class="caret"></i></span>
              </a>
              <ul class="dropdown-menu" style="background-color: #FFFFFF;">
                <li>
                  <a href="profile.php?id=<?php echo (int)$user['id_user']; ?>">
                    <i class="glyphicon glyphicon-user"></i>
                    Perfil
                  </a>
                </li>
                <li>
                  <a href="edit_account.php" title="edit account">
                    <i class="glyphicon glyphicon-cog"></i>
                    Configuración
                  </a>
                </li>
                <li class="last">
                  <a href="logout.php">
                    <i class="glyphicon glyphicon-off"></i>
                    Salir
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </header>
    <div class="sidebar">
      <?php if ($user['user_level'] === '1') : ?>
        <!-- Sistemas (Administrador) -->
        <?php include_once('super_admin_menu.php'); ?>

      <?php elseif ($user['user_level'] === '2') : ?>
        <!-- Presidencia y Secretaría Técnica -->
        <?php include_once('osc_menu.php'); ?>

      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="page">
    <div class="container-fluid">