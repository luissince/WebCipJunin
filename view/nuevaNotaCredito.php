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
            <div class="content-wrapper">

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
                                <select class="form-control" id="cbNotaCredito">
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
                            <input type="date" class="form-control pull-right" id="txtFechaRegistro">
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
                                <select class="form-control" id="cbTipoComprobante" disabled>
                                    <option value=""> - seleccione - </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Serie y numero del comprobante <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="B001-1  F001-1  bb002-1" id="txtComprobante">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary" id="btnBuscar"> <i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Motivo <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <select class="form-control" id="cbMotivoNotaCredito">
                                    <option value=""> - seleccione - </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Tipo documento identidad <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <select class="form-control" id="cbTipoDocumentoIdentidad" disabled>
                                    <option value=""> - seleccione - </option>
                                    <option value="1"> DNI </option>
                                    <option value="6"> RUC </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>N° de documento <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="N° Dni, Ruc etc" id="txtNumeroDocumento" disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Nombre / razón social <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Ingrese nombre o razón social" id="txtNombres" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <label>Dirección <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Dirección del local o propiedad" id="txtDireccion" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 top-padding">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                    <thead style="background-color: #FDB2B1;color: #B72928;">
                                        <th width="5%;" class="text-center">#</th>
                                        <th width="30%;">Detalle</th>
                                        <th width="18%;">Cantidad</th>
                                        <th width="18%;">Precio Unitario</th>
                                        <th width="18%;">Afectación</th>
                                        <th width="18%;">Importe</th>
                                    </thead>
                                    <tbody id="tbTable">
                                        <tr>
                                            <td colspan="6" class="text-center">No hay datos para mostrar.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label>Op. Gravadas: </label>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label id="lblOpGravadas">S/ 00.00 </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label>Op. Gratuitas: </label>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label id="lblOpGratuitas">S/ 00.00 </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label>Op. Exoneradas: </label>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label id="lblOpExoneradas">S/ 00.00 </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label>Op. Inafectas: </label>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label id="lblOpInafectas">S/ 00.00 </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label>Descuentos: </label>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label id="lblDescuentos">S/ 00.00 </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label>igv (18%): </label>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label id="lblIgv">S/ 00.00 </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label>Importe Total: </label>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label id="lblTotal">S/ 00.00 </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

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
            let idPersona = 0;
            let arrayDetalle = [];

            $(document).ready(function() {

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

                $("#txtNumeroDocumento").keypress(function(event) {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b')) {
                        event.preventDefault();
                    }
                });

                $("#txtFechaRegistro").val(tools.getCurrentDate());

                $("#fechaFinal").val(tools.getCurrentDate());

                $("#contacto").append('<option> - seleccione un contacto -</option>');

                $("#btnBuscar").keypress(function(event) {
                    if (event.keyCode === 13) {
                        loadDataComprobante();
                    }
                    event.preventDefault();
                });

                $("#btnBuscar").click(function() {
                    loadDataComprobante();
                });

                $("#txtComprobante").keydown(function(event) {
                    if (event.keyCode === 13) {
                        loadDataComprobante();
                        event.preventDefault();
                    }
                });
            });

            function loadDataComprobante() {
                if ($("#txtComprobante").val().trim() == "") {
                    tools.AlertWarning('Nota de Crédito', "Ingrese la serie y numeración del comprobante.");
                    $("#txtComprobante").focus();
                } else {
                    $.ajax({
                        url: "../app/controller/IngresoController.php",
                        method: "GET",
                        data: {
                            "type": "dataComprobante",
                            "comprobante": $("#txtComprobante").val().trim()
                        },
                        beforeSend: function() {
                            tools.ModalAlertInfo("Nota de Crédito", "Procesando petición..");
                            $("#cbNotaCredito").empty();
                            $("#cbTipoComprobante").empty();
                            $("#cbMotivoNotaCredito").empty();
                            tbTable.empty();
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                let notasCreditos = result.notasCredito;
                                let facturados = result.facturados;
                                let motivos = result.motivo;
                                let ingreso = result.ingreso;
                                arrayDetalle = result.detalle;

                                idIngreso = ingreso.idIngreso;
                                idPersona = ingreso.IdPersona;

                                $("#cbNotaCredito").append('<option value=""> - seleccione - </option>');
                                for (let value of notasCreditos) {
                                    $("#cbNotaCredito").append('<option value="' + value.IdTipoComprobante + '">' + value.Nombre + '</option>');
                                }

                                $("#cbTipoComprobante").append('<option value=""> - seleccione - </option>');
                                for (let value of facturados) {
                                    $("#cbTipoComprobante").append('<option value="' + value.IdTipoComprobante + '">' + value.Nombre + '</option>');
                                }

                                $("#cbMotivoNotaCredito").append('<option value=""> - seleccione - </option>');
                                for (let value of motivos) {
                                    $("#cbMotivoNotaCredito").append('<option value="' + value.IdTablaMotivoAnulacion + '">' + value.Nombre + '</option>');
                                }

                                $("#cbTipoComprobante").val(result.ingreso.TipoComprobante);
                                $("#cbTipoDocumentoIdentidad").val(result.ingreso.TipoDocumento);
                                $("#txtNumeroDocumento").val(result.ingreso.NumeroDocumento);
                                $("#txtNombres").val(result.ingreso.DatosPersona);
                                $("#txtDireccion").val(result.ingreso.Direccion);

                                let count = 0;
                                let opegravada = 0;
                                let opeexogenerada = 0;
                                let totalsinimpuesto = 0;
                                let impuesto = 0;

                                for (let value of arrayDetalle) {
                                    count++;
                                    tbTable.append('<tr>' +
                                        '<td class="text-center">' + count + '</td>' +
                                        '<td>' + value.Concepto + '</td>' +
                                        '<td class="text-right">' + tools.formatMoney(value.Cantidad) + '</td>' +
                                        '<td class="text-right">' + tools.formatMoney(value.Precio) + '</td>' +
                                        '<td class="text-right">' + tools.formatMoney(value.Valor) + '%' + '</td>' +
                                        '<td class="text-right">' + tools.formatMoney(value.Total) + '</td>' +
                                        '</tr>');

                                    let cantidad = value.Cantidad;
                                    let valorImpuesto = value.Valor;
                                    let preciobruto = value.Precio / ((valorImpuesto / 100.00) + 1);

                                    opegravada += valorImpuesto == 0 ? 0 : cantidad * preciobruto;
                                    opeexogenerada += valorImpuesto == 0 ? cantidad * preciobruto : 0;

                                    totalsinimpuesto += cantidad * preciobruto;
                                    impuesto += cantidad * (preciobruto * (valorImpuesto / 100.00));


                                }
                                $("#lblOpGravadas").html("S/ " + tools.formatMoney(opegravada));
                                $("#lblOpExoneradas").html("S/ " + tools.formatMoney(opeexogenerada));
                                $("#lblIgv").html("S/ " + tools.formatMoney(impuesto));
                                $("#lblTotal").html("S/ " + tools.formatMoney(totalsinimpuesto + impuesto));

                                tools.ModalAlertSuccess("Nota de Crédito", "Se obtuvo correctamente los datos.");
                            } else {
                                tools.ModalAlertWarning("Nota de Crédito", result.message);
                            }
                        },
                        error: function(error) {
                            tools.ModalAlertError("Nota de Crédito", "Se produjo un error: " + error.responseText);
                        }

                    });
                }
            }

            function registrarNotaCredito() {
                if ($("#cbNotaCredito").val() == 0) {
                    tools.AlertWarning("Registrar", "seleccion un tipo de nota de crédito");
                    $("#cbNotaCredito").focus();
                } else if ($("#cbMotivoNotaCredito").val() == 0) {
                    tools.AlertWarning("Registrar", "Ingrese un motivo para la nota de crédito");
                    $("#cbMotivoNotaCredito").focus();
                } else {
                    tools.ModalDialog("Nota de Crédito", "¿Está seguro de continuar?", function(value) {
                        if (value == true) {
                            $.ajax({
                                url: "../app/controller/NotaCreditoController.php",
                                method: "POST",
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "type": "registro",
                                    "idIngreso": idIngreso,
                                    "idPersona": idPersona,
                                    "idTipoNotaCredito": $("#cbNotaCredito").val(),
                                    "fechaRegistro": $("#txtFechaRegistro").val(),
                                    "idMotivoNotaCredito": $("#cbMotivoNotaCredito").val(),
                                    "detalleComprobante": arrayDetalle
                                }),
                                beforeSend: function() {
                                    clearComponents();
                                    tools.ModalAlertInfo("Nota de Crédito", "Procesando petición..");
                                },
                                success: function(result) {
                                    if (result.estado === 1) {
                                        tools.ModalAlertSuccess("Nota de Crédito", result.message);
                                    } else {
                                        tools.ModalAlertWarning("Nota de Crédito", result.message);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Nota de Crédito", "Se produjo un error: " + error.responseText);
                                }
                            });
                        }
                    });
                }
            }

            function clearComponents() {
                $("#cbNotaCredito").val('');
                $("#txtFechaRegistro").val(tools.getCurrentDate());
                $("#cbTipoComprobante").val('');
                $("#txtComprobante").val('');
                $("#cbMotivoNotaCredito").val('');
                $("#cbTipoDocumentoIdentidad").val('');
                $("#txtNumeroDocumento").val('');
                $("#txtNombres").val('');
                $("#txtDireccion").val('');
                $("#lblOpGravadas").html('S/ 00.00');
                $("#lblOpGratuitas").html('S/ 00.00');
                $("#lblOpExoneradas").html('S/ 00.00');
                $("#lblOpInafectas").html('S/ 00.00');
                $("#lblDescuentos").html('S/ 00.00');
                $("#lblIgv").html('S/ 00.00');
                $("#lblTotal").html('S/ 00.00');
                tbTable.empty();
                arrayDetalle = [];
            }
        </script>
    </body>

    </html>
<?php }
