function CorreoyWeb() {
    this.loadCorreoyWeb = function(idDni) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getcorreoyweb",
                idDni: idDni
            },
            beforeSend: function() {
                $("#tbGradosyWeb").empty();
                $("#tbGradosyWeb").append('<tr class="text-center"><td colspan="3"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tbGradosyWeb").empty();
                    if (result.data.length == 0) {
                        $("#tbGradosyWeb").append('<tr class="text-center"><td colspan="3"><p>No tiene registrado ningun correo o sitio web.</p></td></tr>');
                    } else {
                        for (let correoyweb of result.data) {
                            $("#tbGradosyWeb").append('<tr>' +
                                '<td>' + correoyweb.Id + '</td>' +
                                '<td>' + correoyweb.Tipo + '</td>' +
                                '<td>' + correoyweb.Direccion + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbGradosyWeb").empty();
                    $("#tbGradosyWeb").append('<tr class="text-center"><td colspan="3"><p>' + result.message + '</p></td></tr>');
                }

            },
            error: function(error) {
                $("#tbGradosyWeb").empty();
                $("#tbGradosyWeb").append('<tr class="text-center"><td colspan="3"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddCorreoyWeb = function() {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getaddcorreo",
            },
            beforeSend: function() {
                $("#TipoCorreo").empty();
            },
            success: function(result) {
                console.log(result);
                if (result.estado == 1) {
                    $("#TipoCorreo").append('<option value="">- Seleccione -</option>');
                    for (let tipoCorreo of result.correos) {
                        $("#TipoCorreo").append('<option value="' + tipoCorreo.IdCorreo + '">' + tipoCorreo.Correoyweb + '</option>');
                    }
                } else {
                    tools.AlertWarning("Correo", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                tools.AlertError("Correo", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudCorreo = function() {

        if ($("#TipoCorreo").val() == '') {
            tools.AlertWarning('Correo', "Seleccione un tipo");
            $("#TipoCorreo").focus();
        } else if ($("#txtCorreo").val() == '') {
            tools.AlertWarning('Correo', "Ingrese un correo o web");
            $("#txtCorreo").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertCorreo",
                    "dni": $("#dni").val(),
                    "tipo": $("#TipoCorreo").val(),
                    "correo": $("#txtCorreo").val(),
                },
                beforeSend: function() {
                    tools.AlertInfo("Correo", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        $("#addCorreoyWeb").modal("hide");
                        tools.AlertSuccess("Correo", "Se registro correctamente.");
                    } else {
                        tools.AlertWarning("Correo", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function(error) {
                    tools.AlertError("Correo", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}