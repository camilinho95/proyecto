<template>
  <div>
    <div class="input-group mb-3">
      <!-- Searh form-->
      <div class="col-md-7">
        <input
          type="text"
          name="filtroIdManzana"
          class="form-control"
          placeholder="Digite ID manzana..."
          v-model="filtro.filtroIdManzana"
        />
      </div>
    </div>
    <hr />

    <div
      style="display:none;"
      id="solicitudNoEncontrada"
      class="alert alert-danger alert-dismissible fade show"
      role="alert"
    >
      <strong>Sin registros</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <!-- Cartas-->
    <table id="table" class="table responsive">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Id Manzana</th>
          <th scope="col">Manzana</th>
          <th scope="col">Comuna</th>
          <th scope="col">Barrio</th>
          <th scope="col">Estado</th>
          <th scope="col">Fecha solicitud</th>
          <th scope="col">Descargar</th>
          <th scope="col">Comentario</th>
          <th scope="col">Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(solicitud, index) in searchSolicitud" :key="index">
          <td>{{ solicitud.idmanzana }}</td>
          <td>{{ solicitud.manzana }}</td>
          <td>{{ solicitud.comuna }}</td>
          <td>{{ solicitud.barrio }}</td>
          <td v-if="solicitud.estado == 'sin resolver'">
            <p class="text-danger">{{ solicitud.estado }}</p>
          </td>
          <td v-if="solicitud.estado == 'resuelta'">
            <p class="text-success">{{ solicitud.estado }}</p>
          </td>
          <td>{{ solicitud.created_at }}</td>
          <td>
            <a @click="getFiles(solicitud.idmanzana, '.pdf')" v-bind:href="link">PDF |</a>
            <a @click="getFiles(solicitud.idmanzana, '.dwg')" v-bind:href="link">CAD</a>
          </td>
          <td>
            <textarea
              style=" resize: none;"
              name="comentario"
              id
              cols="20"
              rows="1"
              v-model="solicitud.comentario"
            ></textarea>
          </td>
          <td>
            <form @submit.prevent="resolverSolicitud(solicitud)">
              <input hidden type="text" name="id" v-model="solicitud.id" />

              <textarea
                style=" resize: none;"
                hidden
                name="comentario"
                id
                cols="20"
                rows="1"
                v-model="solicitud.comentarioAux"
              ></textarea>
              <input
                hidden
                type="text"
                id="idmanzana"
                name="idmanzana"
                v-model="solicitud.idmanzana"
              />
              <input hidden type="text" id="manzana" name="manzana" v-model="solicitud.manzana" />
              <input hidden type="text" id="comuna" name="comuna" v-model="solicitud.comuna" />
              <input hidden type="text" id="barrio" name="barrio" v-model="solicitud.barrio" />
              <input hidden type="text" id="estado" name="estado" v-model="solicitud.estado" />
              <button
                v-if="solicitud.estado == 'sin resolver'"
                type="submit"
                title="Resolver"
                class="btn btn-success btn-sm"
                @click="fillFormSolicitud(solicitud)"
              >Resolver</button>
              <button
                v-if="solicitud.estado == 'resuelta'"
                disabled
                type="submit"
                title="Ya ha sido resuelta"
                class="btn btn-success btn-sm"
                @click="fillFormSolicitud(solicitud)"
              >Resolver</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      solicitudes: [],
      solicitud: {
        comuna: "",
        barrio: "",
        manzana: "",
        idmanzana: "",
        estado: "",
        comentario: ""
      },

      link: "",
      filtro: {
        filtroIdManzana: ""
      },
      errors: []
    };
  },

  mounted() {
    this.getSolicitudes();
  },
  computed: {
    searchSolicitud() {
      var aux = this.solicitudes.filter(item =>
        item.idmanzana
          .toLowerCase()
          .includes(this.filtro.filtroIdManzana.toLowerCase())
      );

      if (aux.length <= 0) {
        $("#solicitudNoEncontrada").css("display", "block");
        $("#table").hide();
      } else {
        $("#solicitudNoEncontrada").css("display", "none");
        $("#table").show();
      }
      return this.solicitudes.filter(item =>
        item.idmanzana
          .toLowerCase()
          .includes(this.filtro.filtroIdManzana.toLowerCase())
      );
    }
  },
  methods: {
    getFiles(idmanzana, extension) {
      this.link = "/carta/download/" + idmanzana+extension;
      console.log(this.link);
      
    },
    getSolicitudes() {
      axios.get("/solicitudes").then(res => {
        this.solicitudes = res.data;
        //  console.log(this.solicitudes);
      });
    },

    clearComentarioInput() {
      this.solicitud.comentario = "";
    },
    resolverSolicitud(solicitud) {
      const datosNuevos = this.solicitud;
      const url = `/solicitud/${solicitud.id}`;

      axios
        .put(url, datosNuevos)
        .then(res => {
          const solicitudServidor = res.data;
          console.log(solicitudServidor);

          this.solicitudes.push(solicitudServidor);
          this.getSolicitudes();
          this.errors = [];

          swal.fire({
            icon: "success",
            text: "Solicitud resuelta con éxito"
          });
          this.clearComentarioInput();
        })
        .catch(error => {
          this.errors = error.response.data.errors;
        });
    },

    fillFormSolicitud(solicitud) {
      (this.solicitud.id = solicitud.id),
        (this.solicitud.comuna = solicitud.comuna),
        (this.solicitud.barrio = solicitud.barrio),
        (this.solicitud.manzana = solicitud.manzana),
        (this.solicitud.idmanzana = solicitud.idmanzana),
        (this.solicitud.estado = "resuelta"),
        (this.solicitud.comentario = solicitud.comentario);

      console.log(this.solicitud);
    }
  }
};
</script>
