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
          name="filtroIdManzana"
          class="form-control"
          placeholder="Digite ID manzana..."
          v-model="filtro.filtroIdManzana"
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
            type="number"
            name="comuna"
            id="comuna"
            placeholder="Número de Comuna"
            class="form-control mb-4"
            v-model="carta.comuna"
            v-on:keyup="fillIdManzana()"
          />

          <span v-if="errors.barrio" class="text-danger">{{ errors.barrio[0] }}</span>
          <input
            type="number"
            name="barrio"
            id="barrio"
            placeholder="Número de Barrio"
            class="form-control mb-4"
            v-model="carta.barrio"
            v-on:keyup="fillIdManzana()"
          />

          <span v-if="errors.manzana" class="text-danger">{{ errors.manzana[0] }}</span>
          <input
            type="number"
            name="manzana"
            id="manzana"
            placeholder="Número de Manzana"
            class="form-control mb-4"
            v-model="carta.manzana"
            v-on:keyup="fillIdManzana()"
          />     

          <span v-if="errors.idmanzana" class="text-danger">{{ errors.idmanzana[0] }}</span>
          <input
            disabled
            type="number"
            name="idmanzana"
            id="idmanzana"
            placeholder="ID Manzana"
            class="form-control mb-4"
            v-model="carta.idmanzana"
          />
         <div class="row">
            <span v-if="errors.pdf" class="text-danger">{{ errors.pdf[0] }}</span>
            <div class="col-md-6">
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
             <span v-if="errors.dwg" class="text-danger">{{ errors.dwg[0] }}</span>
             <div class="col-md-6">
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
                @change="dwgChange">
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

    <div style="display:none;" id="cartaNoEncontrada" class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong> Sin registros</strong>
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
          <th scope="col">Descargar</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(carta, index) in searchCarta" :key="index">
          <td>{{carta.idmanzana}}</td>
          <td>{{carta.manzana}}</td>
          <td>{{carta.comuna}}</td>
          <td>{{carta.barrio}}</td>
          <td>
           
            <a @click="downloadCartaPdf(carta.pdf)" v-bind:href="pdfLink">PDF |</a>
           <a @click="downloadCartaDwg(carta.dwg)" v-bind:href="dwgLink"> DWG</a>
          </td>
          <td>
             <button 
              v-if="carta.deleted_at == null"
              @click="fillFormEdit(carta)"
              data-toggle="modal"
              data-target="#modalEdit"
              title="Editar"
              class="btn btn-primary btn-sm"> 
              <i class="far fa-edit"></i>
            </button>
            <button 
              disabled
              v-if="carta.deleted_at != null"
              title="No puedes editar Carta inactiva"
              class="btn btn-primary btn-sm"> 
              <i class="far fa-edit"></i>
            </button>

            <button 
             v-if="carta.deleted_at == null"
               title="Inactivar" 
               class="btn btn-danger btn-sm"
               @click="disableCarta(carta.id)">
               <i class="fas fa-lock"></i>
            </button>
             <button 
             v-if="carta.deleted_at != null"
               title="Activar" 
               class="btn btn-success btn-sm"
               @click="enableCarta(carta.id)">
               <i class="fas fa-unlock-alt"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

     <!-- Modal Edit Carta -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar carta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <form @submit.prevent="updateCarta(carta)" >
             <input type="hidden" name="_token" :value="csrf">
             
              <span v-if="errorsUpdate.comuna" class="text-danger">{{ errorsUpdate.comuna[0] }}</span>
              <input
                type="text"
                name="comuna"
                id="comunaUpdate"
                placeholder="Número de comuna"
                class="form-control mb-4"
                v-model="carta.comuna"
                v-on:keyup="fillIdManzanaUpdate()"
              />
              <span v-if="errorsUpdate.barrio" class="text-danger">{{ errorsUpdate.barrio[0] }}</span>
                            
              <input
                type="text"
                name="barrio"
                id="barrioUpdate"
                placeholder="Número de barrio"
                class="form-control mb-4"
                v-model="carta.barrio"
                 v-on:keyup="fillIdManzanaUpdate()"
                />

              <span v-if="errorsUpdate.manzana" class="text-danger">{{ errorsUpdate.manzana[0] }}</span>
              <input
                class="form-control  mb-4"
                type="text"
                id="manzanaUpdate"
                name="manzana"
                placeholder="Número de manzana"
                v-model="carta.manzana"
                 v-on:keyup="fillIdManzanaUpdate()"
                />

              <span v-if="errorsUpdate.idmanzana" class="text-danger">{{ errorsUpdate.idmanzana[0] }}</span>
              <input
                disabled
                class="form-control mb-4"
                type="text"
                id="idmanzanaUpdate"
                name="idmanzana"
                placeholder="ID manzana"
                v-model="carta.idmanzana"/>

                <label 
                  for="pdfUpdate"
                  class="btn btn-default"><li class="fas fa-upload"></li> Archivo PDF
                  <li class="fas fa-file"></li>
                </label>
                <input 
                  type="file" 
                  name="pdf" 
                  id="pdfUpdate"                  
                  @change="pdfChangeUpdate">
                  <span>
                    <span class="mb-3" id="nombrePdfUpdate">Escoja un archivo</span>
                  </span>
                  <br>
                  <span v-if="errorsUpdate.pdf" class="text-danger">{{ errorsUpdate.pdf[0] }}</span>
                  <br>
                  <label 
                    for="dwgUpdate"
                    class="btn btn-default"><li class="fas fa-upload"></li> Archivo DWG
                    <li class="fas fa-file"></li>
                    </label>
                  <input 
                    type="file" 
                    name="dwg" 
                    id="dwgUpdate"
                    class="mb-4"
                    @change="dwgChangeUpdate">
                    <span>
                      <span id="nombreCadUpdate">Escoja un archivo</span>
                    </span><br>
                    <span v-if="errorsUpdate.dwg" class="text-danger">{{ errorsUpdate.dwg[0] }}</span>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
  #pdf{
    display: none;
  }
  #dwg{
    display: none;
  }
  #pdfUpdate{
    display: none;
  }
  #dwgUpdate{
    display: none;
  }
