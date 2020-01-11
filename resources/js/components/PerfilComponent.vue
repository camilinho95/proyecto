<template>
  <div class="card">
    <div class="card-header">Perfil</div>
    <div class="card-body">
      <!-- Add user's form-->
      <div class="col-md-7 offset-2 form-group">
        <form @submit.prevent="UpdateUser(user.id)">
          <input type="hidden" name="_token" :value="csrf">

          <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
          <input
            type="text"
            name="name"
            id="name"
            class="form-control mb-4"
            v-model="user.name"

          />

          <input
            disabled
            type="email"
            :placeholder="`${user.email}`"
            class="form-control mb-4"
            v-model="user.email"
          />
          

          <input
            v-if="user.role == 0"
            disabled
            type="text"
            placeholder="Administrador"
            class="form-control mb-4" 
          />

          <input
            v-if="user.role == 1"
            disabled
            type="text"
            placeholder="Usuario ventanilla"
            class="form-control mb-4"
          />

          <input
            v-if="user.role == 2"
            disabled
            type="text"
            placeholder="Usuario cartografía"
            class="form-control mb-4"
          />

          <span v-if="errors.password" class="text-danger">{{ errors.password[0] }}</span>
          <div class="form-row mb-4">
            <div class="input-group col-md-8">
              <input
                id="txtPassword"
                class="form-control"
                type="password"
                name="password"
                placeholder="Ingresa una contraseña"
                v-model="user.password"
              />
              <div class="input-group-append">
                <button class="btn btn-primary" type="button" @click="showPassword()">
                  <span class="fa fa-eye icon"></span>
                </button>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary col-md-4">Actualizar datos</button>
        </form>
      </div>
      <hr />
    </div>
  </div>
</template>


<script>
let user = document.head.querySelector('meta[name="user"]');

export default {
  data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      usuario:[],
      errors:[],
    }
  },

  computed: {
    user(){
      return JSON.parse(user.content);
    }
  },

  methods:{
    getUserData(){

    },
    
    showPassword(){
      var cambio = document.getElementById("txtPassword");
      if(cambio.type == "password"){
        cambio.type = "text";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');

      }else{
        cambio.type = "password";
         $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }
    } ,

    UpdateUser(id){
      //console.log(this.user.name + this.user.email + this.user.role + this.user.password + id);
      
       const nuevosDatos = this.user;
       const url = `/perfil/${id}`;
       
       axios.put(url, nuevosDatos)
       .then(res =>{        
           this.errors = [];
              swal.fire({
                icon:'success',
                text: 'Datos actualizados con éxito'
            })  
       }).catch(error => {
             this.errors = error.response.data.errors
       });    
    }
  }
}
</script>