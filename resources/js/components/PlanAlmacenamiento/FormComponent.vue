<template>
    <div class="container">
        <div class="row justify-content-center" v-for="item in archivos" :key="item.id">
                <div class="card" style="width: 18rem;">
              <img src="https://picsum.photos/300/300" class="card-img-top" alt="">
              <div class="card-body">
                <h5 class="card-title text-bold">{{ item.tamaño.tamaño }}&nbsp;{{ item.tipo_archivo.tipo_archivo }}</h5>
                <p class="card-text"></p>
                <a href="#" class="btn btn-primary">Comprar</a>
              </div>
            </div>
            </div>
    </div>
</template>

<script>
    export default {
        props: ["user"],
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
                    fecha_ingreso:null,
                    user: null
                },
                
                nubes:[],
                tipo_archivos:[],
                tamaños:[],
                fecha_ingresos:[]   
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

      
    },
    mounted() {
     this.fetchArchivos();
     //this.fetchNubes();
     //this.fetchTipos();
     //this.fetchTamaños();
     //this.fetchFechas();

        }
}
</script>