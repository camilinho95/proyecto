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
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(solicitud, index) in searchCarta" :key="index">
          <td>{{solicitud.idmanzana}}</td>
          <td>{{solicitud.manzana}}</td>
          <td>{{solicitud.comuna}}</td>
          <td>{{solicitud.barrio}}</td>
          <td>
           <form @submit.prevent="addSolicitud()">
            <input
                hidden 
                type="text"
                id="idmanzana"
                name="idmanzana" 
                v-model="solicitud.idmanzana">  
            <input
                hidden 
                type="text"
                id="manzana"
                name="manzana" 
                v-model="solicitud.manzana">  
            <input
                hidden 
                type="text"
                id="comuna"
                name="comuna" 
                v-model="solicitud.comuna">  
            <input
                hidden 
                type="text"
                id="barrio"
                name="barrio" 
                v-model="solicitud.barrio">
             <input
                hidden 
                type="text"
                id="estado"
                name="estado" 
                v-model="solicitud.estado">     
            <input
                hidden 
                type="text"
                id="comentario"
                name="comentario" 
                v-model="solicitud.comentario">     
             <button     
                type="submit"            
                title="Resolver" 
                class="btn btn-success btn-sm"
                @click="fillFormSolicitud(solicitud)"
               > 
               Solicitar carta
             </button>           
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
      solicitudes:[],
            
        solicitud:{
            idmanzana: '', 
            manzana:'',
            comuna:'', 
            barrio:'',
            estado:'',
            comentario:''
        },
        filtro:{
            filtroIdManzana: '',
        },
      errors:[]
    }   
  },

 computed: {
    searchCarta(){
      var aux = this.solicitudes.filter((item) => item.idmanzana.toLowerCase().includes(this.filtro.filtroIdManzana.toLowerCase()));

      if (aux.length <= 0) {
           $("#cartaNoEncontrada").css("display", "block");
          $('#table').hide();
      }else{
          $("#cartaNoEncontrada").css("display", "none");
           $('#table').show();
      }
       return this.solicitudes.filter((item) => item.idmanzana.toLowerCase().includes(this.filtro.filtroIdManzana.toLowerCase()));

    }
 },
 mounted() {
      this.getCartas();
 },
 methods: {
      getCartas(){
        axios.get('/solicitud').then(res =>{
          this.solicitudes = res.data;
          // console.log(this.solicitudes);
        })
      },
      

      fillFormSolicitud(solicitud){
        this.solicitud.idmanzana = solicitud.idmanzana,
        this.solicitud.manzana =  solicitud.manzana,
        this.solicitud.comuna =  solicitud.comuna,
        this.solicitud.barrio = solicitud.barrio,
        this.solicitud.estado = 'sin resolver',
        this.solicitud.comentario = 'sin comentario'
        
        console.log(this.solicitud);
        
      },
      addSolicitud(){
        const solicitudNueva = this.solicitud;

        axios.post('/solicitud', solicitudNueva )
          .then(res => {
            
            const solicitudServidor = res.data
            // console.log(solicitudServidor);
            
              this.solicitudes.push(solicitudServidor); 
              this.getCartas();
              this.errors = [];

                swal.fire({
                  icon:'success',
                  text: 'Solicitud creada con éxito'
                })

        }).catch(error => {
             this.errors = error.response.data.errors
        });
      }
 },
};
</script>