<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
?>
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
                <section class="content-header">
                    <h3 class="no-margin">Perfil <small> Datos </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="modal-overlay d-none" id="divOverlayModal">
                            <div class="modal-overlay-content">
                                <div>
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                                <div>
                                    <label id="lblOverlayModal">Cargando información...</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <img class="profile-user-img img-responsive img-circle" src="images/noimage.jpg" alt="User profile picture">

                                    <h3 class="profile-username text-center" id="lblDatos">--</h3>

                                    <p class="text-muted text-center" id="lblRol">--</p>

                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Datos</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="settings">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label for="txtUsuario" class="col-sm-2 control-label">Usuario:</label>

                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="txtUsuario" placeholder="Ingrese su usuario para el sistema.">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtClave" class="col-sm-2 control-label">Contraseña:</label>

                                                <div class="col-sm-10">
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="txtClave" placeholder="Ingrese su contraseña para el sistema.">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" id="btnView"><i class="fa fa-eye"></i></button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button class="btn btn-warning" id="btnActualizar"><i class="fa fa-edit"></i>Actualizar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                        </div>
                        <!-- /.col -->
                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <!-- start footer -->
            <?php include('./layout/footer.php') ?>
            <!-- end footer -->
        </div>
        <!-- ./wrapper -->
        <script src="js/tools.js"></script>
        <script>
            let tools = new Tools();

            let idUsuario = <?php echo $_SESSION['IdUsuario']; ?>;

            $(document).ready(function() {
                loadInitPerfil();

                $("#btnView").click(function() {
                    $("#txtClave").attr("type", $("#txtClave").prop("type") == "text" ? "password" : "text");
                });

                $("#btnView").keypress(function(event) {
                    if (event.keyCode == 13) {
                        $("#txtClave").attr("type", $("#txtClave").prop("type") == "text" ? "password" : "text");
                    }
                    event.preventDefault();
                });

                $("#btnActualizar").click(function() {
                    updatePerfil();
                });

                $("#btnActualizar").keypress(function(event) {
                    if (event.keyCode == 13) {
                        updatePerfil();
                    }
                    event.preventDefault();
                });
            });

            function loadInitPerfil() {
                $.ajax({
                    url: "../app/controller/UsuarioController.php",
                    method: "GET",
                    data: {
                        "type": "usuario",
                        "idUsuario": idUsuario
                    },
                    beforeSend: function() {
                        $("#divOverlayModal").removeClass("d-none");
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            $("#divOverlayModal").addClass("d-none");
                            $("#lblDatos").html(result.object.Nombres + ", " + result.object.Apellidos);
                            $("#lblRol").html(result.object.RolNombre);
                            $("#txtUsuario").val(result.object.Usuario)
                            $("#txtClave").val(result.object.Clave)
                        } else {
                            $("#lblOverlayModal").html(result.message);
                        }
                    },
                    error: function(error) {
                        $("#lblOverlayModal").html(error.responseText);
                    }
                });
            }

            function updatePerfil() {
                tools.ModalDialog("Perfil", "¿Está seguro de continuar?", function(value) {
                    if (value == true) {
                        $.ajax({
                            url: "../app/controller/UsuarioController.php",
                            method: "POST",
                            data: {
                                "type": "updatePerfil",
                                "idUsuario": idUsuario,
                                "usuario": $("#txtUsuario").val().trim(),
                                "clave": $("#txtClave").val().trim()
                            },
                            beforeSend: function() {
                                tools.ModalAlertInfo("Perfil", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Perfil", result.message);
                                } else {
                                    tools.ModalAlertWarning("Perfil", result.message);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Perfil", "Se produjo un error: " + error.responseText);
                            }
                        });
                    }
                });
            }
        </script>
    </body>

    </html>
<?php }
