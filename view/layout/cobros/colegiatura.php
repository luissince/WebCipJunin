<div class="row">
    <div class="modal fade" id="mdColegiatura">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-plus">
                        </i> Pago de Colegiatura
                    </h4>
                </div>
                <div class="modal-body">
                    <form role="form" class="no-padding">
                        <div class="row" style="padding-bottom: 10px;">
                            <div class="col-md-12 text-left ">
                                <h5>Tipo de Pago</h5>
                                <select class="form-control" id="cbTipodePago">
                                    <option value="">- - Seleccione - -</option>
                                    <option value="4">Colegiatura Ordinaria</option>
                                    <option value="9">Colegiatura otras Modalidades</option>
                                    <option value="10">Colegiatura por Tesis Local</option>
                                    <option value="11">Colegiatura por Tesis Externa</option>
                                </select>
                            </div>
                        </div>
                        <div class="box box-solid">
                            <div class="box-header no-padding">
                                <div class="row">
                                    <div class="col-md-8 text-left border">
                                        <p>Concepto</p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p>Monto</p>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body no-padding text-center" id="ctnConceptos">
                            </div>
                        </div>
                        <div class="row no-padding">
                            <div class="col-md-6 text-right">
                                <div class="checkbox no-margin">
                                    <label>
                                        <input type="checkbox"> Dono libro
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 no-padding">
                                <div class="col-md-6 text-right">
                                    <span>Total:</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span id="lblTotalColegiatura">0.00</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnAceptarColegiatura">
                        <i class="fa fa-check"></i> Aceptar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <i class="fa fa-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>