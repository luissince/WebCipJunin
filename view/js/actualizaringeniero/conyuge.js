function Conyuge() {
    this.loadConyuge = function(idDni) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getconyuge",
                idDni: idDni
            },
            beforeSend: function() {
                $("#tbConyuge").empty();
                $("#tbConyuge").append('<tr class="text-center"><td colspan="3"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');

            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tbConyuge").empty();
                    if (result.data.length == 0) {
                        $("#tbConyuge").append('<tr class="text-center"><td colspan="3"><p>No tiene registrado ningun conyuge.</p></td></tr>');
                    } else {
                        for (let conyuge of result.data) {
                            $("#tbConyuge").append('<tr>' +
                                '<td>' + conyuge.Id + '</td>' +
                                '<td>' + conyuge.NombreCompleto + '</td>' +
                                '<td>' + conyuge.Hijos + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbConyuge").empty();
                    $("#tbConyuge").append('<tr class="text-center"><td colspan="3"><p>' + result.message + '</p></td></tr>');
                }
            },
            error: function(error) {
                $("#tbConyuge").empty();
                $("#tbConyuge").append('<tr class="text-center"><td colspan="3"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.crudConyuge = function() {

        if ($("#txtConyuge").val() == '') {
            tools.AlertWarning('Conyuge', "Ingrese nombre de un conyuge");
            $("#txtConyuge").focus();
        } else if (($("#txtHijos").val() == '') || ($("#txtHijos").val() <= 0)) {
            tools.AlertWarning('Conyuge', "Ingrese un numero de hijos valido");
            $("#txtHijos").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertConyuge",
                    "dni": $("#dni").val(),
                    "conyuge": $("#txtConyuge").val(),
                    "hijos": $("#txtHijos").val(),
                },
                beforeSend: function() {
                    tools.AlertInfo("Conyuge", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        $("#addConyuge").modal("hide");
                        tools.AlertSuccess("Conyuge", "Se registro correctamente.");
                    } else {
                        tools.AlertWarning("Conyuge", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function(error) {
                    tools.AlertError("Conyuge", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}