function Certificado() {
    this.componentesCertificado = function() {
        $("#btnCertHabilidad").click(function() {
            $('#mdCertHabilidad').modal('show');
        });

        $("#btnCertHabilidad").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdCertHabilidad').modal('show');
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
}