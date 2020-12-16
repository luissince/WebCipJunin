function Certificado() {
    this.componentesCertificado = function() {
        $("#btnCertificado").click(function() {
            if (idDNI == 0) {
                tools.AlertWarning("Certificado", "No selecciono ningún ingeniero para obtener sus cuotas.")
            } else {
                $("#btnCertHabilidad").click(function() {
                    $('#mdCertHabilidad').modal('show');
                    loadCertificadoHabilidad(idDNI);
                });
        
                $("#btnCertHabilidad").keypress(function(event) {
                    if (event.keyCode === 13) {
                        $('#mdCertHabilidad').modal('show');
                        loadCertificadoHabilidad(idDNI);
                    }
                    event.preventDefault();
                });

                $("#btnCertProyecto").click(function() {
                    $('#mdCertProyecto').modal('show');
                    loadCertificadoProyecto(idDNI);
                    loadUbigeoProyecto();
                });
        
                $("#btnCertProyecto").keypress(function(event) {
                    if (event.keyCode === 13) {
                        $('#mdCertProyecto').modal('show');
                        loadCertificadoProyecto(idDNI);
                        loadUbigeoProyecto();
                    }
                    event.preventDefault();
                });

                $("#btnCertResidenciaObra").click(function() {
                    $('#mdCertResidenciaObra').modal('show');
                    loadCertificadoObra(idDNI);
                    loadUbigeoObras();
                });
        
                $("#btnCertResidenciaObra").keypress(function(event) {
                    if (event.keyCode === 13) {
                        $('#mdCertResidenciaObra').modal('show');
                        loadCertificadoObra(idDNI);
                        loadUbigeoObras();
                    }
                    event.preventDefault();
                });                
            }
            
        });
        
        $("#btnAceptarProyecto").click(function() {
            console.log($('#cbDepartamentoProyecto').val());
        });

        $("#btnAceptarProyecto").keypress(function(event) {
            if (event.keyCode === 13) {
                
            }
            event.preventDefault();
        });

    }

    function loadCertificadoHabilidad($dni) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 5,
                "Dni": $dni,
            },
            beforeSend: function() {
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadCertificado").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
                } else {
                    tools.AlertWarning("Especialidad", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function loadCertificadoProyecto($dni){
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 7,
                "Dni": $dni,
            },
            beforeSend: function() {
                $("#cbEspecialidadProyecto").empty();
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadProyecto").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
                } else {
                    tools.AlertWarning("Especialidad", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function loadCertificadoObra($dni){
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 6,
                "Dni": $dni,
            },
            beforeSend: function() {
                $("#cbEspecialidadObra").empty();
            },
            success: function(result) {
                console.log(result);
                if (result.estado == 1) {
                    $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadObra").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
                } else {
                    tools.AlertWarning("Especialidad", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    
    function loadUbigeoProyecto(){
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                type: "getubigeo",
            },
            beforeSend: function () {
                
            },
            success: function (result) {
                if (result.estado == 1) {
                   
                    $("#cbDepartamentoProyecto").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let Ubigeo of result.ubicacion) {
                        $("#cbDepartamentoProyecto").append('<option value="' + Ubigeo.IdUbicacion + '">' + Ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoProyecto').select2();

                } else {
                    tools.AlertWarning("ubigeo", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
                tools.AlertError("ubigeo", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    function loadUbigeoObras(){
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                type: "getubigeo",
            },
            beforeSend: function () {
                
            },
            success: function (result) {
                if (result.estado == 1) {
                   
                    $("#cbDepartamentoObra").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let Ubigeo of result.ubicacion) {
                        $("#cbDepartamentoObra").append('<option value="' + Ubigeo.IdUbicacion + '">' + Ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoObra').select2();

                } else {
                    tools.AlertWarning("ubigeo", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
                tools.AlertError("ubigeo", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }
}