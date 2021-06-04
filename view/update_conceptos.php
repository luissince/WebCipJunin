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
            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <section class="content">

                    <div class="row">

                        <h4 style="padding-left:1em;"><i class="fa fa-list-alt"></i> Actualizar Datos del Concepto <span id="Load_date"></span></h4>
                        <div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:1em;">

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="categoria">Categoria: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="categoria" class="form-control">
                                                <option value="0">- - Seleccione - -</option>
                                                <option value="1">Cuota ordinaria</option>
                                                <option value="2">Cuota ordinaria (Admistia)</option>
                                                <option value="3">Cuota ordinaria (Vitalicio)</option>
                                                <option value="12">Cuota ordinaria (Resolución 15)</option>
                                                <option value="4">Colegiatura</option>
                                                <option value="9">Colegiatura otras modalidades</option>
                                                <option value="10">Colegiatura por tesis local</option>
                                                <option value="11">Colegiatura por tesis externa</option>
                                                <option value="5">Certificado de habilidad</option>
                                                <option value="6">Certificado de residencia de obra</option>
                                                <option value="7">Certificado de Proyecto</option>
                                                <option value="8">Peritaje</option>
                                                <option value="100">Ingresos Diversos</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="codigo">Codigo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="codigo" type="text" name="codigo" class="form-control" placeholder="Codigo del concepto" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="concepto">Concepto: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="concepto" type="text" name="concepto" class="form-control" placeholder="Nombre del concepto" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="precio">Precio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="precio" type="number" name="precio" class="form-control" placeholder="Monto del concepto" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fecha_inicio">Fecha Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="fecha_inicio" type="date" name="fecha_inicio" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fecha_fin">Fecha Fin: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="fecha_fin" type="date" name="fecha_fin" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Referido a: <i class="fa fa-fw fa-asterisk text-danger"></i></p>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="rbJunin" name="referido" value="" checked="checked">
                                            <label for="rbJunin">CIP Junin</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="rbNacional" name="referido" value="1">
                                            <label for="rbNacional">CIP Nacional</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Agrege especificaciones: <i class="fa fa-fw fa-asterisk text-danger"></i></p>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="precio_ordinario" name="espesifico" value="0" checked="checked">
                                            <label for="precio_ordinario">Precio Ordinario</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="precio_transeunte" name="espesifico" value="1">
                                            <label for="precio_transeunte">Precio para Transeunte</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="precio_vitalicio" name="espesifico" value="2">
                                            <label for="precio_vitalicio">Precio para Vitalicio</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="precio_variable" name="espesifico" value="128">
                                            <label for="precio_variable">Precio Variable</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Estado: <i class="fa fa-fw fa-asterisk text-danger"></i></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" id="estado">
                                            <label for="estado" id="lblEstado">Inactivo</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                        <button type="button" class="btn btn-danger" name="btnAceptar" id="btnaceptar">
                                            <i class="fa fa-check"></i> Editar</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" name="btncancelar" id="btncancelar">
                                            <i class="fa fa-remove"></i> Cancelar</button>
                                    </div>
                                </div>

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
            let spiner = $("#Load_date");
            let state = false;

            let idConcepto = "<?php echo  $_GET["idConcepto"]; ?>";

            $(document).ready(function() {

                loadDataConcepto(idConcepto)


                $("#btnaceptar").click(function() {
                    validateUpdateConcepto();
                });

                $("#btnaceptar").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        validateUpdateConcepto();
                    }
                    event.preventDefault();
                });

                $("#btncancelar").click(function() {
                    location.href = "conceptos.php"
                });

                $("#btncancelar").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        location.href = "conceptos.php"
                    }
                    event.preventDefault();
                });

                $("#estado").change(function() {
                    $("#lblEstado").html($("#estado").is(":checked") ? "Activo" : "Inactivo");
                });

            });

            function loadDataConcepto(idConcepto) {
                $.ajax({
                    url: "../app/controller/ConceptoController.php",
                    method: "GET",
                    data: {
                        "type": "data",
                        "idConcepto": idConcepto
                    },
                    beforeSend: function() {
                        spiner.append(
                            '<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>'
                        )
                    },
                    success: function(result) {
                        spiner.remove()
                        if (result.estado === 1) {
                            console.log(result)
                            let concepto = result.object;
                            switch (concepto.Categoria) {
                                case "1":
                                    $("#categoria").val("1")
                                    break
                                case "2":
                                    $("#categoria").val("2")
                                    break
                                case "3":
                                    $("#categoria").val("3")
                                    break
                                case "4":
                                    $("#categoria").val("4")
                                    break
                                case "5":
                                    $("#categoria").val("5")
                                    break
                                case "6":
                                    $("#categoria").val("6")
                                    break
                                case "7":
                                    $("#categoria").val("7")
                                    break
                                case "8":
                                    $("#categoria").val("8")
                                    break
                                case "9":
                                    $("#categoria").val("9")
                                    break
                                case "10":
                                    $("#categoria").val("10")
                                    break
                                case "11":
                                    $("#categoria").val("11")
                                    break
                                case "12":
                                    $("#categoria").val("12")
                                    break
                                case "100":
                                    $("#categoria").val("100")
                                    break
                                default:
                            }

                            $("#codigo").val(concepto.Codigo)
                            $("#concepto").val(concepto.Concepto)
                            $("#precio").val(concepto.Precio)
                            let fInicio = concepto.Inicio.split("/").reverse().join("-");
                            let fFinal = concepto.Fin.split("/").reverse().join("-");
                            document.getElementById("fecha_inicio").value = tools.getDateForma(fInicio, 'yyyy-mm-dd');
                            document.getElementById("fecha_fin").value = tools.getDateForma(fFinal, 'yyyy-mm-dd');

                            if (concepto.Asignado == "0") {
                                $("#precio_ordinario").prop("checked", true);
                            } else if (concepto.Asignado == "1") {
                                $("#precio_transeunte").prop("checked", true);
                            } else if (concepto.Asignado == "2") {
                                $("#precio_vitalicio").prop("checked", true);
                            } else if (concepto.Asignado == "3") {
                                $("#precio_variable").prop("checked", true);
                            }

                            if (concepto.Propiedad == 0) {
                                $("#rbJunin").prop("checked", true);
                            } else {
                                $("#rbNacional").prop("checked", true);
                            }

                            $("#estado").prop("checked", concepto.Estado == 0 ? false : true);
                            $("#lblEstado").html($("#estado").is(":checked") ? "Activo" : "Inactivo");
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

            function validateUpdateConcepto() {
                if (state) {
                    updateConcepto();
                } else {
                    tools.AlertWarning("Advertencia",
                        "Nose pudo cargar los datos correctamente, recargue la pantalla por favor.");
                }
            }

            function updateConcepto() {
                if ($("#categoria").val() == "0") {
                    tools.AlertWarning("Advertencia", "Seleccione la categoría del concepto.");
                } else if ($("#concepto").val() == '' || $("#concepto").val().length < 2) {
                    tools.AlertWarning("Advertencia", "Ingrese el nombre del concepto.");
                } else if ($("#precio").val() == '' || $("#precio").val().length == 0) {
                    tools.AlertWarning("Advertencia", "Ingrese el precio del concepto.");
                } else if ($("#fecha_inicio").val() == '') {
                    tools.AlertWarning("Advertencia", "Seleccione la fecha de inicio.");
                } else if ($("#fecha_inicio").val() == '') {
                    tools.AlertWarning("Advertencia", "Seleccione la fecha de fin.");
                } else {
                    tools.ModalDialog("Conceptos", "¿Está seguro de continuar?", function(value) {
                        if (value == true) {
                            $.ajax({
                                url: "../app/controller/ConceptoController.php",
                                method: "POST",
                                data: {
                                    "type": "update",
                                    "IdConcepto": idConcepto,
                                    "Categoria": $("#categoria").val(),
                                    "Concepto": $("#concepto").val(),
                                    "Precio": $("#precio").val(),
                                    "Propiedad": $("#rbJunin").is(":checked") ? 0 : 48,
                                    "Inicio": $("#fecha_inicio").val(),
                                    "Fin": $("#fecha_inicio").val(),
                                    "Observacion": "",
                                    "Codigo": $("#codigo").val(),
                                    "Estado": $("#estado").is(":checked"),
                                    "Asignado": $("#precio_ordinario").is(":checked") ? 0 : $("#precio_transeunte").is(":checked") ? 1 : $("#precio_vitalicio").is(":checked") ? 2 : 3,
                                },
                                beforeEnd: function() {
                                    $("#btnaceptar").empty();
                                    $("#btnaceptar").append('<img src="./images/spiner.gif" width="25" height="25" />')
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.AlertSuccess("Mensaje", result.message)
                                        setTimeout(function() {
                                            location.href = "conceptos.php"
                                        }, 1000);
                                    } else {
                                        tools.AlertWarning("Mensaje", result.message)
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
                    });
                }
            }
        </script>
    </body>

    </html>
<?php }
