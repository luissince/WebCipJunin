function Colegiatura() {

    this.loadColegiatura = function(idDni) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getcolegiatura",
                idDni: idDni
            },
            beforeSend: function() {
                $("#tbColegiaturas").empty();
                $("#tbColegiaturas").append('<tr class="text-center"><td colspan="11"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tbColegiaturas").empty();
                    if (result.data.length == 0) {
                        $("#tbColegiaturas").append('<tr class="text-center"><td colspan="11"><p>No tiene registrado ninguna colegiatura.</p></td></tr>');
                    } else {
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
                    }
                } else {
                    $("#tbColegiaturas").empty();
                    $("#tbColegiaturas").append('<tr class="text-center"><td colspan="11"><p>' + result.message + '</p></td></tr>');
                }
            },
            error: function(error) {
                $("#tbColegiaturas").empty();
                $("#tbColegiaturas").append('<tr class="text-center"><td colspan="11"><p>Se produjo un error interno, comuniquese con el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddColegiatura = function() {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getaddcolegiatura",
            },
            beforeSend: function() {
                $("#Sede").empty();
                $("#Especialidad").empty();
                $("#UniversidadEgreso").empty();
                $("#UniversidadTitulacion").empty();
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
                    tools.AlertWarning("colegiatura", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                tools.AlertError("colegiatura", "Error Fatal: Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudColegiatura = function() {
        if ($("#Sede").val() == '') {
            tools.AlertWarning('Colegiatura', "Seleccione una sede");
            $("#Sede").focus();
        } else if ($("#Especialidad").val() == '') {
            tools.AlertWarning('Colegiatura', "Seleccione una especialidad");
            $("#Especialidad").focus();
        } else if (!tools.validateDate($("#FechaColegiacion").val())) {
            tools.AlertWarning('Colegiatura', "Ingrese la fecha de colegiatura");
            $("#FechaColegiacion").focus();
        } else if ($("#UniversidadEgreso").val() == '') {
            tools.AlertWarning('Colegiatura', "Seleccione una universidad de egreso");
            $("#UniversidadEgreso").focus();
        } else if (!tools.validateDate($("#FechaEgreso").val())) {
            tools.AlertWarning('Colegiatura', "Ingree la fecha de egreso");
            $("#FechaEgreso").focus();
        } else if ($("#UniversidadTitulacion").val() == '') {
            tools.AlertWarning('Colegiatura', "Seleccione una universidad de titulacion");
            $("#UniversidadTitulacion").focus();
        } else if (!tools.validateDate($("#FechaTitulo").val())) {
            tools.AlertWarning('Colegiatura', "Ingrese una fecha de titulacion");
            $("#FechaTitulo").focus();
        } else if ($("#txtResolucion").val() == '') {
            tools.AlertWarning('Colegiatura', "Ingrese una resolucion valida");
            $("#txtResolucion").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertColegiatura",
                    "dni": $("#dni").val(),
                    "sede": $("#Sede").val(),
                    "principal": $('#Principal').is(":checked"),
                    "especialidad": $("#Especialidad").val(),
                    "fechacolegiacion": $("#FechaColegiacion").val(),
                    "universidadegreso": $("#UniversidadEgreso").val(),
                    "fechaegreso": $("#FechaEgreso").val(),
                    "universidadtitulacion": $("#UniversidadTitulacion").val(),
                    "fechatitulo": $("#FechaTitulo").val(),
                    "resolucion": $("#txtResolucion").val(),
                },
                beforeSend: function() {
                    tools.AlertInfo("Colegiatura", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        $("#addColegiatura").modal("hide");
                        tools.AlertSuccess("Colegiatura", "Se registro correctamente.");
                    } else {
                        tools.AlertWarning("Colegiatura", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function(error) {
                    tools.AlertError("Colegiatura", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }

}