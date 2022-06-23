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
                            <a href="#" @click="editModalDet(sancione)">
                                <i type="button"  class='fas far fa-clipboard green' title="Ver Detalle" data-toggle="modal" data-target="#VerDetalle" ></i>
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

                            <h5 class="modal-title" v-show="!editmode"> Ingresar Nueva Sancion</h5>
                            <h5 class="modal-title" v-show="editmode"> Modificar Sancion </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <form @submit.prevent="editmode ? updateSancione() : createSancione()" >

                        <div class="modal-body">
                            <div class="row">
                                <div class="text-center">
                                    <div class="col-md-4">
                                        <img  v-bind:src="'/images/' + form.lup + '.jpg'" onerror="this.src='/images/SinFoto2.jpg'" height="100" width="100" class="img-circle" />
                                        <br>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <br>
                                    <div v-for="personal in personal.data" :key="personal.id">
                                        <h3 v-if="personal.id == form.personal_id " class="text-capitalize ">{{personal.catpersonal.detalle + " " + personal.apellido + ", " + personal.nombre}}</h3>
                                    </div>
                                    <hr>
                                </div>
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

                                <input v-model="form.lup" type="hidden" name="lup"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('lup') }">
                                <has-error :form="form" field="lup"></has-error>


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
                                    <label>Destino</label>
                                    <input v-model="form.destino" type="text" name="destino"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('destino') }">
                                    <has-error :form="form" field="destino"></has-error>
                                </div>

                                <div class="col-md-6">
                                    <label>Destino General</label>
                                    <input v-model="form.dest_gral" type="text" name="dest_gral"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('dest_gral') }">
                                    <has-error :form="form" field="dest_gral"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Fecha de la Sancion</label>
                                    <input v-model="form.fecha_sancion" type="date" name="fecha_sancion"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('fecha_sancion') }">
                                    <has-error :form="form" field="fecha_sancion"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <label>Tipo de Sancion</label>
                                    <!-- <input v-model="form.tipo_sancion" type="text" name="tipo_sancion"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('tipo_sancion') }">
                                    <has-error :form="form" field="tipo_sancion"></has-error> -->

                                    <select class="form-control" v-model="form.tipo_sancion" type="text" name="tipo_sancion">
                                        <option value="Apercibimiento">Apercibimiento</option>
                                        <option value="Apercibimiento Leve">Apercibimiento Leve</option>
                                        <option value="Apercibimiento Grave">Apercibimiento Grave</option>
                                        <option value="Suspencion de Empleo">Suspencion de Empleo</option>
                                    </select>
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
                                        class="form-control text-uppercase" :class="{ 'is-invalid': form.errors.has('detalle') }"></textarea>
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
                                        class="form-control text-uppercase" :class="{ 'is-invalid': form.errors.has('observaciones') }"></textarea>
                                    <has-error :form="form" field="observaciones"></has-error>
                                </div>

                            </div>

                            </div>
                        <div class="modal-footer">

                            <div class="col-md-12">
                            <form class="was-validated">
                                <div class="input-group ">
                                    <input type="file" class="form-control" accept="application/pdf"  aria-label="file example" id="pdf" required>
                                    <button class="btn btn-primary" type="button">Archivar PDF</button>
                                </div>
                            </form>
                            </div>
                                <!-- Muestra el nombre del archivo REVISAR
                                <form action="/ver.vue">
                                <label for="myfile">Select a file:</label>
                                <input type="file" id="myfile" name="myfile"><br><br>
                                <input type="submit" value="Submit">
                                </form> -->

                                <button type="button" class="btn btn-primary" data-dismiss="modal" >Ver PDF</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="borrarInpPDF">Cerrar</button>

                                <button v-show="editmode" type="submit" class="btn btn-success">Grabar Modificación</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Grabar</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detalle -->
<!--
        <div class="modal fade" id="VerDetalle" tabindex="-1" role="dialog" aria-labelledby="VerDetalle" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" style="max-width: 50%!important;" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Detalle de la Sanción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="text-center">
                                <div class="col-md-4">
                                    <img  v-bind:src="'/images/' + form.lup + '.jpg'" onerror="this.src='/images/SinFoto2.jpg'" height="100" width="100" class="img-circle" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <div v-for="personal in personal.data" :key="personal.id">
                                    <h3 v-if="personal.id == form.personal_id " class="text-capitalize ">{{personal.catpersonal.detalle + " " + personal.apellido + ", " + personal.nombre}}</h3>
                                </div>
                                <label>Nro de L.U.P. :  {{form.lup}}</label>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <br><br><label>Fecha de la Sancion : {{ form.fecha_sancion }}</label><br>
                            </div>
                            <div class="col-md-4">
                                 <label class="text-capitalize"> Tipo de Sancion : {{ form.tipo_sancion }}</label><br>
                            </div>
                            <div class="col-md-4">
                                <label>Número de RR.HH. : {{ form.numero_rrhh }}</label><br>
                            </div>
                            <div class="col-md-4">
                                 <label> Destino : {{ form.destino }}</label><br>
                            </div>
                            <div class="col-md-4">
                                <label>Destino Gral. : {{ form.dest_gral }}</label><br>
                            </div>
                            <div class="col-md-4">
                                 <label> Suspension de Emp. : {{ form.susp_empleo }}</label><br>
                            </div>
                            <div class="col-md-4">
                                 <label> Fecha de la Notificacion : {{ form.fecha_not }}</label><br>
                            </div>
                            <div class="col-md-12">
                                 <label>Detalle : </label><br>
                                 <label align="justify" class="text-uppercase">{{ form.detalle }}</label><br>
                                <hr>
                            </div>
                            <div class="col-md-12" v-for="personal in personal.data" :key="personal.lup" >
                                <label v-if="personal.lup == form.Impuesta_lup" class="text-capitalize"> Impuesta por : {{form.Impuesta_lup + "  -  " + personal.catpersonal.detalle + " " + personal.apellido + ", " + personal.nombre}}</label>
                            </div>
                            <div class="col-md-12">
                                <hr>
                             </div>
                            <div class="col-md-4">
                                 <label> Cumplida : {{ form.cumplida }}</label><br>
                            </div>
                            <div class="col-md-4">
                                 <label> Primer Recurso : {{ form.pri_recurso }}</label><br>
                            </div>
                            <div class="col-md-4">
                                 <label> Segundo Recurso : {{ form.seg_recurso }}</label><br>
                            </div>
                            <div class="col-md-4">
                                 <label> Resolucion : {{ form.resolucion }}</label><br>
                            </div>
                            <div class="col-md-4">
                                 <label> Notificacion : {{ form.notificacion }}</label><br>
                            </div>
                            <div class="col-md-12">
                                 <label>Observaciones : </label><br>
                                 <label align="justify" class="text-uppercase">{{ form.observaciones }}</label><br>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                            <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                            <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                            </svg>
                            Ver PDF
                        </button>
                        <button class="btn btn-primary" data-dismiss="modal">

                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Volver</button>
                    </div>

                </div>
            </div>
        </div> -->

        <!-- Fin Modal Detalle -->

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


          borrarInpPDF(){
                document.getElementById("pdf").value = "";
            },

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
            console.log(sancione)
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(sancione);

          },
          editModalDet(sancione){

              this.editmode = true;
              this.form.reset();
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

            console.log('Debuggeando con JAVSCRiPT: ' + JSON.stringify(this.form));
            //this.$Progress.finish();
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
