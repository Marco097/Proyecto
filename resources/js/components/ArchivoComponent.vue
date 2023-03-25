<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        <div class="col-6">
                            <h5 class="float-start">Listado de Archivos </h5>
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
                               <th scope="col">Nombre</th>
                               <th scope="col">Nube</th>
                               <th scope="col">Tipo Archivo</th>
                               <th scope="col">Tamaño</th>
                               <th scope="col">Fecha Ingreso</th>
                               <th scope="col">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in archivos" :key="item.id">
                                <td>{{ item.nombre }}</td>
                                <td>{{ item.nube.almacenamiento }}</td>
                                <td>{{ item.tipo_archivo.tipo_archivo }}</td>
                                <td>{{ item.tamaño.tamaño }}</td>
                                <td>{{ item.fecha_ingreso.fecha_ingreso }}</td>
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
  <div class="modal-dialog modal-dialog-centered moda-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="archivoModalLabel">{{ formTitle }}</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--definiendo cuerpo del formulario modal-->
        <div class="row">
            <div class="form-group col-6">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" v-model="archivo.nombre">
            <span class="text-danger" v-show="archivoErrors.nombre">Nombre es requerido</span>
        </div>
        <div class="col-6">
            <label for="nube">Nube</label>
            <select v-model="archivo.nube_id" class="form-control">
                <option v-for="nube in nubes" :value="nube.id">
                    {{ nube.almacenamiento }}
                </option>
            </select>
            <span class="text-danger" v-show="archivoErrors.nube">Seleccione la Nube </span>
        </div>
      </div>
      <div class="row">
            <div class="form-group col-6">
            <label for="tipo_archivo">Tipo Archivo</label>
            <select v-model="archivo.tipo_archivo_id" class="form-control">
                <option v-for="tipo_archivo in tipo_archivos" :value="tipo_archivo.id">
                    {{ tipo_archivo.tipo_archivo }}
                </option>
            </select>
            <span class="text-danger" v-show="archivoErrors.tipo_archivo"> Seleccione El tipo de archivo </span>
        </div>
        <div class="col-6">
            <label for="tamaño">Tamaño</label>
            <select v-model="archivo.tamaño_id" class="form-control">
                <option v-for="tamaño in tamaños" :value="tamaño.id">
                    {{ tamaño.tamaño }}
                </option>
            </select>
            <span class="text-danger" v-show="archivoErrors.tamaño"> Seleccione el Tamaño </span>
        </div>
      </div>
      <div class="row">
            <div class="form-group col-6">
            <label for="fecha_ingreso">Fecha Ingreso</label>
            <select v-model="archivo.fecha_ingreso_id" class="form-control">
                <option v-for="fecha_ingreso in fecha_ingresos" :value="fecha_ingreso.id">
                    {{ fecha_ingreso.fecha_ingreso }}
                </option>
            </select>
            <span class="text-danger" v-show="archivoErrors.fecha_ingreso"> Seleccione la Fecha </span>
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
                    nube_id:null,
                    tipo_archivo_id:null,
                    tamaño_id:null,
                    fecha_ingreso_id:null,
                    nube:null,
                    tipo_archivo:null,
                    tamaño:null,
                    fecha_ingreso:null
                },
                editedArchivo: -1,
                archivoErrors:{
                    nombre:false,
                    nube:false,
                    tipo_archivo:false,
                    tamaño:false,
                    fecha_ingreso:false
                },
                nubes:[],
                tipo_archivos:[],
                tamaños:[],
                fecha_ingresos:[]   
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
            async fetchNubes(){
                let me = this;
                await this.axios.get('/nubes')
                .then(response =>{
                    me.nubes = response.data;
                })
            },
            async fetchTipos(){
                let me = this;
                await this.axios.get('/tipo_archivos')
                .then(response =>{
                    me.tipo_archivos = response.data;
                })
            },
            async fetchTamaños(){
                let me = this;
                await this.axios.get('/tamaños')
                .then(response =>{
                    me.tamaños = response.data;
                })
            },
            async fetchFechas(){
                let me = this;
                await this.axios.get('/fecha_ingresos')
                .then(response =>{
                    me.fecha_ingresos = response.data;
                })
            },

            showDialog(){
                this.nube = {
                    id:null,
                    nombre:"",
                    nube:null,
                    tipo_archivo:null,
                    tamaño:null,
                    fecha_ingreso:null,
                    nube_id:null,
                    tipo_archivo_id:null,
                    tamaño_id:null,
                    fecha_ingreso_id:null
                };
                this.archivoErrors = {
                    nombre:false,
                    nube:false,
                    tipo_archivo:false,
                    tamaño:false,
                    fecha_ingreso:false
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
                       id: null,
                       nombre: "",
                       nube: null,
                       tipo_archivo: null,
                       tamaño: null,
                       fecha_ingreso: null
                    }
                },300);
                $('#archivoModal').modal('hide');
            },
            async saveOrUpdate(){
                let me = this;

                me.archivo.nombre == '' ? me.archivoErrors.nombre = true : me.archivoErrors.nombre = false;
                me.archivo.nube_id == null ? me.archivoErrors.nube = true : me.archivoErrors.nube = false;
                me.archivo.tipo_archivo_id == null ? me.archivoErrors.tipo_archivo = true : me.archivoErrors.tipo_archivo = false;
                me.archivo.tamaño_id == null ? me.archivoErrors.tamaño = true : me.archivoErrors.tamaño = false;
                me.archivo.fecha_ingreso_id == null ? me.archivoErrors.fecha_ingreso = true : me.archivoErrors.fecha_ingreso = false;

                if(me.archivo.nombre){
                    let accion = me.archivo.id == null ? "add" : "upd";
                    
                    me.archivo.nube = {
                        "id" : me.archivo.nube_id
                    };
                    me.archivo.tipo_archivo = {
                        "id" : me.archivo.tipo_archivo_id
                    };
                    me.archivo.tamaño = {
                        "id" : me.archivo.tamaño_id
                    };
                    me.archivo.fecha_ingreso = {
                        "id" : me.archivo.fecha_ingreso_id
                    };

                    if(accion == "add"){
                        await this.axios.post('/archivos', me.archivo)
                        .then(response => {
                            if(response.status == 201){
                            //console.log(response.data);
                            me.verificarAccion(response.data.data,response.status,accion);
                            me.hideDialog();
                            }
                        }).catch(errors =>{
                            console.log(errors);
                        })
                    }else{
                        await this.axios.put(`/archivos/${me.archivo.id}`, me.archivo)
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
                        me.editedArchivo = me.archivos.indexOf(this.archivo);
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
                        //me.archivos.unshift(nube);

                        me.fetchArchivos();
                        Toast.fire({
                            icon: 'success',
                            'title': 'Archivo Registrado con Exito..!'
                        });
                        break;
                    case "upd":
                        Object.assign(me.archivos[me.editedArchivo], archivo);
                        Toast.fire({
                            icon: 'success',
                            'title': 'Archivo Actualizado con Exito..!'
                        });
                        break;
                    case "del":
                        if(statusCode == 201){
                                me.archivos.splice(this.editedArchivo,1);
                                Toast.fire({
                                    icon: 'success',
                                    'title': 'Archivo Eliminado..!'
                                });
                            }else{
                            Toast.fire({
                                icon: 'warning',
                                'title': 'Error al eliminar la Archivo, intente de nuevo'
                            });
                        }
                        break;

                    }
        },
      
    },
    mounted() {
     this.fetchArchivos();
     this.fetchNubes();
     this.fetchTipos();
     this.fetchTamaños();
     this.fetchFechas();

        }
}
</script>