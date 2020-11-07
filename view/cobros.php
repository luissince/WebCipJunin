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
                    <div class="modal fade" id="mdCuotas">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
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
                                        </div>
                                    </div>
                                    <div class="row" style="overflow-x: auto; height:280px">
                                        <div class="col-md-12">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Cuota del Mes</th>
                                                        <th>Monto</th>
                                                    </tr>
                                                </thead>
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
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
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
                                                <select class="form-control" id="cbEspecialidad">
                                                    <option>- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtIngeniero">Cantidad</label>
                                                <input type="number" class="form-control" id="txtIngeniero" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
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
                                                <th>Impuesto</th>
                                                <th>Monto</th>
                                                <th>Editar</th>
                                                <th>Quitar</th>
                                            </thead>
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
                                        <button class="btn btn-success btn-block">
                                            <div class="col-md-6 text-left">
                                                <h4>COBRAR</h4>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <h4>S/ 0.00</h4>
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
            });

            $("#btnCuotas").click(function() {
                $('#mdCuotas').modal('show');
                loadCuotas();
            });

            $("#btnCuotas").on("keyup", function() {
                if (event.keyCode === 13) {
                    $('#mdCuotas').modal('show');
                    loadCuotas();
                }
            });

            //Modal cuotas
            $("#btnCuotaNormal").click(function() {
                $("#lblCuotasMensaje").html("Cuotas Normales");
            });
            
            $("#btnCuotaNormal").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $("#lblCuotasMensaje").html("Cuotas Normales");
                }
            });

            $("#btnCuotaAmnistia").click(function() {
                $("#lblCuotasMensaje").html("Cuotas de Amnistia");
            });

            $("#btnCuotaAmnistia").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $("#lblCuotasMensaje").html("Cuotas de Amnistia");
                }
            });

            $("#btnCuotaVitalicio").click(function() {
                $("#lblCuotasMensaje").html("Cuotas de Vitalicio");
            });

            $("#btnCuotaVitalicio").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $("#lblCuotasMensaje").html("Cuotas de Vitalicio");
                }
            });
            //Modal certificado
            $("#btnCertHabilidad").click(function() {
                $('#mdCertHabilidad').modal('show');
            });

            $("#btnCertHabilidad").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $('#mdCertHabilidad').modal('show');
                }
            });

            $("#btnCertProyecto").click(function() {
                $('#mdCertProyecto').modal('show');
            });

            $("#btnCertProyecto").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $('#mdCertProyecto').modal('show');
                }
            });

            $("#btnCertResidenciaObra").click(function() {
                $('#mdCertResidenciaObra').modal('show');
            });

            $("#btnCertResidenciaObra").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $('#mdCertResidenciaObra').modal('show');
                }
            });

            //Modal peritaje
            $("#btnPeritaje").click(function() {
                $('#mdPeritaje').modal('show');
            });

            $("#btnPeritaje").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $('#mdPeritaje').modal('show');
                }
            });

            //Modal otros
            $("#btnOtro").click(function() {
                $('#mdOtros').modal('show');
            });

            $("#btnOtro").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $('#mdOtros').modal('show');
                }
            });

        });

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

        function loadCuotas() {
            $.ajax({
                url: "../app/controller/ConceptoController.php",
                method: "GET",
                data: {
                    "type": "typecolegiatura",
                    "categoria": 1
                },
                beforeSend: function() {
                    $("#tbCuotas").empty();
                },
                success: function(result) {
                    console.log(result)
                    if (result.estado === 1) {
                        let totalCuotas = 0;
                        for (let value of result.data) {
                            $("#tbCuotas").append('<tr >' +
                                '<td class="no-padding"><div><label><input type="checkbox"> ' + value.Fechas + '</label></div></td>' +
                                '<td class="no-padding">' + tools.formatMoney(value.Precio) + '</td>' +
                                +'</tr>');
                            totalCuotas += parseFloat(value.Precio);
                        }
                        $("#lblTotalCuotas").html("TOTAL DE " + (result.data.length) + " CUOTAS: " + tools.formatMoney(totalCuotas));
                    } else {

                    }
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

        }
    </script>
</body>

</html>