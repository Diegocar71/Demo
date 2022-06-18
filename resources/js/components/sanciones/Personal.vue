<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Listado del Personal</h3>

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
                        Agegar Personal
                    </button>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Foto</th>
                      <th>L.U.P.</th>
                      <th>Apellido</th>
                      <th>Nombre</th>
                      <th>Categoria</th>
                      <th>Accion</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="personal in personals.data" :key="personal.id">

                        <td><img v-bind:src="'/images/' + personal.lup + '.jpg'" onerror="this.src='/images/SinFoto2.jpg'" height="60" width="60" class="img-circle"></td>

                        <td>{{personal.lup}}</td>
                        <td class="text-capitalize">{{personal.apellido}}</td>
                        <td class="text-capitalize">{{personal.nombre}}</td>
                        <td class="text-capitalize">{{personal.catpersonal.detalle}}</td>
                        <td>

                        <a href="#" @click="editModal(personal)">
                            <i class="fa fa-edit blue" title="Editar"></i>
                        </a>
                        /
                        <a href="#" @click="deletePersonal(personal.id)">
                            <i class="fa fa-trash red" title="Eliminar"></i>
                        </a>
                        /

                        <!-- Boton para ver las Sanciones -->

                        <a href="#" @click="VerSancion(personal.id)">
                            <router-link to="/sanciones"> <i class='fas fa-address-card green' title="Ver Sanciones"></i> </router-link>
                        </a>

                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="personals" @pagination-change-page="getResults"></pagination>
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
                    <h5 class="modal-title" v-show="!editmode">Ingresar Nuevo Personal</h5>
                    <h5 class="modal-title" v-show="editmode">Modificar Personal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updatePersonal() : createPersonal()">
                    <div class="modal-body">
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
                            <label>Apellido</label>
                            <input v-model="form.apellido" type="text" name="apellido"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('apellido') }">
                            <has-error :form="form" field="apellido"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input v-model="form.nombre" type="text" name="nombre"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                            <has-error :form="form" field="nombre"></has-error>
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
                personals : {},
                form: new Form({
                    id : '',
                    lup : '',
                    apellido : '',
                    nombre: '',
                    catpersonal_id: '',

                }),
                categorias: [],
                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();

              axios.get('api/personal?page=' + page).then(({ data }) => (this.personals = data.data));

              this.$Progress.finish();
          },
          loadPersonals(){

            // if(this.$gate.isAdmin()){
              axios.get("api/personal").then(({ data }) => (this.personals = data.data));
            // }
          },
          loadCatpersonal(){
              axios.get("/api/catpersonal/list").then(({ data }) => (this.categorias = data.data));
          },

          editModal(personal){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(personal);
           },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createPersonal(){
              this.$Progress.start();

              this.form.post('api/personal')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadPersonals();

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
                      title: '¡Ocurrió algún error! El Personal ya Existe'
                  });
              })
          },
          updatePersonal(){
              this.$Progress.start();
              this.form.put('api/personal/'+ this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadPersonals();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deletePersonal(id){
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
                              this.form.delete('api/personal/'+id).then(()=>{
                                      Swal.fire(
                                      '¡Eliminado!',
                                      'Su archivo ha sido Eliminado.',
                                      'éxito'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadPersonals();
                              }).catch((data)=> {
                                  Swal.fire("¡Ha fallado!", data.message, "aAvertencia");
                              });
                        }
                  })
          },

        },
        mounted() {

        },
        created() {
            this.$Progress.start();

            this.loadPersonals();
            this.loadCatpersonal();

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
