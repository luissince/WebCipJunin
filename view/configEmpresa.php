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
                    <h3 class="no-margin"> Empresa <small> Configuración </small> </h3>
                </section>

                <section class="content">
                    <div class="row">
                        <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>
                                        <i></i>
                                        R.U.C:
                                    </label>
                                    <div class="form-group">
                                        <input id="txtNumDocumento" class="form-control" type="text" placeholder="R.U.C.">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class="lbl-titulo ">
                                        <i></i>
                                        Razón Social
                                    </label>
                                    <div class="form-group">
                                        <input id="txtRazonSocial" class="form-control" type="text" placeholder="Razón Social" />
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>
                                        <i></i>
                                        Nombre Comercial
                                    </label>
                                    <div class="form-group">
                                        <input id="txtNomComercial" class="form-control" type="text" placeholder="Nombre Comercial">
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center margin">
                                    <img class="img-responsive img-thumbnail" style="width: 160px;height:160px;" id="lblImagen">
                                    <!-- <img src="./image/noimage.jpg" style="object-fit: cover;" width="160" height="160" id="lblImagen"> -->
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center margin">
                                    <label for="SubirImagen" class="btn btn-warning"><i class="fa fa-photo"></i> Subir imagen</label>
                                    <input type="file" id="SubirImagen" style="display:none" accept="image/png, image/jpeg, image/gif, image/svg">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>
                                <i></i>
                                Dirección Fiscal:
                            </label>
                            <div class="form-group">
                                <input id="txtDireccion" class="form-control" type="text" placeholder="Ingrese su dirección fiscal">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>
                                <i></i>
                                Teléfono
                            </label>
                            <div class="form-group">
                                <input id="txtTelefono" class="form-control" type="text" placeholder="Teléfono">

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>
                                <i></i>
                                Celular
                            </label>
                            <div class="form-group">
                                <input id="txtCelular" class="form-control" type="text" placeholder="Celular">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>
                                <i></i>
                                Página Web
                            </label>
                            <div class="form-group">
                                <input id="txtPaginWeb" class="form-control" type="text" placeholder="Página Web">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>
                                <i></i>
                                Email
                            </label>
                            <div class="form-group">
                                <input id="txtEmail" class="form-control" type="text" placeholder="Email" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="subtitulo-texto">
                                Usuario y Password SOL - SUNAT
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label class="lbl-titulo ">
                                <i></i>
                                Usuario Sol
                            </label>
                            <div class="form-group">
                                <input id="txtUsuarioSol" class="form-control" type="text" placeholder="Usuario Sol" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label class="lbl-titulo ">
                                <i></i>
                                Contraseña Sol
                            </label>
                            <div class="form-group">
                                <input id="txtClaveSol" class="form-control" type="password" placeholder="Password SOL" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Certificado Electrónico y Password
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Seleccionar Archivo</label>
                                <div class="input-group">
                                    <input class="form-control form-control-lg" type="file" class="custom-file-input" id="fileCertificado" style="display: none;">
                                    <label class="form-control" for="fileCertificado" id="lblNameCertificado">Seleccionar archivo</label>
                                    <div class="input-group-btn">
                                        <label class="btn btn-success" for="fileCertificado">Subir</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label class="lbl-titulo ">
                                <i></i>
                                Contraseña de tu Certificado
                            </label>
                            <div class="form-group">
                                <input id="txtClaveCertificado" class="form-control" type="password" placeholder="Contraseña de tu Certificado" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button id="btnGuardar" class="btn btn-primary" type="button">
                                <i class="fa fa-save"></i> Guardar Información
                            </button>
                        </div>
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
            let idEmpresa = 0;
            let txtNumDocumento = $("#txtNumDocumento");
            let txtRazonSocial = $("#txtRazonSocial");
            let txtNomComercial = $("#txtNomComercial");
            let lblImagen = $("#lblImagen");
            let fileImage = $("#SubirImagen");
            let txtDireccion = $("#txtDireccion");
            let txtTelefono = $("#txtTelefono");
            let txtCelular = $("#txtCelular");
            let txtPaginWeb = $("#txtPaginWeb");
            let txtEmail = $("#txtEmail");
            let txtUsuarioSol = $("#txtUsuarioSol");
            let txtClaveSol = $("#txtClaveSol");
            let lblNameCertificado = $("#lblNameCertificado");
            let fileCertificado = $("#fileCertificado");
            let txtClaveCertificado = $("#txtClaveCertificado");

            $(document).ready(function() {

                $("#SubirImagen").on('change', function(event) {
                    lblImagen.attr("src", URL.createObjectURL(event.target.files[0]));
                });

                $("#fileCertificado").on('change', function(event) {
                    lblNameCertificado.val(event.target.files[0].name);
                    lblNameCertificado.html(event.target.files[0].name);
                });

                $("#btnGuardar").keypress(function(event) {
                    if (event.keyCode == 13) {
                        crudEmpresa();
                    }
                    event.preventDefault();
                });

                $("#btnGuardar").click(function() {
                    crudEmpresa();
                });
                // modalEvents();
                LoadDataEmpresa();
            });

            function LoadDataEmpresa() {
                $.ajax({
                    url: "../app/controller/configEmpresaController.php",
                    method: "GET",
                    data: {

                    },
                    beforeSend: function() {
                        tools.AlertInfo("Mi Empresa", "Cargando información.", "toast-bottom-right");
                    },
                    success: function(result) {
                        let data = result;
                        if (data.estado == 1) {
                            idEmpresa = data.result.IdEmpresa;
                            txtNumDocumento.val(data.result.NumeroDocumento);
                            txtRazonSocial.val(data.result.RazonSocial);
                            txtNomComercial.val(data.result.NombreComercial);
                            if (data.result.Image == "") {
                                lblImagen.prop("src", "images/noimage.jpg");
                            } else {
                                lblImagen.attr("src", "data:image/png;base64," + data.result.Image);
                            }
                            txtDireccion.val(data.result.Domicilio);
                            txtTelefono.val(data.result.Telefono);
                            txtCelular.val(data.result.Celular);
                            txtPaginWeb.val(data.result.PaginaWeb);
                            txtEmail.val(data.result.Email);
                            txtUsuarioSol.val(data.result.UsuarioSol);
                            txtClaveSol.val(data.result.ClaveSol);
                            lblNameCertificado.html(data.result.CertificadoRuta)
                            txtClaveCertificado.val(data.result.CertificadoClave);
                            tools.AlertSuccess("Mi Empresa", " Se cargó correctamente los datos.", "toast-bottom-right");
                        } else {
                            tools.AlertWarning("Mi Empresa", data.message, "toast-bottom-right");
                        }

                    },
                    error: function(error) {
                        console.log(error)
                        tools.AlertError("Mi Empresa",
                            "Error en :" + error.responseText, "toast-bottom-right");
                    }
                });
            }

            function crudEmpresa() {
                var formData = new FormData();
                formData.append("idEmpresa", idEmpresa);
                formData.append("txtNumDocumento", txtNumDocumento.val());
                formData.append("txtRazonSocial", txtRazonSocial.val());
                formData.append("txtNomComercial", txtNomComercial.val());
                formData.append("txtDireccion", txtDireccion.val());
                formData.append("txtTelefono", txtTelefono.val());
                formData.append("txtCelular", txtCelular.val());
                formData.append("txtPaginWeb", txtPaginWeb.val());
                formData.append("txtEmail", txtEmail.val());

                formData.append("imageType", fileImage[0].files.length);
                formData.append("image", fileImage[0].files[0]);

                formData.append("txtUsuarioSol", txtUsuarioSol.val());
                formData.append("txtClaveSol", txtClaveSol.val());
                formData.append("certificadoUrl", lblNameCertificado.html());
                formData.append("certificadoType", fileCertificado[0].files.length);
                formData.append("certificado", fileCertificado[0].files[0]);
                formData.append("txtClaveCertificado", txtClaveCertificado.val());

                tools.ModalDialog("Mi Empresa", "¿Está seguro de continuar?", function(value) {
                    if (value == true) {
                        $.ajax({
                            url: "../app/controller/configEmpresaController.php",
                            method: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                tools.ModalAlertInfo("Mi Empresa", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.state == 1) {
                                    tools.ModalAlertSuccess("Mi Empresa", result.message);
                                    LoadDataEmpresa();
                                } else {
                                    tools.ModalAlertWarning("Mi Empresa", result.message);
                                }

                            },
                            error: function(error) {
                                tools.ModalAlertError("Mi Empresa", "Se produjo un error: " + error.responseText);
                            }
                        });
                    }
                });

            }
        </script>
    </body>

    </html>

<?php }
