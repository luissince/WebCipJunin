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
            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <section class="content-header">
                    <h3 class="no-margin">Nueva Nota de Débito <small> Documento </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-success">
                                    <i class="fa fa-save"></i>
                                    Registrar
                                </button>
                                <button type="button" class="btn btn-danger" id="cancelarNotaCredito">
                                    <i class="fa fa-trash-o"></i>
                                    Limpiar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Documento Nota de débito <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <select class="form-control" style="width: 100%;">
                                    <option value="0"> - seleccione - </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Moneda <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <select class="form-control" style="width: 100%;">
                                    <option value="0"> - seleccione - </option>
                                    <option value="1"> Soles S/. </option>
                                    <option value="2"> Dolares USD </option>

                                </select>
                            </div>
                        </div>
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
                                <select class="form-control" style="width: 100%;">
                                    <option value="0"> - seleccione - </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Serie y numero del comprobante</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="B001-1  F001-1  bb002-1" style="height: 35px;" disabled>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat" style="height: 35px;"><i class="fa fa-search"></i> Buscar </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Motivo <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <select class="form-control" style="width: 100%;">
                                    <option value="0"> - seleccione - </option>
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
                                <select class="form-control" style="width: 100%;">
                                    <option value="0"> - seleccione - </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>N° de documento</label>
                            <input type="text" class="form-control" placeholder="N° Dni, Ruc etc" disabled>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Nombre / razón social</label>
                            <div class="form-group">
                                <input type="text" class="form-control" disabled placeholder="N° Dni, Ruc etc">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Dirección <i class="text-danger fa fa-info-circle"></i></label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Dirección de vivienda">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Celular</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="N° de celular o teleléno">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label>Correo Electrónico</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Ingrese su correo electrónico">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 top-padding">
                            <div class="table-responsive">
                                <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                    <thead style="background-color: #FDB2B1;color: #B72928;">
                                        <th style="width:5%;">#</th>
                                        <th style="width:15%;">Opciones</th>
                                        <th style="width:20%;">Detalle</th>
                                        <th style="width:15%;">unidad</th>
                                        <th style="width:15%;">Cantidad</th>
                                        <th style="width:15%;">Precio Unitario</th>
                                        <th style="width:15%;">Importe</th>
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
                                <input type="text" style="width: 100%; height: 9em; border-radius: 7px solid black;">
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-md-10 col-sm-12 col-xs-12">
                                        <label>Importe Bruto: </label>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <label>0.00 </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-sm-12 col-xs-12">
                                        <label>Descuento: </label>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <label>0.00 </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-sm-12 col-xs-12">
                                        <label>Sub Importe: </label>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <label>0.00 </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-sm-12 col-xs-12">
                                        <label>Impuest (%): </label>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <label>0.00 </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-sm-12 col-xs-12">
                                        <label>Importe Neto: </label>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <label>0.00 </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <?php include('./layout/footer.php') ?>

        </div>
        <script src="js/tools.js"></script>
        <script>
            let tools = new Tools();

            $(document).ready(function() {
                $("#fechaRegistro").val(tools.getCurrentDate());

                $("#fechaFinal").val(tools.getCurrentDate());

                // $("#btnExcel").click(function() {
                //     if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                //         if (!state) {
                //             openExcel($("#fechaInicio").val(), $("#fechaFinal").val());
                //         }
                //     }
                // });
            });
            $("#contacto").append('<option> - seleccione un contacto -</option>')

            $("#btnExcel").click(function() {
                $("#mdAlert").modal("show")
            });
        </script>
    </body>

    </html>
<?php }
