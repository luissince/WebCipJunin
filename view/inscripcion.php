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

            <!-- modal añadir  -->
            <div class="row">
                <div class="modal fade" id="mdInscripcion" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title" id="titleModal">
                                    <i class="fa fa-book">
                                    </i> Nuevo Inscripción
                                </h4>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Ingeniero(a) <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select class="form-control select2" id="cbIngeniero" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Monto <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="txtCurso" type="text" class="form-control" placeholder="Ingrese el nombre del curso" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptar">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal añadir -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content-header">
                    <h3 class="no-margin"> Inscripción <small>LISTA</small> </h3>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
                        <li class="active">Inscripción</li>
                    </ol>
                </section>

                <section class="invoice">
                    <div class="box box-default not-border not-box-shadow">
                        <div class="box-body">

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Curso: <strong class="text-primary" id="lblCurso"></strong></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Capitulo: <strong class="text-primary" id="lblCapitulo"></strong></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Precio Curso: <strong class="text-primary" id="lblPrecioCurso"></strong></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Precio Certificado: <strong class="text-primary" id="lblPrecioCertificado"></strong></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Fecha Inicio: <strong class="text-primary" id="lblFechaInicio"></strong></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Hora Inicio: <strong class="text-primary" id="lblHoraInicio"></strong></label>
                                </div>
                            </div>

                            <br />

                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label>Nueva incripción.</label>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success" id="btnNuevo">
                                            <i class="fa fa-plus"></i> Agregar incripción
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label>Opción.</label>
                                    <div class="form-group">
                                        <button class="btn btn-default" id="btnActualizar">
                                            <i class="fa fa-refresh"></i> Recargar
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Filtrar por dni o apellidos.</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="search" id="buscar" class="form-control" placeholder="Escribe y presiona enter para filtrar" aria-describedby="search" value="">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-primary" id="btnSearch">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                            <thead style="background-color: #FDB2B1;color: #B72928;">
                                                <th width="5%" class="text-center">#</th>
                                                <th width="20%">Curso</th>
                                                <th width="20%">Organizador</th>
                                                <th width="10%">Capitulo</th>
                                                <th width="15%">Fecha/Hora</th>
                                                <th width="10%">Estado</th>
                                                <th width="10%" class="text-center">Inscripción</th>
                                                <th width="5%" class="text-center">Editar</th>
                                                <th width="5%" class="text-center">Eliminar</th>
                                            </thead>
                                            <tbody id="tbTable">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12" style="text-align:center;">
                                        <ul class="pagination">
                                            <li>
                                                <button class="btn btn-primary" id="btnIzquierda">
                                                    <i class="fa fa-toggle-left"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <span id="lblPaginaActual" class="font-weight-bold">0</span>
                                            </li>
                                            <li><span>a</span></li>
                                            <li>
                                                <span id="lblPaginaSiguiente" class="font-weight-bold">0</span>
                                            </li>
                                            <li>
                                                <button class="btn btn-primary" id="btnDerecha">
                                                    <i class="fa fa-toggle-right"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div id="divLoad" class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
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
        <script src="js/tools.js"></script>
        <script>
            let tools = new Tools();
            let state = false;
            let opcion = 0;
            let totalPaginacion = 0;
            let paginacion = 0;
            let filasPorPagina = 10;
            let tbTable = $("#tbTable");

            let idUsuario = <?= $_SESSION['IdUsuario'] ?>;
            let idCurso = <?= $_GET['idCurso'] ?>

            $(document).ready(function() {

                $("#btnNuevo").click(function() {
                    $("#mdInscripcion").modal('show');
                });

                $("#btnNuevo").keyup(function(event) {
                    if (event.keyCode == 13) {
                        $("#mdInscripcion").modal('show');
                        event.preventDefault();
                    }
                });

                $("#btnAceptar").click(function(event) {
                    onEventGuardar();
                });

                $("#btnAceptar").keyup(function(event) {
                    if (event.keyCode == 13) {
                        onEventGuardar();
                        event.preventDefault();
                    }
                });

                $('#cbIngeniero').select2({
                    placeholder: "Buscar Ingeniero",
                    width: '100%',
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

                loadInit();
            });

            async function loadInit() {
                try {
                    const result = await axios.get("../app/web/CursoWeb.php", {
                        params: {
                            "type": "id",
                            "idCurso": idCurso
                        }
                    });

                    $("#lblCurso").html(result.data.Descripcion);
                    $("#lblCapitulo").html(result.data.Capitulo);
                    $("#lblPrecioCurso").html("S/ " + result.data.PrecioCurso);
                    $("#lblPrecioCertificado").html("S/ " + result.data.PrecioCertificado);
                    $("#lblFechaInicio").html(tools.getDateForma(result.data.FechaInicio));
                    $("#lblHoraInicio").html(tools.getTimeForma(result.data.HoraInicio));

                    $("#divLoad").removeClass("overlay");
                    $("#divLoad").html("");
                } catch (error) {

                }
            }

            async function onEventGuardar(){
                console.log($("#cbIngeniero").val())
            }
        </script>
    </body>

    </html>
<?php }
