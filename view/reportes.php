<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][15]["ver"] == 1) {
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

                <!-- Modal Resumen de ingresos -->
                <div class="row">
                    <div class="modal fade" id="linkListaIngresos">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-file-pdf-o"></i> Resumen de Ingresos Filtros
                                    </h4>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fi_ingresos">Fecha Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="fi_ingresos" type="date" name="fi_ingresos" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ff_ingresos">Fecha Fin: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="ff_ingresos" type="date" name="ff_ingresos" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger" name="btnAceptarIngresos" data-dismiss="modal" id="btnAceptarIngresos">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Resumen de Aportes del CIN -->
                <div class="row">
                    <div class="modal fade" id="linkListaResumenCIN">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-file-pdf-o"></i> Aportes del CIN Filtros
                                    </h4>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="optionsRadioAportes" id="brAportes" value="opcion1" checked="">
                                                        Todos los Registros
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="optionsRadioAportes" id="brAportesColegiado" value="opcion2">
                                                        Según el Colegiado
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <!-- <select class="form-control" id="cbIngeniero" disabled="">
                                                                </select> -->
                                                <select class="form-control select2" id="cbIngeniero" style="width: 100%;" disabled="">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fi_AportesCIN">Fecha Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="fi_AportesCIN" type="date" name="fi_AportesCIN" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ff_AportesCIN">Fecha Fin: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="ff_AportesCIN" type="date" name="ff_AportesCIN" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" id="btnGenerarExcelAportesCIN">
                                        <i class="fa fa-file-excel-o"></i> Excel</button>
                                    <button type="submit" class="btn btn-danger" name="btnAceptarAportesCIN" id="btnAceptarAportesCIN">
                                        <i class="fa fa-file-pdf-o"></i> Pdf</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Modal -->

                <!-- Modal Reportes de Comprobantes emitidos -->
                <div class="row">
                    <div class="modal fade" id="ComprobantesEmitidos">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" id="closeModalComprobantes">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-file-pdf-o"></i> Reporte de Comprobantes Emitidos
                                    </h4>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="optionsRadios" id="brComprobantes" value="opcion1" checked="">
                                                        Todos los comprobantes
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="optionsRadios" id="brTipoComprobantes" value="opcion2">
                                                        Según el tipo de documento
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" id="cbTipodeDocumento" disabled="">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control" id="cbTipodePago">
                                                    <option value="0">- Cualquier medio de pago -</option>
                                                    <option value="1"> Efectivo</option>
                                                    <option value="2"> Deposito</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fi_comprobantes">Fecha Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="fi_comprobantes" type="date" name="fi_comprobantes" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ff_comprobantes">Fecha Fin: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="ff_comprobantes" type="date" name="ff_ingresos" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success" id="btnGenerarExcel">
                                            <i class="fa fa-file-excel-o"></i> Excel</button>
                                        <button type="button" class="btn btn-danger" id="btnGenerarPdf">
                                            <i class="fa fa-file-pdf-o"></i> Pdf</button>
                                        <button type="button" class="btn btn-primary" id="btnCancelar">
                                            <i class="fa fa-remove"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Modal -->

                <!-- Modal Lista de Colegiados -->
                <div class="row">
                    <div class="modal fade" id="mdListadeColegiados">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" id="closeModalColegiado">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-file-pdf-o"></i> Reporte de Colegiados
                                    </h4>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="optionsColegiado" id="brColegiados" value="opcion1" checked="">
                                                        Todos los colegiados
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="optionsColegiado" id="brColegiadosFecha" value="opcion5">
                                                        Colegiados segun su fecha de registro
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Fecha de inicio.</label>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" id="finicioColegiado">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Fecha de fin.</label>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" id="ffinColegiado">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="optionsColegiado" id="brColegiados_Categoria" value="opcion2">
                                                        Según su Categoria
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <select id="cbCategoriaColegiado1" class="form-control" disabled="">
                                                    <option value="">- - Filtre por Categoria - -</option>
                                                    <option value="T">Transeunte</option>
                                                    <option value="O">Ordinario</option>
                                                    <option value="V">Vitalicio</option>
                                                    <option value="R">Retirado</option>
                                                    <option value="F">Fallecido</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsColegiado" id="brColegiados_Categoria_Fecha" value="opcion3">
                                                            Colegiados que cumplen(25 años, 30 años y 50 años)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" id="cbCategoriaColegiado2" disabled="">
                                                    <option value="">- - Filtre el año - -</option>
                                                    <option value="1">25 Años</option>
                                                    <option value="2">30 Años</option>
                                                    <option value="3">50 Años</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="fi_colegiado">Fecha de Busqueda: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <select class="form-control" id="fi_colegiado">
                                                                <option value="">- - Seleccione el Año - -</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="optionsColegiado" id="brColegiados_Resolucion" value="opcion4">
                                                        Colegiados afiliados ala resolución n° 15
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success" id="btnGenerarExcelColegiado">
                                            <i class="fa fa-file-excel-o"></i> Excel</button>
                                        <button type="button" class="btn btn-danger" id="btnGenerarPdfColegiado">
                                            <i class="fa fa-file-pdf-o"></i> Pdf</button>
                                        <button type="button" class="btn btn-primary" id="btnCancelarColegiado">
                                            <i class="fa fa-remove"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Modal -->

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content">

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> <i class="fa fa-user"></i> Reportes</div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <div class="row">

                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="" data-toggle="modal" data-target="#linkListaIngresos">
                                                            <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                                <div class="panel-body" style="text-align: center;">
                                                                    <img src="images/portapapeles.png" alt="Vender" width="87">
                                                                    <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                        Resumen de Ingresos
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="" data-toggle="modal" data-target="#mdListadeColegiados">
                                                            <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                                <div class="panel-body" style="text-align: center;">
                                                                    <img src="images/informe-medico.png" alt="Vender" width="87">
                                                                    <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                        Lista de Colegiados
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="" data-toggle="modal" data-target="#linkListaResumenCIN">
                                                            <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                                <div class="panel-body" style="text-align: center;">
                                                                    <img src="images/sitio-web.png" alt="Vender" width="87">
                                                                    <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                        Resumen de Aportes al CIN
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="" id="linkListaGlobal">
                                                            <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                                <div class="panel-body" style="text-align: center;">
                                                                    <img src="images/reportglobal.png" alt="Vender" width="87">
                                                                    <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                        Reporte Global
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="" data-toggle="modal" data-target="#ComprobantesEmitidos">
                                                            <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                                <div class="panel-body" style="text-align: center;">
                                                                    <img src="images/ReporteComprobantes.png" alt="Vender" width="87">
                                                                    <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                        Reporte de Comprobantes Emitidos
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
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
            <script src="./js/tools.js"></script>
            <script>
                let tools = new Tools();

                $(document).ready(function() {

                    tipoDeDocumento();

                    //close Modal Colegiado
                    $("#closeModalColegiado").click(function() {
                        cleanModalColegiado();
                    });

                    //close Modal Comprobantes
                    $("#closeModalComprobantes").click(function() {
                        cleanModalComprobantes();
                    });

                    //Reporte de colegiados
                    for (let i = 2000; i < 3500; i++) {
                        $("#fi_colegiado").append('<option value="' + (i + 1) + '">' + (i + 1) + '</option>');
                    }
                    $("#fi_colegiado").val(tools.getCurrentYear());
                    $("#fi_colegiado").prop('disabled', true)
                    $("#finicioColegiado").prop('disabled', true)
                    $("#ffinColegiado").prop('disabled', true)

                    //Resumen de ingresos
                    $("#fi_ingresos").val(tools.getCurrentDate())
                    $("#ff_ingresos").val(tools.getCurrentDate())

                    //Resumen de aportes del CIN
                    $("#fi_AportesCIN").val(tools.getCurrentDate())
                    $("#ff_AportesCIN").val(tools.getCurrentDate())

                    //Reporte de comprobante emitidos
                    $("#fi_comprobantes").val(tools.getCurrentDate())
                    $("#ff_comprobantes").val(tools.getCurrentDate())

                    $("#btnAceptarIngresos").click(function() {
                        let fechaInicial = $("#fi_ingresos").val();
                        let fechaFinal = $("#ff_ingresos").val();
                        if (fechaInicial != '' && fechaFinal != null) {
                            window.open("../app/sunat/resumeningresos.php?fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal, "_blank");
                        }
                    });

                    $("#linkListaGlobal").click(function() {
                        window.open("../app/sunat/resumenGlobal.php", "_blank");
                    });

                    //Radio Buttons Reporte de colegiados
                    $("#brColegiados").click(function() {
                        $("#cbCategoriaColegiado1").attr('disabled', true)
                        $("#cbCategoriaColegiado1").val('')
                        $("#cbCategoriaColegiado2").attr('disabled', true)
                        $("#cbCategoriaColegiado2").val('')
                        $("#fi_colegiado").prop('disabled', true)
                        $("#finicioColegiado").prop('disabled', true)
                        $("#ffinColegiado").prop('disabled', true)
                    });

                    $("#brColegiadosFecha").click(function() {
                        $("#finicioColegiado").prop('disabled', false)
                        $("#ffinColegiado").prop('disabled', false)
                        $("#cbCategoriaColegiado1").attr('disabled', true)
                        $("#cbCategoriaColegiado1").val('')
                        $("#cbCategoriaColegiado2").attr('disabled', true)
                        $("#cbCategoriaColegiado2").val('')
                        $("#fi_colegiado").prop('disabled', true)
                    });

                    $("#brColegiados_Categoria").click(function() {
                        $("#cbCategoriaColegiado1").removeAttr('disabled')
                        $("#cbCategoriaColegiado2").val('')
                        $("#cbCategoriaColegiado2").attr('disabled', true)
                        $("#fi_colegiado").prop('disabled', true)
                        $("#finicioColegiado").prop('disabled', true)
                        $("#ffinColegiado").prop('disabled', true)
                    });

                    $("#brColegiados_Categoria_Fecha").click(function() {
                        $("#cbCategoriaColegiado2").removeAttr('disabled')
                        $("#cbCategoriaColegiado1").val('')
                        $("#cbCategoriaColegiado1").attr('disabled', true)
                        $("#fi_colegiado").prop('disabled', false)
                        $("#finicioColegiado").prop('disabled', true)
                        $("#ffinColegiado").prop('disabled', true)
                    });

                    $("#brColegiados_Resolucion").click(function() {
                        $("#cbCategoriaColegiado1").attr('disabled', true)
                        $("#cbCategoriaColegiado2").attr('disabled', true)
                        $("#fi_colegiado").attr('disabled', true)
                        $("#finicioColegiado").prop('disabled', true)
                        $("#ffinColegiado").prop('disabled', true)
                    });

                    //Radio Buttons Reporte de comprobante emitidos
                    $("#brComprobantes").click(function() {
                        $("#cbTipodeDocumento").attr('disabled', '')
                    });

                    $("#brTipoComprobantes").click(function() {
                        $("#cbTipodeDocumento").removeAttr('disabled')
                    });

                    //Radio Buttons Aportes del CIN
                    $("#brAportes").click(function() {
                        $("#cbIngeniero").attr('disabled', '')
                    });

                    $("#brAportesColegiado").click(function() {
                        $("#cbIngeniero").removeAttr('disabled')
                    });


                    //Buttons Export Documents de Colegiados---------------------------------------------------------------------------------------
                    $("#btnAceptarAportesCIN").click(function() {
                        let tipo = $("#brAportes").is(":checked") ? 0 : 1;
                        let fechaInicial = $("#fi_AportesCIN").val();
                        let fechaFinal = $("#ff_AportesCIN").val();
                        let dni = $("#cbIngeniero").val();
                        if (tools.validateDate(fechaInicial) && tools.validateDate(fechaFinal)) {
                            if ($("#fi_AportesCIN").val() > $("#ff_AportesCIN").val()) {
                                tools.AlertWarning("Aportes", "La fecha inicial no puede ser mayor que la fecha final")
                                $("#fi_AportesCIN").focus();
                            } else {
                                window.open("../app/sunat/resumenaportecin.php?fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal + "&colegiado=" + dni + "&tipo=" + tipo, "_blank");
                            }
                        } else {
                            tools.AlertWarning("Aportes", "Ingrese un rango de fecha válido");
                            $("#fi_AportesCIN").focus();
                        }
                    });

                    $("#btnGenerarExcelAportesCIN").click(function() {
                        let tipo = $("#brAportes").is(":checked") ? 0 : 1;
                        let fechaInicial = $("#fi_AportesCIN").val();
                        let fechaFinal = $("#ff_AportesCIN").val();
                        let dni = $("#cbIngeniero").val();
                        if (tools.validateDate(fechaInicial) && tools.validateDate(fechaFinal)) {
                            if ($("#fi_AportesCIN").val() > $("#ff_AportesCIN").val()) {
                                tools.AlertWarning("Aportes", "La fecha inicial no puede ser mayor que la fecha final")
                                $("#fi_AportesCIN").focus();
                            } else {
                                window.open("../app/sunat/excelResumenAportenCIN.php?fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal + "&colegiado=" + dni + "&tipo=" + tipo, "_blank");
                            }
                        } else {
                            tools.AlertWarning("Aportes", "Ingrese un rango de fecha válido");
                            $("#fi_AportesCIN").focus();
                        }
                    });

                    //Buttons Export Documents de Colegiados---------------------------------------------------------------------------------------
                    $("#btnGenerarExcelColegiado").click(function() {
                        if ($("#brColegiados").is(':checked')) {
                            openExcelColegiado('', '', '', 1);
                        } else if ($("#brColegiadosFecha").is(':checked')) {
                            if (tools.validateDate($("#finicioColegiado").val()) && tools.validateDate($("#ffinColegiado").val())) {
                                if ($("#finicioColegiado").val() > $("#ffinColegiado").val()) {
                                    tools.AlertWarning("reportes", "La fecha inicial no puede ser mayor que la fecha final")
                                    $("#finicioColegiado").focus();
                                } else {
                                    openExcelColegiado('', $("#finicioColegiado").val(), $("#ffinColegiado").val(), 5);
                                }
                            }
                        } else if ($("#brColegiados_Categoria").is(':checked')) {
                            if ($("#cbCategoriaColegiado1").val() == '') {
                                tools.AlertWarning("reportes", "Seleccione una categoria")
                                $("#cbCategoriaColegiado1").focus();
                            } else {
                                openExcelColegiado($("#cbCategoriaColegiado1").val(), '', '', 2);
                            }
                        } else if ($("#brColegiados_Categoria_Fecha").is(':checked')) {
                            if ($("#cbCategoriaColegiado2").val() == '') {
                                tools.AlertWarning("Colegiados", "Seleccione el año a filtrar")
                                $("#cbCategoriaColegiado2").focus();
                            } else if ($("#fi_colegiado").val() == "") {
                                tools.AlertWarning("Colegiados", "Seleccione un año")
                                $("#fi_colegiado").focus();
                            } else {
                                openExcelColegiado($("#cbCategoriaColegiado2").val(), $("#fi_colegiado").val(), '', 3);
                            }
                        } else if ($("#brColegiados_Resolucion").is(':checked')) {
                            openExcelColegiado('', '', '', 4);
                        }
                    });

                    $("#btnGenerarPdfColegiado").click(function() {
                        if ($("#brColegiados").is(':checked')) {
                            openPDFColegiado('', '', '', 1);
                        } else if ($("#brColegiadosFecha").is(':checked')) {
                            if (tools.validateDate($("#finicioColegiado").val()) && tools.validateDate($("#ffinColegiado").val())) {
                                if ($("#finicioColegiado").val() > $("#ffinColegiado").val()) {
                                    tools.AlertWarning("reportes", "La fecha inicial no puede ser mayor que la fecha final")
                                    $("#finicioColegiado").focus();
                                } else {
                                    openPDFColegiado('', $("#finicioColegiado").val(), $("#ffinColegiado").val(), 5);
                                }
                            }
                        } else if ($("#brColegiados_Categoria").is(':checked')) {
                            if ($("#cbCategoriaColegiado1").val() == '') {
                                tools.AlertWarning("reportes", "Seleccione una categoria")
                                $("#cbCategoriaColegiado1").focus();
                            } else {
                                openPDFColegiado($("#cbCategoriaColegiado1").val(), '', '', 2);
                            }
                        } else if ($("#brColegiados_Categoria_Fecha").is(':checked')) {
                            if ($("#cbCategoriaColegiado2").val() == '') {
                                tools.AlertWarning("Colegiados", "Seleccione el año a filtrar")
                                $("#cbCategoriaColegiado2").focus();
                            } else if ($("#fi_colegiado").val() == "") {
                                tools.AlertWarning("Colegiados", "Seleccione un año")
                                $("#fi_colegiado").focus();
                            } else {
                                openPDFColegiado($("#cbCategoriaColegiado2").val(), $("#fi_colegiado").val(), '', 3);
                            }
                        } else if ($("#brColegiados_Resolucion").is(':checked')) {
                            openPDFColegiado('', '', '', 4);
                        }
                    });

                    //Buttons Export Document de comprobante emitidos---------------------------------------------------------------------------------------
                    $("#btnGenerarExcel").click(function() {
                        if (tools.validateDate($("#fi_comprobantes").val()) && tools.validateDate($("#ff_comprobantes").val())) {
                            if ($("#fi_comprobantes").val() > $("#ff_comprobantes").val()) {
                                tools.AlertWarning("reportes", "La fecha inicial no puede ser mayor que la fecha final")
                                $("#fi_comprobantes").focus();
                            } else {
                                openExcel($("#fi_comprobantes").val(), $("#ff_comprobantes").val(), $("#cbTipodeDocumento").val(), $("#cbTipodePago").val());
                            }
                        } else {
                            tools.AlertWarning("reportes", "Ingrese un rango de fecha válido")
                            $("#fi_comprobantes").focus();
                        }
                    });

                    $("#btnGenerarPdf").click(function() {
                        if (tools.validateDate($("#fi_comprobantes").val()) && tools.validateDate($("#ff_comprobantes").val())) {
                            if ($("#fi_comprobantes").val() > $("#ff_comprobantes").val()) {
                                tools.AlertWarning("reportes", "La fecha inicial no puede ser mayor que la fecha final")
                                $("#fi_comprobantes").focus();
                            } else {
                                openPdf($("#fi_comprobantes").val(), $("#ff_comprobantes").val(), $("#cbTipodeDocumento").val(), $("#cbTipodePago").val());
                            }
                        } else {
                            tools.AlertWarning("reportes", "Ingrese un rango de fecha válido")
                            $("#fi_comprobantes").focus();
                        }
                    });

                    //Cancel Resumen de Colegiados
                    $("#btnCancelarColegiado").click(function() {
                        cleanModalColegiado();
                        // $("#div_fechas").
                    });

                    //Cancel Resumen de Comprobantes Emitidos
                    $("#btnCancelar").click(function() {
                        cleanModalComprobantes();
                    });

                    $('#cbIngeniero').select2({
                        placeholder: "Buscar Ingeniero",

                        ajax: {
                            url: "../app/controller/ListarIngenierosController.php",
                            type: "GET",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    type: "alldata",
                                    search: params.term
                                };
                            },
                            processResults: function(response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true
                        }
                    });

                });

                function tipoDeDocumento() {
                    $.ajax({
                        url: "../app/controller/ComprobanteController.php",
                        method: "GET",
                        data: {
                            "type": "comprobante",
                            "destino": "all"
                        },
                        beforeSend: function() {
                            $("#cbTipodeDocumento").empty();
                            comprobantes = [];
                        },
                        success: function(result) {
                            if (result.estado === 1) {
                                comprobantes = result.data;
                                $("#cbTipodeDocumento").append('<option value="">- Seleccione -</option>');
                                for (let value of comprobantes) {
                                    $("#cbTipodeDocumento").append('<option value="' + value.IdTipoComprobante + '">' + value.Nombre + ' (' + value.Serie + ')</option>')
                                }
                            } else {
                                $("#cbTipodeDocumento").append('<option value="">- Seleccione -</option>');
                            }
                        },
                        error: function(error) {
                            $("#cbTipodeDocumento").append('<option value="">- Seleccione -</option>');
                        }
                    });
                }

                function openExcel(fechaInicio, fechaFinal, tipoDocumento, tipoPago) {
                    let nombreComprobante = $("#cbTipodeDocumento").find('option:selected').text().toLowerCase();
                    if ($("#brComprobantes").is(':checked')) {
                        window.open("../app/sunat/excelventa.php?txtFechaInicial=" + fechaInicio + "&txtFechaFinal=" + fechaFinal + "&cbTipoDocumento=" + "null" + "&cbTipoPago=" + tipoPago, "_blank");
                        cleanModalComprobantes();
                    } else {
                        if ($("#cbTipodeDocumento").val() == '') {
                            tools.AlertWarning("reportes", "Seleccione un tipo de documento")
                            $("#cbTipodeDocumento").focus();
                        } else {
                            window.open("../app/sunat/excelventa.php?txtFechaInicial=" + fechaInicio + "&txtFechaFinal=" + fechaFinal + "&cbTipoDocumento=" + tipoDocumento + "&nombreComprobante=" + nombreComprobante + "&cbTipoPago=" + tipoPago, "_blank");
                            cleanModalComprobantes();
                        }
                    }
                }

                function openPdf(fechaInicio, fechaFinal, tipoDocumento, tipoPago) {
                    let nombreComprobante = $("#cbTipodeDocumento").find('option:selected').text().toLowerCase();
                    if ($("#brComprobantes").is(':checked')) {
                        window.open("../app/sunat/resumenComprobantes.php?txtFechaInicial=" + fechaInicio + "&txtFechaFinal=" + fechaFinal + "&cbTipoDocumento=" + "null" + "&cbTipoPago=" + tipoPago, "_blank");
                    } else {
                        if ($("#cbTipodeDocumento").val() == '') {
                            tools.AlertWarning("reportes", "Seleccione un tipo de documento")
                            $("#cbTipodeDocumento").focus();
                        } else {
                            window.open("../app/sunat/resumenComprobantes.php?txtFechaInicial=" + fechaInicio + "&txtFechaFinal=" + fechaFinal + "&cbTipoDocumento=" + tipoDocumento + "&nombreComprobante=" + nombreComprobante + "&cbTipoPago=" + tipoPago, "_blank");
                        }
                    }
                }

                function openExcelColegiado(condicion, fiColegiado, ffColegiado, opcion) {
                    window.open("../app/sunat/excelResumenColegiados.php?condicion=" + condicion + "&fiColegiado=" + fiColegiado + "&ffColegiado=" + ffColegiado + "&opcion=" + opcion, "_blank");
                }

                function openPDFColegiado(condicion, fiColegiado, ffColegiado, opcion) {
                    window.open("../app/sunat/resumenColegiados.php?condicion=" + condicion + "&fiColegiado=" + fiColegiado + "&ffColegiado=" + ffColegiado + "&opcion=" + opcion, "_blank");
                }

                function cleanModalColegiado() {
                    $("#mdListadeColegiados").modal("hide");
                    $("#brColegiados").prop('checked', true)
                    $("#brColegiados_Categoria").prop('checked', false)
                    $("#brColegiados_Categoria_Fecha").prop('checked', false)
                    $("#cbCategoriaColegiado1").attr('disabled', '')
                    $("#cbCategoriaColegiado1").val('')
                    $("#cbCategoriaColegiado2").attr('disabled', '')
                    $("#cbCategoriaColegiado2").val('')
                    $("#fi_colegiado").val(tools.getCurrentYear());
                    $("#fi_colegiado").prop('disabled', true)
                }

                function cleanModalComprobantes() {
                    $("#ComprobantesEmitidos").modal("hide");
                    $("#brComprobantes").prop('checked', true);
                    $("#brTipoComprobantes").prop('checked', false);
                    $("#cbTipodeDocumento").attr('disabled', '');
                    $("#cbTipodeDocumento").val('');
                    $("#fi_comprobantes").val(tools.getCurrentDate());
                    $("#ff_comprobantes").val(tools.getCurrentDate());
                    $("#cbTipodePago").val('0');
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
