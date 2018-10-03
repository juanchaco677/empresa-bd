
<form class="formulario-ge" id="formulario-reporte-general"   enctype="multipart/form-data"  method="POST" action=" {{route('oprimirPdfGeneral')}}">
<input type="hidden" id="tiporeporte" name="tiporeporte" value="">
    {{ csrf_field() }}
<p></p>
<div class="container">
    <div class="row">

        <div class="col-xs-8 col-sm-8 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Informe general, puntos de votación:</h1></div>
                <div class="panel-body">
                      @include("lugar.mesa.informegeneral.formulario.formulario")
                </div>
            </div>
        </div>
    </div>
</div>
</form>
