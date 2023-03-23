<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        <div class="col-6">
                            <h5 class="float-start">Listado de Nubes </h5>
                         </div>
                        <div class="col-6">
                            <button @click="showDialog" class="btn btn-success btn-sm float-end" >Nuevo</button>
                         </div>
                    </div>

                </div>

                    <div class="card-body">
                        <table class="table bordered">
                            <thead>
                            <tr>
                               <th scope="col">Nubes</th>
                               <th scope="col">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in nubes" :key="item.id">
                                <td>{{ item.almacenamiento }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" @click="showDialogEditar(item)">Editar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-danger btn-sm" @click="eliminar(item)">Eliminar</button>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="nubeModal" tabindex="-1" aria-labelledby="nubeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="nubeModalLabel">{{ formTitle }}</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--definiendo cuerpo del formulario modal-->
        <div class="row">
            <div class="form-group col-12">
            <label for="Almacenamiento">Almacenamiento</label>
            <input type="text" class="form-control" v-model="nube.almacenamiento">
            <span class="text-danger" v-show="nubeErrors.almacenamiento">Espacio de almacenamineto es requerido</span>
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
                nubes: [],
                nube:{
                    id:null,
                    almacenamiento:""
                },
                editedNube: -1,
                nubeErrors:{
                    almacenamiento:false
                }
            }
        },
        computed:{
            formTitle(){
                return this.nube.id == null ? "Agregar Nube" : "Actualizar Nube";
            },
            btnTitle(){
                return this.nube.id == null ? "Guardar" : "Actualizar";
            }
        },
        methods:{
            async fetchNubes(){
                let me = this;
                await this.axios.get('/nubes')
                .then(response =>{
                    me.nubes = response.data;
                })
            },

            showDialog(){
                this.nube = {
                    id:null,
                    almacenamiento:""
                };
                this.nubeErrors = {
                    almacenamiento:false
                };
                $('#nubeModal').modal('show');
            },
            showDialogEditar(nube){
                let me = this;
                $('#nubeModal').modal('show');
                me.editedNube = me.nubes.indexOf(nube);
                me.nube = Object.assign({},nube);
            },
            hideDialog(){
                let me = this;
                setTimeout(() => {
                    me.nube = {
                        id:null,
                        almacenamiento:""
                    };
                },300)
                $('#nubeModal').modal('hide');
            },
            async saveOrUpdate(){
                let me = this;
                me.nube.almacenamiento == '' ? me.nubeErrors.almacenamiento = true : me.nubeErrors.almacenamiento = false;
                if(me.nube.almacenamiento){
                    let accion = me.nube.id == null ? "add" : "upd";
                    if(accion == "add"){
                        await this.axios.post('/nubes', me.nube)
                        .then(response =>{
                            console.log(response.data);
                            me.verificarAccion(response.data.data,response.status,accion);
                            me.hideDialog();
                        }).catch(errors =>{
                            console.log(errors);
                        })
                    }else{
                        await this.axios.put(`/nubes/${me.nube.id}`, me.nube)
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
            async eliminar(nube){
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
                        me.editedNube = me.nubes.indexOf(nube);
                        this.axios.delete(`/nubes/${nube.id}`)
                        .then(response => {
                            me.verificarAccion(null,response.status,"del");
                        }).catch(errors => {
                            console.log(errors);
                        })
                    }
                })
                   
            },
            verificarAccion(nube,statusCode, accion){
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
                        me.nubes.unshift(nube);
                        Toast.fire({
                            icon: 'success',
                            'title': 'Nube Registrada con Exito..!'
                        });
                        break;
                    case "upd":
                        Object.assign(me.nubes[me.editedNube], nube);
                        Toast.fire({
                            icon: 'success',
                            'title': 'Nube Actualizada con Exito..!'
                        });
                        break;
                    case "del":
                        if(statusCode == 201){
                                me.nubes.splice(this.editedNube,1);
                                Toast.fire({
                                    icon: 'success',
                                    'title': 'Nube Eliminar..!'
                                });
                            }else{
                            Toast.fire({
                                icon: 'warning',
                                'title': 'Error al eliminar la Nube, intente de nuevo'
                            });
                        }
                        break;

                    }
        },
      
    },
    mounted() {
         //this.$swal()
     this.fetchNubes();
        }
}
</script>