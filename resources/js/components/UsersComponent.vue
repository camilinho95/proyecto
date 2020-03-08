<template>
  <div>
    <div class="input-group mb-3">
      <div class="col-md-6 mb-3">
        <button
         @click="clearForm()"
          data-toggle="collapse"
          data-target="#clAgregarUsuario"
          class="btn btn-success btn-md"
        >Nuevo usuario</button>
      </div>

      <!-- Searh form-->
      <div class="col-md-6">
        <input type="text" name="filtroUser" v-model="filtro.filtroUser" class="form-control" placeholder="Buscar usuario..." />
      </div>
    </div>
    <hr />

    <!-- Add user's form-->
    <div class="collapse" id="clAgregarUsuario">
      <div class="col-md-8 col-md-offset-2 form-group">
        <form @submit.prevent="addUser" >
          <input type="hidden" name="_token" :value="csrf">
      
          <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
          <input
            type="text"
            name="name"
            id="name"
            placeholder="Nombre completo"
            class="form-control mb-4"
            v-model="usuario.name"
          />

          <span v-if="errors.email" class="text-danger">{{ errors.email[0] }}</span>
          <input
            type="email"
            name="email"
            id="email"
            placeholder="Correo electrónico"
            class="form-control mb-4"
            v-model="usuario.email"
          />          
               
          <div class="form-group mb-4">
            <span v-if="errors.role" class="text-danger">{{ errors.role[0] }}</span>
            <select class="custom-select" id="role" name="role" v-model="usuario.role">
              <option value selected>Seleccionar cargo...</option>
              <option value="0">Administrador</option>
              <option value="1">Usuario ventanilla</option>
              <option value="2">Usuario cartografía</option>
            </select>
          </div>          

          <span v-if="errors.password" class="text-danger">{{ errors.password[0] }}</span>
           <div class="form-row mb-4">
                <div class="input-group col-md-8">
                  <input
                    id="txtPassword"
                    class="form-control"
                    type="password"
                    name="password"
                    placeholder="Ingresa una contraseña"
                    v-model="usuario.password"                  
                  />
                  <div class="input-group-append">
                    <button 
                      class="btn btn-primary" 
                      type="button"
                      @click="showPassword()">
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

    <div style="display:none;" id="userNoEncontrado" class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong> Usuario no encontrado!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <!-- List user's table-->
    <table id="table" class="table responsive">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Correo</th>
          <th scope="col">Cargo</th>
          <th scope="col">Estado</th>
          <th scope="col">Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in searchUser" :key="index">
          <th scope="row">{{user.id}}</th>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td v-if="user.role===0">
            Administrador
          </td>
          <td v-if="user.role===1">
            Ventanilla
          </td>
          <td v-if="user.role===2">
            Cartografía
          </td>
          <td v-if="user.deleted_at == null">
            <p class="text-success">Activo</p>
          </td>
          <td v-if="user.deleted_at != null">
            <p class="text-danger">Inactivo</p>
          </td>
          <td>
            <button 
              v-if="user.deleted_at == null"
              @click="fillFormEdit(user)"
              data-toggle="modal"
              data-target="#modalEdit"
              title="Editar"
              class="btn btn-primary btn-sm"> 
              <i class="far fa-edit"></i>
            </button>
            <button 
              disabled
              v-if="user.deleted_at != null"
              title="No puedes editar usuario inactivo"
              class="btn btn-primary btn-sm"> 
              <i class="far fa-edit"></i>
            </button>

            <button 
             v-if="user.deleted_at == null"
               title="Inactivar" 
               class="btn btn-danger btn-sm"
               @click="disableUser(user.id)">
               <i class="fas fa-lock"></i>
            </button>
             <button 
             v-if="user.deleted_at != null"
               title="Activar" 
               class="btn btn-success btn-sm"
               @click="enableUser(user.id)">
               <i class="fas fa-unlock-alt"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <nav>
       <ul class="pagination">
        <li v-if="pagination.current_page > 1" class="page-item">
          <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1)">
            Atrás
          </a>
        </li>
        <li  class="page-item" v-for="(page, index) in pagesNumber" :key="index" v-bind:class="[page == isActived ? 'active':'']"> 
         <a class="page-link"  href="#" @click.prevent="changePage(page)">
            {{ page }}
          </a>
        </li>
        <li v-if="pagination.current_page < pagination.last_page" class="page-item">
          <a class="page-link"  href="#" @click.prevent="changePage(pagination.current_page + 1)"> 
            Siguiente
          </a>
        </li>
      </ul>
    </nav>

    <!-- Modal Edit user -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <form @submit.prevent="updateUser(usuario)" >
             <input type="hidden" name="_token" :value="csrf">
             
              <span v-if="errorsUpdate.name" class="text-danger">{{ errorsUpdate.name[0] }}</span>
              <input
                type="text"
                name="name"
                id="name"
                placeholder="Nombre completo"
                class="form-control mb-4"
                v-model="usuario.name"
              />
              
              <input
                disabled
                type="email"
                name="email"
                id="email"
                placeholder="Correo electrónico"
                class="form-control mb-4"
                v-model="usuario.email"
              />


              <span v-if="errorsUpdate.role" class="text-danger">{{ errorsUpdate.role[0] }}</span>
              <div class="form-group mb-4">
                <select class="custom-select" id="role" name="role" v-model="usuario.role">
                  <option value selected>Seleccionar cargo...</option>
                  <option value="0">Administrador</option>
                  <option value="1">Usuario ventanilla</option>
                  <option value="2">Usuario cartografía</option>
                </select>
              </div>
              
              <span v-if="errorsUpdate.password" class="text-danger">{{ errorsUpdate.password[0] }}</span>
              <div class="form-row mb-4">
                <div class="input-group col-md-8">
                  <input
                    id="txtPasswordEdit"
                    class="form-control"
                    type="password"
                    name="password"
                    placeholder="Ingresa una contraseña"
                    v-model="usuario.password"                  
                  />
                  <div class="input-group-append">
                    <button 
                      class="btn btn-primary" 
                      type="button"
                      @click="showPasswordEdit()">
                        <span class="fa fa-eye icon"></span> 
                    </button>
                  </div>
                </div>
              </div>

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

