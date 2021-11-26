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
            <!-- *******************************************************-->
            <!-- modal añadir colegiatura -->
            <div class="row">
                <div class="modal fade" id="addColegiatura">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-university">
                                    </i> Añadir Colegiatura
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Sede</label>
                                            <div class="col-sm-8">
                                                <select id="Sede" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Especialidad</label>
                                            <div class="col-sm-8">
                                                <select id="Especialidad" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Fecha de Colegiación</label>
                                            <div class="col-sm-8">
                                                <input id="FechaColegiacion" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Egreso" class="col-sm-4 control-label">Universidad de Egreso</label>
                                            <div class="col-sm-8">
                                                <select id="UniversidadEgreso" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="FechaEgreso" class="col-sm-4 control-label">Fecha de Egreso</label>
                                            <div class="col-sm-8">
                                                <input id="FechaEgreso" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Titulacion" class="col-sm-4 control-label">Universidad de Titulacion</label>
                                            <div class="col-sm-8">
                                                <select id="UniversidadTitulacion" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="FechaTitulo" class="col-sm-4 control-label">Fecha de Titulo</label>
                                            <div class="col-sm-8">
                                                <input id="FechaTitulo" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtResolucion" class="col-sm-4 control-label">Resolución</label>
                                            <div class="col-sm-8">
                                                <input id="txtResolucion" type="text" class="form-control" placeholder="Resolución" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarColegiatura">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAddCancel">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal add colegiatura  -->

            <!-- modal editar colegiatura -->
            <div class="row">
                <div class="modal fade" id="editColegiatura">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-university">
                                    </i> Editar Colegiatura
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Sede</label>
                                            <div class="col-sm-8">
                                                <select id="ESede" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Especialidad</label>
                                            <div class="col-sm-8">
                                                <select id="EEspecialidad" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Fecha de Colegiación</label>
                                            <div class="col-sm-8">
                                                <input id="EFechaColegiacion" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Egreso" class="col-sm-4 control-label">Universidad de Egreso</label>
                                            <div class="col-sm-8">
                                                <select id="EUniversidadEgreso" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="EFechaEgreso" class="col-sm-4 control-label">Fecha de Egreso</label>
                                            <div class="col-sm-8">
                                                <input id="EFechaEgreso" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Titulacion" class="col-sm-4 control-label">Universidad de Titulacion</label>
                                            <div class="col-sm-8">
                                                <select id="EUniversidadTitulacion" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="EFechaTitulo" class="col-sm-4 control-label">Fecha de Titulo</label>
                                            <div class="col-sm-8">
                                                <input id="EFechaTitulo" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtResolucion" class="col-sm-4 control-label">Resolución</label>
                                            <div class="col-sm-8">
                                                <input id="EtxtResolucion" type="text" class="form-control" placeholder="Resolución" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="EbtnAceptarColegiatura">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal editar colegiatura  -->

            <!-- modal eliminar colegiatura  -->
            <div class="row">
                <div class="modal fade" id="deleteColegiatura">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-university">
                                    </i> Eliminar Colegiatura
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-12 control-label">¿Estas seguro que deseas elimininar esta colegiatura?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnDeleteColegiatura">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-delete">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal eliminar colegiatura -->
            <!-- *******************************************************-->

            <!-- *******************************************************-->
            <!-- modal añadir domicilio -->
            <div class="row">
                <div class="modal fade" id="addDomicilio">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-home">
                                    </i> Añadir Domicilio
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tipo</label>
                                            <div class="col-sm-8">
                                                <select id="tipoDomicilio" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Dep/Prov/Dist</label>
                                            <div class="col-sm-8">
                                                <select id="Departamento" name="selValue" class="form-control selectpicker" data-live-search="true" title="- Seleccione -">
                                                    <select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Direccion</label>
                                            <div class="col-sm-8">
                                                <input id="Direccion" type="text" class="form-control" placeholder="Ingrese una dirección válida" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarDomicilio">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAddCancel">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal add domicilio  -->

            <!-- modal editar domicilio -->
            <div class="row">
                <div class="modal fade" id="editDomicilio">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-home">
                                    </i> Editar Domicilio
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tipo</label>
                                            <div class="col-sm-8">
                                                <select id="EtipoDomicilio" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Dep/Prov/Dist</label>
                                            <div class="col-sm-8">
                                                <select id="EDepartamento" name="selValue" class="form-control selectpicker" data-live-search="true" title="- Seleccione -">
                                                    <select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Direccion</label>
                                            <div class="col-sm-8">
                                                <input id="EDireccion" type="text" class="form-control" placeholder="Ingrese una dirección válida" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="EbtnAceptarDomicilio">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal editar domicilio  -->

            <!-- modal eliminar domicilio  -->
            <div class="row">
                <div class="modal fade" id="deleteDomicilio">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-home">
                                    </i> Eliminar Domicilio
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-12 control-label">¿Estas seguro que deseas elimininar este domicilio?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnDeleteDomicilio">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-delete">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal eliminar domicilio -->
            <!-- *******************************************************-->

            <!-- *******************************************************-->
            <!-- modal añadir telefono -->
            <div class="row">
                <div class="modal fade" id="addTelefono">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-phone">
                                    </i> Añadir Telefono
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tipo</label>
                                            <div class="col-sm-8">
                                                <select id="TipoCelular" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Numero</label>
                                            <div class="col-sm-8">
                                                <input id="txtNumero" type="text" class="form-control" placeholder="Ingrese su numero" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarCelular">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAddCancel">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal add telefono  -->

            <!-- modal editar telefono -->
            <div class="row">
                <div class="modal fade" id="editTelefono">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-phone">
                                    </i> Editar Telefono
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tipo</label>
                                            <div class="col-sm-8">
                                                <select id="ETipoCelular" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Numero</label>
                                            <div class="col-sm-8">
                                                <input id="EtxtNumero" type="text" class="form-control" placeholder="Ingrese su numero" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="EbtnAceptarCelular">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal editar telefono  -->

            <!-- modal eliminar telefono  -->
            <div class="row">
                <div class="modal fade" id="deleteTelefono">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-phone">
                                    </i> Eliminar Telefono
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-12 control-label">¿Estas seguro que deseas elimininar este telefono/celular?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnDeleteTelefono">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal eliminar telefono -->
            <!-- *******************************************************-->

            <!-- *******************************************************-->
            <!-- modal añadir conyuge -->
            <div class="row">
                <div class="modal fade" id="addConyuge">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-user-plus">
                                    </i> Añadir Conyuge
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Conyuge" class="col-sm-4 control-label">Conyuge</label>
                                            <div class="col-sm-8">
                                                <input id="txtConyuge" type="text" class="form-control" placeholder="Nombre Conyuge" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Conyuge" class="col-sm-4 control-label">Numero de hijos</label>
                                            <div class="col-sm-8">
                                                <input id="txtHijos" type="number" class="form-control" placeholder="Ingrese numero de hijos" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarConyuge">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal add conyuge  -->

            <!-- modal editar conyuge -->
            <div class="row">
                <div class="modal fade" id="editConyuge">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-user-plus">
                                    </i> Editar Conyuge
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Conyuge" class="col-sm-4 control-label">Conyuge</label>
                                            <div class="col-sm-8">
                                                <input id="EtxtConyuge" type="text" class="form-control" placeholder="Nombre Conyuge" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Conyuge" class="col-sm-4 control-label">Numero de hijos</label>
                                            <div class="col-sm-8">
                                                <input id="EtxtHijos" type="number" class="form-control" placeholder="Ingrese numero de hijos" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="EbtnAceptarConyuge">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal editar conyuge  -->

            <!-- modal eliminar conyuge  -->
            <div class="row">
                <div class="modal fade" id="deleteConyuge">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-user-plus">
                                    </i> Eliminar Conyuge
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-12 control-label">¿Estas seguro que deseas elimininar conyuge?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnDeleteConyuge">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal eliminar conyuge -->
            <!-- *******************************************************-->

            <!-- *******************************************************-->
            <!-- modal añadir experiencia -->
            <div class="row">
                <div class="modal fade" id="addExperiencia">
                    <div class="modal-dialog modal-xs" style="width: 550px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-suitcase">
                                    </i> Añadir Experiencia
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Entidad</label>
                                            <div class="col-sm-8">
                                                <input id="txtEntidad" type="text" class="form-control" placeholder="Entidad" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="padding-top: 0.5em;">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Experiencia profesional</label>
                                            <div class="col-sm-8">
                                                <input id="txtExperiencia" type="text" class="form-control" placeholder="Experiencia" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="FechaInicio" class="col-sm-4 control-label">Fecha de Inicio</label>
                                            <div class="col-sm-8">
                                                <input id="FechaInicio" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="FechaFin" class="col-sm-4 control-label">Fecha de Termino</label>
                                            <div class="col-sm-8">
                                                <input id="FechaFin" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarExperiencia">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal add experiencia  -->

            <!-- modal editar experiencia -->
            <div class="row">
                <div class="modal fade" id="editExperiencia">
                    <div class="modal-dialog modal-xs" style="width: 550px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-suitcase">
                                    </i> Editar Experiencia
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Entidad</label>
                                            <div class="col-sm-8">
                                                <input id="EtxtEntidad" type="text" class="form-control" placeholder="Entidad" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="padding-top: 0.5em;">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Experiencia profesional</label>
                                            <div class="col-sm-8">
                                                <input id="EtxtExperiencia" type="text" class="form-control" placeholder="Experiencia" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="FechaInicio" class="col-sm-4 control-label">Fecha de Inicio</label>
                                            <div class="col-sm-8">
                                                <input id="EFechaInicio" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="FechaFin" class="col-sm-4 control-label">Fecha de Termino</label>
                                            <div class="col-sm-8">
                                                <input id="EFechaFin" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="EbtnAceptarExperiencia">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal editar experiencia  -->

            <!-- modal eliminar experiencia  -->
            <div class="row">
                <div class="modal fade" id="deleteExperiencia">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-suitcase">
                                    </i> Eliminar Experiencia
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-12 control-label">¿Estas seguro que deseas elimininar la experiencia?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnDeleteExperiencia">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal eliminar experiencia -->
            <!-- *******************************************************-->

            <!-- *******************************************************-->
            <!-- modal añadir grados y estudios -->
            <div class="row">
                <div class="modal fade" id="addGradosyEstudios">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-mortar-board">
                                    </i> Añadir Grados y Estudios
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Grado" class="col-sm-3 control-label">Grado</label>
                                            <div class="col-sm-9">
                                                <select id="selectGrado" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Materia" class="col-sm-3 control-label">Materia</label>
                                            <div class="col-sm-9">
                                                <input id="txtMateria" type="text" class="form-control" placeholder="Materia" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-3 control-label">Universidad</label>
                                            <div class="col-sm-9">
                                                <select id="selectUniversidad" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Fecha" class="col-sm-3 control-label">Fecha </label>
                                            <div class="col-sm-9">
                                                <input id="fechaEstudios" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarEstudios">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal add grados y estudios  -->

            <!-- modal editar grados y estudios -->
            <div class="row">
                <div class="modal fade" id="editarGradosyEstudios">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-mortar-board">
                                    </i> Editar Grados y Estudios
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Grado" class="col-sm-3 control-label">Grado</label>
                                            <div class="col-sm-9">
                                                <select id="EselectGrado" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Materia" class="col-sm-3 control-label">Materia</label>
                                            <div class="col-sm-9">
                                                <input id="EtxtMateria" type="text" class="form-control" placeholder="Materia" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-3 control-label">Universidad</label>
                                            <div class="col-sm-9">
                                                <select id="EselectUniversidad" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Fecha" class="col-sm-3 control-label">Fecha </label>
                                            <div class="col-sm-9">
                                                <input id="EfechaEstudios" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="EbtnAceptarEstudios">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal editar grados y estudios  -->

            <!-- modal eliminar estudio  -->
            <div class="row">
                <div class="modal fade" id="deleteEstudio">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-mortar-board"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-suitcase">
                                    </i> Eliminar Estudioa
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-12 control-label">¿Estas seguro que deseas elimininar el estudio?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnDeleteEstudio">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal eliminar estudio -->
            <!-- *******************************************************-->

            <!-- *******************************************************-->
            <!-- modal añadir correo y web -->
            <div class="row">
                <div class="modal fade" id="addCorreoyWeb">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-at">
                                    </i> Añadir Correo y Web
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tipo</label>
                                            <div class="col-sm-9">
                                                <select id="TipoCorreo" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Correo / Web</label>
                                            <div class="col-sm-9">
                                                <input id="txtCorreo" type="text" class="form-control" placeholder="Ingrese un Correo o web" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarCorreo">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal add correo y web  -->

            <!-- modal editar correo y web -->
            <div class="row">
                <div class="modal fade" id="editCorreoyWeb">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-at">
                                    </i> Editar Correo y Web
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tipo</label>
                                            <div class="col-sm-9">
                                                <select id="ETipoCorreo" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Correo / Web</label>
                                            <div class="col-sm-9">
                                                <input id="EtxtCorreo" type="text" class="form-control" placeholder="Ingrese un Correo o web" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="EbtnAceptarCorreo">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal editar correo y web  -->

            <!-- modal eliminar correo y web  -->
            <div class="row">
                <div class="modal fade" id="deleteCorreo">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-mortar-board"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-at">
                                    </i> Eliminar Correo/Web
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-12 control-label">¿Estas seguro que deseas elimininar tal dirección?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnDeleteCorreo">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal eliminar correo y web -->
            <!-- *******************************************************-->

            <!-- *******************************************************-->
            <!-- modal reincorporación -->
            <div class="row">
                <div class="modal fade" id="mdReincorporacion">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-user">
                                    </i> Reincorparación del Ingeniero
                                </h4>
                            </div>
                            <div class="modal-body">

                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Fecha (Ingrese la fecha de su ultima cuota en su sede anterior)</label>
                                            <div class="col-sm-9">
                                                <input id="txtFechaReincorporacion" type="date" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnSaveReincorporacion">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal reincorporación  -->

            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <section class="content-header">
                    <h4><i class="fa fa-user"></i> Actualizar Datos del Ingeniero(a) <span id="Load_date"></span></h4>
                </section>
                <!-- *******************************************************-->
                <!-- dosiseño principal-->
                <section class="content">
                    <!-- *******************************************************-->
                    <!-- actualizacion del ingeniero-->
                    <div class="modal-overlay d-none" id="divLoad">
                        <div class="modal-overlay-content">
                            <div>
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div>
                                <label id="lblOverlayModal">Cargando información...</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 text-center">
                            <div class="row">
                                <div class="form-group">
                                    <img class="img-responsive img-thumbnail" style="width: 160px;height:160px;" id="lblImagen">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="SubirImagen" class="btn btn-warning">Subir imagen</label>
                                    <input type="file" id="SubirImagen" style="display:none" accept="image/png, image/jpeg, image/gif, image/svg">
                                </div>
                                <div class="form-group">
                                    <label class="btn btn-default">Quitar imagen</label>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <button class="btn btn-success" id="guardarImagen">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-9 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label for="numDoc">DNI: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <button type="button" id="btnReniec" class="btn btn-default btn-flat"><img src="./images/reniec.png" width="16" height="16" /></button>
                                            </div>
                                            <input id="numDoc" type="text" class="form-control" placeholder="Dni" required="" minlength="8" maxlength="8">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="Nombres">Nombres: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="Nombres" type="text" name="Nombres" class="form-control" placeholder="Nombres" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="Apellidos">Apellidos: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="Apellidos" type="text" name="Apellidos" class="form-control" placeholder="Apellidos" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="Genero">Genero: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <select id="Genero" class="form-control">
                                            <option value="M">Maculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="Nacimiento">Nacimiento: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="Nacimiento" type="date" name="Nacimiento" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="Estado_civil">Estado civil: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <select id="Estado_civil" class="form-control">
                                            <option value="S">Soltero/a</option>
                                            <option value="C">Casado/a</option>
                                            <option value="V">Viudo/a</option>
                                            <option value="D">Divorciado/a</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="Ruc">Dirección Principal:</label>
                                        <input id="Ruc" type="text" name="Ruc" class="form-control" placeholder="Dirección de viviendan principal">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="Razon_social">Télefono/Celular Prinpal:</label>
                                        <input id="Razon_social" type="text" name="Razon_social" class="form-control" placeholder="N° de teléfono o celular principal">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                    <div class="form-group">
                                        <label for="Codigo">Codigo CIP: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="Codigo" type="text" name="Codigo" class="form-control" placeholder="Codigo" required="">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <div class="form-group">
                                        <label for="Tramite">Nuevo:</label>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="Tramite"> Tramite
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="Condicion">Condición: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <select id="Condicion" class="form-control">
                                            <option value="O">ORDINARIO</option>
                                            <option value="T">TRANSEUNTE</option>
                                            <option value="F">FALLECIDO</option>
                                            <option value="R">RETIRADO</option>
                                            <option value="V">VITALICIO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                            <button type="button" class="btn btn-danger" name="btnAceptar" id="btnaceptar">
                                <i class="fa fa-check"></i> Editar</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" name="btncancelar" id="btncancelar">
                                <i class="fa fa-remove"></i> Cancelar</button>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!--FORMULARIOS INFERIORES-->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Colegiatura</a></li>
                                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Domicilios</a></li>
                                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Telefonos</a></li>
                                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Conyuge</a></li>
                                    <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">Experiencia</a></li>
                                    <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false">Grados y Estudios</a></li>
                                    <li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false">Correo y Web</a></li>
                                    <li class="pull-right"><button class="btn btn-info btn-sm" id="btnReincorporacion"><i class="fa fa-plus"></i> Reincorporación</button></li>
                                    <li class="pull-right"><button class="btn btn-success btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Nuevo</button></li>
                                </ul>
                                <div class="tab-content">
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                                <thead style="background-color: #FDB2B1; color: #B72928;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Sede</th>
                                                        <th>Capitulo</th>
                                                        <th>Especialidad</th>
                                                        <th>F. Colegiado</th>
                                                        <th>Universidad de egreso</th>
                                                        <th>F. Egreso</th>
                                                        <th>Universidad de titulo</th>
                                                        <th>F. Titulacion</th>
                                                        <th>Resolución</th>
                                                        <th colspan="2" style="text-align: center;">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbColegiaturas">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                                <thead style="background-color: #FDB2B1; color: #B72928;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tipo</th>
                                                        <th>Direccion</th>
                                                        <th>Ubigeo</th>
                                                        <th style="text-align: center;">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbDomicilio">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                                <thead style="background-color: #FDB2B1; color: #B72928;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tipo</th>
                                                        <th>Numero</th>
                                                        <th style="text-align: center;">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbTelefono">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_4">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                                <thead style="background-color: #FDB2B1; color: #B72928;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nombre Completo</th>
                                                        <th>Hijos</th>
                                                        <th style="text-align: center;">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbConyuge">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_5">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                                <thead style="background-color: #FDB2B1; color: #B72928;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Entidad</th>
                                                        <th>Experiencia Profesional</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Fecha Fin</th>
                                                        <th style="text-align: center;">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbExperiencia">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_6">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                                <thead style="background-color: #FDB2B1; color: #B72928;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Grado</th>
                                                        <th>Materia</th>
                                                        <th>Universidad</th>
                                                        <th>Fecha</th>
                                                        <th style="text-align: center;">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbGradosyExperiencia">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_7">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                                <thead style="background-color: #FDB2B1; color: #B72928;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tipo</th>
                                                        <th>Direccion</th>
                                                        <th style="text-align: center;">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbGradosyWeb">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                    </div>

                </section>
            </div>
            <!-- Fin de la actualizacion del ingeniero-->
            <!-- /.content -->
            <!-- start footer -->
            <?php include('./layout/footer.php') ?>
            <!-- end footer -->
        </div>
        <!-- /.content-wrapper -->
        <!-- ./wrapper -->
        <script src="js/tools.js"></script>
        <script src="js/actualizaringeniero/colegiatura.js"></script>
        <script src="js/actualizaringeniero/domicilio.js"></script>
        <script src="js/actualizaringeniero/telefono.js"></script>
        <script src="js/actualizaringeniero/conyuge.js"></script>
        <script src="js/actualizaringeniero/experiencia.js"></script>
        <script src="js/actualizaringeniero/estudios.js"></script>
        <script src="js/actualizaringeniero/correoyweb.js"></script>
        <script>
            let spiner = $("#Load_date");
            let lblImagen = $("#lblImagen");
            let fileImage = $("#SubirImagen");

            let idDNI = "<?php echo  $_GET["idPersona"]; ?>";
            let idUsuario = "<?php echo $_SESSION['IdUsuario']; ?>";
            let state = false;

            let tools = new Tools();
            let modelColegiatura = new Colegiatura();
            let modelDomicilio = new Domicilio();
            let modelTelefono = new Celular();
            let modelConyuge = new Conyuge();
            let modelExperiencia = new Experiencia();
            let modelEstudios = new Estudios();
            let modelCorreoyWeb = new CorreoyWeb();

            $(document).ready(function() {
                loadDataPersona(idDNI);

                $("#btnaceptar").click(function() {
                    if (state) {
                        if ($("#numDoc").val() == '' || $("#numDoc").val().length < 8) {
                            tools.AlertWarning("Advertencia", "Ingrese un número de dni correcto por favor.");
                        } else if ($("#Nombres").val() == '') {
                            tools.AlertWarning("Advertencia", "Ingrese los nombres completos por favor.");
                        } else if ($("#Apellidos").val() == '') {
                            tools.AlertWarning("Advertencia", "Ingrese los apellidos completos por favor.");
                        } else if (!$('#Tramite').is(":checked") && $("#Codigo").val() == '') {
                            tools.AlertWarning("Advertencia", "Ingrese el número cip por favor.");
                        } else {

                            let formData = new FormData();
                            formData.append("type", "update");
                            formData.append("dni", idDNI);
                            formData.append("num_duc", $("#numDoc").val());
                            formData.append("nombres", $("#Nombres").val().trim().toUpperCase());
                            formData.append("apellidos", $("#Apellidos").val().trim().toUpperCase());
                            formData.append("sexo", $("#Genero").val());
                            formData.append("nacimiento", $("#Nacimiento").val());
                            formData.append("estado_civil", $("#Estado_civil").val());
                            formData.append("ruc", $("#Ruc").val().trim().toUpperCase());
                            formData.append("rason_social", $("#Razon_social").val().trim());
                            formData.append("cip", $("#Codigo").val().trim());
                            formData.append("condicion", $("#Condicion").val());
                            formData.append("idUsuario", idUsuario);
                            updatePersona(formData);
                        }
                    } else {
                        tools.AlertWarning("Advertencia",
                            "Nose pudo cargar los datos correctamente, recargue la pantalla otra ves.");
                    }
                });

                $("#btncancelar").click(function() {
                    location.href = "ingenieros.php"
                });

                $("#btncancelar").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        location.href = "ingenieros.php"
                    }
                });

                $("#Tramite").on("change", function() {
                    $("#Codigo").prop("disabled", this.checked);
                });

                $("#btnNuevo").click(function() {
                    selectModal();
                });

                $("#btnNuevo").keypress(function(event) {
                    if (event.keyCode === 13) {
                        selectModal();
                    }
                    event.preventDefault();
                });

                $("#btnReincorporacion").click(function() {
                    $("#mdReincorporacion").modal("show");
                });

                $("#btnReincorporacion").keypress(function(event) {
                    if (event.keyCode === 13) {
                        $("#mdReincorporacion").modal("show");
                    }
                    event.preventDefault();
                });

                $("#btnSaveReincorporacion").click(function() {
                    if (!tools.validateDate($("#txtFechaReincorporacion").val())) {
                        tools.AlertWarning("", "Ingrese la fecha de reincorporación");
                    } else {
                        tools.ModalDialog("Ingeniero", "¿Está seguro de continuar?", function(value) {
                            if (value == true) {
                                $.ajax({
                                    url: "../app/controller/PersonaController.php",
                                    method: "POST",
                                    data: {
                                        "type": "reincorporacion",
                                        "idDNI": idDNI,
                                        "fecha": $("#txtFechaReincorporacion").val(),
                                        "idUsuario": idUsuario
                                    },
                                    beforeSend: function() {
                                        $("#mdReincorporacion").modal("hide");
                                        tools.ModalAlertInfo("Ingeniero", "Procesando petición..");
                                    },
                                    success: function(result) {
                                        if (result.estado === 1) {
                                            tools.ModalAlertSuccess("Ingeniero", result.message);
                                        } else {
                                            tools.ModalAlertWarning("Ingeniero", result.message);
                                        }
                                    },
                                    error: function(error) {
                                        tools.ModalAlertError("Ingeniero", "Se produjo un error: " + error.responseText);
                                    }
                                });
                            }
                        });

                    }
                });

                $("#SubirImagen").on('change', function(event) {
                    lblImagen.attr("src", URL.createObjectURL(event.target.files[0]));
                });

                // //carga las tablas inferiores
                modelColegiatura.loadColegiatura(idDNI);
                modelDomicilio.loadDomicilio(idDNI);
                modelTelefono.loadTelefono(idDNI);
                modelConyuge.loadConyuge(idDNI);
                modelExperiencia.loadExperiencia(idDNI);
                modelEstudios.loadGradosyEstudios(idDNI);
                modelCorreoyWeb.loadCorreoyWeb(idDNI);

                $("#guardarImagen").click(function() {
                    updateImage();
                });

                $("#guardarImagen").keypress(function(event) {
                    if (event.keyCode === 13) {
                        updateImage();
                    }
                    event.preventDefault();
                });

                $("#btnAceptarColegiatura").click(function() {
                    modelColegiatura.crudColegiatura();
                });

                $("#btnAceptarColegiatura").keypress(function(event) {
                    if (event.keyCode === 13) {
                        modelColegiatura.crudColegiatura();
                    }
                    event.preventDefault();
                });

                $("#btnAceptarDomicilio").click(function() {
                    modelDomicilio.crudDomicilio();
                });

                $("#btnAceptarDomicilio").keypress(function(event) {
                    if (event.keyCode === 13) {
                        modelDomicilio.crudDomicilio();
                    }
                    event.preventDefault();
                });

                $("#btnAceptarCelular").click(function() {
                    modelTelefono.crudCelular();
                });

                $("#btnAceptarCelular").keypress(function(event) {
                    if (event.keyCode === 13) {
                        modelTelefono.crudCelular();
                    }
                    event.preventDefault();
                });

                $("#btnAceptarConyuge").click(function() {
                    modelConyuge.crudConyuge();
                });

                $("#btnAceptarConyuge").keypress(function(event) {
                    if (event.keyCode === 13) {
                        modelConyuge.crudConyuge();
                    }
                    event.preventDefault();
                });
                $("#btnAceptarExperiencia").click(function() {
                    modelExperiencia.crudExperiencia();
                });

                $("#btnAceptarExperiencia").keypress(function(event) {
                    if (event.keyCode === 13) {
                        modelExperiencia.crudExperiencia();
                    }
                    event.preventDefault();
                });

                $("#btnAceptarEstudios").click(function() {
                    modelEstudios.crudEstudios();
                });

                $("#btnAceptarEstudios").keypress(function(event) {
                    if (event.keyCode === 13) {
                        modelEstudios.crudEstudios();
                    }
                    event.preventDefault();
                });

                $("#btnAceptarCorreo").click(function() {
                    modelCorreoyWeb.crudCorreo();
                });

                $("#btnAceptarCorreo").keypress(function(event) {
                    if (event.keyCode === 13) {
                        modelCorreoyWeb.crudCorreo();
                    }
                    event.preventDefault();
                });

                $("#btnReniec").click(function() {
                    if ($("#numDoc").val().trim() == '') {
                        tools.AlertWarning("Ingenieros", "Ingrese un dni en el campo.");
                        $("#numDoc").focus();
                    } else if ($("#numDoc").val().length !== 8) {
                        tools.AlertWarning("Ingenieros", "El dni debe tener 8 caracteres.");
                        $("#numDoc").focus();
                    } else {
                        loadReniecApi($("#numDoc").val());
                    }

                });

                $("#btnReniec").keypress(function(event) {
                    if (event.keyCode == 13) {
                        loadReniecApi($("#numDoc").val());
                    }
                    event.preventDefault();
                });
            });


            function selectModal() {
                if ($("#tab_1").hasClass('active')) {
                    $("#addColegiatura").modal("show");
                    modelColegiatura.loadAddColegiatura();
                } else if ($("#tab_2").hasClass('active')) {
                    $("#addDomicilio").modal("show");
                    modelDomicilio.loadAddDomicilio();
                } else if ($("#tab_3").hasClass('active')) {
                    $("#addTelefono").modal("show");
                    modelTelefono.loadAddCelular();
                } else if ($("#tab_4").hasClass('active')) {
                    $("#addConyuge").modal("show");
                    modelConyuge.loadAddConyuge();
                } else if ($("#tab_5").hasClass('active')) {
                    $("#addExperiencia").modal("show");
                    modelExperiencia.loadAddExperiencia();
                } else if ($("#tab_6").hasClass('active')) {
                    $("#addGradosyEstudios").modal("show");
                    modelEstudios.loadAddEstudios();
                } else if ($("#tab_7").hasClass('active')) {
                    $("#addCorreoyWeb").modal("show");
                    modelCorreoyWeb.loadAddCorreoyWeb();
                }
            }

            function loadDataPersona(id) {
                $.ajax({
                    url: "../app/controller/PersonaController.php",
                    method: "GET",
                    data: {
                        "type": "data",
                        "dni": id
                    },
                    beforeSend: function() {
                        spiner.append(
                            '<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>'
                        );
                    },
                    success: function(result) {
                        spiner.remove();
                        if (result.estado === 1) {
                            let persona = result.persona;

                            if (result.imagen == null) {
                                lblImagen.attr("src", "images/ayuda.png");
                            } else {
                                lblImagen.attr("src", "data:image/(png|jpg|jpge|gif);base64," + result.imagen[1]);
                            }

                            $("#numDoc").val(persona.NumDoc);
                            $("#Nombres").val(persona.Nombres)
                            $("#Apellidos").val(persona.Apellidos)

                            if (persona.Sexo == "M") {
                                $("#Genero").val("M")
                            } else {
                                $("#Genero").val("F")
                            }

                            document.getElementById("Nacimiento").value = tools.getDateForma(persona
                                .FechaNacimiento, 'yyyy-mm-dd');

                            if (persona.EstadoCivil == "C") {
                                $("#Estado_civil").val("C");
                            } else if (persona.EstadoCivil == "V") {
                                $("#Estado_civil").val("V");
                            } else if (persona.EstadoCivil == "D") {
                                $("#Estado_civil").val("D");
                            } else {
                                $("#Estado_civil").val("S");
                            }

                            if (persona.RUC == "") {
                                $("#Ruc").val("")
                            } else {
                                $("#Ruc").val(persona.RUC)
                            }

                            if (persona.RAZONSOCIAL == null) {
                                $("#Razon_social").val("")
                            } else {
                                $("#Razon_social").val(persona.RAZONSOCIAL)
                            }

                            if (persona.CIP == "") {
                                $("#Tramite").prop("checked", true);
                                $("#Codigo").prop("disabled", !$('#cbTramite').is(":checked"));
                            } else {
                                $("#Tramite").prop("checked", false);
                                $("#Codigo").val(persona.CIP)
                                $("#Codigo").prop("disabled", $('#cbTramite').is(":checked"));
                            }

                            switch (persona.Condicion) {
                                case "O":
                                    $("#Condicion").val("O")
                                    break;
                                case "T":
                                    $("#Condicion").val("T")
                                    break;
                                case "F":
                                    $("#Condicion").val("F")
                                    break;
                                case "R":
                                    $("#Condicion").val("R")
                                    break;
                                case "V":
                                    $("#Condicion").val("V")
                                    break;
                                default:
                                    // code block

                            }

                            tools.AlertInfo("Información", "Se cargo correctamente los datos.");
                            state = true;
                        } else {
                            tools.AlertWarning("Advertencia", result.message);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tools.AlertError("Error", error);
                        state = false;
                    }
                });
            }

            function updatePersona(formData) {
                $.ajax({
                    url: "../app/controller/PersonaController.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $("#btnaceptar").empty();
                        $("#btnaceptar").append('<img src="./images/spiner.gif" width="25" height="25" />')
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.AlertSuccess("Mensaje", "Se actualizaron correctamente los datos.")
                            setTimeout(function() {
                                location.href = "ingenieros.php"
                            }, 1000);
                        } else if (result.estado == 2) {
                            tools.AlertWarning("Mensaje", result.message);
                            setTimeout(function() {
                                $("#btnaceptar").empty();
                                $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
                            }, 1000);
                        } else {
                            tools.AlertWarning("Mensaje", result.message);
                            setTimeout(function() {
                                $("#btnaceptar").empty();
                                $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
                            }, 1000);
                        }
                    },
                    error: function(error) {
                        tools.AlertError("Error", error.responseText);
                        $("#btnaceptar").empty();
                        $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
                    }
                });
            }

            function loadReniecApi(numero) {
                $.ajax({
                    url: "https://dniruc.apisperu.com/api/v1/dni/" + numero + "?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFsZXhhbmRlcl9keF8xMEBob3RtYWlsLmNvbSJ9.6TLycBwcRyW1d-f_hhCoWK1yOWG_HJvXo8b-EoS5MhE",
                    type: "GET",
                    data: {},
                    beforeSend: function() {
                        $("#divLoad").removeClass("d-none");
                    },
                    success: function(result) {
                        $("#divLoad").addClass("d-none");
                        $("#Nombres").val(result.nombres);
                        $("#Apellidos").val(result.apellidoPaterno + " " + result.apellidoMaterno);
                    },
                    error: function(error) {
                        $("#divLoad").addClass("d-none");
                    }
                });
            }

            function updateImage() {
                let files = document.getElementById('SubirImagen').files;
                if (files.length == 0) {
                    tools.AlertWarning("Imagen", "Seleccione una imagen antes de");
                } else {
                    let file = files[0];
                    let blob = file.slice();
                    let reader = new FileReader();

                    reader.onloadend = function(evt) {
                        if (evt.target.readyState == FileReader.DONE) {
                            let base64String = evt.target.result.replace(/^data:.+;base64,/, '');
                            $.ajax({
                                url: "../app/controller/UpdateImagePersona.php",
                                type: 'POST',
                                accepts: "application/json",
                                contentType: "application/json; charset=utf-8",
                                data: JSON.stringify({
                                    "dni": idDNI,
                                    "image": base64String,
                                }),
                                success: function(result) {

                                    if (result.estado == 1) {
                                        tools.AlertSuccess("Imagen", "Se registro correctamente.");
                                    } else {
                                        tools.AlertWarning("Imagen", result.message);
                                    }
                                },
                                error: function(response) {
                                    tools.AlertError("Imagen", "Se produjo un error, contactese con el administrador del sistema");
                                }
                            });
                        }
                    };
                    reader.readAsDataURL(blob);
                }
            }
        </script>
    </body>

    </html>

<?php }
