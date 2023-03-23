<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        <div class="col-6">
                            <h4 class="float-start"> Listado de Archivos </h4>
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
                               <th scope="col">Nombres</th>
                               <th scope="col">Nube</th>
                               <th scope="col">Tipo Archivo</th>
                               <th scope="col">Fecha Ingreso</th>
                               <th scope="col">Tamaño</th>
                               <th scope="col">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in archivos" :key="item.id">
                                <td>{{ item.nombre }}</td>
                                <td>{{ item.nube.almacenamiento }}</td>
                                <td>{{ item.detalle_archivo.tipo_archivo }}</td>
                                <td>{{ item.detalle_archivo.fecha_ingreso }}</td>
                                <td>{{ item.detalle_archivo.tamaño }}</td>
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
<div class="modal fade" id="archivoModal" tabindex="-1" aria-labelledby="archivoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="archivoModalLabel">{{ formTitle }}</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--definiendo cuerpo del formulario modal-->
        <div class="row">
            <div class="form-group col-12">
            <label for="Nombre">Nombre</label>
            <input type="text" class="form-control" v-model="archivo.nombre">
        </div>
        <div class="col-6">
                            <label for="nube">Nube</label>
                            <select v-model="archivo.nube_id" class="form-control">
                                <option v-for="nube in nubes" :value="nube.id">
                                    {{ nube.almacenamiento }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="detalle_archivo">Detalle Archivo</label>
                            <select v-model="archivo.detalle_archivo_id" class="form-control">
                                <option v-for="detalle_archivo in detalle_archivos" :value="detalle_archivo.id">
                                    {{ detalle_archivo.tipo_archivo }}
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
                archivos: [],
                archivo:{
                    id:null,
                    nombre:"",
                    nube: null,
                    detalle_archivo: null,
                    nube_id: null,
                    detalle_archivo_id: null
                },
                editedArchivo: -1,
                archivoErrors:{
                    nombre:false,
                    nube: false,
                    detalle_archivo: false
                }
            }
        },
        computed:{
            formTitle(){
                return this.archivo.id == null ? "Agregar Archivo" : "Actualizar Archivo";
            },
            btnTitle(){
                return this.archivo.id == null ? "Guardar" : "Actualizar";
            }
        },
        methods:{
            async fetchArchivos(){
                let me = this;
                await this.axios.get('/archivos')
                .then(response =>{
                    me.archivos = response.data;
                })
            },
            async fetchNubes() {
            let me = this;
            await this.axios.get('/nubes')
            .then(response => {
                me.nubes = response.data;
            })
        },
        async fetchDetalle() {
            let me = this;
            await this.axios.get('/detalle_archivos')
            .then(response => {
                me.detalle_archivos = response.data;
            });
        },
            showDialog(){
                this.archivo = {
                    id:null,
                    nombre:"",
                    nube: null,
                    detalle_archivo: null,
                    nube_id: null,
                    detalle_archivo_id: null
                };
                this.archivoErrors = {
                    nombre:false,
                    nube: false,
                    detalle_archivo: false
                };
                $('#archivoModal').modal('show');
            },
            showDialogEditar(archivo){
                let me = this;
                $('#archivoModal').modal('show');
                me.editedArchivo = me.archivos.indexOf(archivo);
                me.archivo = Object.assign({},archivo);
            },
            hideDialog(){
                let me = this;
                setTimeout(() => {
                    me.archivo = {
                        id:null,
                        nombre:"",
                        nube: null,
                        detalle_archivo: null,
                    };
                },300)
                $('#archivoModal').modal('hide');
            },
            async saveOrUpdate() {
            let me = this;

            me.archivo.nombre == '' ? me.archivoErrors.nombre = true : me.archivoErrors.nombre = false;
            me.archivo.nube_id == null ? me.archivoErrors.nube = true : me.archivoErrors.nube = false;
            me.archivo.detalle_archivo_id == null ? me.archivoErrors.detalle_archivo = true : me.archivoErrors.detalle_archivo = false;
            if (me.archivo.nombre) {
                let accion = me.archivo.id == null ? "add" : "upd";

                me.archivo.nube = {
                    "id": me.archivo.nube_id
                };
                me.archivo.detalle_archivo = {
                    "id": me.archivo.detalle_archivo_id
                };
                if (accion == "add") {
                    await this.axios.post('/archivos', me.archivo)
                        .then(response => {
                            //console.log(response.data);
                            if (response.status == 201) {
                                me.verificarAccion(
                                    response.data.data,
                                    response.status,
                                    accion)
                                me.hideDialog();

                            }
                        }).catch(errors => {
                            console.log(errors);
                        })
                } else {
                    // peticion para actualizar una marca
                    await this.axios
                        .put(`/archivos/${me.archivo.id}`, me.archivo)
                        .then(response => {
                            if (response.status == 202) {
                                me.verificarAccion(
                                    response.data.data,
                                    response.status,
                                    accion
                                );
                                me.hideDialog();
                            }
                        }).catch((errors) => {
                            console.log(errors);
                        });
                }
            }
        },
            async eliminar(archivo){
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
                        me.editedNube = me.nubes.indexOf(archivo);
                        this.axios.delete(`/archivos/${archivo.id}`)
                        .then(response => {
                            me.verificarAccion(null,response.status,"del");
                        }).catch(errors => {
                            console.log(errors);
                        })
                    }
                })
                   
            },
            verificarAccion(archivo,statusCode, accion){
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
                    me.fetchArchivos();
                    Toast.fire({
                        icon: 'success',
                        'title': 'Auto Registrada con Exito...!'
                    });
                    break;
                        break;
                    case "upd":
                        Object.assign(me.archivos[me.editedArchivo], archivo);
                        Toast.fire({
                            icon: 'success',
                            'title': 'Nube Actualizada con Exito..!'
                        });
                        break;
                    case "del":
                        if(statusCode == 201){
                                me.archivos.splice(this.editedArchivo,1);
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
     this.fetchArchivos();
            this.fetchNubes();
            this.fetchDetalle();
        }
}
</script>