<script>

import { log } from 'util';
export default {
  data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      usuarios:[],
        usuario: {
            name: '', 
            email:'',
            role:'', 
            password:'',
        },
        filtro:{
            filtroUser: '',
        },

        pagination: {
          'total': 0,
          'current_page': 0,
          'per_page': 0,
          'last_page': 0,
          'from': 0,
          'to': 0,
        },
        errors:[],
        errorsUpdate:[],
        offset: 3,
    }
  },

  mounted() {
    this.getUsers();
  },

  computed: {

    searchUser(){

       var aux = this.usuarios.filter((item) => item.name.toLowerCase().includes(this.filtro.filtroUser.toLowerCase()));

      if (aux.length <= 0) {
          $("#userNoEncontrado").css("display", "block");
          $('#table').hide();
      }else{
          $("#userNoEncontrado").css("display", "none");
          $('#table').show();
      }
       return this.usuarios.filter((item) => item.name.toLowerCase().includes(this.filtro.filtroUser.toLowerCase()));
    },

    disableInput(){      
      return this.usuario === 0;
    }
    ,
    isActived: function(){
      return this.pagination.current_page;
    },
    pagesNumber: function(){
      if (!this.pagination.to) {
         return [];
      }

      var from = this.pagination.current_page - this.offset; 
      if (from < 1) {
        from = 1;        
      }

      var to = from + (this.offset * 2);
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },
   
  methods: {

    clearForm(){
        this.usuario.name = '';
        this.usuario.email = '';
        this.usuario.role = '';
        this.usuario.password = '';
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
    showPasswordEdit(){
      var cambio = document.getElementById("txtPasswordEdit");
      if(cambio.type == "password"){
        cambio.type = "text";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');

      }else{
        cambio.type = "password";
         $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }
    } ,

    changePage: function(page){
      this.pagination.current_page = page;
      this.getUsers(page);
    },

    getUsers(page){
      axios.get('/usuarios?page='+page).then(res =>{
        this.usuarios = res.data.users.data;
        this.pagination = res.data.pagination;
      })
    },

    addUser() {
      const usuarioNuevo = this.usuario;
     
        axios.post('/usuarios', usuarioNuevo)
          .then(res => {
            const usuarioServidor = res.data
              this.usuarios.push(usuarioServidor);              
              this.clearForm();  
              this.getUsers();

              this.errors = [];
                swal.fire({
                  icon:'success',
                  text: 'Usuario creado con éxito'
                })

        }).catch(error => {
             this.errors = error.response.data.errors
        });
    },

    fillFormEdit(user){
       this.usuario.name = user.name,
       this.usuario.email = user.email,
       this.usuario.role = user.role,
       this.usuario.password = user.password,
       this.usuario.id = user.id
       this.usuario.deleted_at  = user.deleted_at

    },
    updateUser(user) {
     const datosNuevos = this.usuario;
       const url = `/usuarios/${user.id}`;
       
       axios.put(url, datosNuevos)
       .then(res =>{        
           this.errorsUpdate = [];
           $('#modalEdit').modal('hide');

              swal.fire({
                icon:'success',
                text: 'Usuario actualizado con éxito'
            })  
           this.clearForm();  
           this.getUsers();
          
       }).catch(error => {
             this.errorsUpdate = error.response.data.errors
       });             
    },

    disableUser(id){
      //console.log(id);

      swal.fire({
      title: 'Estás seguro de inactivar usuario?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, inactivar!'
    }).then((result) => {
      if (result.value) {

         axios.delete(`/usuarios/${id}`)
          .then(()=>{
            this.getUsers();
        })

        swal.fire(
          'Usuario Inactivado!',
          'Usuario inactivado con éxito.',
          'success'
        )
      }
    })
    },

    enableUser(id){
      //console.log(id);

      swal.fire({
      title: 'Estás seguro de activar usuario?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, activar!'
    }).then((result) => {
      if (result.value) {

         axios.get(`/restore/${id}`)
          .then(()=>{
            this.getUsers();
        })

        swal.fire(
          'Usuario activado!',
          'Usuario activado con éxito.',
          'success'
        )
      }
    })
    }
  }
 
};
</script>