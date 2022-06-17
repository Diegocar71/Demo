<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Listado de Sanciones</h3>

                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" size="6" maxlength="6" placeholder="Buscar por LUP">

                            <!-- Realizar la busqueda por LUP -->
                            <button class="btn btn-navbar" type="submit">
                                <i class="fa fa-search"></i>
                                <!-- Realizar la busqueda -->
                            </button>

                            <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                                <i class="fa fa-plus-square"></i>
                                Agregar Sanción
                            </button>

                        </div>
                    </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                        <th>L.U.P.</th>
                        <th>Personal</th>
                        <th>Fecha Sanción</th>
                        <th>Tipo Sanción</th>
                        <th>Impuesta por</th>
                        <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sancione in sanciones.data" :key="sancione.id">

                        <td >{{sancione.lup }}</td>
                        <td class="text-capitalize">{{sancione.catpersonal.detalle + " " + sancione.personal.apellido + ", " + sancione.personal.nombre}}</td>
                        <td>{{sancione.fecha_sancion}}</td>
                        <td class="text-capitalize">{{sancione.tipo_sancion}}</td>
                        <td>{{sancione.Impuesta_lup}}</td>

                        <td>

                            <a href="#" @click="editModal(sancione)">
                                <i class="fa fa-edit blue" title="Editar"></i>
                            </a>
                            /
                            <a href="#" @click="deleteSancione(sancione.id)">
                                <i class="fa fa-trash red" title="Eliminar"></i>
                            </a>
                            /
                            <!-- Boton para ver los Detalles -->

                            <a href="#" @click="VerDetalle(sancione.id)">
                                <router-link to="/detallesancion"> <i class='fas far fa-clipboard green' title="Ver Detalle" ></i> </router-link>
                            </a>

                        </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="sanciones" @pagination-change-page="getResults"></pagination>
                </div>

                </div>
                <!-- /.card -->
            </div>


            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 50%!important;" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <!-- <img  v-bind:src="'/images/logoPsa2.png'" height="30" width="30" class="img-circle"/> -->
                        <h5 class="modal-title" v-show="!editmode"> Ingresar Nueva Sancion</h5>
                        <h5 class="modal-title" v-show="editmode"> Modificar Sancion </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode ? updateSancione() : createSancione()" >

                        <div class="modal-body">
                            <div class="text-center">
                                <img  v-bind:src="'/images/' + form.lup + '.jpg'" onerror="this.src='/images/SinFoto2.jpg'" height="100" width="100" class="img-circle" />
                                <has-error :form="form" field="foto"></has-error>
                                <hr>

                                <div v-for="personal in personal.data" :key="personal.id">
                                    <h3 v-if="personal.id == form.personal_id " class="text-capitalize ">{{personal.catpersonal.detalle + " " + personal.apellido + ", " + personal.nombre}}</h3>
                                </div>

                                <hr>
                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <label>L.U.P.</label>
                                    <select class="form-control" v-model="form.personal_id">
                                    <option
                                        v-for="(cat,index) in legajo" :key="index"
                                        :value="index"
                                        :selected="index == form.personal_id">{{ cat }}</option>
                                    </select>
                                    <has-error :form="form" field="personal_id"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Nº de Disposición</label>
                                    <input v-model="form.numero_disp" type="text" name="numero_disp"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('numero_disp') }">
                                    <has-error :form="form" field="numero_disp"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Nº de RR.HH.</label>
                                    <input v-model="form.numero_rrhh" type="text" name="numero_rrhh"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('numero_rrhh') }">
                                    <has-error :form="form" field="numero_rrhh"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Categoria</label>
                                    <select class="form-control" v-model="form.catpersonal_id">
                                    <option
                                        v-for="(cat,index) in categorias" :key="index"
                                        :value="index"
                                        :selected="index == form.catpersonal_id">{{ cat }}</option>
                                    </select>
                                    <has-error :form="form" field="catpersonal_id"></has-error>
                                </div>

                                <div class="col-md-6">
                                    <label>Destino General</label>
                                    <input v-model="form.dest_gral" type="text" name="dest_gral"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('dest_gral') }">
                                    <has-error :form="form" field="dest_gral"></has-error>
                                </div>

                                <div class="col-md-6">
                                    <label>Destino</label>
                                    <input v-model="form.destino" type="text" name="destino"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('destino') }">
                                    <has-error :form="form" field="destino"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Fecha de la Sancion</label>
                                    <input v-model="form.fecha_sancion" type="date" name="fecha_sancion"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('fecha_sancion') }">
                                    <has-error :form="form" field="fecha_sancion"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Tipo de Sancion</label>
                                    <input v-model="form.tipo_sancion" type="text" name="tipo_sancion"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('tipo_sancion') }">
                                    <has-error :form="form" field="tipo_sancion"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Suspension de Empleo</label>
                                    <input v-model="form.susp_empleo" type="text" name="susp_empleo"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('susp_empleo') }">
                                    <has-error :form="form" field="susp_empleo"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Fecha de la Notificacion</label>
                                    <input v-model="form.fecha_not" type="date" name="fecha_not"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('fecha_not') }">
                                    <has-error :form="form" field="fecha_not"></has-error>
                                </div>

                                <div class="col-md-12">
                                    <label>Detalle</label>
                                    <textarea v-model="form.detalle" name="detalle"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('detalle') }"></textarea>
                                    <has-error :form="form" field="detalle"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Impuesta por</label>
                                    <input v-model="form.Impuesta_lup" type="text" name="Impuesta_lup"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('Impuesta_lup') }">
                                    <has-error :form="form" field="Impuesta_lup"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Cumplida</label>
                                    <input v-model="form.cumplida" type="text" name="cumplida"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('cumplida') }">
                                    <has-error :form="form" field="cumplida"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>1º Recurso</label>
                                    <input v-model="form.pri_recurso" type="text" name="pri_recurso"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('pri_recurso') }">
                                    <has-error :form="form" field="pri_recurso"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>2º Recurso</label>
                                    <input v-model="form.seg_recurso" type="text" name="seg_recurso"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('seg_recurso') }">
                                    <has-error :form="form" field="seg_recurso"></has-error>
                                </div>

                                <div class="col-md-8">
                                    <label>Resolucion</label>
                                    <input v-model="form.resolucion" type="text" name="resolucion"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('resolucion') }">
                                    <has-error :form="form" field="resolucion"></has-error>
                                </div>

                                <div class="col-md-4">
                                    <label>Notificacion</label>
                                    <input v-model="form.notificacion" type="text" name="notificacion"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('notificacion') }">
                                    <has-error :form="form" field="notificacion"></has-error>
                                </div>

                                <div class="col-md-12">
                                    <label>Observaciones</label>
                                    <textarea v-model="form.observaciones" name="observaciones"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('observaciones') }"></textarea>
                                    <has-error :form="form" field="observaciones"></has-error>
                                </div>

                            </div>

                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Grabar Modificación</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Grabar</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</template>


