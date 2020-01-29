<template>
  <div>
    <div class="input-group mb-3">
      <div class="col-md-6 mb-3">
        <button
          data-toggle="collapse"
          data-target="#clAgregarCarta"
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

    <!-- Cartas Form-->
    <div class="collapse" id="clAgregarCarta">
      <div class="col-md-8 col-md-offset-2 form-group">
        <form @submit.prevent="addCarta">
          
          <input type="hidden" name="_token" :value="csrf" />

          <span v-if="errors.comuna" class="text-danger">{{ errors.comuna[0] }}</span>
          <input
            type="text"
            name="comuna"
            id="comuna"
            placeholder="Número de Comuna"
            class="form-control mb-4"
            v-model="carta.comuna"
          />

          <span v-if="errors.barrio" class="text-danger">{{ errors.barrio[0] }}</span>
          <input
            type="text"
            name="barrio"
            id="barrio"
            placeholder="Número de Barrio"
            class="form-control mb-4"
            v-model="carta.barrio"
          />

          <span v-if="errors.manzana" class="text-danger">{{ errors.manzana[0] }}</span>
          <input
            type="text"
            name="manzana"
            id="manzana"
            placeholder="Número de Manzana"
            class="form-control mb-4"
            v-model="carta.manzana"
          />         

          <span v-if="errors.idmanzana" class="text-danger">{{ errors.idmanzana[0] }}</span>
          <input
            type="text"
            name="idmanzana"
            id="idmanzana"
            placeholder="ID Manzana"
            class="form-control mb-4"
            v-model="carta.idmanzana"
          />
         <div class="row">
            <div class="col-md-6">
            <span v-if="errors.pdf" class="text-danger">{{ errors.pdf[0] }}</span>
              <label 
                for="pdf"
                class="btn btn-default"><li class="fas fa-upload"></li> Archivo PDF
                <li class="fas fa-file"></li>
               </label>
              <input 
                type="file" 
                name="pdf" 
                id="pdf"
                class="mb-4"
                @change="pdfChange">
                <span>
                  <span id="nombrePdf">Escoja un archivo</span>
                </span>
              <br>
            </div>
             <div class="col-md-6">
             <span v-if="errors.dwg" class="text-danger">{{ errors.dwg[0] }}</span>
              <label 
                for="dwg"
                class="btn btn-default"><li class="fas fa-upload"></li> Archivo DWG
                <li class="fas fa-file"></li>
               </label>
              <input 
                type="file" 
                name="dwg" 
                id="dwg"
                class="mb-4"
                @change="cadChange">
                <span>
                  <span id="nombreCad">Escoja un archivo</span>
                </span>
              <br>
            </div>
         </div>
         <hr>
          <button type="submit" class="btn btn-primary col-md-4">Crear</button>
          <button
            type="button"
            data-toggle="collapse"
            data-target="#clAgregarCarta"
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
        <tr v-for="(carta, index) in cartas" :key="index">
          <td>{{carta.idmanzana}}</td>
          <td>{{carta.manzana}}</td>
          <td>{{carta.comuna}}</td>
          <td>{{carta.barrio}}</td>
          <td>
            <a href="#">PDF |</a>
            <a href="#">DWG</a>
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
<style>
  #pdf{
    display: none;
  }
  #dwg{
    display: none;
  }
</style>
<script>
export default {
  

  data(){
      return{
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      cartas:[],
        carta: {
            comuna:'',
            barrio:'', 
            manzana:'',
            idmanzana: '',
            pdf:'',
            dwg:''
        },
      errors:[],

      }
  },

  mounted() {
    this.getCartas();
  },

  methods:{

    pdfChange(e){ 
      // console.log(e.target.files[0]);
       
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);
      fileReader.onload = (e) =>{
         this.carta.pdf = e.target.result;
      }
      console.log(this.carta);
            

      var archivoInput = document.getElementById('pdf');
      var archivoRutaPdf = archivoInput.value;
      var nombreArchivo = document.getElementById('nombrePdf');
      var extPermitida = /(.pdf|.PDF)$/;
      
     

      if (!extPermitida.exec(archivoRutaPdf)) {
        alert('Debes seleccionar un archivo en formato PDF');  
        archivoInput.value = '';
      }else{
          nombreArchivo.textContent = archivoInput.value;
      }
    },

    cadChange(e){
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);
      fileReader.onload = (e) =>{
         this.carta.dwg  = e.target.result;
      }
      console.log(this.carta);
      
      var archivoInput = document.getElementById('dwg');
      var archivoRutaCad = archivoInput.value;
      var nombreArchivo = document.getElementById('nombreCad');
      var extPermitida = /(.dwg|.DWG)$/;

      if (!extPermitida.exec(archivoRutaCad)) {
        alert('Debes seleccionar un archivo en formato DWG');  
        archivoInput.value = '';
      }else{
          nombreArchivo.textContent = archivoInput.value;
      }
    },


     getCartas(){
        axios.get('/cartas').then(res =>{
          this.cartas = res.data;
          // console.log(this.cartas);          
        })
     },

      clearForm(){
        this.carta.comuna = '';
        this.carta.barrio = '';
        this.carta.manzana = '';
        this.carta.idmanzana = '';
    },

     llenarIdManzana: function(){            

      },

     addCarta() {
     // console.log(this.carta);
              
      const cartaNueva = this.carta;
      

        axios.post('/cartas', cartaNueva )
          .then(res => {

            
            const cartaServidor = res.data
            console.log(cartaServidor);
            
              this.cartas.push(cartaServidor);              
              this.clearForm();  
              this.getCartas();
              this.errors = [];

                swal.fire({
                  icon:'success',
                  text: 'carta creada con éxito'
                })

        }).catch(error => {
             this.errors = error.response.data.errors
        });
    }
  }
};
</script>