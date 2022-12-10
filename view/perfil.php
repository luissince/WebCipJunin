<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
?>
    <!DOCTYPE html>
    <html lang="es">

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

            async function loadInitPerfil() {
                try {
                    $("#divOverlayModal").removeClass("d-none");

                    let result = await axios.get("../app/web/UsuarioWeb.php", {
                       params:{
                        "type": "usuario",
                        "idUsuario": idUsuario
                       }
                    });
                  
                    $("#divOverlayModal").addClass("d-none");
                    $("#lblDatos").html(result.data.Nombres + ", " + result.data.Apellidos);
                    $("#lblRol").html(result.data.RolNombre);
                    $("#txtUsuario").val(result.data.Usuario)
                    $("#txtClave").val(result.data.Clave)
                } catch (error) {
                    if (error.response) {
                        $("#lblOverlayModal").html(error.response.data);
                    } else {
                        $("#lblOverlayModal").html("Se produjo un error interno, intente nuevamente.");
                    }
                }
            }

            function updatePerfil() {
                tools.ModalDialog("Perfil", "¿Está seguro de continuar?", async function(value) {
                    if (value == true) {
                        try {
                            tools.ModalAlertInfo("Perfil", "Procesando petición..");

                            let result =await axios.post("../app/web/UsuarioWeb.php", {
                                "type": "updatePerfil",
                                "idUsuario": idUsuario,
                                "usuario": $("#txtUsuario").val().trim(),
                                "clave": $("#txtClave").val().trim()
                            });

                            tools.ModalAlertSuccess("Perfil", result.data);
                        } catch (error) {
                            if (error.response) {
                                tools.ModalAlertWarning("Perfil", error.response.data);
                            } else {
                                tools.ModalAlertError("Perfil", "Se produjo un error interno, intente nuevamente.");
                            }
                        }
                    }
                });
            }
        </script>
    </body>

    </html>
<?php }
