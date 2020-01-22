<template>
  <div>
    <div class="input-group mb-3">
      <div class="col-md-6 mb-3">
        <button
          data-toggle="collapse"
          data-target="#clAgregarUsuario"
          class="btn btn-success btn-md"
        >Nueva carta catastral</button>
      </div>

      <!-- Searh form-->
      <div class="col-md-6">
        <input
          type="text"
          name="filtroName"
          class="form-control"
          placeholder="Digite ID manzana..."
        />
      </div>
    </div>
    <hr />

    <!-- Solicitudes Form-->
    <div class="collapse" id="clAgregarUsuario">
      <div class="col-md-8 col-md-offset-2 form-group">
        <form enctype="multipart/form-data">
          
          <input type="hidden" name="_token" :value="csrf" />

          <span class="text-danger"></span>
          <input
            type="text"
            name="manzana"
            id="manzana"
            placeholder="Número de Manzana"
            class="form-control mb-4"
          />

          <span class="text-danger"></span>
          <input
            type="text"
            name="comuna"
            id="comuna"
            placeholder="Número de Comuna"
            class="form-control mb-4"
          />

          <span class="text-danger"></span>
          <input
            type="text"
            name="barrio"
            id="barrio"
            placeholder="Número de Barrio"
            class="form-control mb-4"
          />

          <span class="text-danger"></span>
          <input
            type="text"
            name="idManzana"
            id="idManzana"
            placeholder="ID Manzana"
            class="form-control mb-4"
            disabled
          />

          <div class="row ">
           <div class="col-md-6">
              <span class="text-danger"></span>
              <label for="file-pdf" class="btn btn-default">
                <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo PDF
              </label>
              <input id="file-pdf" name="pdf"  v-on:input="cambiarPDF()" type="file" style="display: none;" />
              <label id="nombrePdf"></label>
           </div>
           <div class="col-md-6">         
              <span class="text-danger"></span>
              <label for="file-cad" class="btn btn-default">
                <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo CAD
              </label>
              <input id="file-cad" name="cad" v-on:input="cambiarCAD()" type="file" style="display: none;" />
              <label id="nombreCad"></label>
           </div>
         </div>
         <br>

          <button type="submit" class="btn btn-primary col-md-4">Crear</button>
          <button
            type="button"
            data-toggle="collapse"
            data-target="#clAgregarUsuario"
            class="btn btn-danger col-md-4"
          >Cancelar</button>
        </form>
      </div>
      <hr />
    </div>

    <!-- Cartas-->
    <table class="table responsive">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Id Manzana</th>
          <th scope="col">Manzana</th>
          <th scope="col">Comuna</th>
          <th scope="col">Barrio</th>
          <th scope="col">Descargar</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>2323991</td>
          <td>06</td>
          <td>21</td>
          <td>37</td>
          <td>
            <a href="#">PDF |</a>
            <a href="#">CAD</a>
          </td>
          <td>
            <button title="Resolver" class="btn btn-primary btn-sm">
              <i class="fas fa-edit"></i>
            </button>
            <button title="Eliminar carta" class="btn btn-danger btn-sm">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>

export default {

  methods:{
     cambiarPDF() {
        var pdrs = document.getElementById("file-pdf").files[0].name;
        document.getElementById("nombrePdf").innerHTML = pdrs;
     },
     cambiarCAD() {
        var pdrs = document.getElementById("file-cad").files[0].name;
        document.getElementById("nombreCad").innerHTML = pdrs;
     }
  }
};
</script>