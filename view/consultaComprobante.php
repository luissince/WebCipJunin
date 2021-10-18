<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][21]["ver"] == 1) {
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
                        <h3 class="no-margin"> Comprobantes Electrónicos <small> Consulta </small> </h3>
                    </section>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <!-- <li class="active"><a href="#tab_1" data-toggle="tab">Consulta Básica</a></li> -->
                                        <li class="active"><a href="#tab_2" data-toggle="tab">Consulta avanzada</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- <div class="tab-pane active" id="tab_1">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Numero de RUC del emisor <i class="text-danger fa fa-info-circle"></i></label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-right">
                                                <div class="form-group">
                                                    <label> : </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" placeholder="RUC" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tipo de comprobante <i class="text-danger fa fa-info-circle"></i></label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-right">
                                                <div class="form-group">
                                                    <label> : </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select id="codComp" class="form-control">
                                                        <option value="1">Factura</option>
                                                        <option value="2">Boleta De Venta</option>
                                                        <option value="3">Nota de Crédito</option>
                                                        <option value="4">Nota de Débito</option>
                                                        <option value="5">Recibo por Honorarios</option>
                                                        <option value="6">Nota Crédito Recibo por Honorarios </option>
                                                        <option value="7">Liquidación de Compra</option>
                                                        <option value="8">Póliza de Adjudicación Electrónica</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Serie y número de comprobante <i class="text-danger fa fa-info-circle"></i></label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-right">
                                                <div class="form-group">
                                                    <label> : </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <table style="width: 100%;">
                                                        <tbody>
                                                            <tr style="width: 100%">
                                                                <td style="width: 45%"><input class="form-control" name="numeroSerie" id="numeroSerie" placeholder="Serie" maxlength="4">
                                                                </td>
                                                                <td style="width: 10%; text-align: center;"> - </td>
                                                                <td style="width: 45%"><input class="form-control" name="numero" id="numero" placeholder="Número" maxlength="8">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tipo y número de documento del receptor </label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-right">
                                                <div class="form-group">
                                                    <label> : </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <table style="width: 100%;">
                                                        <tbody>
                                                            <tr style="width: 100%">
                                                                <td style="width: 45%;"><select name="codDocRecep" id="codDocRecep" class="form-control">
                                                                        <option value="">Sin documento</option>
                                                                        <option value="1">RUC</option>
                                                                        <option value="2">DNI</option>
                                                                        <option value="3">Carnet de extranjeria</option>
                                                                        <option value="4">Pasaporte</option>
                                                                        <option value="5">Cédula diplomática de identidad</option>
                                                                        <option value="6">Documento Tributario No Domiciliado</option>
                                                                    </select></td>
                                                                <td style="width: 10%; text-align: center;"> - </td>
                                                                <td style="width: 45%"><input name="numDocRecep" id="numDocRecep" class="form-control" placeholder="Nro Doc" maxlength="15" readonly="">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Fecha de emisión <i class="text-danger fa fa-info-circle"></i></label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-right">
                                                <div class="form-group">
                                                    <label> : </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="date" placeholder="Fecha de emisión" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Importe total <i class="text-danger fa fa-info-circle"></i></label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-right">
                                                <div class="form-group">
                                                    <label> : </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <div class="form-group">
                                                    <input type="text" placeholder="Importe total" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                            </div>
                                            <div class="col-md-12">
                                                <center>
                                                    <button type="button" id="btnConsultar" class="btn btn-primary">
                                                        <strong>Consultar</strong>
                                                    </button>
                                                    <button type="button" id="btnLimpiar" class="btn btn-danger">
                                                        <strong>Limpiar</strong>
                                                    </button>
                                                </center>
                                            </div>

                                        </div>
                                    </div> -->
                                        <div class="tab-pane active" id="tab_2">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <h4>Credenciales </h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <h4>Datos del Comprobante </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label style="color: #676363;">Ruc: </label>
                                                    <div class="form-group">
                                                        <input id="txtRuc" class="form-control" type="text" placeholder="Ingrese su RUC">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label style="color: #676363;">Ruc Emisor: </label>
                                                    <div class="form-group">
                                                        <input id="txtRucEmision" class="form-control" type="text" placeholder="Ingrese RUC">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label style="color: #676363;">usuario: </label>
                                                    <div class="form-group">
                                                        <input id="txtUsuario" class="form-control" type="text" placeholder="Ingrese su Usuario">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label style="color: #676363;">Tipo: </label>
                                                    <div class="form-group">
                                                        <!-- <input id="txtTipo" class="form-control" type="text" placeholder="Ingrese Codigo de documento (factura: 01 / boleta: 03 / etc)"> -->
                                                        <select id="txtTipo" class="form-control">
                                                            <option value=""> -- Seleccione -- </option>
                                                            <option value="01">01 - Factura</option>
                                                            <option value="03">03 - Boleta De Venta</option>
                                                            <option value="07">07 - Nota de Crédito</option>
                                                            <option value="08">08 - Nota de Débito</option>
                                                            <option value="R1">R1 - Recibo por Honorarios</option>
                                                            <option value="R7">R7 - Nota Crédito Recibo por Honorarios </option>
                                                            <option value="04">04 - Liquidación de Compra</option>
                                                            <option value="23">23 - Póliza de Adjudicación Electrónica</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label style="color: #676363;">Contraseña: </label>
                                                    <div class="form-group">
                                                        <input id="txtClave" class="form-control" type="password" placeholder="Ingrese Contraseña">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label style="color: #676363;">Serie: </label>
                                                    <div class="form-group">
                                                        <input id="txtSerie" class="form-control" type="text" placeholder="F001 / B001 / etc" maxlength="4">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">

                                                </div>
                                                <div class="col-md-6">
                                                    <label style="color: #676363;">Correlativo: </label>
                                                    <div class="form-group">
                                                        <input id="txtCorrelativo" class="form-control" type="number" placeholder="ingrese correlativo (1,2,3...)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button class="btn btn-success" id="consultarEstado"> Consultar Estado </button>
                                                        <button class="btn btn-primary" id="consultarCdr"> Consultar CDR </button>
                                                        <button class="btn btn-danger" id="limpiarConsulta"> Limpiar </button>
                                                    </div>
                                                </div class="col-md-6">
                                                <div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="box box-primary" style="border-radius: 5px;">
                                        <div class="box-header">
                                            <h3 class="box-title">RESULTADO</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div style="font-size: 15px;">
                                                        Codigo : <span id="lblCodigoRpt"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div style="font-size: 15px;">
                                                        Mensaje : <span id="lblMensajeRpt"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div style="font-size: 15px;">
                                                        Ruta de descarga : <span id="lblRutaDescarga"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

                $(document).ready(function() {
                    loadInitConsultaAvanzada();

                    $("#consultarEstado").click(function() {
                        validateFields("");
                    });

                    $("#consultarEstado").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            validateFields("");
                        }
                    });

                    $("#limpiarConsulta").click(function() {
                        limpiarResponse();
                    });

                    $("#limpiarConsulta").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            limpiarResponse();
                        }
                    });

                    $("#consultarCdr").click(function() {
                        validateFields("cdr");
                    });

                    $("#consultarCdr").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            validateFields("cdr");
                        }
                    });

                });

                function loadInitConsultaAvanzada() {
                    $.ajax({
                        url: "../app/controller/ConfigEmpresaController.php",
                        method: "GET",
                        data: {},
                        beforeSend: function() {

                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                $("#txtRuc").val(result.result.NumeroDocumento);
                                $("#txtUsuario").val(result.result.UsuarioSol);
                                $("#txtClave").val(result.result.ClaveSol);
                                $("#txtRucEmision").val(result.result.NumeroDocumento);
                            }
                        },
                        error: function(error) {

                        }
                    });
                }

                function validateFields(cdr) {
                    if ($("#txtRuc").val() == '' || $("#txtRuc").val().length != 11) {
                        tools.AlertWarning("Advertencia", "ingrese un RUC válido.");
                        $("#txtRuc").focus();
                    } else if ($("#txtUsuario").val() == '' || $("#txtUsuario").val().length == 0) {
                        tools.AlertWarning("Advertencia", "El campo usuario es requerido.");
                        $("#txtUsuario").focus();
                    } else if ($("#txtClave").val() == '' || $("#txtClave").val().length == 0) {
                        tools.AlertWarning("Advertencia", "El campo contraseña es requerido.");
                        $("#txtClave").focus();
                    } else if ($("#txtRucEmision").val() == '' || $("#txtRucEmision").val().length != 11) {
                        tools.AlertWarning("Advertencia", "Ingrese un RUC de Emision Válido.");
                        $("#txtRucEmision").focus();
                    } else if ($("#txtTipo").val() == '') {
                        tools.AlertWarning("Advertencia", "Seleccione tipo de documento.");
                        $("#txtTipo").focus();
                    } else if ($('#txtSerie').val() == '' || $("#txtSerie").val().length == 0) {
                        tools.AlertWarning("Advertencia", "Ingrese una serie correcta.");
                        $("#txtSerie").focus();
                    } else if ($('#txtCorrelativo').val() == '' || $("#txtCorrelativo").val().length == 0) {
                        tools.AlertWarning("Advertencia", "Ingrese un correlativo.");
                        $("#txtCorrelativo").focus();
                    } else {
                        consultarCdr(cdr);
                    }
                }

                function consultarCdr(cdr) {
                    $.ajax({
                        url: "../app/examples/pages/cdrStatus.php",
                        method: "GET",
                        data: {
                            rucSol: $("#txtRuc").val(),
                            userSol: $("#txtUsuario").val(),
                            passSol: $("#txtClave").val(),
                            ruc: $("#txtRucEmision").val(),
                            tipo: $("#txtTipo").val(),
                            serie: $('#txtSerie').val().toUpperCase(),
                            numero: $('#txtCorrelativo').val(),
                            cdr: cdr
                        },
                        beforeSend: function() {
                            $("#ReduxComponent").empty();
                            tools.ModalAlertInfo("Consultar Datos", "Procesando petición..");
                        },
                        success: function(result) {
                            if (result.state == true) {
                                if (result.accepted == true) {
                                    tools.ModalAlertSuccess("Consultar Comprobante", "Resultado: Código " + result.code + " " + result.message);
                                    if (cdr != "") {
                                        $("#lblRutaDescarga").append('<a onclick="descargarCdr(\'' + result.file + '\')"" style="cursor:pointer">' + result.file + '</a>');
                                    }
                                } else {
                                    tools.ModalAlertWarning("Consultar Comprobante", "Resultado: Código " + result.code + " " + result.message);
                                }
                            } else {
                                tools.ModalAlertWarning("Consultar Comprobante", "Resultado: Código " + result.code + " " + result.message);
                            }
                            $("#lblCodigoRpt").html(result.code);
                            $("#lblMensajeRpt").html(result.message);

                        },
                        error: function(error) {
                            tools.ModalAlertError("Consultar Datos", error.responseText);
                        }
                    });
                }

                function limpiarResponse() {
                    $("#txtTipo").val('');
                    $('#txtSerie').val('');
                    $('#txtCorrelativo').val('');
                    $("#lblCodigoRpt").html('');
                    $("#lblMensajeRpt").html('');
                    $("#lblRutaDescarga").empty();
                }

                function descargarCdr(ruta) {
                    let ruta_completa = "../app/files/" + ruta;
                    window.open(ruta_completa, 'Download');
                }
            </script>
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
