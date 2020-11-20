function Experiencia() {

    this.loadExperiencia = function(idDni) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getexperiencia",
                idDni: idDni
            },
            beforeSend: function() {
                $("#tbExperiencia").empty();
                $("#tbExperiencia").append('<tr class="text-center"><td colspan="5"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tbExperiencia").empty();
                    if (result.data.length == 0) {
                        $("#tbExperiencia").append('<tr class="text-center"><td colspan="5"><p>No tiene registrado ningun conyuge.</p></td></tr>');
                    } else {
                        for (let experiencia of result.data) {
                            $("#tbExperiencia").append('<tr>' +
                                '<td>' + experiencia.Id + '</td>' +
                                '<td>' + experiencia.Entidad + '</td>' +
                                '<td>' + experiencia.Experiencia + '</td>' +
                                '<td>' + experiencia.FechaInicio + '</td>' +
                                '<td>' + experiencia.FechaFin + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbExperiencia").empty();
                    $("#tbExperiencia").append('<tr class="text-center"><td colspan="5"><p>' + result.message + '</p></td></tr>');
                }
            },
            error: function(error) {
                $("#tbExperiencia").empty();
                $("#tbExperiencia").append('<tr class="text-center"><td colspan="5"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.crudExperiencia = function() {

        if ($("#txtEntidad").val() == '') {
            tools.AlertWarning('Experiencia', "Ingrese una entidad valida");
            $("#txtEntidad").focus();
        } else if ($("#txtExperiencia").val() == '') {
            tools.AlertWarning('Experiencia', "Ingrese una experiencia valida");
            $("#txtExperiencia").focus();
        } else if (!tools.validateDate($("#FechaInicio").val())) {
            tools.AlertWarning('Experiencia', "Ingrese una fecha de inicio valida");
            $("#FechaInicio").focus();
        } else if (!tools.validateDate($("#FechaFin").val())) {
            tools.AlertWarning('Experiencia', "Ingrese una fecha de fin valida");
            $("#FechaFin").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertExperiencia",
                    "dni": $("#dni").val(),
                    "entidad": $("#txtEntidad").val(),
                    "experiencia": $("#txtExperiencia").val(),
                    "fechaInicio": $("#FechaInicio").val(),
                    "fechaFin": $("#FechaFin").val(),
                },
                beforeSend: function() {
                    tools.AlertInfo("Experiencia", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        $("#addExperiencia").modal("hide");
                        tools.AlertSuccess("Experiencia", "Se registro correctamente.");
                    } else {
                        tools.AlertWarning("Experiencia", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function(error) {
                    tools.AlertError("Experiencia", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}