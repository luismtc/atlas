<div class="card mb-2" v-if="actual == 2">
  <div class="card-body px-2 py-2">
    <form @submit.prevent="verPendientes">
      <div class="input-group input-group-sm">
        <div class="input-group-prepend">
          <button 
            type="button" 
            id="btnExpandir" 
            aria-label="Expandir" 
            class="btn btn-sm btn-secondary"
            @click="expandir = !expandir"
          >
            <i aria-hidden="true" class="fa fa-expand-alt"></i>
          </button>
          <div class="input-group-text">
            <input 
              type="checkbox" 
              aria-label="Checkbox for following text input" 
              v-model="bform.pendiente"
              id="inputPendientes"
            >
          </div>
        </div>
        <input
          type="date"
          class="form-control"
          id="btnBfomrFdel"
          v-model="bform.ifdel"
          :required="!bform.pendiente"
          aria-label="Fecha del">
        <input
          type="date"
          class="form-control"
          id="btnBfomrFal"
          v-model="bform.ifal"
          :required="!bform.pendiente"
          aria-label="Fecha al">
        <div class="input-group-append">
          <button 
            type="submit" 
            id="btnBfomrBuscar" 
            aria-label="Buscar" 
            class="btn btn-sm btn-outline-secondary px-4"
          >
            <i aria-hidden="true" class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<template v-if="actual == 2 && actividades.length > 0">
  <filtro-actividades :actividades="actividades" :detalle="true"></filtro-actividades>
</template>