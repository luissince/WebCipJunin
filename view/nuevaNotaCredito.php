<?php
session_start();
// $title_page = "Nota de débito";
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
            <div class="content-wrapper pre-scrollable" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <div class="box" style="border: none;">
                    <section class="content-header">
                        <h3 class="no-margin">Nueva Nota de Crédito <small> Documento </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="registrarNotaCredito">
                                        <i class="fa fa-save"></i>
                                        Registrar
                                    </button>
                                    <button type="button" class="btn btn-danger" id="limpiarNotaCredito">
                                        <i class="fa fa-trash-o"></i>
                                        Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Documento Nota de crédito <i class="text-danger fa fa-info-circle"></i></label>
                                <div class="form-group">
                                    <select class="form-control" style="width: 100%;" id="selectNotaCredito">
                                        <option value="0"> - seleccione - </option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Moneda <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <select class="form-control" style="width: 100%;">
                                    <option value="0"> - seleccione - </option>
                                    <option value="1"> Soles S/. </option>
                                    <option value="2"> Dolares USD </option>

                                </select>
                            </div>
                            </div> -->
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Fecha de Registro</label>
                                <input type="date" class="form-control pull-right" id="fechaRegistro">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h4>Documento a modificar </h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Tipo de comprobante <i class="text-danger fa fa-info-circle"></i></label>
                                <div class="form-group">
                                    <select class="form-control" style="width: 100%;" id="tipoComprobante">
                                        <option value=""> - seleccione - </option>
                                        <option value="03"> Boleta </option>
                                        <option value="01"> Factura </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Serie y numero del comprobante <i class="text-danger fa fa-info-circle"></i></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="B001-1  F001-1  bb002-1" style="height: 35px; border-radius: 0px;" id="documentoABuscar" onkeypress="pulsar(event)">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-info btn-flat" style="height: 35px; border-radius: 0px;" id="btnBuscarDocumento"><i class="fa fa-search"></i> Buscar </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Motivo <i class="text-danger fa fa-info-circle"></i></label>
                                <div class="form-group">
                                    <select class="form-control" style="width: 100%;" id="motivoNotaCredito">
                                        <option value=""> - seleccione - </option>
                                        <option value="1"> Anulación de la operación</option>
                                        <option value="2"> Anulación por error en el ruc </option>
                                        <option value="3"> Corrección por error en la descripción </option>
                                        <option value="4"> Descuento global </option>
                                        <option value="5"> Descuento por ítem </option>
                                        <option value="6"> Devolución total </option>
                                        <option value="7"> Devolución por ítem </option>
                                        <option value="8"> Bonificación </option>
                                        <option value="9"> Disminución en el valor </option>
                                        <option value="10"> Otros Conceptos </option>
                                        <option value="11"> Ajustes de operaciones de exportación </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Tipo documento identidad <i class="text-danger fa fa-info-circle"></i></label>
                                <div class="form-group">
                                    <select class="form-control" style="width: 100%;" id="tipoDocumentoIdentidad">
                                        <option value=""> - seleccione - </option>
                                        <option value="1"> DNI </option>
                                        <option value="6"> RUC </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>N° de documento <i class="text-danger fa fa-info-circle"></i></label>
                                <input type="number" class="form-control" placeholder="N° Dni, Ruc etc" id="numeroDocumento">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Nombre / razón social <i class="text-danger fa fa-info-circle"></i></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Ingrese nombre o razón social" id="txtNombres">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Dirección </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Dirección de vivienda" id="txtDireccion">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Celular</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="N° de celular o teleléno" id="txtTelefono">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Correo Electrónico</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Ingrese su correo electrónico" id="txtCorreo">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 top-padding">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1;color: #B72928;">
                                            <th style="width:6%;">#</th>
                                            <!-- <th style="width:20%;">Opciones</th> -->
                                            <th style="width:20%;">Detalle</th>
                                            <!-- <th style="width:15%;">unidad</th> -->
                                            <th style="width:18%;">Cantidad</th>
                                            <th style="width:18%;">Precio Unitario</th>
                                            <th style="width:18%;">Importe</th>
                                        </thead>
                                        <tbody id="tbTable">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <input type="text" style="width: 100%; height: 12em; border-radius: 7px solid black;" id="txtComentario" placeholder="&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;ingrese una descripción (opcional)">
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                            <label>Operaciones Gravadas: </label>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <label id="lblOpGravadas">00.00 </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                            <label>Operaciones Gratuitas: </label>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <label id="lblOpGratuitas">00.00 </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                            <label>Operaciones Exoneradas: </label>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <label id="lblOpExoneradas">00.00 </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                            <label>Operaciones Inafectas: </label>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <label id="lblOpInafectas">00.00 </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                            <label>Descuentos: </label>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <label id="lblDescuentos">00.00 </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                            <label>igv (18%): </label>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <label id="lblIgv">00.00 </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                            <label>Importe Total: </label>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <label id="lblTotal">00.00 </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div id="divLoad" style="justify-content: center; align-items: center; display: flex;">

                    </div>
                </div>
            </div>
            <!-- /.content-wrapper -->
            <!-- start footer -->
            <?php include('./layout/footer.php') ?>
            <!-- end footer -->
        </div>
        <script src="js/tools.js"></script>
        <script>
            let tools = new Tools();
            let tbTable = $("#tbTable");
            let idIngreso = 0;
            let arrayDetalle = [];

            $(document).ready(function() {
                clearComponents();

                $("#registrarNotaCredito").click(function() {
                    registrarNotaCredito();
                });

                $("#registrarNotaCredito").keypress(function(event) {
                    if (event.keyCode === 13) {
                        registrarNotaCredito();
                    }
                    event.preventDefault();
                });

                $("#limpiarNotaCredito").click(function() {
                    clearComponents();
                });

                $("#limpiarNotaCredito").keypress(function(event) {
                    if (event.keyCode === 13) {
                        clearComponents();
                    }
                    event.preventDefault();
                });

                loadNotasCredito();

                $("#fechaRegistro").val(tools.getCurrentDate());

                $("#fechaFinal").val(tools.getCurrentDate());

                $("#contacto").append('<option> - seleccione un contacto -</option>')

                $("#btnExcel").click(function() {
                    $("#mdAlert").modal("show")
                });



                $("#btnBuscarDocumento").click(function() {
                    loadDataComprobante();
                });

                $("#btnBuscarDocumento").keypress(function(event) {
                    if (event.keyCode === 13) {
                        loadDataComprobante();
                    }
                    event.preventDefault();
                });
            });

            function pulsar(e) {
                if (e.keyCode === 13) {
                    loadDataComprobante();
                }
            }

            function loadNotasCredito() {
                $.ajax({
                    url: "../app/controller/ComprobanteController.php",
                    method: "GET",
                    data: {
                        "type": "getNotasCredito"
                    },
                    beforeSend: function() {
                        $("#selectNotaCredito").empty();
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            $("#selectNotaCredito").append('<option value="">-  Seleccione  -</option>');
                            for (let notas of result.comprobantes) {
                                $("#selectNotaCredito").append('<option value="' + notas.IdTipoComprobante + '">' + notas.Nombre + '</option>');
                            }
                        } else {
                            $("#cbCliente").append('<option value="">- Seleccione -</option>');
                        }
                    },
                    error: function(error) {
                        $("#selectNotaCredito").append('<option value="">- Seleccione -</option>');
                    }
                });
            }

            function loadDataComprobante() {
                let documentoABuscar = $("#documentoABuscar").val();
                let serie = documentoABuscar.toUpperCase().split('-')[0];
                let correlativo =parseInt(documentoABuscar.split('-')[1]);

                if (serie.charAt(0) != 'B' && serie.charAt(0) != 'F') {
                    tools.AlertWarning('Serie', "Ingrese una serie de comprobante correcta");
                    $("#documentoABuscar").focus();
                } else {
                    if (serie.length != 4) {
                        tools.AlertWarning('Serie', "La serie debe tener 4 caracteres");
                        $("#documentoABuscar").focus();
                    } else {
                        if (!(correlativo >= 0)) {
                            tools.AlertWarning('Correlativo', "Ingrese un correlativo correcto");
                            $("#documentoABuscar").focus();
                        } else {
                            $.ajax({
                                url: "../app/controller/ListarIngresos.php",
                                method: "GET",
                                data: {
                                    "type": "dataComprobante",
                                    "serie": serie,
                                    "correlativo": correlativo
                                },
                                beforeSend: function() {
                                    $("#divLoad").addClass("overlay");
                                    $("#divLoad").append('<i class="fa fa-refresh fa-spin"></i>' + '<h4 class="text-bold pt-2" style="padding-top: 4em;">Cargando...</h4>');

                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        $("#divLoad").removeClass("overlay");
                                        $("#divLoad").empty();

                                        // clearComponents();
                                        tbTable.empty();

                                        idIngreso = result.data.idIngreso;

                                        $("#tipoComprobante").val(result.data.TipoComprobante)
                                        $("#tipoDocumentoIdentidad").val(result.data.TipoDocumento)
                                        $("#numeroDocumento").val(result.data.NumeroDocumento)
                                        $("#txtNombres").val(result.data.DatosPersona)
                                        $("#txtDireccion").val(result.data.Direccion)
                                        $("#txtTelefono").val(result.data.Telefono)
                                        $("#txtCorreo").val(result.data.Correo)

                                        arrayDetalle = result.detalle;

                                        for (let detalleComprobante of arrayDetalle) {

                                            tbTable.append('<tr>' +
                                                '<td style="text-align: center;color: #2270D1;">' + detalleComprobante.Id + '</td>' +
                                                '<td>' + detalleComprobante.Concepto + '</td>' +
                                                '<td>' + detalleComprobante.Cantidad + '</td>' +
                                                '<td>' + tools.formatMoney(detalleComprobante.Precio) + '</td>' +
                                                '<td>' + tools.formatMoney(detalleComprobante.Total) + '</td>' +
                                                '</tr>'
                                            );
                                        }
                                        console.log(arrayDetalle)

                                        $("#lblOpExoneradas").html(tools.formatMoney(result.totales.totalconimpuesto))
                                        $("#lblTotal").html(tools.formatMoney(result.totales.totalconimpuesto))

                                        tools.AlertSuccess("Información", "Se cargo correctamente los datos.")
                                    } else if (result.estado == 2) {                                       
                                        $("#divLoad").removeClass("overlay");
                                        $("#divLoad").empty();
                                        tbTable.empty();
                                        tools.AlertWarning("Información", result.mensaje);
                                    }

                                },
                                error: function(error) {
                                    $("#divLoad").removeClass("overlay");
                                    $("#divLoad").empty();
                                    tbTable.empty();
                                    tools.AlertWarning("Información", error);
                                }

                            });
                        }
                    }
                }
            }

            function registrarNotaCredito() {
                let documentoABuscar = $("#documentoABuscar").val();
                let serie = documentoABuscar.toUpperCase().split('-')[0];
                let correlativo = documentoABuscar.split('-')[1];

                if ($("#selectNotaCredito").val() == 0) {
                    tools.AlertWarning("Registrar", "seleccion un tipo de nota de crédito");
                    $("#selectNotaCredito").focus();
                } else if ($("#tipoComprobante").val() == 0) {
                    tools.AlertWarning("Registrar", "seleccion un tipo de comprobante");
                    $("#tipoComprobante").focus();
                } else if ($("#documentoABuscar").val() == "") {
                    tools.AlertWarning("Registrar", "Ingrese una serie y correlativo correcto");
                    $("#documentoABuscar").focus();
                } else if ($("#motivoNotaCredito").val() == 0) {
                    tools.AlertWarning("Registrar", "Ingrese un motivo para la nota de crédito");
                    $("#motivoNotaCredito").focus();
                } else if ($("#tipoDocumentoIdentidad").val() == 0) {
                    tools.AlertWarning("Registrar", "Seleccione un tipo de documento de identidad");
                    $("#motivoNotaCredito").focus();
                } else if ($("#numeroDocumento").val() == "") {
                    tools.AlertWarning("Registrar", "Ingrese un numero de documento válido");
                    $("#numeroDocumento").focus();
                } else if ($("#tipoDocumentoIdentidad").val() == 1 && $("#numeroDocumento").val().length != 8) {
                    tools.AlertWarning("Registrar", "El número de documento ingresado no coordina con el tipo de documento");
                    $("#tipoDocumentoIdentidad").focus();
                } else if ($("#tipoDocumentoIdentidad").val() == 6 && $("#numeroDocumento").val().length != 11) {
                    tools.AlertWarning("Registrar", "El número de documento ingresado no coordina con el tipo de documento");
                    $("#tipoDocumentoIdentidad").focus();
                } else if ($("#txtNombres").val() == "") {
                    tools.AlertWarning("Registrar", "El nombre/razón social no puede estar vacio");
                    $("#txtNombres").focus();
                } else {
                    $.ajax({
                        url: "../app/controller/AddNotaCreditoController.php",
                        method: "POST",
                        accepts: "application/json",
                        contentType: "application/json",
                        data: JSON.stringify({
                            "tipoNotaCredito": $("#selectNotaCredito").val(),
                            "fechaRegistro": $("#fechaRegistro").val(),
                            "tipoComprobante": $("#tipoComprobante").val(),
                            "serie": serie,
                            "correlativo": correlativo,
                            "motivoNotaCredito": $("#motivoNotaCredito").val(),
                            "tipoDocumentoIdentidad": $("#tipoDocumentoIdentidad").val(),
                            "numeroDocumentoIdentidad": $("#numeroDocumento").val(),
                            "nombreRazonSocial": $("#txtNombres").val(),
                            "direccion": $("#txtDireccion").val(),
                            "celular": $("#txtTelefono").val(),
                            "correo": $("#txtCorreo").val(),
                            "idIngreso": idIngreso,
                            "comentario": $("#txtComentario").val(),
                            "detalleComprobante": arrayDetalle
                        }),
                        beforeSend: function() {
                            clearComponents();
                            tools.ModalAlertInfo("Nota de Crédito", "Procesando petición..");
                        },
                        success: function(result) {
                            clearComponents();
                            if (result.estado === 1) {
                                tools.ModalAlertSuccess("Nota de Crédito", result.mensaje);
                                setTimeout(function() {
                                    location.href = "notaCredito.php"
                                }, 1000);
                            } else if (result.estado === 2) {
                                tools.ModalAlertWarning("Nota de Crédito", result.mensaje);
                            } else {
                                tools.ModalAlertWarning("Nota de Crédito", result.mensaje);
                            }
                        },
                        error: function(error) {
                            clearComponents();
                            tools.ModalAlertError("Nota de Crédito", "Se produjo un error: " + error.responseText);
                        }
                    });
                }
            }

            function clearComponents() {
                $("#selectNotaCredito").val('');
                $("#fechaRegistro").val(tools.getCurrentDate());
                $("#tipoComprobante").val('');
                $("#documentoABuscar").val('');
                $("#motivoNotaCredito").val('');
                $("#tipoDocumentoIdentidad").val('');
                $("#numeroDocumento").val('');
                $("#txtNombres").val('');
                $("#txtDireccion").val('');
                $("#txtTelefono").val('');
                $("#txtCorreo").val('');
                $("#txtComentario").val('');
                $("#lblOpExoneradas").html('00.00');
                $("#lblTotal").html('00.00');
                tbTable.empty();
                arrayDetalle = [];
            }
        </script>
    </body>

    </html>
<?php }
