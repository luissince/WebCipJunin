<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('./layout/head.php'); ?>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #FFFFFF;">
            <!-- Main content -->
            <section class="content-header">
                <h3 class="no-margin">Validación de Certificado </h3>
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
                                <img class="profile-user-img img-responsive img-circle" src="images/noimage.jpg" alt="User profile picture" id="lblImagen">

                                <h3 class="profile-username text-center" id="lblDatos">--</h3>

                                <p class="text-muted text-center" id="lblCip">--</p>

                                <p class="text-muted text-center" id="lblNum">--</p>

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
                                            <label for="txtUsuario" class="col-sm-2 control-label">N° Cert.:</label>

                                            <div class="col-sm-10">
                                                <label class="control-label" id="lblNumero">-</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtUsuario" class="col-sm-2 control-label">Especialidad:</label>

                                            <div class="col-sm-10">
                                                <label class="control-label" id="lblEspecialidad">-</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtClave" class="col-sm-2 control-label">Asunto:</label>

                                            <div class="col-sm-10">
                                                <label class="control-label" id="lblAsunto">-</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtClave" class="col-sm-2 control-label">Entidad:</label>

                                            <div class="col-sm-10">
                                                <label class="control-label" id="lblEntidad">-</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtClave" class="col-sm-2 control-label">Lugar:</label>

                                            <div class="col-sm-10">
                                                <label class="control-label" id="lblLugar">-</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtClave" class="col-sm-2 control-label">Fch. Registro:</label>

                                            <div class="col-sm-10">
                                                <label class="control-label" id="lblRegistro">-</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtClave" class="col-sm-2 control-label">Fch. Vigencia:</label>

                                            <div class="col-sm-10">
                                                <label class="control-label" id="lblVigencia">-</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="info-box bg-purple" id="divBox">
                                    <span class="info-box-icon" id="divIcon"><i class="fa fa-refresh"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" id="lblCertificado">-</span>
                                        <span class="info-box-number">Consejo Departamental</span>
                                        <span class="info-box-number">Colegio de Ingenieros del Perú</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box box-success box-shadow-none">
                                    <div class="box-header">
                                        <h3 class="box-title">Observación</h3>
                                    </div>
                                    <div class="box-body">


                                        <div class="form-group">
                                            <label>
                                                Certificado Válido <small class="label label-success"><i class="fa fa-check"></i></small>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Certificado Vencido <small class="label label-warning"><i class="fa fa-warning"></i></small>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Certificado Anulado <small class="label label-danger"><i class="fa fa-ban"></i></small>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Certificado No Existente <small class="label label-default"><i class="fa fa-times"></i></small>
                                            </label>
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
        <!-- end footer -->
    </div>
    <!-- ./wrapper -->
    <script src="js/tools.js"></script>
    <script>
        let tools = new Tools();
        let token = "<?php echo isset($_GET['token']) ? $_GET['token'] : ""; ?>";
        let lblImagen = $("#lblImagen");

        $(document).ready(function() {
            loadInitCertificado();
        });

        function loadInitCertificado() {

            if (token == "") {
                $("#lblCertificado").html("Certificado no Existente");

                $("#divBox").removeClass("bg-purple").addClass("bg-times");
                $("#divIcon").empty();
                $("#divIcon").append('<i class="fa fa-times"></i>');
                return;
            }

            if (token == undefined) {
                $("#lblCertificado").html("Certificado no Existente");

                $("#divBox").removeClass("bg-purple").addClass("bg-times");
                $("#divIcon").empty();
                $("#divIcon").append('<i class="fa fa-times"></i>');
                return;
            }

            $.ajax({
                url: "../app/controller/IngresoController.php",
                method: "POST",
                data: {
                    "type": "validateCert",
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    $("#divOverlayModal").removeClass("d-none");
                },
                success: function(result) {
                    // console.log(result);
                    if (result.estado == "1") {
                        if (result.image == null) {
                            lblImagen.attr("src", "images/noimage.jpg");
                        } else {
                            lblImagen.attr("src", "data:image/(png|jpg|jpge|gif);base64," + result.image[1]);
                        }

                        $("#lblDatos").html(result.data.Nombres + " " + result.data.Apellidos);
                        $("#lblCip").html("Cip: " + result.data.CIP);
                        $("#lblNum").html("Dni: " + result.data.NumDoc);

                        $("#lblNumero").html(result.data.Numero);
                        $("#lblEspecialidad").html(result.data.Especialidad);
                        $("#lblAsunto").html(result.data.Asunto);
                        $("#lblEntidad").html(result.data.Entidad);
                        $("#lblLugar").html(result.data.Lugar);
                        $("#lblRegistro").html(result.data.FechaRegistro);
                        $("#lblVigencia").html(result.data.HastaFecha);

                        $("#lblCertificado").html(result.tipo);
                        if (result.data.Vencimiento == "0") {
                            $("#divBox").removeClass("bg-purple").addClass("bg-yellow");
                            $("#divIcon").empty();
                            $("#divIcon").append('<i class="fa fa-warning"></i>');
                        } else {
                            if (result.data.Anulado == "0") {
                                $("#divBox").removeClass("bg-purple").addClass("bg-green");
                                $("#divIcon").empty();
                                $("#divIcon").append('<i class="fa fa-check"></i>');

                            } else {
                                $("#divBox").removeClass("bg-purple").addClass("bg-red");
                                $("#divIcon").empty();
                                $("#divIcon").append('<i class="fa fa-ban"></i>');
                            }
                        }
                    } else {
                        $("#lblCertificado").html("Certificado no Existente");

                        $("#divBox").removeClass("bg-purple").addClass("bg-times");
                        $("#divIcon").empty();
                        $("#divIcon").append('<i class="fa fa-times"></i>');
                    }
                    $("#divOverlayModal").addClass("d-none");
                },
                error: function(error) {
                    console.log(error)
                    $("#divOverlayModal").addClass("d-none");
                    $("#lblCertificado").html("Certificado no Existente");

                    $("#divBox").removeClass("bg-purple").addClass("bg-times");
                    $("#divIcon").empty();
                    $("#divIcon").append('<i class="fa fa-times"></i>');
                }
            });
        }
    </script>
</body>

</html>