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
                                            <div class="box-body no-padding" id="ctnConceptos">
                                                <!-- <div class="row">
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
                                                </div> -->
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
                                        <button type="button" class="btn btn-success">
                                            <i class="fa fa-plus"></i> Normal
                                        </button>
                                        <button type="button" class="btn btn-success">
                                            <i class="fa fa-plus"></i> Amnistia
                                        </button>
                                        <button type="button" class="btn btn-success">
                                            <i class="fa fa-plus"></i> Vitalicio
                                        </button>
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
                                        <p>
                                            <button id="btnColegitura" type="button" class="btn btn-primary" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Colegiatura
                                            </button>
                                            <button id="btnCuotas" type="button" class="btn btn-primary" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Cuotas
                                            </button>
                                            <button id="btnCertificado" type="button" class="btn btn-primary" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Certificado
                                            </button>
                                            <button id="btnPeritaje" type="button" class="btn btn-primary" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Peritaje
                                            </button>
                                            <button id="btnOtro" type="button" class="btn btn-primary" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Otros
                                            </button>
                                        </p>
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
            });

            $("#btnCuotas").on("keyup", function() {
                if (event.keyCode === 13) {
                    $('#mdCuotas').modal('show');
                }
            });

        });

        function loadColegiatura() {
            $.ajax({
                url: "../app/controller/ConceptoController.php",
                method: "GET",
                data: {
                    "type": "typecolegiatura",
                },
                beforeEnd: function() {
                    $("#ctnConceptos").empty();

                },
                success: function(result) {
                    if (result.estado === 1) {
                        let total = 0;
                        for (let value of result.data) {
                            $("#ctnConceptos").append('<div id="' + value.idConcepto + '" class="row">' +
                                '<div class="col-md-8 text-left">' +
                                '<p>' + value.Concepto + '</p>' +
                                '</div>' +
                                '<div class="col-md-4 text-right">' +
                                '<p>' + value.Precio + '</panel>' +
                                '</div>');
                            total += parseFloat(value.Precio);
                        }
                        $("#lblTotal").html(tools.formatMoney(total));
                    } else {

                    }
                },
                error: function(error) {

                }
            });
        }

        function loadCuotas() {

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