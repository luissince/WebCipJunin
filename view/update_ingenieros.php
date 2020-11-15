<?php

if (!isset($_GET["idPersona"])) {
    echo '<script>location.href = "ingenieros.php";</script>';
} else {
}
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
            <section class="content">

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
                                        <i class="fa fa-archive">
                                        </i> Añadir Colegiatura
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Sede" class="col-sm-4 control-label">Sede</label>
                                                <div class="col-sm-4">
                                                    <select id="Sede" class="form-control">
                                                    </select>
                                                </div>
                                                <div class="checkbox col-sm-4">
                                                    <label>
                                                        <input type="checkbox">
                                                        Principal
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Especialidad" class="col-sm-4 control-label">Especialidad</label>
                                                <div class="col-sm-8">
                                                    <select id="Especialidad" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="FechaColegiacion" class="col-sm-4 control-label">Fecha de Colegiación</label>
                                                <div class="col-sm-4">
                                                    <input id="FechaColegiacion" type="date" name="Nacimiento" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="FechaEgreso" class="col-sm-4 control-label">Fecha de Egreso</label>
                                                <div class="col-sm-4">
                                                    <input id="FechaEgreso" type="date" name="Nacimiento" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="FechaTitulo" class="col-sm-4 control-label">Fecha de Titulo</label>
                                                <div class="col-sm-4">
                                                    <input id="FechaTitulo" type="date" name="Nacimiento" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
                <!--end modal add colegiatura  -->

                <!-- modal añadir domicilio -->
                <div class="row">
                    <div class="modal fade" id="addDomicilio">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Añadir Domicilio
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Tipo" class="col-sm-2 control-label">Tipo</label>
                                                <div class="col-sm-6">
                                                    <select id="Tipo" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Direccion" class="col-sm-2 control-label">Dep/Prov/Dist</label>
                                                <div class="col-sm-6">
                                                    <select id="Departamento" class="form-control selectpicker" data-live-search="true" title="- Seleccione -">
                                                        <!-- <option value="">vallor1</option>
                                                    <option value="">vallor1</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Direccion" class="col-sm-2 control-label">Direccion</label>
                                                <div class="col-sm-6">
                                                    <input id="Direccion" type="text" class="form-control" placeholder="Resolución" required="">
                                                </div>
                                            </div>
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
                <!--end modal add domicilio  -->

                <!-- modal añadir telefono -->
                <div class="row">
                    <div class="modal fade" id="addTelefono">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Añadir Telefono
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Tipo" class="col-sm-2 control-label">Tipo</label>
                                                <div class="col-sm-4">
                                                    <select id="TipoCelular" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Direccion" class="col-sm-2 control-label">Numero</label>
                                                <div class="col-sm-4">
                                                    <input id="Direccion" type="text" class="form-control" placeholder="Ingrese su numero" required="">
                                                </div>
                                            </div>
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
                <!--end modal add telefono  -->

                <!-- modal añadir conyuge -->
                <div class="row">
                    <div class="modal fade" id="addConyuge">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Añadir Conyuge
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Conyuge" class="col-sm-3 control-label">Conyuge</label>
                                                <div class="col-sm-6">
                                                    <input id="Conyuge" type="text" class="form-control" placeholder="Nombre Conyuge" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Hijos" class="col-sm-3 control-label">Numero de hijos</label>
                                                <div class="col-sm-4">
                                                    <select id="Hijos" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
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
                <!--end modal add conyuge  -->

                <!-- modal añadir experiencia -->
                <div class="row">
                    <div class="modal fade" id="addExperiencia">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Añadir Experiencia
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Entidad" class="col-sm-4 control-label">Entidad</label>
                                                <div class="col-sm-6">
                                                    <input id="Entidad" type="text" class="form-control" placeholder="Entidad" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Experiencia" class="col-sm-4 control-label">Experiencia profesional</label>
                                                <div class="col-sm-6">
                                                    <input id="Experiencia" type="text" class="form-control" placeholder="Experiencia" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="FechaInicio" class="col-sm-4 control-label">Fecha de Inicio</label>
                                                <div class="col-sm-4">
                                                    <input id="FechaInicio" type="date" name="Nacimiento" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="FechaFin" class="col-sm-4 control-label">Fecha de Termino</label>
                                                <div class="col-sm-4">
                                                    <input id="FechaFin" type="date" name="Nacimiento" class="form-control" required="">
                                                </div>
                                            </div>
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
                <!--end modal add experiencia  -->

                <!-- modal añadir grados y estudios -->
                <div class="row">
                    <div class="modal fade" id="addGradosyEstudios">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Añadir Grados y Estudios
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Grado" class="col-sm-3 control-label">Grado</label>
                                                <div class="col-sm-3">
                                                    <select id="Grado" class="form-control">
                                                        <option value="J">Bachiller</option>
                                                        <option value="A">Certificación</option>
                                                        <option value="A">Diplomado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Materia" class="col-sm-3 control-label">Materia</label>
                                                <div class="col-sm-6">
                                                    <input id="Materia" type="text" class="form-control" placeholder="Materia" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Universidad" class="col-sm-3 control-label">Universidad</label>
                                                <div class="col-sm-6">
                                                    <select id="Universidad" class="form-control">
                                                        <option value="J">Pontifica Universidad La Catolica</option>
                                                        <option value="A">Univerisad Alas Peruana</option>
                                                        <option value="A">Universidad Cesar Vallejo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Fecha" class="col-sm-3 control-label">Fecha </label>
                                                <div class="col-sm-4">
                                                    <input id="Fecha" type="date" name="Nacimiento" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Direccion" class="col-sm-3 control-label">Direccion</label>
                                                <div class="col-sm-6">
                                                    <input id="Direccion" type="text" class="form-control" placeholder="Materia" required="">
                                                </div>
                                            </div>
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
                <!--end modal add grados y estudios  -->

                <!-- modal añadir correo y web -->
                <div class="row">
                    <div class="modal fade" id="addCorreoyWeb">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Añadir Correo y Web
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Tipo" class="col-sm-3 control-label">Tipo</label>
                                                <div class="col-sm-6">
                                                    <select id="Tipo" class="form-control">
                                                        <option value="J">Correo Electronico</option>
                                                        <option value="A">Pagina Web</option>
                                                        <option value="A">Otros</option>
                                                    </select>
                                                </div>
                                            </div>
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
                <!--end modal add correo y web  -->

                <div class="row">

                    <h4 style="padding-left:1em;"><i class="fa fa-user"></i> Actualizar Datos del Ingeniero(a) <span id="Load_date"></span></h4>
                    <div>
                        <form action="">

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="text-align: center; padding-top:1em;">
                                <img width="70" src="images/ayuda.png">
                                <!-- <label for="Foto">Subir foto</label>
                                <input type="file" id="Foto" name="Foto"> -->
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" style="padding-top:1em;">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="dni">DNI: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="dni" type="text" name="Dni" class="form-control" placeholder="DNI" required="" minlength="8" value="<?php echo  $_GET["idPersona"]; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="Nombres">Nombres: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="Nombres" type="text" name="Nombres" class="form-control" placeholder="Nombres" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="Apellidos">Apellidos: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="Apellidos" type="text" name="Apellidos" class="form-control" placeholder="Apellidos" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label for="Genero">Genero: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="Genero" class="form-control">
                                                <option value="M">Maculino</option>
                                                <option value="F">Femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label for="Nacimiento">Nacimiento: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="Nacimiento" type="date" name="Nacimiento" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
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
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="Ruc">RUC (opcional):</label>
                                            <input id="Ruc" type="text" name="Ruc" class="form-control" placeholder="número de RUC">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="Razon_social">Razon social (opcional):</label>
                                            <input id="Razon_social" type="text" name="Razon_social" class="form-control" placeholder="Razon social">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                        <div class="form-group">
                                            <label for="Codigo">Codigo CIP: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="Codigo" type="number" name="Codigo" class="form-control" placeholder="Codigo" required="">
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
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
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
                            <div class="modal-footer">
                                <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                <button type="button" class="btn btn-danger" name="btnAceptar" id="btnaceptar">
                                    <i class="fa fa-check"></i> Editar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" name="btncancelar" id="btncancelar">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </form>

                    </div>

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Colegiatura</a></li>
                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Domicilios</a></li>
                            <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Telefonos</a></li>
                            <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Conyuge</a></li>
                            <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">Experiencia</a></li>
                            <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false">Grados y Estudios</a></li>
                            <li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false">Correo y Web</a></li>
                            <li class=""><a href="#tab_8" data-toggle="tab" aria-expanded="false">Foto</a></li>
                            <li class="pull-right"><button class="btn btn-success btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Nuevo</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="col-md-12">
                                    <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
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
                                                <th>Principal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbColegiaturas">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                <div class="col-md-8">
                                    <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1; color: #B72928;">
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>Direccion</th>
                                                <th>Ubigeo</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbDomicilio">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_3">
                                <div class="col-md-4">
                                    <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1; color: #B72928;">
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>Numero</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbTelefono">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_4">
                                <div class="col-md-8">
                                    <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1; color: #B72928;">
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre Completo</th>
                                                <th>Hijos</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbConyuge">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_5">
                                <div class="col-md-8">
                                    <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1; color: #B72928;">
                                            <tr>
                                                <th>#</th>
                                                <th>Entidad</th>
                                                <th>Experiencia Profesional</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Fin</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbExperiencia">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_6">
                                <div class="col-md-8">
                                    <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1; color: #B72928;">
                                            <tr>
                                                <th>#</th>
                                                <th>Grado</th>
                                                <th>Materia</th>
                                                <th>Universidad</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbGradosyExperiencia">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_7">
                                <div class="col-md-8">
                                    <table class="table table-striped table-hover table-sm" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1; color: #B72928;">
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>Direccion</th>
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
        let spiner = $("#Load_date");

        let state = false;

        $(document).ready(function() {
            loadDataPersona($("#dni").val());

            $("#btnaceptar").click(function() {
                if (state) {
                    if ($("#dni").val() == '' || $("#dni").val().length < 8) {
                        tools.AlertWarning("Advertencia", "Ingrese un número de dni correcto por favor.");
                    } else if ($("#Nombres").val() == '') {
                        tools.AlertWarning("Advertencia", "Ingrese los nombres completos por favor.");
                    } else if ($("#Apellidos").val() == '') {
                        tools.AlertWarning("Advertencia", "Ingrese los apellidos completos por favor.");
                    } else if (!$('#Tramite').is(":checked") && $("#Codigo").val() == '' || !$('#Tramite').is(":checked") && $("#Codigo").val().length < 4) {
                        tools.AlertWarning("Advertencia", "Ingrese el número cip por favor.");
                    } else {
                        updatePersona($("#dni").val(), $("#Nombres").val(), $("#Apellidos").val(), $("#Genero")
                            .val(), $("#Nacimiento").val(), $("#Estado_civil").val(), $("#Ruc").val(), $(
                                "#Razon_social").val(), $("#Codigo").val(), $("#Condicion").val());
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

            $("#cbTramite").on("change", function() {
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



            $("#Departamento").change(function() {
                console.log($("#Departamento").val());
            });

            //carga las tablas inferiores
            loadColegiatura($("#dni").val());
            loadDomicilio($("#dni").val());
            loadTelefono($("#dni").val());
            loadConyuge($("#dni").val());
            loadExperiencia($("#dni").val());
            loadGradosyEstudios($("#dni").val());
            loadCorreoyWeb($("#dni").val());



        });

        function onCheked() {
            $("#checkkBoxId").attr("checked") ? alert("Checked") : alert("Unchecked");
        }

        function selectModal() {

            if ($("#tab_1").hasClass('active')) {
                $("#addColegiatura").modal("show");
                loadAddColegiatura();
            } else if ($("#tab_2").hasClass('active')) {
                $("#addDomicilio").modal("show");
                loadAddDomicilio();
            } else if ($("#tab_3").hasClass('active')) {
                $("#addTelefono").modal("show");
                loadAddCelular();
            } else if ($("#tab_4").hasClass('active')) {
                $("#addConyuge").modal("show");
                loadAddHijos();
            } else if ($("#tab_5").hasClass('active')) {
                $("#addExperiencia").modal("show");
            } else if ($("#tab_6").hasClass('active')) {
                $("#addGradosyEstudios").modal("show");
            } else if ($("#tab_7").hasClass('active')) {
                $("#addCorreoyWeb").modal("show");
            } else {

            }
            // data-toggle="modal" data-target="#mostrarHistorial"
        }

        function loadDataPersona(idPersona) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    "type": "data",
                    "dni": idPersona
                },
                beforeSend: function() {
                    spiner.append(
                        '<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>'
                    )
                },
                success: function(result) {
                    spiner.remove();
                    if (result.estado === 1) {
                        let persona = result.object;

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

        function updatePersona(idPersona, nombres, apellidos, sexo, nacimiento, estado_civil, ruc, rason_social, cip,
            condicion) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "update",
                    "dni": idPersona,
                    "nombres": nombres.toUpperCase(),
                    "apellidos": apellidos.toUpperCase(),
                    "sexo": sexo,
                    "nacimiento": nacimiento,
                    "estado_civil": estado_civil,
                    "ruc": ruc,
                    "rason_social": rason_social,
                    "cip": cip,
                    "condicion": condicion,
                },
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

        function loadColegiatura(idDni) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getcolegiatura",
                    idDni: idDni
                },
                beforeSend: function() {},
                success: function(result) {
                    for (let cv of result.data) {
                        $("#tbColegiaturas").append('<tr>' +
                            '<td>' + cv.Id + '</td>' +
                            '<td>' + cv.sede + '</td>' +
                            '<td>' + cv.capitulo + '</td>' +
                            '<td>' + cv.especialidad + '</td>' +
                            '<td>' + cv.fechaColegiado + '</td>' +
                            '<td>' + cv.universidadEgreso + '</td>' +
                            '<td>' + cv.fechaEgreso + '</td>' +
                            '<td>' + cv.universidadTitulacion + '</td>' +
                            '<td>' + cv.fechaTitulacion + '</td>' +
                            '<td>' + cv.resolucion + '</td>' +
                            '<td>' + cv.principal + '</td>' +
                            '</tr>');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadDomicilio(idDni) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getdomicilio",
                    idDni: idDni
                },
                beforeSend: function() {},
                success: function(result) {
                    for (let domicilio of result.data) {
                        $("#tbDomicilio").append('<tr>' +
                            '<td>' + domicilio.Id + '</td>' +
                            '<td>' + domicilio.tipo + '</td>' +
                            '<td>' + domicilio.direccion + '</td>' +
                            '<td>' + domicilio.ubigeo + '</td>' +
                            '</tr>');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }

        function loadTelefono(idDni) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "gettelefono",
                    idDni: idDni
                },
                beforeSend: function() {},
                success: function(result) {
                    for (let telefono of result.data) {
                        $("#tbTelefono").append('<tr>' +
                            '<td>' + telefono.Id + '</td>' +
                            '<td>' + telefono.tipo + '</td>' +
                            '<td>' + telefono.numero + '</td>' +
                            '</tr>');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadConyuge(idDni) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getconyuge",
                    idDni: idDni
                },
                beforeSend: function() {},
                success: function(result) {
                    for (let conyuge of result.data) {
                        $("#tbConyuge").append('<tr>' +
                            '<td>' + conyuge.Id + '</td>' +
                            '<td>' + conyuge.NombreCompleto + '</td>' +
                            '<td>' + conyuge.Hijos + '</td>' +
                            '</tr>');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadExperiencia(idDni) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getexperiencia",
                    idDni: idDni
                },
                beforeSend: function() {},
                success: function(result) {
                    for (let experiencia of result.data) {
                        $("#tbExperiencia").append('<tr>' +
                            '<td>' + experiencia.Id + '</td>' +
                            '<td>' + experiencia.Entidad + '</td>' +
                            '<td>' + experiencia.Experiencia + '</td>' +
                            '<td>' + experiencia.FechaInicio + '</td>' +
                            '<td>' + experiencia.FechaFin + '</td>' +
                            '</tr>');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadGradosyEstudios(idDni) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getgradosyestudios",
                    idDni: idDni
                },
                beforeSend: function() {},
                success: function(result) {
                    for (let gradosyestudios of result.data) {
                        $("#tbGradosyExperiencia").append('<tr>' +
                            '<td>' + gradosyestudios.Id + '</td>' +
                            '<td>' + gradosyestudios.Grado + '</td>' +
                            '<td>' + gradosyestudios.Materia + '</td>' +
                            '<td>' + gradosyestudios.Universidad + '</td>' +
                            '<td>' + gradosyestudios.Fecha + '</td>' +
                            '</tr>');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadCorreoyWeb(idDni) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getcorreoyweb",
                    idDni: idDni
                },
                beforeSend: function() {},
                success: function(result) {
                    for (let correoyweb of result.data) {
                        $("#tbGradosyWeb").append('<tr>' +
                            '<td>' + correoyweb.Id + '</td>' +
                            '<td>' + correoyweb.Tipo + '</td>' +
                            '<td>' + correoyweb.Direccion + '</td>' +
                            '</tr>');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadAddColegiatura() {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getaddcolegiatura",
                },
                beforeSend: function() {
                    $("#Sede").empty();
                    $("#Especialidad").empty();
                },
                success: function(result) {
                    if (result.estado == 1) {

                        $("#Sede").append('<option value="">- Seleccione -</option>');
                        for (let sede of result.sedes) {
                            $("#Sede").append('<option value="' + sede.IdConsejo + '">' + sede.Sede + '</option>');
                        }
                        $("#Especialidad").append('<option value="">- Seleccione -</option>');
                        for (let especialidad of result.espacialidades) {
                            $("#Especialidad").append('<option value="' + especialidad.IdEspecialidad + '">' + especialidad.Especialidad + '</option>');
                        }
                        $("#UniversidadEgreso").append('<option value="">- Seleccione -</option>');
                        for (let universidadegreso of result.universidades) {
                            $("#UniversidadEgreso").append('<option value="' + universidadegreso.IdUniversidad + '">' + universidadegreso.Universidad + '</option>');
                        }
                        $("#UniversidadTitulacion").append('<option value="">- Seleccione -</option>');
                        for (let universidadtitulacion of result.universidades) {
                            $("#UniversidadTitulacion").append('<option value="' + universidadtitulacion.IdUniversidad + '">' + universidadtitulacion.Universidad + '</option>');
                        }
                    } else {

                    }
                    console.log(result);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadAddDomicilio() {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getadddomicilio",
                },
                beforeSend: function() {
                    $("#Tipo").empty();
                    $("#Departamento").empty();
                },
                success: function(result) {


                    if (result.estado == 1) {
                        $("#Tipo").append('<option value="">- Seleccione -</option>');
                        for (let tipoDomicilio of result.tipodomicilio) {
                            $("#Tipo").append('<option value="' + tipoDomicilio.IdTipo + '">' + tipoDomicilio.Descripcion + '</option>');
                        }

                        let ubigeos = '';
                        for (let Departamento of result.ubicacion) {
                            ubigeos += '<option value="' + Departamento.IdUbicacion + '">' + Departamento.Ubicacion + '</option>';
                        }
                        $("#Departamento").html(ubigeos).selectpicker('refresh');
                    } else {

                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            });
        }

        function loadAddCelular() {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getaddcelular",
                },
                beforeSend: function() {
                    $("#TipoCelular").empty();
                },
                success: function(result) {
                    console.log(result);
                    if (result.estado == 1) {
                        $("#TipoCelular").append('<option value="">- Seleccione -</option>');
                        for (let tipoCelular of result.tipo) {
                            $("#TipoCelular").append('<option value="' + tipoCelular.IdTipo + '">' + tipoCelular.Tipo + '</option>');
                        }
                    } else {

                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadAddHijos() {
            $("#Hijos").append('<option value="">- Seleccione -</option>');
            for (let i = 1; i <= 7; i++) {
                if (i == 1) {
                    $("#Hijos").append('<option value="' + i + '">' + i + ' Hijo(a)' + '</option>');
                } else {
                    $("#Hijos").append('<option value="' + i + '">' + i + ' Hijos(as)' + '</option>');
                }
            }
        }

        function loadAddEstudios() {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "GET",
                data: {
                    type: "getaddestudios",
                },
                beforeSend: function() {
                    $("#TipoCelular").empty();
                },
                success: function(result) {
                    console.log(result);
                    if (result.estado == 1) {
                        $("#TipoCelular").append('<option value="">- Seleccione -</option>');
                        for (let tipoCelular of result.tipo) {
                            $("#TipoCelular").append('<option value="' + tipoCelular.IdTipo + '">' + tipoCelular.Tipo + '</option>');
                        }
                    } else {

                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
</body>

</html>

<?php
