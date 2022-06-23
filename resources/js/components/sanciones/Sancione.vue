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
                    <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                        <i class="fa fa-plus-square"></i>
                        Agegar Una Sancion
                    </button>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>L.U.P.</th>
                      <th>Categoria o Grado</th>
                      <th>Tipo de Sancion</th>
                      <th>Fecha de la Sancion</th>
                      <th>Accion</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="sancione in sanciones.data" :key="sancione.id">

                        <td>{{sancione.lup}}</td>
                        <td>{{sancione.catpersonal.detalle}}</td>
                        <td>{{sancione.tipo_sancion}}</td>
                        <td>{{sancione.fecha_sancion}}</td>
                        <td>

                        <a href="#" @click="editModal(sancione)">
                            <i class="fa fa-edit blue" title="Editar"></i>
                        </a>
                        /
                        <a href="#" @click="deletePersonal(sancione.id)">
                            <i class="fa fa-trash red" title="Eliminar"></i>
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
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode">Ingresar Nueva Sancion</h5>
                        <h5 class="modal-title" v-show="editmode">Modificar Sancion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode ? updateSancione() : createSancione()">
                        <div class="modal-body">

                            <!-- <input v-model="form.personal_id" type="text" name="personal_id"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('personal_id') }">
                            <has-error :form="form" field="personal_id"></has-error> -->

                            <div class="text-center">
                                <img  v-bind:src="'/images/' + form.lup + '.jpg'" onerror="this.src='/images/SinFoto2.jpg'" height="100" width="100" class="img-circle" >
                                <has-error :form="form" field="foto"></has-error>
                            </div>
                            <div class="form-group">
                                <label>L.U.P.</label>
                                <input v-model="form.lup" type="text" name="lup"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('lup') }">
                                <has-error :form="form" field="lup"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Categoria</label>
                                <select class="form-control" v-model="form.catpersonal_id">
                                <option
                                    v-for="(cat,index) in categorias" :key="index"
                                    :value="index"
                                    :selected="index == form.catpersonal_id">{{ cat }}</option>
                                </select>
                                <has-error :form="form" field="catpersonal_id"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Sancion</label>
                                <input v-model="form.tipo_sancion" type="text" name="tipo_sancion"
                                    class="form-control text-capitalize" :class="{ 'is-invalid': form.errors.has('tipo_sancion') }">
                                <has-error :form="form" field="tipo_sancion"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Fecha de la Sancion</label>
                                <input v-model="form.fecha_sancion" type="text" name="fecha_sancion" class="form-control" :class="{ 'is-invalid': form.errors.has('fecha_sancion') }">
                                <has-error :form="form" field="fecha_sancion"></has-error>
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
                form: new Form({
                    id : '',
                    // personal_id : '',
                    lup : '',
                    tipo_sancion : '',
                    fecha_sancion: '',
                    catpersonal_id: '',

                }),
                categorias: [],

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
              this.form.put('api/sancione/'+ this.form.id)
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
                                      '¡Eliminado!',
                                      'Su archivo ha sido Eliminado.',
                                      'éxito'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadSanciones();
                              }).catch((data)=> {
                                  Swal.fire("¡Ha fallado!", data.message, "Avertencia");
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

            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },

    }

</script>
