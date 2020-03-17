<template id="filtro-actividades">
  <div class="card">
    <ul class="list-group list-group-flush">
      <li class="list-group-item d-print-none">
        <div class="input-group input-group-sm">
          <select 
            class="form-control" 
            v-model="filtro.semana" 
            aria-label="Lista de semanas">
            <option :value="null">Semana</option>
            <option 
              v-for="(s, i) in semanas" 
              :value="s"
              :key="s">{{ s }}</option>
          </select>
          <select 
            class="form-control" 
            v-model="filtro.responsable" 
            aria-label="Lista de responsables de actividades">
            <option value="todos">Responsable</option>
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
          aria-label="Nombre del proyecto">
          <div class="input-group-append">
            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Vista</button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
              <a class="dropdown-item" href="javascript:;" @click="modo = 1">Lista</a>
              <a class="dropdown-item" href="javascript:;" @click="modo = 2">Cronograma</a>
            </div>
          </div>
        </div>
      </li>
      <template v-if="modo == 1">
        <actividad-item  
          v-for="(i, index) in lista"
          :act="i"
          :detalle="detalle"
          :key="i.actividad"
          v-on:proyecto="proyecto"
          :index="index">
        </actividad-item>
      </template>
      <template v-if="modo == 2">
        <cronograma-lista :actividades="lista" :expandir="expandir"></cronograma-lista>
      </template>
    </ul>
  </div>
</template>