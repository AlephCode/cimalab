<div class="container mt-3">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
        Agregar laboratorio
    </button>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar laboratorio</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <!--       MODAL FORMULARIO   AGREGAR USUARIO          -->
                <form onsubmit="return false" id="form-lab_submit">

                    <div class="form-row">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre de laboratorio:</label>
                                    <input value="" type="text" class="form-control" id="form-lab_name" name="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Capacidad:</label>
                                    <input value="" type="number" class="form-control" id="form-lab_capacity" name="" required>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submitEdit submit-lab_add">Agregar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

