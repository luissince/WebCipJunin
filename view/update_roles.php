
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('./layout/head.php'); ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- start header -->
        <?php include('./layout/header.php') ?>
        <!-- end header -->
        <!-- start menu -->
        <?php include('./layout/menu.php') ?>
        <!-- end menu -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #FFFFFF;">
            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <h4 style="padding-left:1em;"><i class="fa fa-list-alt"></i> Actualizar Datos del Rol <span
                            id="Load_date"></span></h4>
                    <div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:1em;">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre: <i
                                                class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="nombre" type="text" name="nombre" class="form-control"
                                            placeholder="Nombre del rol" required="" minlength="3">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción: <i
                                                class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="descripcion" type="text" name="descripcion" class="form-control"
                                            placeholder="Descripción del rol" required="" minlength="3">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="estado">Estado: </label>
                                        <select id="estado" class="form-control">
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>        
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p class="text-left text-danger">Todos los campos marcados con <i
                                            class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                    <button type="button" class="btn btn-danger" name="btnAceptar" id="btnaceptar">
                                        <i class="fa fa-check"></i> Editar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                                        name="btncancelar" id="btncancelar">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>

                        </div>
                    </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <script src="js/tools.js"></script>
    <script>
    let tools = new Tools();
    let spiner = $("#Load_date");
    let state = false;

    let idRol = "<?php echo  $_GET["idRol"]; ?>";

    $(document).ready(function() {

        loadDataRol(idRol)


        $("#btnaceptar").click(function() {
            validateUpdateRol();
        });

        $("#btnaceptar").on("keyup", function(event) {
            if (event.keyCode === 13) {
                validateUpdateRol();
            }
            event.preventDefault();
        });

        $("#btncancelar").click(function() {
            location.href = "roles.php"
        });

        $("#btncancelar").on("keyup", function(event) {
            if (event.keyCode === 13) {
                location.href = "roles.php"
            }
            event.preventDefault();
        });

    });

    function loadDataRol(idRol) {
        $.ajax({
            url: "../app/controller/RolController.php",
            method: "GET",
            data: {
                "type": "data",
                "idRol": idRol
            },
            beforeSend: function() {
                spiner.append(
                    '<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>'
                )
            },
            success: function(result) {
                // console.log(result)
                spiner.remove()
                if (result.estado === 1) {
                    let rol = result.object;
                    $("#nombre").val(rol.Nombre)
                    $("#descripcion").val(rol.Descripcion)
                    $("#estado").val(rol.Estado)                
                    tools.AlertInfo("Información", "Se cargo correctamente los datos.");
                    state = true;
                } else {
                    tools.AlertWarning("Advertencia", result.message);
                    state = false;
                }
            },
            error: function(error) {
                tools.AlertError("Error", error);
                state = false;
            }
        });
    }

    function validateUpdateRol() {
        if (state) {
            if ($("#nombre").val() == '' || $("#nombre").val().length < 3) {
                tools.AlertWarning("Advertencia", "Ingrese el nombre del rol.");
            } else if ($("#descripcion").val() == '' || $("#descripcion").val().length == 4) {
                tools.AlertWarning("Advertencia", "Ingrese la descripción del rol.");
            } else {
                updateRol(idRol,
                    $("#nombre").val(),
                    $("#descripcion").val(),
                    $("#estado").val());
            }
        } else {
            tools.AlertWarning("Advertencia",
                "Nose pudo cargar los datos correctamente, recargue la pantalla por favor.");
        }
    }

    function updateRol(IdRol, nombre, descripcion, estado) {
        $.ajax({
            url: "../app/controller/RolController.php",
            method: "POST",
            data: {
                "type": "updateRol",
                "idRol": IdRol,
                "Nombre": (nombre.toUpperCase()).trim(),
                "Descripcion": (descripcion.toUpperCase()).trim(),
                "Estado": estado                
            },
            beforeEnd: function() {
                $("#btnaceptar").empty();
                $("#btnaceptar").append('<img src="./images/spiner.gif" width="25" height="25" />')
                
            },
            success: function(result) {
                
                if (result.estado == 1) {
                    tools.AlertSuccess("Mensaje", result.message)
                    setTimeout(function() {
                        location.href = "roles.php"
                    }, 1000);
                } else {
                    tools.AlertWarning("Mensaje", result.message)
                    setTimeout(function() {
                        $("#btnaceptar").empty();
                        $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
                    }, 1000);
                }
            },
            error: function(error) {
                tools.AlertError("Error", error.responseText);
                $("#btnaceptar").empty();
                $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
            }
        });
    }
    </script>
</body>

</html>
