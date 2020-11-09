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
                                            <div class="box-body no-padding" id="ctnConceptos">
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
                                                    <span id="lblTotal">0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" name="btnAceptar" id="btnaceptar">
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
                                        <div class="col-md-8">
                                            <button id="btnCuotaNormal" type="button" class="btn btn-success">
                                                <i class="fa fa-plus"></i> Normal
                                            </button>
                                            <button id="btnCuotaAmnistia" type="button" class="btn btn-success">
                                                <i class="fa fa-plus"></i> Amnistia
                                            </button>
                                            <button id="btnCuotaVitalicio" type="button" class="btn btn-success">
                                                <i class="fa fa-plus"></i> Vitalicio
                                            </button>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="text-info" id="lblCuotasMensaje">
                                                Cuotas normales
                                            </h4>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="selectall" checked> Seleccionar todo
                                                </label>
                                            </div>
                                            <button id="btnAddCuota" type="button" class="btn btn-success">
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
                                    <div class="row" style="overflow-x: auto; height:280px">
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
                                            <h5 id="lblNumeroCuotas" class="no-margin margin-5px">CUOTAS DEL: 01/10/2020 al 10/10/2020</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" name="btnAceptar" id="btnaceptar">
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
                                                <label for="txtIngeniero">Ingeniero(a)</label>
                                                <input type="text" class="form-control" id="txtIngeniero" placeholder="Datos completos del ingeniero">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Especialidad(es)</label>
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtFecha">Fecha</label>
                                                <input type="date" class="form-control" id="txtFecha">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtCorrelativo">Correlativo</label>
                                                <input type="text" class="form-control" id="txtCorrelativo" placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtAsunto">Asunto</label>
                                                <input type="text" class="form-control" id="txtAsunto" placeholder="Ingrese el asunto">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtEntidad">Entidad o Propietario</label>
                                                <input type="text" class="form-control" id="txtEntidad" placeholder="Ingrese la entidad o el propietario">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtLugar">Lugar</label>
                                                <input type="text" class="form-control" id="txtLugar" placeholder="Ingrese el lugar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" name="btnAceptar" id="btnaceptar">
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
                                                <label for="txtIngeniero">Ingeniero(a)</label>
                                                <input type="text" class="form-control" id="txtIngeniero" placeholder="Datos completos del ingeniero">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Especialidad(es)</label>
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtFecha">Hábil Hasta</label>
                                                <input type="date" class="form-control" id="txtFecha">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtAsunto">Certificado N°</label>
                                                <input type="text" class="form-control" id="txtAsunto" placeholder="Número del certificado">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtAsunto">Modalidad</label>
                                                <input type="text" class="form-control" id="txtAsunto" placeholder="Ingrese la modalidad">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtAsunto">Propietario</label>
                                                <input type="text" class="form-control" id="txtAsunto" placeholder="Ingrese el propietario">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtAsunto">Proyecto</label>
                                                <input type="text" class="form-control" id="txtAsunto" placeholder="Ingrese el nombre del proyecto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtAsunto">Monto de Contrato</label>
                                                <input type="number" class="form-control" id="txtAsunto" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Departamento:</label>
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Provincia:</label>
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Distrito:</label>
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtAsunto">Urb./A.A.H.H./PP.JJ/Asoc</label>
                                                <input type="text" class="form-control" id="txtAsunto" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtAsunto">Jr./Av./Calle/Pasaje</label>
                                                <input type="text" class="form-control" id="txtAsunto" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtAsunto">Monto a Cobrar</label>
                                                <input type="number" class="form-control" id="txtAsunto" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" name="btnAceptar" id="btnaceptar">
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
                                                <label for="txtIngeniero">Ingeniero(a)</label>
                                                <input type="text" class="form-control" id="txtIngeniero" placeholder="Datos completos del ingeniero">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Especialidad(es)</label>
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtFecha">Hábil Hasta</label>
                                                <input type="date" class="form-control" id="txtFecha">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtFecha">Certificado N°</label>
                                                <input type="text" class="form-control" id="txtFecha">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtFecha">Modalidad</label>
                                                <input type="text" class="form-control" id="txtFecha">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtFecha">Proyecto</label>
                                                <input type="text" class="form-control" id="txtFecha">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtFecha">Propietario</label>
                                                <input type="text" class="form-control" id="txtFecha">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtFecha">Monto de Contrato:</label>
                                                <input type="number" class="form-control" id="txtFecha">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Departamento:</label>
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Pronvincia:</label>
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Distrito:</label>
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtFecha">Monto a Cobrar:</label>
                                                <input type="number" class="form-control" id="txtFecha">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" name="btnAceptar" id="btnaceptar">
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
                    <div class="modal fade" id="mdPeritaje">
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
                                                <label for="txtIngeniero">Descripción</label>
                                                <input type="text" class="form-control" id="txtIngeniero" placeholder="Ingrese la descripción">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtIngeniero">Monto</label>
                                                <input type="number" class="form-control" id="txtIngeniero" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" name="btnAceptar" id="btnaceptar">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
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
                    <div class="modal fade" id="mdOtros">
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
                                                <label>Concepto</label>
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
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <button class="btn btn-primary" id="btnIzquierda">
                                                <i class="fa fa-toggle-left"></i>
                                            </button>
                                            <span id="lblPaginaActual" class="font-weight-bold">0</span>
                                            <span>&nbsp;</span>
                                            <span>a</span>
                                            <span>&nbsp;</span>
                                            <span id="lblPaginaSiguiente" class="font-weight-bold">0</span>
                                            <button class="btn btn-primary" id="btnDerecha">
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
                                            <table class="table table-striped table-hover table-sm">
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
                                    <button type="button" class="btn btn-warning" id="btnAceptarIngenieros">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end ingenieros -->

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
                                                <th>#</th>
                                                <th>Cantidad</th>
                                                <th>Concepto</th>
                                                <th>Precio</th>
                                                <th>Monto</th>
                                                <th>Quitar</th>
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

                                <div class="row ">
                                    <div class="col-md-6 text-left no-margin">
                                        <h5>B001</h5>
                                    </div>

                                    <div class="col-md-6 text-right no-margin">
                                        <h5>0000000</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <h5>N° Cip</h5>
                                        <h5 id="lblCipSeleccionado">--</h5>
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
        <!-- start footer -->
        <?php include('./layout/footer.php'); ?>;
        <!-- end footer -->
    </div>
    <!-- ./wrapper -->
    <script src="js/tools.js"></script>
    <script>
        let tools = new Tools();
        let cuotas = [];
        let countCurrentDate = 0;
        let arrayIngresos = [];
        let sumaTotal = 0;

        //paginacion ingenieros
        let state = false;
        let opcion = 0;
        let totalPaginacion = 0;
        let paginacion = 0;
        let filasPorPagina = 10;
        let idDNI = 0;

        $(document).ready(function() {

            loadComprobantes();

            $("#btnColegitura").click(function() {
                $('#mdColegiatura').modal('show');
                loadColegiatura();
            });

            $("#btnColegitura").keypress(function(event) {
                if (event.keyCode === 13) {
                    $('#mdColegiatura').modal('show');
                    loadColegiatura();
                }
                event.preventDefault();
            });

            $("#btnCuotas").click(function() {
                $('#mdCuotas').modal('show');
                loadCuotas(1);
            });

            $("#btnCuotas").keypress(function() {
                if (event.keyCode === 13) {
                    $('#mdCuotas').modal('show');
                    loadCuotas(1);
                }
                event.preventDefault();
            });

            //Modal cuotas
            $("#btnCuotaNormal").click(function() {
                $("#lblCuotasMensaje").html("Cuotas Normales");
                loadCuotas(1);
            });

            $("#btnCuotaNormal").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#lblCuotasMensaje").html("Cuotas Normales");
                    loadCuotas(1);
                }
                event.preventDefault();
            });

            $("#btnCuotaAmnistia").click(function() {
                $("#lblCuotasMensaje").html("Cuotas de Amnistia");
                loadCuotas(2);
            });

            $("#btnCuotaAmnistia").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#lblCuotasMensaje").html("Cuotas de Amnistia");
                    loadCuotas(2);
                }
                event.preventDefault();
            });

            $("#btnCuotaVitalicio").click(function() {
                $("#lblCuotasMensaje").html("Cuotas de Vitalicio");
                loadCuotas(3);
            });

            $("#btnCuotaVitalicio").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#lblCuotasMensaje").html("Cuotas de Vitalicio");
                    loadCuotas(3);
                }
                event.preventDefault();
            });
            //Modal certificado
            $("#btnCertHabilidad").click(function() {
                $('#mdCertHabilidad').modal('show');
            });

            $("#btnCertHabilidad").keypress(function(event) {
                if (event.keyCode === 13) {
                    $('#mdCertHabilidad').modal('show');
                }
                event.preventDefault();
            });

            $("#btnCertProyecto").click(function() {
                $('#mdCertProyecto').modal('show');
            });

            $("#btnCertProyecto").keypress(function(event) {
                if (event.keyCode === 13) {
                    $('#mdCertProyecto').modal('show');
                }
                event.preventDefault();
            });

            $("#btnCertResidenciaObra").click(function() {
                $('#mdCertResidenciaObra').modal('show');
            });

            $("#btnCertResidenciaObra").keypress(function(event) {
                if (event.keyCode === 13) {
                    $('#mdCertResidenciaObra').modal('show');
                }
                event.preventDefault();
            });

            //Modal peritaje
            $("#btnPeritaje").click(function() {
                $('#mdPeritaje').modal('show');
            });

            $("#btnPeritaje").keypress(function(event) {
                if (event.keyCode === 13) {
                    $('#mdPeritaje').modal('show');
                }
                event.preventDefault();
            });

            //Modal otros
            $("#btnOtro").click(function() {
                $('#mdOtros').modal('show');
                loadOtros();
            });

            $("#btnOtro").keypress(function(event) {
                if (event.keyCode === 13) {
                    $('#mdOtros').modal('show');
                    loadOtros();
                }
                event.preventDefault();
            });

            //
            $("#selectall").on("click", function() {
                $(".cuotasid").attr("checked", this.checked);
            });

            $("#btnAddCuota").click(function() {
                cuotas.push({
                    "mes": "mi pene",
                    "monto": 20,
                    "year": "chucha"
                });
                addCuotas();
            });

            $("#btnAddCuota").keypress(function(event) {
                if (event.keyCode === 13) {
                    cuotas.push({
                        "mes": "mi pene",
                        "monto": 20,
                        "year": "chucha"
                    });
                    addCuotas();
                }
                event.preventDefault();
            });

            $("#btnCloseCuotas").click(function() {
                $('#mdCuotas').modal('hide');
                countCurrentDate = 0;
            });

            $("#btnCancelarCuotas").click(function() {
                $('#mdCuotas').modal('hide');
                countCurrentDate = 0;
            });

            //
            $("#btnAceptarOtros").click(function() {
                validateIngreso();
            });

            $("#btnAceptarOtros").keypress(function(event) {
                var keycode = event.keyCode || event.which;
                if (keycode == '13') {
                    validateIngreso();
                }
                event.preventDefault();
            });

            $("#cbOtrosConcepto").change(function(event) {
                $("#txtMontoOtrosConceptos").val($("#cbOtrosConcepto").find('option:selected').attr('id'))
            });

            //ingenieros
            //----------------------------------------
            $("#btnIngenieros").click(function(event) {
                $('#mdIngenieros').modal('show');
                loadInitIngenieros();
            });

            $("#btnIngenieros").keypress(function(event) {
                if (event.keyCode === 13) {
                    $('#mdIngenieros').modal('show');
                    loadInitIngenieros();
                }
                event.preventDefault();
            });

            $('#mdIngenieros').on('shown.bs.modal', function() {
                $('#txtBuscarIngeniero').focus();
            });

            $("#txtBuscarIngeniero").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    if (!state) {
                        paginacion = 1;
                        loadIngenieros($("#txtBuscarIngeniero").val());
                        opcion = 1;
                    }
                }
            });

            $("#btnIzquierda").click(function() {
                if (!state) {
                    if (paginacion > 1) {
                        paginacion--;
                        onEventPaginacion();
                    }
                }
            });

            $("#btnDerecha").click(function() {
                if (!state) {
                    if (paginacion < totalPaginacion) {
                        paginacion++;
                        onEventPaginacion();
                    }
                }
            });

            $("#btnAceptarIngenieros").click(function(event) {

            });

            $("#btnAceptarIngenieros").keypress(function(event) {
                if (event.keyCode === 13) {

                }
                event.preventDefault();
            });
            //----------------------------------------

            $("#btnCobrar").click(function() {
                if ($("#cbComprobante").val() == '') {
                    tools.AlertWarning("Ingreso", "Seleccione un comprobante para continuar.");
                } else if (arrayIngresos.length == 0) {
                    tools.AlertWarning("Ingreso", "No hay conceptos para continuar.");
                } else if (idDNI == 0) {
                    tools.AlertWarning("Ingreso", "No selecciono ningún ingeneniero para continuar.");
                } else {
                    alertify.confirm('Ingreso', '¿Está seguro de continuar?', function() {
                        registrarIngreso();
                    }, function() {

                    });
                }

            });

            $("#btnCobrar").keypress(function() {
                if ($("#cbComprobante").val() != '') {
                    registrarIngreso();
                } else {
                    tools.AlertWarning("", "Seleccione un comprobante para continuar.");
                }
                event.preventDefault();
            });

        });

        function validateIngreso() {
            if ($("#cbOtrosConcepto").val() != "") {
                if ($("#txtCantidadOtrosConceptos").val() !== "") {
                    if (!validateDuplicate($("#cbOtrosConcepto").val())) {
                        arrayIngresos.push({
                            "idConcepto": parseInt($("#cbOtrosConcepto").val()),
                            "num": (arrayIngresos.length + 1),
                            "cantidad": parseInt($('#txtCantidadOtrosConceptos').val()),
                            "concepto": $('#cbOtrosConcepto option:selected').html(),
                            "precio": parseFloat($("#cbOtrosConcepto").find('option:selected').attr('id')),
                            "monto": parseInt($("#txtCantidadOtrosConceptos").val()) * parseFloat($("#cbOtrosConcepto").find('option:selected').attr('id'))
                        });
                        addIngresos();
                        $('#mdOtros').modal('hide');
                        $("#txtCantidadOtrosConceptos").val("1");
                        $("#txtMontoOtrosConceptos").val("");
                    } else {
                        tools.AlertWarning("Ingresos Diversos", "Ya existe un concepto con los datos.")
                    }
                } else {
                    tools.AlertWarning("Ingresos Diversos", "Debe ingresar una cantidad mayor a cero")
                }
            } else {
                tools.AlertWarning("Ingresos Diversos", "Debe escoger un concepto")
            }
        }

        function loadColegiatura() {
            $.ajax({
                url: "../app/controller/ConceptoController.php",
                method: "GET",
                data: {
                    "type": "typecolegiatura",
                    "categoria": 4
                },
                beforeSend: function() {
                    $("#ctnConceptos").empty();
                },
                success: function(result) {
                    console.log(result)
                    if (result.estado === 1) {
                        let totalColegiatura = 0;
                        cuotas = result.data;
                        for (let value of result.data) {
                            $("#ctnConceptos").append('<div id="' + value.idConcepto + '" class="row">' +
                                '<div class="col-md-8 text-left">' +
                                '<p>' + value.Concepto + '</p>' +
                                '</div>' +
                                '<div class="col-md-4 text-right">' +
                                '<p>' + value.Precio + '</panel>' +
                                '</div>');
                            totalColegiatura += parseFloat(value.Precio);
                        }
                        $("#lblTotal").html(tools.formatMoney(totalColegiatura));
                    } else {

                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadCuotas(categoria) {
            $.ajax({
                url: "../app/controller/ConceptoController.php",
                method: "GET",
                data: {
                    "type": "typecolegiatura",
                    "categoria": categoria,
                    "dni": "20707246",
                    "mes": countCurrentDate
                },
                beforeSend: function() {
                    $("#tbCuotas").empty();
                    cuotas.splice(0, cuotas.length);

                },
                success: function(result) {
                    console.log(result)
                    if (result.estado === 1) {
                        cuotas = result.data;
                        let totalCuotas = 0;
                        for (let value of cuotas) {
                            $("#tbCuotas").append('<tr >' +
                                '<td class="no-padding"><div><label><input type="checkbox" class="cuotasid" checked> ' + value.mes + ' - ' + value.year + '</label></div></td>' +
                                '<td class="no-padding">' + tools.formatMoney(value.monto) + '</td>' +
                                +'</tr>');
                            totalCuotas += parseFloat(value.monto);
                        }
                        $("#lblTotalCuotas").html("TOTAL DE " + (result.data.length) + " CUOTAS: " + tools.formatMoney(totalCuotas));

                    } else {}
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadCertificado() {

        }

        function loadPeritaje() {

        }

        function loadOtros() {
            $.ajax({
                url: "../app/controller/ConceptoController.php",
                method: "GET",
                data: {
                    "type": "typecolegiatura",
                    "categoria": 100,
                    "dni": "20707246",
                },
                beforeSend: function() {
                    $("#cbOtrosConcepto").empty();
                },
                success: function(result) {
                    if (result.estado === 1) {
                        $("#cbOtrosConcepto").append(' <option id="" value="">- Seleccione -</option>');
                        for (let value of result.data) {
                            $("#cbOtrosConcepto").append('<option id="' + value.Precio + '" value="' + value.IdConcepto + '">' + value.Concepto + ' (' + value.Precio + ')</option>');
                        }
                    } else {

                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function onEventPaginacion() {
            switch (opcion) {
                case 0:
                    loadIngenieros("");
                    break;
                case 1:
                    loadIngenieros($("#txtBuscarIngeniero").val());
                    break;
            }
        }

        function loadInitIngenieros() {
            if (!state) {
                paginacion = 1;
                loadIngenieros("");
                opcion = 0;
            }
        }

        function loadIngenieros(search) {
            let tbIngenieros = $("#tbIngenieros");
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    "type": "listdata",
                    "search": search,
                    "posicionPagina": ((paginacion - 1) * filasPorPagina),
                    "filasPorPagina": filasPorPagina
                },
                beforeSend: function() {
                    tbIngenieros.empty();
                    tbIngenieros.append(
                        '<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                    );
                    state = true;
                },
                success: function(result) {
                    if (result.estado === 1) {
                        tbIngenieros.empty();
                        for (let value of result.personas) {
                            tbIngenieros.append('<tr ondblclick=onSelectedIngeniero(\'' + value.Dni + '\')>' +
                                '<td>' + value.Id + '</td>' +
                                '<td>' + value.Cip + '</td>' +
                                '<td>' + value.Dni + '</td>' +
                                '<td>' + value.Ingeniero + '</td>' +
                                '<td>' + value.Condicion + '</td>' +
                                '<td>' + value.FechaUltimaCuota + '</td>' +
                                '<td>' + (value.Deuda <= 0 ? '0 Cuotas' : value.Deuda + ' Cuota(s)') + '</td>' +
                                '</tr>');
                        }
                        totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                            filasPorPagina))));
                        $("#lblPaginaActual").html(paginacion);
                        $("#lblPaginaSiguiente").html(totalPaginacion);
                        state = false;
                    } else {
                        tbIngenieros.empty();
                        tbIngenieros.append(
                            '<tr class="text-center"><td colspan="8"><p>No se pudo cargar la información.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html("0");
                        $("#lblPaginaSiguiente").html("0");
                        state = false;
                    }
                },
                error: function(error) {
                    tbIngenieros.empty();
                    tbIngenieros.append(
                        '<tr class="text-center"><td colspan="8"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html("0");
                    $("#lblPaginaSiguiente").html("0");
                    state = false;
                }
            });
        }

        function onSelectedIngeniero(idIngeniero) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    "type": "data",
                    "dni": idIngeniero
                },
                beforeSend: function() {
                    $('#mdIngenieros').modal('hide');
                    tools.AlertInfo("Ingeniero", "En proceso de busqueda.");
                },
                success: function(data) {
                    if (data.estado === 1) {
                        idDNI = data.object.idDNI;
                        $("#lblCipSeleccionado").html(data.object.CIP);
                        $("#lblDocumentSeleccionado").html(data.object.idDNI);
                        $("#lblDatosSeleccionado").html(data.object.Apellidos + " " + data.object.Nombres);
                        $("#lblDireccionSeleccionado").html("");
                        tools.AlertSuccess("Ingeniero", "Los obtuvo los datos correctamente.");
                    } else {
                        $("#lblCipSeleccionado").html("--");
                        $("#lblDocumentSeleccionado").html("--");
                        $("#lblDatosSeleccionado").html("--");
                        $("#lblDireccionSeleccionado").html("--");
                        tools.AlertWarning("Ingeniero", "Se produjo un problema en obtener los datos, intente nuevamente.");
                    }
                },
                error: function(error) {
                    tools.AlertError("Ingeniero", "Error en obtener los datos, comuníquese con su proveedor o intente nuevamente.");
                }
            });
        }

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

        function addCuotas() {
            countCurrentDate++;
            loadCuotas(1);
        }

        function registrarIngreso() {
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
                    "ingresos": arrayIngresos
                }),
                beforeSend: function() {
                    $("#cbOtrosConcepto").empty();
                },
                success: function(result) {
                    if (result.estado === 1) {
                        arrayIngresos.splice(0, arrayIngresos.length);
                        addIngresos();
                        $("#lblCipSeleccionado").html("--");
                        $("#lblDocumentSeleccionado").html("--");
                        $("#lblDatosSeleccionado").html("--");
                        $("#lblDireccionSeleccionado").html("--");
                        idDNI = 0;
                        tools.AlertSuccess("Información", result.mensaje);
                    } else {
                        tools.AlertWarning("Mensaje", result.mensaje);
                    }
                },
                error: function(error) {
                    tools.AlertError("Error", error.responseText);
                }
            });
        }

        function addIngresos() {
            $("#tbIngresos").empty();
            sumaTotal = 0;
            for (let value of arrayIngresos) {
                $("#tbIngresos").append('<tr>' +
                    '<td>' + value.num + '</td>' +
                    '<td>' + value.cantidad + '</td>' +
                    '<td>' + value.concepto + '</td>' +
                    '<td>' + tools.formatMoney(value.precio) + '</td>' +
                    '<td>' + tools.formatMoney(value.monto) + '</td>' +
                    '<td><button class="btn btn-warning" onClick="removeIngresos(\'' + value.idConcepto + '\')"><i class="fa fa-trash"></i></button></td>' +
                    '</tr>');
                sumaTotal += parseFloat(value.monto);
            }
            $("#lblSumaTotal").html(tools.formatMoney(sumaTotal));
        }

        function removeIngresos(idConcepto) {
            for (let i = 0; i < arrayIngresos.length; i++) {
                if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                    arrayIngresos.splice(i, 1);
                    break;
                }
            }
            addIngresos();
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