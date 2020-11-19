function Otros() {
    this.componentesOtros = function() {
        $("#btnOtro").click(function() {
            $('#mdOtros').modal('show');
            loadOtros();
        });

        $("#btnOtro").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdOtros').modal('show');
                loadOtros();
            }
            event.preventDefault();
        });
        $("#btnAceptarOtros").click(function() {
            validateIngresoOtros();
        });

        $("#btnAceptarOtros").keypress(function(event) {
            var keycode = event.keyCode || event.which;
            if (keycode == '13') {
                validateIngresoOtros();
            }
            event.preventDefault();
        });
        $("#cbOtrosConcepto").change(function(event) {
            $("#txtMontoOtrosConceptos").val($("#cbOtrosConcepto").find('option:selected').attr('id'))
        });
    }

    function loadOtros() {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 100,
                "dni": "20707246",
            },
            beforeSend: function() {
                $("#cbOtrosConcepto").empty();
            },
            success: function(result) {
                if (result.estado === 1) {
                    $("#cbOtrosConcepto").append(' <option id="" value="">- Seleccione -</option>');
                    for (let value of result.data) {
                        $("#cbOtrosConcepto").append('<option id="' + value.Precio + '" value="' + value.IdConcepto + '">' + value.Concepto + ' (' + value.Precio + ')</option>');
                    }
                } else {

                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function validateIngresoOtros() {
        if ($("#cbOtrosConcepto").val() != "") {
            if ($("#txtCantidadOtrosConceptos").val() !== "") {
                if (!validateDuplicate($("#cbOtrosConcepto").val())) {
                    arrayIngresos.push({
                        "idConcepto": parseInt($("#cbOtrosConcepto").val()),
                        "categoria": 100,
                        "cantidad": parseFloat($('#txtCantidadOtrosConceptos').val()),
                        "concepto": $('#cbOtrosConcepto option:selected').html(),
                        "precio": parseFloat($("#cbOtrosConcepto").find('option:selected').attr('id')),
                        "monto": parseFloat($("#txtCantidadOtrosConceptos").val()) * parseFloat($("#cbOtrosConcepto").find('option:selected').attr('id'))
                    });
                    addIngresos();
                    $('#mdOtros').modal('hide');
                    $("#txtCantidadOtrosConceptos").val("1");
                    $("#txtMontoOtrosConceptos").val("");
                } else {
                    tools.AlertWarning("Ingresos Diversos", "Ya existe un concepto con los datos.")
                }
            } else {
                tools.AlertWarning("Ingresos Diversos", "Debe ingresar una cantidad mayor a cero")
            }
        } else {
            tools.AlertWarning("Ingresos Diversos", "Debe escoger un concepto")
        }
    }

    function validateDuplicate(idConcepto) {
        let ret = false;
        for (let i = 0; i < arrayIngresos.length; i++) {
            if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                ret = true;
                break;
            }
        }
        return ret;
    }

}