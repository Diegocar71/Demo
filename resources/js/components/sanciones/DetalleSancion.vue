<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detalle de la Sanción</h3>

                            <router-link to="/sanciones"><button type="button" class="btn btn-sm btn-primary float-right">
                                <i class="fa fa-reply-all" aria-hidden="true"></i>
                                Volver
                            </button></router-link>
                        </div>

                        <!-- Detalle de la Sancion -->

                        <div class="card-body">
                            <div class="text-left">
                                <img  v-bind:src="'/images/' + 501004 + '.jpg'" onerror="this.src='/images/SinFoto2.jpg'" height="100" width="100" class="img-circle" >
                                <has-error :form="form" field="foto"></has-error>
                            </div>

                            <hr>
                            <br>
                            <label>L.U.P.:</label>
                        </div>

                        <!-- Fin Detalle de la Sancion -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
