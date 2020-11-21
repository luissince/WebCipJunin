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
            <section class="content">

                <!-- modal start ingenieros -->
                <div class="row">
                    <div class="modal fade" id="mdIngenieros">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Lista de Ingenieros
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row" style="margin-bottom: 15px;">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <button class="btn btn-danger" id="btnIzquierda">
                                                <i class="fa fa-toggle-left"></i>
                                            </button>
                                            <span id="lblPaginaActual" class="font-weight-bold">0</span>
                                            <span>&nbsp;</span>
                                            <span>a</span>
                                            <span>&nbsp;</span>
                                            <span id="lblPaginaSiguiente" class="font-weight-bold">0</span>
                                            <button class="btn btn-danger" id="btnDerecha">
                                                <i class="fa fa-toggle-right"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="search" id="txtBuscarIngeniero" class="form-control" placeholder="Buscar por información, n° cip o dni" aria-describedby="search">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <button id="btnBuscarIngeniero" class="btn btn-default col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <i class="fa fa-search"></i> Buscar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" style="overflow-x: auto; height:280px">
                                        <div class="col-md-12">
                                            <table class="table table-striped table-hover table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Cip</th>
                                                        <th>Dni</th>
                                                        <th>Ingeniero</th>
                                                        <th>Condición</th>
                                                        <th>Ultima Cuota</th>
                                                        <th>Debe</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbIngenieros">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 text-left">
                                            <h5>
                                                <i class="fa fa-info text-danger"></i> <b class="text-success">Para seleccionar un ingeniero has doble click sobre la fila</b>
                                            </h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                <i class="fa fa-remove"></i> Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end ingenieros -->

                <!-- modal start colegiatura-->
                <div class="row">
                    <div class="modal fade" id="mdColegiatura">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-plus">
                                        </i> Pago de Colegiatura
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" class="no-padding">
                                        <div class="box box-solid">
                                            <div class="box-header no-padding">
                                                <div class="row">
                                                    <div class="col-md-8 text-left border">
                                                        <p>Concepto</p>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <p>Monto</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-body no-padding text-center" id="ctnConceptos">
                                            </div>
                                        </div>
                                        <div class="row no-padding">
                                            <div class="col-md-6 text-right">
                                                <div class="checkbox no-margin">
                                                    <label>
                                                        <input type="checkbox"> Dono libro
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 no-padding">
                                                <div class="col-md-6 text-right">
                                                    <span>Total:</span>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span id="lblTotalColegiatura">0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarColegiatura">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end colegiatura-->

                <!-- modal start cuotas -->
                <div class="row">
                    <div class="modal fade" id="mdCuotas" data-backdrop="static">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button id="btnCloseCuotas" type="button" class="close">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-plus">
                                        </i> Pago de Cuotas
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <button id="btnCuotaNormal" type="button" class="btn btn-success">
                                                <i class="fa fa-plus"></i> Ordinaria
                                            </button>
                                            <button id="btnCuotaAmnistia" type="button" class="btn btn-success">
                                                <i class="fa fa-plus"></i> Amnistia
                                            </button>
                                            <button id="btnCuotaVitalicio" type="button" class="btn btn-success">
                                                <i class="fa fa-plus"></i> Vitalicio
                                            </button>
                                        </div>
                                        <div class="col-md-5">
                                            <h4 class="text-info" id="lblCuotasMensaje">
                                                Cuotas Ordinarias
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="selectall" checked> Seleccionar todo
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button id="btnAddCuota" type="button" class="btn btn-danger">
                                                <i class="fa fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="width:100%; height: 35px;">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 73%;">Cuota del Mes</th>
                                                        <th>Monto</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" style="overflow-x: auto; height:260px">
                                        <div class="col-md-12">
                                            <table class="table table-striped table-hover">
                                                <tbody id="tbCuotas">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row no-padding border" style="background-color: #337ab7;color:white;">
                                        <div class="col-md-12 text-center">
                                            <h4 id="lblTotalCuotas" class="no-margin margin-5px">TOTAL DE CUOTAS: 0.00</h4>
                                            <h5 id="lblNumeroCuotas" class="no-margin margin-5px">CUOTAS DEL: 0/0000 al 00/0000</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarCuotas">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="btnCancelarCuotas">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end cuotas -->

                <!-- modal start certificado -->
                <div class="row">
                    <div class="modal fade" id="mdCertHabilidad">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-plus">
                                        </i> Certificado de Habilidad
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtIngenieroCertificado">Ingeniero(a)</label>
                                                <input type="text" class="form-control" id="txtIngenieroCertificado" placeholder="Datos completos del ingeniero">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Especialidad(es)</label>
                                                <select class="form-control" id="cbEspecialidadCertificado">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtFechaCertificado">Fecha</label>
                                                <input type="date" class="form-control" id="txtFechaCertificado">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtCorrelativoCertificado">Correlativo</label>
                                                <input type="text" class="form-control" id="txtCorrelativoCertificado" placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtAsuntoCertificado">Asunto</label>
                                                <input type="text" class="form-control" id="txtAsuntoCertificado" placeholder="Ingrese el asunto">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtEntidadCertificado">Entidad o Propietario</label>
                                                <input type="text" class="form-control" id="txtEntidadCertificado" placeholder="Ingrese la entidad o el propietario">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtLugarCertificado">Lugar</label>
                                                <input type="text" class="form-control" id="txtLugarCertificado" placeholder="Ingrese el lugar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarCertificado">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end certificado -->

                <!-- modal start certificado de proyecto -->
                <div class="row">
                    <div class="modal fade" id="mdCertProyecto">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-plus">
                                        </i> Certificado de Proyecto
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtIngenieroProyecto">Ingeniero(a)</label>
                                                <input type="text" class="form-control" id="txtIngenieroProyecto" placeholder="Datos completos del ingeniero">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Especialidad(es)</label>
                                                <select class="form-control" id="cbEspecialidadProyecto">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtFechaProyecto">Hábil Hasta</label>
                                                <input type="date" class="form-control" id="txtFechaProyecto">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtNumeroCertificadoProyecto">Certificado N°</label>
                                                <input type="text" class="form-control" id="txtNumeroCertificadoProyecto" placeholder="Número del certificado">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtModalidadProyecto">Modalidad</label>
                                                <input type="text" class="form-control" id="txtModalidadProyecto" placeholder="Ingrese la modalidad">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtPropietarioProyecto">Propietario</label>
                                                <input type="text" class="form-control" id="txtPropietarioProyecto" placeholder="Ingrese el propietario">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtProyectoProyecto">Proyecto</label>
                                                <input type="text" class="form-control" id="txtProyectoProyecto" placeholder="Ingrese el nombre del proyecto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtMontoContratoProyecto">Monto de Contrato</label>
                                                <input type="number" class="form-control" id="txtMontoContratoProyecto" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Departamento:</label>
                                                <select class="form-control" id="cbDepartamentoProyecto">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Provincia:</label>
                                                <select class="form-control" id="cbProvinciaProyecto">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Distrito:</label>
                                                <select class="form-control" id="cbDistritoProyecto">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtUrbProyecto">Urb./A.A.H.H./PP.JJ/Asoc</label>
                                                <input type="text" class="form-control" id="txtUrbProyecto" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtCalleProyecto">Jr./Av./Calle/Pasaje</label>
                                                <input type="text" class="form-control" id="txtCalleProyecto" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtMontoCobrarProyecto">Monto a Cobrar</label>
                                                <input type="number" class="form-control" id="txtMontoCobrarProyecto" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarProyecto">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end certificado de proyecto -->

                <!-- modal start certificado de residencia de obra -->
                <div class="row">
                    <div class="modal fade" id="mdCertResidenciaObra">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-plus">
                                        </i> Certificado de Residencia de Obra
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtIngenieroObra">Ingeniero(a)</label>
                                                <input type="text" class="form-control" id="txtIngenieroObra" placeholder="Datos completos del ingeniero">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Especialidad(es)</label>
                                                <select class="form-control" id="cbEspecialidadObra">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtFechaObra">Hábil Hasta</label>
                                                <input type="date" class="form-control" id="txtFechaObra">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtCertificadoNumeroObra">Certificado N°</label>
                                                <input type="text" class="form-control" id="txtCertificadoNumeroObra">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtModalidadObra">Modalidad</label>
                                                <input type="text" class="form-control" id="txtModalidadObra">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtProyectoObra">Proyecto</label>
                                                <input type="text" class="form-control" id="txtProyectoObra">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtPropietarioObra">Propietario</label>
                                                <input type="text" class="form-control" id="txtPropietarioObra">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtMontoContratoObra">Monto de Contrato:</label>
                                                <input type="number" class="form-control" id="txtMontoContratoObra">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Departamento:</label>
                                                <select class="form-control" id="cbDepartamentoObra">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Pronvincia:</label>
                                                <select class="form-control" id="cbProvinciaObra">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Distrito:</label>
                                                <select class="form-control" id="cbDistritoObra">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtMontoCobrarObra">Monto a Cobrar:</label>
                                                <input type="number" class="form-control" id="txtMontoCobrarObra">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarObra">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end certificado de residencia de obra-->

                <!-- modal start peritaje -->
                <div class="row">
                    <div class="modal fade" id="mdPeritaje" data-backdrop="static">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnClosePeritaje">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-plus">
                                        </i> Peritaje
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtDescripcionPeritaje">Descripción</label>
                                                <input type="text" class="form-control" id="txtDescripcionPeritaje" placeholder="Ingrese una descripción sobre el peritaje.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtMontoPeritaje">Monto</label>
                                                <input type="number" class="form-control" id="txtMontoPeritaje" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarPeritaje">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="btnCancelarPeritaje">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end peritaje -->

                <!-- modal start otros -->
                <div class="row">
                    <div class="modal fade" id="mdOtros" data-backdrop="static">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-plus">
                                        </i> Peritaje
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label id="lblConceptos">Conceptos </label>
                                                <select class="form-control" id="cbOtrosConcepto">
                                                    <option value="">- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input type="number" class="form-control" id="txtCantidadOtrosConceptos" placeholder="0.00" value="1" min="1">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtIngeniero">Monto</label>
                                                <input type="number" class="form-control" id="txtMontoOtrosConceptos" placeholder="0.00" required="" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarOtros">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end otros -->

                <!-- <div class="row"> -->
                <div class="row">

                    <div class="col-md-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h5 class="no-margin"> Generar cobro</h5>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-group" role="group">
                                            <button id="btnIngenieros" type="button" class="btn btn-primary" data-toggle="modal">
                                                <i class="fa fa-group"></i> Ingenieros
                                            </button>
                                            <button id="btnColegitura" type="button" class="btn btn-default" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Colegiatura
                                            </button>
                                            <button id="btnCuotas" type="button" class="btn btn-default" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Cuotas
                                            </button>
                                            <div class="btn-group" role="group">
                                                <button id="btnCertificado" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <i class="fa fa-plus"></i> Certificado <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    <li><button id="btnCertHabilidad" type="button" class="btn btn-default">Certificado de Habilidad</button></li>
                                                    <li><button id="btnCertProyecto" type="button" class="btn btn-default">Certificado de Proyecto</button></li>
                                                    <li><button id="btnCertResidenciaObra" type="button" class="btn btn-default">Certificado de Residencia de Obra</button></li>
                                                </ul>
                                            </div>
                                            <button id="btnPeritaje" type="button" class="btn btn-default" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Peritaje
                                            </button>
                                            <button id="btnOtro" type="button" class="btn btn-default" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Otros
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead style="background-color: #FDB2B1;color: #B72928;">
                                                <th width="5%">#</th>
                                                <th width="15%">Cantidad</th>
                                                <th width="35%">Concepto</th>
                                                <th width="15%">Precio</th>
                                                <th width="20%">Monto</th>
                                                <th width="10%">Quitar</th>
                                            </thead>
                                            <tbody id="tbIngresos">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h5 class="no-margin">Detalle del Cobro</h5>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="btnCobrar" class="btn btn-success btn-block">
                                            <div class="col-md-6 text-left">
                                                <h4>COBRAR</h4>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <h4 id="lblSumaTotal">0.00</h4>
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-left no-margin">
                                        <h5>Comprobante</h5>
                                        <select class="form-control" id="cbComprobante">

                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>N° Cip</h5>
                                                <h5 id="lblCipSeleccionado">--</h5>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Tipo</h5>
                                                <h5 id="lblTipoIngenieroSeleccionado">--</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-left">
                                        <h5>N° Documento</h5>
                                        <h5 id="lblDocumentSeleccionado">--</h5>
                                    </div>
                                    <div class="col-md-12 text-left">
                                        <h5>Nombres/Razón Social</h5>
                                        <h5 id="lblDatosSeleccionado">--</h5>
                                    </div>
                                    <div class="col-md-12 text-left">
                                        <h5>Dirección</h5>
                                        <h5 id="lblDireccionSeleccionado">--</h5>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
                <!-- </div> -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <script src="js/tools.js"></script>
    <script src="js/cobros/cobrosingenieros.js"></script>
    <script src="js/cobros/colegiatura.js"></script>
    <script src="js/cobros/cuotas.js"></script>
    <script src="js/cobros/certificados.js"></script>
    <script src="js/cobros/peritaje.js"></script>
    <script src="js/cobros/otros.js"></script>
    <script>
        let tools = new Tools();
        //cuotas
        let cuotas = [];
        let countCurrentDate = 0;
        let cuotasEstate = false;
        let cuotasInicio = "";
        let cuotasFin = "";

        //colegiatura
        let colegiaturas = [];
        let colegiaturaEstado = false;

        //ingresos totales
        let arrayIngresos = [];
        let sumaTotal = 0;

        //paginacion ingenieros
        let state = false;
        let opcion = 0;
        let totalPaginacion = 0;
        let paginacion = 0;
        let filasPorPagina = 10;
        let idDNI = 0;
        let modelCobrosIngenieros = new CobroIngenieros();

        let modelColegiatura = new Colegiatura();

        let modelCuotas = new Cuotas();

        let modelCertificado = new Certificado();

        let modelPeritaje = new Peritaje();

        let modelOtros = new Otros();

        $(document).ready(function() {
            // comprobantes
            loadComprobantes();

            //ingenieros
            modelCobrosIngenieros.componentesIngenieros();

            //colegiatura
            modelColegiatura.componentesColegiatura(addIngresos,validateDuplicate);

            //coutas
            modelCuotas.componentesCuotas();

            //certificado
            modelCertificado.componentesCertificado();

            //peritaje
            modelPeritaje.componentesPeritaje(addIngresos);

            //otros
            modelOtros.componentesOtros(addIngresos, validateDuplicate);

            //cobro
            componentesRegistrarIngreso();

        });

        function loadComprobantes() {
            $.ajax({
                url: "../app/controller/ComprobanteController.php",
                method: "GET",
                data: {},
                beforeSend: function() {
                    $("#cbComprobante").empty();
                },
                success: function(result) {
                    if (result.estado === 1) {
                        $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                        for (let value of result.data) {
                            $("#cbComprobante").append('<option value="' + value.IdTipoComprobante + '">' + value.Nombre + '</option>')
                        }
                    } else {
                        $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                    }
                },
                error: function(error) {
                    $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                }
            });
        }


        function componentesRegistrarIngreso() {
            $("#btnCobrar").click(function() {
                registrarIngreso();
            });

            $("#btnCobrar").keypress(function(event) {
                if (event.keyCode === 13) {
                    registrarIngreso();
                }
                event.preventDefault();
            });
        }

        function registrarIngreso() {
            if ($("#cbComprobante").val() == '') {
                tools.AlertWarning("Ingreso", "Seleccione un comprobante para continuar.");
            } else if (arrayIngresos.length == 0) {
                tools.AlertWarning("Ingreso", "No hay conceptos para continuar.");
            } else if (idDNI == 0) {
                tools.AlertWarning("Ingreso", "No selecciono ningún ingeneniero para continuar.");
            } else {
                alertify.confirm('Ingreso', '¿Está seguro de continuar?', function() {
                    $.ajax({
                        url: "../app/controller/IngresosController.php",
                        method: "POST",
                        accepts: "application/json",
                        contentType: "application/json",
                        data: JSON.stringify({
                            "idTipoDocumento": parseInt($("#cbComprobante").val()),
                            "idCliente": idDNI,
                            "idUsuario": 1,
                            "estado": 'C',
                            "estadoCuotas": cuotasEstate,
                            "estadoColegiatura": colegiaturaEstado,
                            "ingresos": arrayIngresos,
                            "cuotasInicio": cuotasInicio,
                            "cuotasFin": cuotasFin
                        }),
                        beforeSend: function() {
                            tools.AlertInfo("Ingreso", "Se está procesando el registro.");
                        },
                        success: function(result) {
                            if (result.estado === 1) {
                                cancelarIngreso();
                                tools.AlertSuccess("Ingreso", result.mensaje);
                            } else {
                                tools.AlertWarning("Ingreso", result.mensaje);
                            }
                        },
                        error: function(error) {
                            tools.AlertError("Ingreso", "Se produjo un error: " + error.responseText);
                        }
                    });
                }, function() {

                });
            }
        }

        function addIngresos() {
            $("#tbIngresos").empty();
            sumaTotal = 0;
            let arrayRenderTable = [];

            for (let value of arrayIngresos) {
                if (!arrayRenderTable.find(ar => ar.categoria == value.categoria && value.categoria == 1 ||
                        ar.categoria == value.categoria && value.categoria == 2 ||
                        ar.categoria == value.categoria && value.categoria == 3 ||
                        ar.categoria == value.categoria && value.categoria == 4)) {
                    arrayRenderTable.push({
                        "idConcepto": parseInt(value.idConcepto),
                        "categoria": value.categoria,
                        "cantidad": value.cantidad,
                        "concepto": value.categoria == 1 ? "Cuotas Ordinarias" : value.categoria == 4 ? "Colegiatura" : value.categoria == 2 ? "Cuotas de Administia" : value.categoria == 3 ? "Cuotas de Vitalicio" : value.concepto,
                        "precio": parseFloat(value.precio),
                        "monto": parseFloat(value.precio) * parseFloat(value.cantidad)
                    });
                } else {
                    for (let i = 0; i < arrayRenderTable.length; i++) {
                        if (arrayRenderTable[i].categoria == value.categoria) {
                            let newConcepto = arrayRenderTable[i];
                            newConcepto.idConcepto = parseInt(value.idConcepto);
                            newConcepto.categoria = parseInt(value.categoria);
                            newConcepto.cantidad = newConcepto.cantidad;
                            newConcepto.concepto = value.categoria == 1 ? "Cuotas Ordinarias" : value.categoria == 4 ? "Colegiatura" : value.categoria == 2 ? "Cuotas de Administia" : value.categoria == 3 ? "Cuotas de Vitalicio" : value.concepto;
                            newConcepto.precio += parseFloat(value.precio);
                            newConcepto.monto = newConcepto.precio * newConcepto.cantidad;
                            arrayRenderTable[i] = newConcepto;
                        }
                    }
                }
            }

            let count = 0;
            for (let value of arrayRenderTable) {
                count++;
                $("#tbIngresos").append('<tr>' +
                    '<td>' + count + '</td>' +
                    '<td>' + value.cantidad + '</td>' +
                    '<td>' + value.concepto + '</td>' +
                    '<td>' + tools.formatMoney(value.precio) + '</td>' +
                    '<td>' + tools.formatMoney(value.monto) + '</td>' +
                    '<td><button class="btn btn-warning" onClick="removeIngresos(\'' + value.idConcepto + '\',\'' + value.categoria + '\')"><i class="fa fa-trash"></i></button></td>' +
                    '</tr>');
                sumaTotal += parseFloat(value.monto);
            }

            $("#lblSumaTotal").html(tools.formatMoney(sumaTotal));
        }

        function removeIngresos(idConcepto, categoria) {
            for (let i = 0; i < arrayIngresos.length; i++) {
                if (arrayIngresos[i].categoria == 100) {
                    if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        break;
                    }
                } else if (arrayIngresos[i].categoria == 5) {
                    if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        break;
                    }
                } else if (arrayIngresos[i].categoria == 6) {
                    if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        break;
                    }
                } else if (arrayIngresos[i].categoria == 7) {
                    if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        break;
                    }
                } else if (arrayIngresos[i].categoria == 8) {
                    if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        break;
                    }
                } else {
                    if (arrayIngresos[i].categoria == categoria && categoria == 1) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        cuotasEstate = false;
                    } else if (arrayIngresos[i].categoria == categoria && categoria == 2) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        cuotasEstate = false;
                    } else if (arrayIngresos[i].categoria == categoria && categoria == 3) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        cuotasEstate = false;
                    } else if (arrayIngresos[i].categoria == categoria && categoria == 4) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        colegiaturaEstado = false;
                    }
                }
            }
            addIngresos();
        }

        function cancelarIngreso() {
            arrayIngresos.splice(0, arrayIngresos.length);
            addIngresos();
            $("#lblCipSeleccionado").html("--");
            $("#lblTipoIngenieroSeleccionado").html("--");
            $("#lblDocumentSeleccionado").html("--");
            $("#lblDatosSeleccionado").html("--");
            $("#lblDireccionSeleccionado").html("--");
            idDNI = 0;
            cuotasEstate = false;
            colegiaturaEstado = false;
        }

        function validateDuplicate(idConcepto) {
            let ret = false;
            for (let i = 0; i < arrayIngresos.length; i++) {
                if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                    ret = true;
                    break;
                }
            }
            return ret;
        }
        
    </script>
</body>

</html>