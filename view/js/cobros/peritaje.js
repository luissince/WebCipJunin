function Peritaje() {
    this.componentesPeritaje = function(addIngresos) {
        this.addIngresos = addIngresos;
        $("#btnPeritaje").click(function() {
            $('#mdPeritaje').modal('show');
            loadPeritaje();
        });

        $("#btnPeritaje").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdPeritaje').modal('show');
                loadPeritaje();
            }
            event.preventDefault();
        });

        $('#mdPeritaje').on('shown.bs.modal', function() {
            $('#txtDescripcionPeritaje').focus();
        });

        $("#btnAceptarPeritaje").click(function() {
            validateIngresoPeritaje();
        });

        $("#btnAceptarPeritaje").keypress(function(event) {
            if (event.keyCode === 13) {
                validateIngresoPeritaje();
            }
            event.preventDefault();
        });

        $("#btnClosePeritaje").click(function() {
            $('#mdPeritaje').modal('hide');
        });

        $("#btnClosePeritaje").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdPeritaje').modal('hide');
            }
            event.preventDefault();
        });

        $("#btnCancelarPeritaje").click(function() {
            $('#mdPeritaje').modal('hide');
        });

        $("#btnCancelarPeritaje").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdPeritaje').modal('hide');
            }
            event.preventDefault();
        });

        $("#txtDescripcionPeritaje").keydown(function(event) {
            if (event.keyCode === 13) {
                validateIngresoPeritaje();
            }
        });

        $("#txtMontoPeritaje").keydown(function(event) {
            if (event.keyCode === 13) {
                validateIngresoPeritaje();
            }
        });
    }

    function loadPeritaje() {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 8,
            },
            beforeSend: function() {

            },
            success: function(result) {
                console.log(result);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function validateIngresoPeritaje() {
        if ($("#txtDescripcionPeritaje").val().trim() == '') {
            tools.AlertWarning("Peritaje", "Ingrese una descripción del peritaje.");
            $("#txtDescripcionPeritaje").focus();
        } else if (!tools.isNumeric($("#txtMontoPeritaje").val())) {
            tools.AlertWarning("Peritaje", "Ingrese el monto del peritaje.");
            $("#txtMontoPeritaje").focus();
        } else {
            arrayIngresos.push({
                "idConcepto": parseInt($("#cbOtrosConcepto").val()),
                "categoria": 8,
                "cantidad": 1,
                "concepto": "Peritaje: " + $("#txtDescripcionPeritaje").val().trim(),
                "precio": parseFloat($("#txtMontoPeritaje").val()),
                "monto": parseFloat(1) * parseFloat($("#txtMontoPeritaje").val())
            });
            this.addIngresos();
            $("#txtDescripcionPeritaje").val("");
            $("#txtMontoPeritaje").val("");
            $('#mdPeritaje').modal('hide');
        }
    }

}