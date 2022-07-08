<div class="row">
    <div class="modal fade" id="mdOtros" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-plus">
                        </i> Otros
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="lblConceptos">Conceptos </label>
                                <select class="form-control" id="cbOtrosConcepto">
                                    <option value="">- Seleccione -</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" class="form-control" id="txtCantidadOtrosConceptos" placeholder="0.00" value="1" min="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtMontoOtrosConceptos">Monto</label>
                                <input type="number" class="form-control" id="txtMontoOtrosConceptos" placeholder="0.00" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtDescripcionOtros">Descripción</label>
                                <input type="text" class="form-control" id="txtDescripcionOtros" placeholder="Ingrese una descripción" >
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnAceptarOtros">
                        <i class="fa fa-check"></i> Aceptar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <i class="fa fa-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>