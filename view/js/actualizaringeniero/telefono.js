function Celular() {
    this.loadTelefono = function(idDni) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "gettelefono",
                idDni: idDni
            },
            beforeSend: function() {
                $("#tbTelefono").empty();
                $("#tbTelefono").append('<tr class="text-center"><td colspan="3"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tbTelefono").empty();
                    if (result.data.length == 0) {
                        $("#tbTelefono").append('<tr class="text-center"><td colspan="3"><p>No tiene registrado ningun telefono o celular.</p></td></tr>');
                    } else {
                        for (let telefono of result.data) {
                            $("#tbTelefono").append('<tr>' +
                                '<td>' + telefono.Id + '</td>' +
                                '<td>' + telefono.tipo + '</td>' +
                                '<td>' + telefono.numero + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbTelefono").empty();
                    $("#tbTelefono").append('<tr class="text-center"><td colspan="3"><p>' + result.message + '</p></td></tr>');
                }
            },
            error: function(error) {
                $("#tbTelefono").empty();
                $("#tbTelefono").append('<tr class="text-center"><td colspan="3"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddCelular = function() {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getaddcelular",
            },
            beforeSend: function() {
                $("#TipoCelular").empty();
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#TipoCelular").append('<option value="">- Seleccione -</option>');
                    for (let tipoCelular of result.tipo) {
                        $("#TipoCelular").append('<option value="' + tipoCelular.IdTipo + '">' + tipoCelular.Tipo + '</option>');
                    }
                } else {
                    tools.AlertWarning("telefono", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                tools.AlertError("telefono", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudCelular = function() {

        if ($("#TipoCelular").val() == '') {
            tools.AlertWarning('Celular', "Seleccione un tipo");
            $("#TipoCelular").focus();
        } else if ($("#txtNumero").val() == '') {
            tools.AlertWarning('Celular', "Ingrese un numero");
            $("#txtNumero").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertCelular",
                    "dni": $("#dni").val(),
                    "tipo": $("#TipoCelular").val(),
                    "numero": $("#txtNumero").val(),
                },
                beforeSend: function() {
                    tools.AlertInfo("telefono", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        $("#addTelefono").modal("hide");
                        tools.AlertSuccess("Celular", "Se registro correctamente.");
                    } else {
                        tools.AlertWarning("Domicilio", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function(error) {
                    tools.AlertError("Colegiatura", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}