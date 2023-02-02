<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('./layout/head.php'); ?>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #FFFFFF;">
            <!-- Main content -->
            <section class="content-header bg-red padding-10px">
                <h3 class="no-margin bg-red text-center">Validación de Certificado de Curso</h3>
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
                        <div class="box box-danger bg-red">
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle" src="images/noimage.jpg" alt="User profile picture" id="lblImagen">

                                <h3 class="profile-username text-center" id="lblDatos">--</h3>

                                <!-- <p class=" text-center text-white" id="lblCip">--</p> -->

                                <!-- <p class=" text-center text-white" id="lblNum">--</p> -->

                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="settings">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="txtUsuario" class="col-sm-2 control-label">N° Cert.:</label>
                                        <div class="col-sm-10">
                                            <label class="control-label" id="lblNumeroCertificado">-</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtUsuario" class="col-sm-2 control-label">Curso:</label>
                                        <div class="col-sm-10">
                                            <label class="control-label" id="lblCurso">-</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtUsuario" class="col-sm-2 control-label">Capitulo:</label>
                                        <div class="col-sm-10">
                                            <label class="control-label" id="lblCapitulo">-</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtUsuario" class="col-sm-2 control-label">Modalidad:</label>
                                        <div class="col-sm-10">
                                            <label class="control-label" id="lblModalidad">-</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtUsuario" class="col-sm-2 control-label">Fch. Registro:</label>
                                        <div class="col-sm-10">
                                            <label class="control-label" id="lblRegistro">-</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="info-box bg-purple" id="divBox" style="margin-bottom: 0em;">
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
                                            Certificado No Existente <small class="label label-default"><i class="fa fa-times"></i></small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
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
        let token = "<?= isset($_GET['token']) ? $_GET['token'] : ""; ?>";
        let lblImagen = $("#lblImagen");

        $(document).ready(function() {
            loadInitCertificado();
        });

        async function loadInitCertificado() {
            // console.log(token)
            if (token == "") {
                $("#lblCertificado").html("Certificado no Existente.");

                $("#divBox").removeClass("bg-purple").addClass("bg-times");
                $("#divIcon").empty();
                $("#divIcon").append('<i class="fa fa-times"></i>');
                return;
            }

            if (token == undefined) {
                $("#lblCertificado").html("Certificado no Existente.");

                $("#divBox").removeClass("bg-purple").addClass("bg-times");
                $("#divIcon").empty();
                $("#divIcon").append('<i class="fa fa-times"></i>');
                return;
            }

            try {
                $("#divOverlayModal").removeClass("d-none");

                const response = await axios.post("../app/web/CursoWeb.php", {
                    "type": "validateCert",
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const result = response.data;

                if (result.image == null) {
                    lblImagen.attr("src", "images/noimage.jpg");
                } else {
                    lblImagen.attr("src", "data:image/(png|jpg|jpge|gif);base64," + result.image[1]);
                }

                $("#lblDatos").html(result.curso.Estudiante);

                $("#lblNumeroCertificado").html(result.curso.Serie + "-" + result.curso.Correlativo);
                $("#lblCurso").html(result.curso.Nombre);
                $("#lblCapitulo").html(result.curso.Capitulo);
                $("#lblModalidad").html(result.curso.Modalidad == "1" ? "PRESENCIAL" : "VIRTUAL");
                $("#lblRegistro").html(result.curso.FechaMoth + "/" + result.curso.FechaYear);

                $("#lblCertificado").html("Certificado Válido.");
                $("#divBox").removeClass("bg-purple").addClass("bg-green");
                $("#divIcon").empty();
                $("#divIcon").append('<i class="fa fa-check"></i>');
              
                $("#divOverlayModal").addClass("d-none");
            } catch (error) {
                $("#divOverlayModal").addClass("d-none");
                $("#lblCertificado").html("Certificado no Existente");

                $("#divBox").removeClass("bg-purple").addClass("bg-times");
                $("#divIcon").empty();
                $("#divIcon").append('<i class="fa fa-times"></i>');
            }
        }
    </script>
</body>

</html>