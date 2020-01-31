<div id="contenidoProyecto">
  <header>
    <ul class="nav justify-content-center mt-2">
      <li class="nav-item ml-2 mr-2" v-for="(i, index) in menu" :index="index" :key="i.valor">
        <button 
          v-if="i.href === false"
          type="button" 
          class="btn btn-outline-dark rounded-circle" 
          :class="{active:actual == i.valor}"
          :title="i.titulo" 
          aria-label="Opción"
          @click.prevent="actual = i.valor"
        >
          <i :class="i.icono" aria-hidden="true"></i> 
        </button>
        <a 
          v-else
          :href="i.href"
          class="btn btn-outline-dark rounded-circle" 
          :title="i.titulo" 
          aria-label="Opción"
        >
          <i :class="i.icono" aria-hidden="true"></i> 
        </a>
      </li>
    </ul>
  </header>
  
  <main role="main" class="container mt-2">
    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <div class="card" v-if="actual == 0">
          <div class="card-body">
            <form @submit.prevent="buscarProyecto" autocomplete="off">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" id="inputPendientes" v-model="form.pendientes">
                  </div>
                </div>
                <input type="search" placeholder="Buscar" aria-label="Buscar" aria-describedby="buscarAtlas" class="form-control form-control-sm" v-model="form.titulo">
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
        </div>

        <div class="list-group" v-if="listaProductos !== null && actual == 1">
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

        <div class="card" v-if="listaPendientes.length > 0 && actual == 2">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <div class="input-group input-group-sm">
                <select 
                  class="form-control" 
                  v-model="filtro.responsable" 
                  aria-label="Lista de responsables de actividades">
                  <option value="todos">TODOS</option>
                  <option 
                    v-for="(r, i) in responsables" 
                    :value="r.id"
                    :key="r.id">{{ r.nombre }}</option>
                </select>
                <input
                type="search"
                class="form-control"
                v-model="filtro.nombre"
                placeholder="Nombre del proyecto"
                aria-label="Nombre del proyecto"
                aria-describedby="btn-buscar">
                <div class="input-group-append">
                  <span class="input-group-text px-4" id="btn-buscar">
                    <span class="fa fa-search"></span>
                  </span>
                </div>
              </div>
            </li>
            <pendiente  
              v-for="(i, index) in pendientes"
              :act="i"
              :detalle="true"
              v-on:proyecto="verProyecto"
              :key="i.actividad"
              :index="index">
            </pendiente>
          </ul>
        </div>

        <form-proyecto v-if="actual == 4"></form-proyecto>
      </div>
    </div>
    <ver-proyecto v-if="actual == 3" :proyecto="proyecto" v-on:regresar="retorno"></ver-proyecto>
    <keep-alive>
      <indicador v-if="actual == 5" v-on:regresar="retorno"></indicador>
    </keep-alive>
  </main>
</div>

<?php $this->load->view('proyecto/form'); ?>
<?php $this->load->view('proyecto/ver'); ?>
<?php $this->load->view('especifico/ver'); ?>
<?php $this->load->view('actividad/form'); ?>
<?php $this->load->view('actividad/lista'); ?>
<?php $this->load->view('indicador/principal'); ?>