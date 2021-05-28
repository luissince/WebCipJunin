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
                    <h3 class="no-margin"> Comprobantes Electrónicos <small> Consulta </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab">Consulta Básica</a></li>
                                    <li><a href="#tab_2" data-toggle="tab">Consulta avanzada</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
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
                                    </div>
                                    <div class="tab-pane" id="tab_2">
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
                                                    <input class="form-control" type="text" placeholder="Ingrese Usuario">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label style="color: #676363;">Ruc Emisor: </label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Ingrese RUC">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label style="color: #676363;">usuario: </label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Ingrese RUC">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label style="color: #676363;">Tipo: </label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Ingrese Codigo de documento (factura: 01 / boleta: 03 / etc)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label style="color: #676363;">Contraseña: </label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Ingrese Contraseña">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label style="color: #676363;">Serie: </label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="F001 / B001 / etc">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <label style="color: #676363;">Correlativo: </label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="ingrese correlativo (1,2,3...)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <button class="btn btn-success"> Consultar Estado </button>
                                                    <button class="btn btn-primary"> Consultar CDR </button>
                                                    <button class="btn btn-danger"> Limpiar </button>
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
            $(document).ready(function() {
                $("#codDocRecep").change(function() {
                    $("#numDocRecep").removeAttr("readonly");
                    console.log($("#codDocRecep").val())
                });

            });
        </script>
    </body>

    </html>
<?php }