<script>

    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
      components: {
          VueTagsInput,
        },
        data () {
            return {
                editmode: false,
                sanciones : {},
                personal: {},
                form: new Form({
                    id : '',
                    personal_id: '',
                    lup : '',
                    numero_disp : '',
                    numero_rrhh : '',
                    catpersonal_id: '',
                    dest_gral: '',
                    destino: '',
                    fecha_sancion: '',
                    tipo_sancion: '',
                    susp_empleo: '',
                    fecha_not: '',
                    detalle: '',
                    Impuesta_lup: '',
                    cumplida: '',
                    pri_recurso: '',
                    seg_recurso: '',
                    resolucion: '',
                    notificacion: '',
                    observaciones: '',


                }),
                categorias: [],
                legajo: [],
                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();

              axios.get('api/sancione?page=' + page).then(({ data }) => (this.sanciones = data.data));

              this.$Progress.finish();
          },
          loadSanciones(){

            // if(this.$gate.isAdmin()){
              axios.get("api/sancione").then(({ data }) => (this.sanciones = data.data));
            // }
          },
          loadCatpersonal(){
              axios.get("/api/catpersonal/list").then(({ data }) => (this.categorias = data.data));
          },
          loadPersonal(){

            // if(this.$gate.isAdmin()){
              axios.get("api/personal").then(({ data }) => (this.personal = data.data));
            // }
          },
          loadLegPersonal(){
              axios.get("/api/personal/list").then(({ data }) => (this.legajo = data.data));
          },

          editModal(sancione){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(sancione);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createSancione(){
              this.$Progress.start();

              this.form.post('api/sancione')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadSanciones();

                } else {
                  Toast.fire({
                      icon: 'error',
                      title: '¡Ocurrió algún error! Inténtalo de nuevo'
                  });

                  this.$Progress.failed();
                }
              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: '¡Ocurrió algún error! Inténtalo de nuevo'
                  });
              })
          },
          updateSancione(){
              this.$Progress.start();
              this.form.put('api/sancione/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadSanciones();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteSancione(id){
              Swal.fire({
                  title: '¿Usted esta seguro?',
                  text: "¡No podrá revertir esto!",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: '¡Sí, bórralo!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/sancione/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadSancione();
                              }).catch((data)=> {
                                  Swal.fire("¡Ha fallado!", data.message, "Advertencia");
                              });
                        }
                  })
          },

        },
        mounted() {

        },
        created() {
            this.$Progress.start();

            this.loadSanciones();
            this.loadCatpersonal();
            this.loadLegPersonal();
            this.loadPersonal();

            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
        },
    }
</script>
