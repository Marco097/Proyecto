<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        <div class="col-6">
                            <h5 class="float-start">Listado de Plan </h5>
                         </div>
                        <div class="col-6">
                            <button @click="showDialog" class="btn btn-success btn-sm float-end" >Nuevo</button>
                         </div>
                    </div>

                </div>
                    <div class="card-body">
                            <table class="table bordered" >
                                <div class="container">
            <div class="row justify-content-center" v-for="item in plan_almacenamientos" :key="item.id">
                    <div class="card" style="width: 25rem;">
                      <img src="https://picsum.photos/300/300" class="card-img-top" alt="">
                      <div class="card-body">
                        <h5 class="card-title text-bold">

                            {{ item.nombre_plan }}
                            &nbsp;
                            {{ item.precio }}
                            &nbsp;
                            {{ item.nube.almacenamiento }}
                            &nbsp;
                            {{ item.user.email }}
                            
                            </h5>
                        <a href="#">  
                             <td>
                                         <button type="button" class="btn btn-primary btn-sm" @click="showDialogEditar(item)">Editar</button>
                                            &nbsp;
                                            <button type="button" class="btn btn-danger btn-sm" @click="eliminar(item)">Eliminar</button>
                                        </td>
                                    </a>
                          </div>
                        </div>
                    </div>
            </div>      
                        </table>
                    </div>
                     </div>
                </div>
            </div>
        </div>
    <!-- Modal -->
