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

                <div class="row">
                    
                    <h4 style="padding-left:1em;"><i class="fa fa-user"></i> Actualizar Datos del Ingeniero(a)</h4>
                    <div>
                        <form action="">
                            
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="text-align: center; padding-top:1em;">
                                <img width="70" src="images/ayuda.png">
                                
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" style="padding-top:1em;">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="dni">DNI: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="dni" type="number" name="Dni" class="form-control" placeholder="DNI"
                                                required="" maxlength="8" minlength="8">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="Nombres">Nombres: <i
                                                    class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="Nombres" type="text" name="Nombres" class="form-control"
                                                placeholder="Nombres" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="Apellidos">Apellidos: <i
                                                    class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="Apellidos" type="text" name="Apellidos" class="form-control"
                                                placeholder="Apellidos" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label for="Genero">Genero: <i
                                                    class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="Genero" class="form-control">
                                                <option>Maculino</option>
                                                <option>Femenino</option>
                                                <option>Otros</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label for="Nacimiento">Nacimiento: <i
                                                    class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="Nacimiento" type="date" name="Nacimiento" class="form-control"
                                                required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label for="Estado_civil">Estado civil: <i
                                                    class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="Estado_civil" class="form-control">
                                                <option>Soltero/a</option>
                                                <option>Casado/a</option>
                                                <option>Viudo/a</option>
                                                <option>Divorciado/a</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="Ruc">RUC (opcional):</label>
                                            <input id="Ruc" type="text" name="Ruc" class="form-control"
                                                placeholder="número de RUC" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="Apellidos">Razon social:</label>
                                            <input id="Apellidos" type="text" name="Apellidos" class="form-control"
                                                placeholder="Apellidos" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                        <div class="form-group">
                                            <label for="Codigo">Codigo CIP: <i
                                                    class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="Codigo" type="number" name="Codigo" class="form-control"
                                                placeholder="Codigo" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                        <div class="form-group">
                                            <label for="Condición">Condición: <i
                                                    class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="Condición" class="form-control">
                                                <option>Vitalicio</option>
                                                <option>Otros</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <div class="form-group">
                                            <label for="Tramite">Tramite:</label>
                                            <div class="text-center">
                                                <input id="Tramite" type="checkbox" name="tramite" value="true" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <p class="text-left text-danger">Todos los campos marcados con <i
                                        class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                <button type="submit" class="btn btn-danger" name="btnAceptar" id="btnaceptar">
                                    <i class="fa fa-check"></i> Editar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </form>
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
</body>

</html>