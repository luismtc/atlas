<div id="contenidoProyecto">
  <?php $this->load->view('proyecto/encabezado'); ?>
  
  <main role="main" class="container mt-2">
    <div class="row">
      <div :class="expandir ? 'col-sm-12' : 'offset-sm-2 col-sm-8'">
        <div class="card" v-if="actual == 1">
          <div class="card-body">
            <form @submit.prevent="buscarProyecto" autocomplete="off">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" id="inputPendientes" v-model="form.pendientes">
                  </div>
                </div>
                <input 
                  type="search" 
                  placeholder="Buscar" 
                  aria-label="Buscar" 
                  aria-describedby="buscarAtlas" 
                  class="form-control form-control-sm" 
                  :required="!form.pendientes"
                  v-model="form.titulo">
                <div class="input-group-append">
                  <button 
                    type="submit" 
                    id="buscarAtlas" 
                    aria-label="Buscar"
                    class="btn btn-sm btn-outline-secondary px-4"
                  >
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>

          <div class="list-group list-group-flush" v-if="listaProductos.length > 0">
            <a 
              v-for="(i, index) in listaProductos"
              href="#"
              class="list-group-item list-group-item-action border border-info bg-secondary text-white"
              @click.prevent="verProyecto(i)"
            >
              <div class="row">
                <div class="col-sm-4 font-weight-normal">{{ i.titulo }}</div>
                <div class="col-sm-7 font-weight-lighter">{{ i.descripcion }}</div>
                <div class="col-sm-1 font-weight-normal">{{ i.avance }}%</div>
              </div>
            </a>
          </div>
        </div>

        <?php $this->load->view('proyecto/form_bform'); ?>

        <form-proyecto v-if="actual == 4" :catalogo="catalogo"></form-proyecto>
      </div>
    </div>
    <ver-proyecto 
      v-if="actual == 3" 
      :proyecto="proyecto" 
      :catalogo="catalogo"
      v-on:regresar="retorno"
    ></ver-proyecto>
    <keep-alive>
      <indicador 
        v-if="actual == 5" 
        :catalogo="catalogo"
        v-on:regresar="retorno"
      ></indicador>
    </keep-alive>
  </main>
</div>

<?php $this->load->view('proyecto/cronograma'); ?>
<?php $this->load->view('proyecto/filtro_actividades'); ?>
<?php $this->load->view('proyecto/form'); ?>
<?php $this->load->view('proyecto/ver'); ?>
<?php $this->load->view('especifico/ver'); ?>
<?php $this->load->view('actividad/form'); ?>
<?php $this->load->view('actividad/lista'); ?>
<?php $this->load->view('indicador/principal'); ?>
