function Estudios() {
    this.loadGradosyEstudios = function(idDni) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getgradosyestudios",
                idDni: idDni
            },
            beforeSend: function() {
                $("#tbGradosyExperiencia").empty();
                $("#tbGradosyExperiencia").append('<tr class="text-center"><td colspan="5"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tbGradosyExperiencia").empty();
                    if (result.data.length == 0) {
                        $("#tbGradosyExperiencia").append('<tr class="text-center"><td colspan="5"><p>No tiene registrado ningun grado o estudio.</p></td></tr>');
                    } else {
                        for (let gradosyestudios of result.data) {
                            $("#tbGradosyExperiencia").append('<tr>' +
                                '<td>' + gradosyestudios.Id + '</td>' +
                                '<td>' + gradosyestudios.Grado + '</td>' +
                                '<td>' + gradosyestudios.Materia + '</td>' +
                                '<td>' + gradosyestudios.Universidad + '</td>' +
                                '<td>' + gradosyestudios.Fecha + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbGradosyExperiencia").empty();
                    $("#tbGradosyExperiencia").append('<tr class="text-center"><td colspan="5"><p>' + result.message + '</p></td></tr>');
                }

            },
            error: function(error) {
                $("#tbGradosyExperiencia").empty();
                $("#tbGradosyExperiencia").append('<tr class="text-center"><td colspan="5"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddEstudios = function() {

        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getaddestudios",
            },
            beforeSend: function() {
                $("#selectGrado").empty();
                $("#selectUniversidad").empty();
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#selectGrado").append('<option value="">- Seleccione -</option>');
                    for (let grados of result.grados) {
                        $("#selectGrado").append('<option value="' + grados.IdGrado + '">' + grados.Grado + '</option>');
                    }
                    $("#selectUniversidad").append('<option value="">- Seleccione -</option>');
                    for (let universidades of result.universidades) {
                        $("#selectUniversidad").append('<option value="' + universidades.IdUniversidad + '">' + universidades.Universidad + '</option>');
                    }
                } else {
                    tools.AlertWarning("Estudios", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                tools.AlertError("Estudios", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudEstudios = function() {

        if ($("#selectGrado").val() == '') {
            tools.AlertWarning('Estudios', "Seleccione un grado");
            $("#selectGrado").focus();
        } else if ($("#txtMateria").val() == '') {
            tools.AlertWarning('Estudios', "Ingrese una materia valida");
            $("#txtMateria").focus();
        } else if ($("#selectUniversidad").val() == '') {
            tools.AlertWarning('Estudios', "Seleccione una universidad antes de continuar");
            $("#selectUniversidad").focus();
        } else if (!tools.validateDate($("#fechaEstudios").val())) {
            tools.AlertWarning('Estudios', "Ingrese una fecha valida");
            $("#fechaEstudios").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertEstudios",
                    "dni": $("#dni").val(),
                    "grado": $("#selectGrado").val(),
                    "materia": $("#txtMateria").val(),
                    "universidad": $("#selectUniversidad").val(),
                    "fechaEstudios": $("#fechaEstudios").val(),
                },
                beforeSend: function() {
                    tools.AlertInfo("Estudios", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        $("#addGradosyEstudios").modal("hide");
                        tools.AlertSuccess("Estudios", "Se registro correctamente.");
                    } else {
                        tools.AlertWarning("Estudios", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function(error) {
                    tools.AlertError("Experiencia", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}