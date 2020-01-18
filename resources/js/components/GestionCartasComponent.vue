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
        <input type="text" name="filtroName" class="form-control" placeholder="Consultar carta..." />
      </div>
    </div>
    <hr />

    <!-- Solicitudes Form-->
    <div class="collapse" id="clAgregarUsuario">
      <div class="col-md-8 col-md-offset-2 form-group">
        <form>
          <input type="hidden" name="_token" :value="csrf" />

          <span class="text-danger"></span>
          <input
            type="text"
            name="name"
            id="name"
            placeholder="Nombre completo"
            class="form-control mb-4"
          />

          <span class="text-danger"></span>
          <input
            type="email"
            name="email"
            id="email"
            placeholder="Correo electrónico"
            class="form-control mb-4"
          />

          <div class="form-group mb-4">
            <span class="text-danger"></span>
            <select class="custom-select" id="role" name="role">
              <option value selected>Seleccionar cargo...</option>
              <option value="0">Administrador</option>
              <option value="1">Usuario ventanilla</option>
              <option value="2">Usuario cartografía</option>
            </select>
          </div>

          <span class="text-danger"></span>
          <div class="form-row mb-4">
            <div class="input-group col-md-8">
              <input
                id="txtPassword"
                class="form-control"
                type="password"
                name="password"
                placeholder="Ingresa una contraseña"
              />
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <span class="fa fa-eye icon"></span>
                </button>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary col-md-4">Agregar</button>
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
          <th scope="col">Estado</th>
          <th scope="col">Descargar</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>2323991</td>
          <td>06</td>
          <td>21</td>
          <td>
               <p class="text-danger">Sin resolver</p>
          </td>
          <td>
             <a href="#">PDF  |</a>
             <a href="#">CAD</a>
          </td>
          <td>
            <button 
               title="Resolver" 
               class="btn btn-success btn-sm"
               >
               <i class="fas fa-check"></i>
            </button>
             <button 
               title="Eliminar carta" 
               class="btn btn-danger btn-sm"
              >
             <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {};
</script>