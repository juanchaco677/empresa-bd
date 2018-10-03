<div class="modal" style="height:700px;"id="modal-registraduria">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Consultar votante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-registraduria-usuario" style="height:500px;">

        <div class="py-5">
          <div class="container">
            <div class="row">
              
              <div class="col-md-12">
                <div  class="form-group">
                     <label for="exampleInputEmail1">Cedula de ciudadania:</label>

                      <input  id="cedulaconsulta" type="number"  placeholder="Cedula" class="form-control" name="nit"  required autofocus>

                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Pegar Datos Registraduria</label>
                    <textarea id="transferir" class="form-control" id="exampleFormControlTextarea1" rows="20"></textarea>
                  </div>
                  <button onclick="transferirDatos('datosregistraduria')"  class="btn btn-primary">
                      Transferir Datos
                  </button> 
                
                  <a class="btn btn-primary" href="https://consulta.infovotantes.co/#/consultavotacion" > Abrir Registraduria</a>
               
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>