</style>
<script>

import { log } from 'util';
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
       filtro:{
            filtroIdManzana: '',
        },
      errors:[],
      errorsUpdate:[],
      pdfLink: '', 
      dwgLink: '',


      }
  },


  mounted() {
    
    this.getCartas();
    
  },

  computed: {
    searchCarta(){
      var aux = this.cartas.filter((item) => item.idmanzana.toLowerCase().includes(this.filtro.filtroIdManzana.toLowerCase()));
      if (aux.length <= 0) {
           $("#cartaNoEncontrada").css("display", "block");
          $('#table').hide();
      }else{
          $("#cartaNoEncontrada").css("display", "none");
           $('#table').show();
      }
       return this.cartas.filter((item) => item.idmanzana.toLowerCase().includes(this.filtro.filtroIdManzana.toLowerCase()));

    }
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

    dwgChange(e){
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);
      fileReader.onload = (e) =>{
         this.carta.dwg  = e.target.result;
      }
      console.log(this.carta);
      
      var archivoInput = document.getElementById('dwg');
      var archivoRutaDwg = archivoInput.value;
      var nombreArchivo = document.getElementById('nombreCad');
      var extPermitida = /(.dwg|.DWG)$/;

      if (!extPermitida.exec(archivoRutaDwg)) {
        alert('Debes seleccionar un archivo en formato DWG');  
        archivoInput.value = '';
      }else{
          nombreArchivo.textContent = archivoInput.value;
      }
    },

    pdfChangeUpdate(e){ 
      // console.log(e.target.files[0]);
       
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);
      fileReader.onload = (e) =>{
         this.carta.pdf = e.target.result;
      }
      console.log(this.carta);
            

      var archivoInput = document.getElementById('pdfUpdate');
      var archivoRutaPdf = archivoInput.value;
      var nombreArchivo = document.getElementById('nombrePdfUpdate');
      var extPermitida = /(.pdf|.PDF)$/;
      
     

      if (!extPermitida.exec(archivoRutaPdf)) {
        alert('Debes seleccionar un archivo en formato PDF');  
        archivoInput.value = '';
      }else{
          nombreArchivo.textContent = archivoInput.value;
      }
    },

    dwgChangeUpdate(e){
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);
      fileReader.onload = (e) =>{
         this.carta.dwg  = e.target.result;
      }
      console.log(this.carta);
      
      var archivoInput = document.getElementById('dwgUpdate');
      var archivoRutaCad = archivoInput.value;
      var nombreArchivo = document.getElementById('nombreCadUpdate');
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

     fillIdManzana(){      
       var c = document.getElementById('comuna').value;     
       var b = document.getElementById('barrio').value;   
       var m = document.getElementById('manzana').value;        
       var aux = c + b + m;

      this.carta.idmanzana = c + b + m;

     },

     fillIdManzanaUpdate(){      
       var c = document.getElementById('comunaUpdate').value;     
       var b = document.getElementById('barrioUpdate').value;     
       var m = document.getElementById('manzanaUpdate').value;        
       var aux = c + b + m;

      this.carta.idmanzana = c + b + m;
 
     },

     addCarta() {
       
     // console.log(this.carta);
      const cartaNueva = this.carta;
        axios.post('/cartas', cartaNueva )
          .then(res => {
            const cartaServidor = res.data
              // console.log(cartaServidor);
              this.cartas.push(cartaServidor);              
              
              this.errors = [];
                swal.fire({
                  icon:'success',
                  text: 'carta creada con éxito'
                })
                this.clearForm();  
                // this.searchCarta();
                this.getCartas();

        }).catch(error => {
             this.errors = error.response.data.errors
        });
    },

    fillFormEdit(carta){
       this.carta.comuna = carta.comuna,
       this.carta.barrio = carta.barrio,
       this.carta.manzana = carta.manzana,
       this.carta.idmanzana = carta.idmanzana,
       this.carta.id = carta.id
    },
    updateCarta(carta){
       const datosNuevos = this.carta;
       const url = `/carta/${carta.id}`;
       
       axios.put(url, datosNuevos)
       .then(res =>{        
           this.errorsUpdate = [];
           $('#modalEdit').modal('hide');
              swal.fire({
                icon:'success',
                text: 'Carta actualizada con éxito'
            })  
           this.clearForm();  
           this.getCartas();
          
       }).catch(error => {
             this.errorsUpdate = error.response.data.errors
       });   
    },
 
    disableCarta(id){

      swal.fire({
      title: 'Estás seguro de inactivar la carta?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, inactivar!'
    }).then((result) => {
      if (result.value) {
        
        var url = `/carta/${id}` 
        axios.delete(url)
            .then(res =>{
            this.getCartas();            
        });   

        swal.fire(
          'Inactivar carta!',
          'Carta inactivada con éxito.',
          'success'
        )
      }
    })
    },

    enableCarta(id){
      //console.log(id);

      swal.fire({
      title: 'Estás seguro de activar la Carta?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, activar!'
    }).then((result) => {
      if (result.value) {

         axios.get(`carta/restore/${id}`)
          .then(()=>{
            this.getCartas();
        })

        swal.fire(
          'Carta activada!',
          'Carta activada con éxito.',
          'success'
        )
      }
    })
    },

    downloadCartaPdf(carta){
      this.pdfLink = '/carta/download/' + carta;
      const url = '/carta/download/' + carta;

        axios.get(url).then(res =>{
           console.log('Carta descargada: '+ carta);    
           console.log('PDF LINK: ', this.pdfLink);
        })
    },
    downloadCartaDwg(carta){
      this.dwgLink = '/carta/download/' + carta;
      const url = '/carta/download/' + carta;

        axios.get(url).then(res =>{
           console.log('Carta descargada: '+ carta);    
           console.log('DWG LINK: ', this.dwgLink);
        })
    }
  }
};
</script>