<div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered moda-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="planModalLabel">{{ formTitle }}</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--definiendo cuerpo del formulario modal-->
        <div class="row">
            <div class="form-group col-6">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" v-model="plan_almacenamiento.nombre_plan">
            <span class="text-danger" v-show="planErrors.nombre_plan">Nombre es requerido</span>
        </div>
        <div class="col-6">
            <label for="nube">Nube </label>
            <select v-model="planErrors.nube_id" class="form-control">
                <option v-for="nube in nubes" :value="nube.id">
                    {{ nube.almacenamiento }}
                </option>
            </select>
            <span class="text-danger" v-show="planErrors.nube">Seleccione la Nube</span>
        </div>
      </div>
      <div class="row">
            <div class="form-group col-6">
            <label for="precio">Precio</label>
            <input type="text" class="form-control" v-model="plan_almacenamiento.precio">
            <span class="text-danger" v-show="planErrors.precio">Precio es requerido</span>
        </div>
        <div class="col-6">
            <label for="usuario">Usuario </label>
            <select v-model="planErrors.user_id" class="form-control">
                <option v-for="user in users" :value="user.id">
                    {{ user.email }}
                </option>
            </select>
           
        </div>
      </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" @click="saveOrUpdate()">{{ btnTitle }}</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        data(){
            return{
                plan_almacenamientos: [],
                plan_almacenamiento:{
                    id:null,
                    nombre_plan:"",
                    precio:"",
                    nube_id:null,
                    user_id:null,
                    nube:null,
                    user:null
                },
                editedPlan: -1,
                planErrors:{
                    nombre_plan:false,
                    precio:false,
                    nube:false,
                    user:false
                },
                nubes:[],
                users:[]
            }
        },
        computed:{
            formTitle(){
                return this.plan_almacenamiento.id == null ? "Agregar Plan" : "Actualizar Plan";
            },
            btnTitle(){
                return this.plan_almacenamiento.id == null ? "Guardar" : "Actualizar";
            }
        },
        methods:{
            async fetchPlan(){
                let me = this;
                await this.axios.get('/plan_almacenamientos')
                .then(response =>{
                    me.plan_almacenamientos = response.data;
                })
            },
            async fetchNubes(){
                let me = this;
                await this.axios.get('/nubes')
                .then(response =>{
                    me.nubes = response.data;
                })
            },
            async fetchUser(){
                let me = this;
                await this.axios.get('/users')
                .then(response =>{
                    me.users = response.data;
                })
            },
            showDialog(){
                this.plan_almacenamiento = {
                    id:null,
                    nombre_plan:"",
                    precio:"",
                    nube:null,
                    user:null,
                    nube_id:null,
                    user_id:null
                };
                this.planErrors = {
                    nombre_plan:false,
                    precio:false,
                    nube:false,
                    user:false
                };
                $('#planModal').modal('show');
            },
            showDialogEditar(plan_almacenamiento){
                let me = this;
                $('#planModal').modal('show');
                me.editedPlan = me.plan_almacenamientos.indexOf(plan_almacenamiento);
                me.plan_almacenamiento = Object.assign({},plan_almacenamiento);
            },
            hideDialog(){
                let me = this;
                setTimeout(() => {
                    me.plan_almacenamiento = {
                       id: null,
                       nombre_plan:"",
                       precio:"",
                       nube:null,
                       user:null
            
                    }
                },300);
                $('#planModal').modal('hide');
            },
            async saveOrUpdate(){
                let me = this;

                me.plan_almacenamiento.nombre_plan == '' ? me.planErrors.nombre_plan = true : me.planErrors.nombre_plan = false;
                me.plan_almacenamiento.precio == '' ? me.planErrors.precio = true : me.planErrors.precio = false;
                me.plan_almacenamiento.nube_id == null ? me.planErrors.nube = true : me.planErrors.nube = false;
                me.plan_almacenamiento.user_id == null ? me.planErrors.user = true : me.planErrors.user = false;


                if(me.plan_almacenamiento.nombre_plan){
                    let accion = me.plan_almacenamiento.id == null ? "add" : "upd";
                    
                    me.plan_almacenamiento.nube = {
                        "id" : me.plan_almacenamiento.nube_id
                    };
                    me.plan_almacenamiento.user = {
                        "id" : me.plan_almacenamiento.user_id
                    };

                    if(accion == "add"){
                        await this.axios.post('/plan_almacenamientos', me.plan_almacenamiento)
                        .then(response => {
                            if(response.status == 201){
                            me.verificarAccion(response.data.data,response.status,accion);
                            me.hideDialog();
                            }
                        }).catch(errors =>{
                            console.log(errors);
                        })
                    }else{
                        await this.axios.put(`/plan_almacenamientos/${me.plan_almacenamiento.id}`, me.plan_almacenamiento)
                        .then(response =>{
                            if(response.status == 202){
                            me.verificarAccion(response.data.data,response.status,accion);
                            me.hideDialog();
                            }
                        }).catch(errors =>{
                            console.log(errors);
                        })
                    }
                }
            },
            async eliminar(plan_almacenamiento){
                let me = this;
                this.$swal.fire({
                    title: 'Seguro/a de eliminar este registro?',
                    text: "No podras revertir la accion",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    }).then((result) => {
                    if(result.value){
                        me.editedPlan = me.plan_almacenamientos.indexOf(plan_almacenamiento);
                        this.axios.delete(`/plan_almacenamientos/${plan_almacenamiento.id}`)
                        .then(response => {
                            me.verificarAccion(null,response.status,"del");
                        }).catch(errors => {
                            console.log(errors);
                        })
                    }
                })
                   
            },
            verificarAccion(plan_almacenamiento,statusCode, accion){
                let me = this;
                const Toast = this.$swal.mixin({
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
                switch (accion) {
                    case "add":
                        me.fetchPlan();
                        Toast.fire({
                            icon: 'success',
                            'title': 'Plan Registrado con Exito..!'
                        });
                        break;
                    case "upd":
                        Object.assign(me.plan_almacenamientos[me.editedPlan], plan_almacenamiento);
                        Toast.fire({
                            icon: 'success',
                            'title': 'Plan Actualizado con Exito..!'
                        });
                        break;
                    case "del":
                        if(statusCode == 201){
                                me.plan_almacenamientos.splice(this.editedPlan,1);
                                Toast.fire({
                                    icon: 'success',
                                    'title': 'Plan Eliminado..!'
                                });
                            }else{
                            Toast.fire({
                                icon: 'warning',
                                'title': 'Error al eliminar el plan, intente de nuevo'
                            });
                        }
                        break;

                    }
        },
      
    },
    mounted() {
     this.fetchPlan();
     this.fetchNubes();
     this.fetchUser();

        }
}
</script>