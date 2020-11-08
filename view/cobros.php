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
                                                <input type="number" class="form-control" id="txtCantidadOtrosConceptos" placeholder="0.00">
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
                                            <button id="btnColegitura" type="button" class="btn btn-primary" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Colegiatura
                                            </button>
                                            <button id="btnCuotas" type="button" class="btn btn-primary" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Cuotas
                                            </button>
                                            <div class="btn-group" role="group">
                                                <button id="btnCertificado" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <i class="fa fa-plus"></i> Certificado <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    <li><button id="btnCertHabilidad" type="button" class="btn btn-default">Certificado de Habilidad</button></li>
                                                    <li><button id="btnCertProyecto" type="button" class="btn btn-default">Certificado de Proyecto</button></li>
                                                    <li><button id="btnCertResidenciaObra" type="button" class="btn btn-default">Certificado de Residencia de Obra</button></li>
                                                </ul>
                                            </div>
                                            <button id="btnPeritaje" type="button" class="btn btn-primary" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Peritaje
                                            </button>
                                            <button id="btnOtro" type="button" class="btn btn-primary" data-toggle="modal">
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
                                                <th>Editar</th>
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
                                <h5 class="no-margin">Detalle del Ingreso</h5>
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
                                        <select class="form-control">
                                            <option value="03">Boleta</option>
                                            <option value="01">Factura</option>
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
                                        <h5>--</h5>
                                    </div>
                                    <div class="col-md-12 text-left">
                                        <h5>N° Documento</h5>
                                        <h5>--</h5>
                                    </div>
                                    <div class="col-md-12 text-left">
                                        <h5>Nombre/Razón Social</h5>
                                        <h5>--</h5>
                                    </div>
                                    <div class="col-md-12 text-left">
                                        <h5>Dirección</h5>
                                        <h5>--</h5>
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
        $(document).ready(function() {

            $("#btnColegitura").click(function() {
                $('#mdColegiatura').modal('show');
                loadColegiatura();
            });

            $("#btnColegitura").on("keyup", function(event) {
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

            $("#btnCuotas").on("keyup", function() {
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

            $("#btnCuotaNormal").on("keyup", function(event) {
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

            $("#btnCuotaAmnistia").on("keyup", function(event) {
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

            $("#btnCuotaVitalicio").on("keyup", function(event) {
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

            $("#btnCertHabilidad").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $('#mdCertHabilidad').modal('show');
                }
                event.preventDefault();
            });

            $("#btnCertProyecto").click(function() {
                $('#mdCertProyecto').modal('show');
            });

            $("#btnCertProyecto").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $('#mdCertProyecto').modal('show');
                }
                event.preventDefault();
            });

            $("#btnCertResidenciaObra").click(function() {
                $('#mdCertResidenciaObra').modal('show');
            });

            $("#btnCertResidenciaObra").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $('#mdCertResidenciaObra').modal('show');
                }
                event.preventDefault();
            });

            //Modal peritaje
            $("#btnPeritaje").click(function() {
                $('#mdPeritaje').modal('show');
            });

            $("#btnPeritaje").on("keyup", function(event) {
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

            $("#btnOtro").on("keyup", function(event) {
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

            $("#btnAddCuota").on("keyup", function(event) {
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

            $("#btnCobrar").click(function(){
                registrarIngreso();
            });

            $("#btnCobrar").keypress(function(){
                registrarIngreso();
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
                        $("#txtCantidadOtrosConceptos").val("");
                    } else {
                        AlertWarning("Ingresos Diversos", "Ya existe un concepto con los datos.")
                    }
                } else {
                    AlertWarning("Ingresos Diversos", "Debe ingresar una cantidad mayor a cero")
                }
            } else {
                AlertWarning("Ingresos Diversos", "Debe escoger un concepto")
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
                    "idTipoDocumento": "01",
                    "idCliente": "00000001",
                    "numRecibo": "1212121202",
                    "idUsuario":1,
                    "estado":'C',
                    "ingresos":arrayIngresos
                }),
                beforeSend: function() {
                    $("#cbOtrosConcepto").empty();
                },
                success: function(result) {
                    console.log(result)
                },
                error: function(error) {
                    console.log(error);
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
                    '<td>' + value.precio + '</td>' +
                    '<td>' + value.monto + '</td>' +
                    '<td><button>Edit</button></td>' +
                    '<td><button onClick="removeIngresos(\'' + value.idConcepto + '\')">Edit</button></td>' +
                    '</tr>');
                sumaTotal += parseFloat(value.monto);
            }
            $("#lblSumaTotal").html(sumaTotal);
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

        function AlertSuccess(title, message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["success"](message, title);
        }

        function AlertWarning(title, message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["warning"](message, title);
        }

        function AlertError(title, message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["error"](message, title)
        }

        function AlertInfo(title, message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["info"](message, title)
        }
    </script>
</body>

</html>