<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][23]["ver"] == 1) {
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
                <!-- modal nuevo Banco  -->
                <div class="row">
                    <div class="modal fade" id="modalReset">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseCertificado">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-refresh"></i> Resetear numeracion
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-overlay d-none" id="divLoad">
                                        <div class="modal-overlay-content">
                                            <div>
                                                <i class="fa fa-refresh fa-spin"></i>
                                            </div>
                                            <div>
                                                <label id="lblOverlayModal">Cargando información...</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Certificado</label>
                                                <input id="txtNombre" type="text" class="form-control" placeholder="Nombre" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtNumeracion">Correlativo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtNumeracion" type="text" class="form-control" placeholder="Numeración de Inicio" required="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-danger" id="btnAceptarCertificado">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="btnCancelarCertificado">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal new Bussinees -->
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Configuración <small> Lista </small> </h3>
                    </section>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- panel izquierdo superior-->
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h5 class="no-margin"> Correlativo Certificados</h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <thead style="background-color: #FDB2B1;color: #B72928;">
                                                        <tr>
                                                            <th width="5%">#</th>
                                                            <th width="25%">Certificado</th>
                                                            <th width="25%">Correlativo</th>
                                                            <th width="10%">Resetear</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbCorrelativoCert">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- panel izquierdo inferior-->
                            </div>
                        </div>
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

                //correlativo certificados
                let tipo = 0;
                let tbCorrelativoCert = $("#tbCorrelativoCert");

                $(document).ready(function() {

                    $("#txtNumeracion").keypress(function(event) {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b')) {
                            event.preventDefault();
                        }
                    });


                    $("#btnAceptarCertificado").click(function() {
                        onEventReset();
                    });

                    $("#btnAceptarCertificado").keydown(function(event) {
                        if (event.keyCode == 13) {
                            onEventReset();
                            event.preventDefault();
                        }
                    });

                    $("#btnCloseCertificado").click(function() {
                        clearModalReset();
                    });

                    $("#btnCloseCertificado").keydown(function(event) {
                        if (event.keyCode == 13) {
                            clearModalReset();
                            event.preventDefault();
                        }
                    });

                    $("#btnCancelarCertificado").click(function() {
                        clearModalReset();
                    });

                    $("#btnCancelarCertificado").keydown(function(event) {
                        if (event.keyCode == 13) {
                            clearModalReset();
                            event.preventDefault();
                        }
                    });

                    loadTableCorrelativoCert();
                });

                function loadTableCorrelativoCert() {
                    $.ajax({
                        url: "../app/controller/ConceptoController.php",
                        method: "GET",
                        data: {
                            "type": "allCorrelativoCert",
                        },
                        beforeSend: function() {
                            tbCorrelativoCert.empty();
                            tbCorrelativoCert.append(
                                '<tr class="text-center"><td colspan="4"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                            );
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                tbCorrelativoCert.empty();
                                for (let cert of result.data) {
                                    $("#tbCorrelativoCert").append('<tr>' +
                                        '<td>' + cert.Id + '</td>' +
                                        '<td>' + cert.Nombre + '</td>' +
                                        '<td>' + cert.Numero + '</td>' +
                                        '<td><button class="btn btn-warning btn-xs" onclick="onReset(\'' + cert.Id + '\',\'' + cert.Nombre + '\')"><i class="fa fa-refresh" style="font-size:20px;"></i></button></td>' +
                                        '</tr>');
                                }
                            } else {
                                tbCorrelativoCert.empty();
                                tbCorrelativoCert.append(
                                    '<tr class="text-center"><td colspan="4"><p>No se pudo cargar la información.</p></td></tr>'
                                );
                            }
                        },
                        error: function(error) {
                            tbCorrelativoCert.empty();
                            tbCorrelativoCert.append(
                                '<tr class="text-center"><td colspan="4"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                            );
                        }
                    });
                }

                function onReset(id, nombre) {
                    $("#modalReset").modal("show");
                    $("#txtNombre").val(nombre);
                    tipo = id;
                }

                function onEventReset() {
                    if ($("#txtNumeracion").val().trim().length == 0) {
                        tools.AlertWarning("Warning", "Ingrese el correlativo del certificado.");
                        $("#txtNumeracion").focus();
                    } else if (!tools.isNumeric($("#txtNumeracion").val().trim())) {
                        tools.AlertWarning("Warning", "El valor ingresado no es numerico.");
                        $("#txtNumeracion").focus();
                    } else {
                        $.ajax({
                            url: "../app/controller/ConceptoController.php",
                            method: "POST",
                            data: {
                                "type": "correlativoCertCrud",
                                "tipo": tipo,
                                "numeracion": parseInt($("#txtNumeracion").val().trim()) - 1
                            },
                            beforeSend: function() {
                                clearModalReset();
                                tools.ModalAlertInfo("Configuración", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Configuración", result.message);
                                } else {
                                    tools.ModalAlertWarning("Configuración", result.message);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Configuración", error.responseText);
                            }
                        });
                    }
                }

                function clearModalReset() {
                    $("#modalReset").modal("hide");
                    $("#txtNombre").val('');
                    $("#txtNumeracion").val('');
                    tipo = 0;
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
