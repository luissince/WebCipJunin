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

                <!-- modal start -->

                <div class="row">
                    <div class="modal fade" id="confirmar">
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
                                        <!--<input type="hidden" name="Usuario" value="{{ Auth::user()->id }}"> -->

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
                                            <div class="box-body no-padding">
                                                <div class="row">
                                                    <div class="col-md-8 text-left">
                                                        <p>Derecho de Colegiatura CD</p>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <p>350.00</panel>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8 text-left">
                                                        <p>Derecho de Colegiatura CD</p>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <p>350.00</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8 text-left">
                                                        <p>Derecho de Colegiatura CD</p>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <p>350.00</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8 text-left">
                                                        <p>Derecho de Colegiatura CD</p>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <p>350.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="dni">DNI: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="dni" type="number" name="Dni" class="form-control" placeholder="DNI" required="" maxlength="8" minlength="8">
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Nombres">Nombres: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="Nombres" type="text" name="Nombres" class="form-control" placeholder="Nombres" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Apellidos">Apellidos: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="Apellidos" type="text" name="Apellidos" class="form-control" placeholder="Apellidos" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Genero">Genero: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="Genero" class="form-control">
                                                        <option>Maculino</option>
                                                        <option>Femenino</option>
                                                        <option>Otros</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Nacimiento">Nacimiento: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="Nacimiento" type="date" name="Nacimiento" class="form-control" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Estado_civil">Estado civil: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Ruc">RUC (opcional):</label>
                                                    <input id="Ruc" type="text" name="Ruc" class="form-control" placeholder="número de RUC" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Apellidos">Razon social:</label>
                                                    <input id="Apellidos" type="text" name="Apellidos" class="form-control" placeholder="Apellidos" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="Codigo">Codigo CIP: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="Codigo" type="number" name="Codigo" class="form-control" placeholder="Codigo" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="Condición">Condición: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="Condición" class="form-control">
                                                        <option>Vitalicio</option>
                                                        <option>Otros</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="Condición">Nuevo </label>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> Tramite
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  -->
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
                                                    <span>0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning" name="btnAceptar" id="btnaceptar">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal end -->

                <!-- <div class="row"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"> <i class="fa fa-money"></i> Generar cobro</div>
                            <div class="panel-body">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmar">
                                    <i class="fa fa-plus"></i> Colegiatura
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal">
                                    <i class="fa fa-plus"></i> Cuotas
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal">
                                    <i class="fa fa-plus"></i> Certificado
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal">
                                    <i class="fa fa-plus"></i> Peritaje
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal">
                                    <i class="fa fa-plus"></i> Otros
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Título del panel con estilo h3</h3>
                            </div>
                            <div class="panel-body">
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
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Título del panel con estilo h3</h3>
                            </div>

                            <div class="panel-body">
                                <div>
                                    <div>COBRAR</div>
                                    <div>IMPORTE TOTAL</div>
                                    <div>S/ 0.00</div>
                                </div>
                                <div>
                                    <div>Comprobante</div>
                                    <div>
                                        <span>B001</span>
                                        <span>0000000</span>
                                    </div>
                                </div>
                                <div>
                                    <div>Colegiado</div>
                                    <div>N° Documento</div>
                                    <div>N° Cip</div>
                                    <div>Nombre/Razón Social</div>
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
    <script>
        $(document).ready(function() {

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

            toastr["success"]("asd", "asd");

        });
    </script>
</body>

</html>