<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
?>

    <!DOCTYPE html>
    <html lang="es">

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
                            AlertWarning("Advertencia", "Ingrese un número de dni correcto por favor.");
                        } else if ($("#Nombres").val() == '') {
                            AlertWarning("Advertencia", "Ingrese los nombres completos por favor.");
                        } else if ($("#Apellidos").val() == '') {
                            AlertWarning("Advertencia", "Ingrese los apellidos completos por favor.");
                        } else if (!$('#Tramite').is(":checked") && $("#Codigo").val() == '' || !$('#Tramite').is(":checked") && $("#Codigo").val().length < 4) {
                            AlertWarning("Advertencia", "Ingrese el número cip por favor.");
                        } else {
                            updatePersona($("#dni").val(), $("#Nombres").val(), $("#Apellidos").val(), $("#Genero")
                                .val(), $("#Nacimiento").val(), $("#Estado_civil").val(), $("#Ruc").val(), $(
                                    "#Razon_social").val(), $("#Codigo").val(), $("#Condicion").val());
                        }
                    } else {
                        AlertWarning("Advertencia",
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

            });

            function onCheked() {
                $("#checkkBoxId").attr("checked") ? alert("Checked") : alert("Unchecked");
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
                            AlertInfo("Información", "Se cargo correctamente los datos.");
                            state = true;
                        } else {
                            AlertWarning("Advertencia", result.message);
                            state = false;
                        }
                    },
                    error: function(error) {
                        AlertError("Error", error);
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
                            AlertSuccess("Mensaje", "Se actualizaron correctamente los datos.")
                            setTimeout(function() {
                                location.href = "ingenieros.php"
                            }, 1000);
                        } else if (result.estado == 2) {
                            AlertWarning("Mensaje", result.message);
                            setTimeout(function() {
                                $("#btnaceptar").empty();
                                $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
                            }, 1000);
                        } else {
                            AlertWarning("Mensaje", result.message);
                            setTimeout(function() {
                                $("#btnaceptar").empty();
                                $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
                            }, 1000);
                        }
                    },
                    error: function(error) {
                        AlertError("Error", error.responseText);
                        $("#btnaceptar").empty();
                        $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
                    }
                });
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

<?php
}
