function Domicilio() {

    this.loadDomicilio = function(idDni) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getdomicilio",
                idDni: idDni
            },
            beforeSend: function() {
                $("#tbDomicilio").empty();
                $("#tbDomicilio").append('<tr class="text-center"><td colspan="4"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tbDomicilio").empty();
                    if (result.data.length == 0) {
                        $("#tbDomicilio").append('<tr class="text-center"><td colspan="4"><p>No tiene registrado ningun domicilio.</p></td></tr>');
                    } else {
                        for (let domicilio of result.data) {
                            $("#tbDomicilio").append('<tr>' +
                                '<td>' + domicilio.Id + '</td>' +
                                '<td>' + domicilio.tipo + '</td>' +
                                '<td>' + domicilio.direccion + '</td>' +
                                '<td>' + domicilio.ubigeo + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbDomicilio").empty();
                    $("#tbDomicilio").append('<tr class="text-center"><td colspan="4"><p>' + result.message + '</p></td></tr>');
                }

            },
            error: function(error) {
                $("#tbDomicilio").empty();
                $("#tbDomicilio").append('<tr class="text-center"><td colspan="4"><p>Se produjo un error interno, comuniquese con el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddDomicilio = function() {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getadddomicilio",
            },
            beforeSend: function() {
                $("#tipoDomicilio").empty();
                $("#Departamento").empty();
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tipoDomicilio").append('<option value="">- Seleccione -</option>');
                    for (let tipoDomicilio of result.tipodomicilio) {
                        $("#tipoDomicilio").append('<option value="' + tipoDomicilio.IdTipo + '">' + tipoDomicilio.Descripcion + '</option>');
                    }
                    $("#Departamento").append('<option value="">- Seleccione -</option>');
                    for (let Departamento of result.ubicacion) {
                        $("#Departamento").append('<option value="' + Departamento.IdUbicacion + '" selected="">' + Departamento.Ubicacion + '</option>');
                    }
                    $("#Departamento").selectpicker("refresh");
                } else {
                    tools.AlertWarning("domicilio", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                tools.AlertError("domicilio", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudDomicilio = function() {

        if ($("#tipoDomicilio").val() == '') {
            tools.AlertWarning('Domicilio', "Seleccione un tipo");
            $("#tipoDomicilio").focus();
        } else if ($("#Departamento").val() == '') {
            tools.AlertWarning('Domicilio', "Seleccione un departamento");
            $("#Departamento").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertDomicilio",
                    "dni": $("#dni").val(),
                    "tipo": $("#tipoDomicilio").val(),
                    "departamento": $('#Departamento').val(),
                    "direccion": $("#Direccion").val(),
                },
                beforeSend: function() {
                    tools.AlertInfo("Domicilio", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        $("#addDomicilio").modal("hide");
                        tools.AlertSuccess("Domicilio", "Se registro correctamente.");
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