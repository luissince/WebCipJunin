function Certificado() {
    this.componentesCertificado = function() {
        $("#btnCertHabilidad").click(function() {
            $('#mdCertHabilidad').modal('show');
            loadCertificadoHabilidad();
        });

        $("#btnCertHabilidad").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdCertHabilidad').modal('show');
                loadCertificadoHabilidad();
            }
            event.preventDefault();
        });

        $("#btnCertProyecto").click(function() {
            $('#mdCertProyecto').modal('show');
        });

        $("#btnCertProyecto").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdCertProyecto').modal('show');
            }
            event.preventDefault();
        });

        $("#btnCertResidenciaObra").click(function() {
            $('#mdCertResidenciaObra').modal('show');
        });

        $("#btnCertResidenciaObra").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdCertResidenciaObra').modal('show');
            }
            event.preventDefault();
        });
    }

    function loadCertificadoHabilidad() {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 5,
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

}