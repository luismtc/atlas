<template id="ver-proyecto">
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="btn-group" role="group" aria-label="Basic example">
          <button type="button" class="btn btn-secondary pl-4 pr-4" @click="$emit('regresar')">
            <i class="fa fa-arrow-left"></i>
          </button>
          <button 
            type="button" 
            class="btn btn-secondary" 
            v-if="fagregar" 
            @click="formEspecifico = !formEspecifico">
            <i class="fa fa-plus"></i> Específico
          </button>
        </div>
      </div>
      <div class="col-sm-6 text-right">
        <strong>{{ proyecto.titulo }}</strong>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-sm-4">
        <ul class="list-group">
          <li class="list-group-item" v-if="formEspecifico">
            <div class="form-group">
              <textarea class="form-control" v-model="descEspecifico" rows="3"></textarea>
            </div>
            <div class="form-group">
              <button class="btn btn-sm btn-primary" @click="guardarEspecifico">
                <i class="fa fa-save"></i> Guardar
              </button>
            </div>
          </li>
          <a
            href="#"
            class="list-group-item list-group-item-action"
            :class="['list-group-item', 'list-group-item-action', {active: opcion == 1}]"
            @click="opcion = 1; actualEspecifico = null;"
          >
            Descripción
          </a>
          <a 
            href="javascript:;"
            v-for="(i, index) in listaEspecificos"
            :class="['list-group-item', 'list-group-item-action', {active: i === actualEspecifico}]"
            @click="verEspecifico(index)"
          >
            {{ i.descripcion }} <span class="badge badge-pill badge-secondary pull-right">{{ i.avance }}%</span>
          </a>
        </ul>
      </div>
      <div class="col-sm-8">
        <div class="card" v-if="opcion == 1">
          <div class="card-body" v-html="proyecto.descripcion"></div>
        </div>
        <div v-if="opcion == 2">
          <especifico-ver :esp="actualEspecifico"><especifico-ver>
        </div>
      </div>
    </div>
  </div>
</div>
</template>