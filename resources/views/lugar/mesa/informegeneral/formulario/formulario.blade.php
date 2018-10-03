<div class="form-group">
    <label for="exampleInputEmail1">Buscar departamento:</label>
    <input type="text" onkeyup="despliegueCombo(this,'{{$urldesplieguedepartamento}}');limpiar(['desplieguefinal','desplieguepunto','desplieguemesa'])" class="form-control"  value="{{empty($objeto)?'':$objeto->nombre}}" placeholder="departamento">
    <small id="emailHelp" class="form-text text-muted">Señor seleccione un Departamento.</small>
</div>

<div class="form-group">
    <div class="col-md-12 ">
       <select style="height: 35px;" name="{{$idname}}" class="form-control despliegue">
         @if (!empty($objeto))
            @include('combos.despliegue');
         @elseif (!empty($departamento))
            <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
         @endif
       </select>
    </div>
</div>


<div class="form-group">
    <label for="exampleInputEmail1">Buscar Ciudad:</label>
    <input type="text" onkeyup="despliegueComboFinal(this,'{{$urldesplieguefinal}}','despliegue','desplieguefinal');limpiar(['desplieguepunto','desplieguemesa'])" class="form-control"  value="{{empty($objetofinal)?'':$objetofinal->nombre}}" placeholder="ciudad">
    <small id="emailHelp" class="form-text text-muted">Señor seleccione una Ciudad.</small>
</div>

<div class="form-group">
    <div class="col-md-12 ">
       <select style="height: 35px;" name="{{$idnamefinal}}" class="form-control desplieguefinal">
         @if (!empty($objetofinal))
            @include('combos.desplieguefinal');
         @elseif (!empty($ciudad))
            <option value="{{$ciudad->id}}">{{$ciudad->nombre}}</option>
         @endif
       </select>
    </div>
</div>


<div class="col-md-2">
  <button type="button" class="btn btn-default" onclick="oprimirReporte('formulario-reporte-general','pdf')" >
    <a style="cursor:pointer;"  ><img src="archivos/pdf.jpg"  width="50" height="50" /></a>
  </button>

</div>
<div class="col-md-2">
  <button type="button" class="btn btn-default" onclick="oprimirReporte('formulario-reporte-general','xlsx')" >
  <a style="cursor:pointer;"  ><img src="archivos/excel.png"  width="50" height="50" /></a>
  </button>
</div>
