<template id="form-actividad">
<div>
  <div class="row mb-2" v-if="previa">
    <div class="offset-sm-2 col-sm-10">
      <button 
        type="button" 
        class="btn btn-sm btn-secondary" 
        @click="previa = !previa"
      >
        <i class="fa fa-arrow-left"></i> Cancelar
      </button>
      <div v-html="form.descripcion"></div>
    </div>
  </div>
  <form autocomplete="off" @submit.prevent="guardarActividad" v-if="!previa">
    <div class="form-group row mb-1">
      <label for="inputActividadSubTitulo" class="col-sm-2 col-form-label">Subtítulo:</label>
      <div class="col-sm-10">
        <input type="text" v-model="form.subtitulo" class="form-control form-control-sm" id="inputActividadSubTitulo">
      </div>
    </div>
    <div class="form-group row mb-1">
      <label for="selectResponsableActividad" class="col-sm-2 col-form-label">Responsable</label>
      <div class="col-sm-10">
        <select v-model="form.responsable" class="form-control form-control-sm" id="selectResponsableActividad">
          <option v-for="item in listaUsuarios" v-bind:value="item.id">{{ item.nombre }} {{ item.apellidos }}</option>
        </select>
      </div>
    </div>
    <div class="form-group row mb-1">
      <label for="fechaCompromiso" class="col-sm-2 col-form-label">Compromiso</label>
      <div class="col-sm-4">
        <input type="date" v-model="form.compromiso" class="form-control form-control-sm" id="fechaCompromiso">
      </div>
      <label for="inputHoras" class="col-sm-2 col-form-label">Horas</label>
      <div class="col-sm-4">
        <input type="number" step="0.01" v-model.number="form.horas" class="form-control form-control-sm" id="inputHoras">
      </div>
    </div>
    <div class="form-group row mb-2">
      <div class="offset-sm-2 col-sm-10">
        <textarea 
          v-model="form.descripcion" 
          style="background-color: #525252; color: #1cdede;"
          class="form-control form-control-sm form-control-mono" 
          rows="3"></textarea>
      </div>
    </div>
    <div class="form-group row mb-1">
      <div class="offset-sm-2 col-sm-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="checkNotificar" v-model="form.notificar">
          <label class="form-check-label" for="checkNotificar">
            Notificar
          </label>
        </div>
      </div>
      <div class="col-sm-6 text-right">
        <button type="button" class="btn btn-sm btn-secondary" @click="previa = !previa">
          <i class="fa fa-refresh"></i> Previa
        </button>
        <button type="reset" class="btn btn-sm btn-secondary" @click="$parent.formActividad = false">
          <i class="fa fa-refresh"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-sm btn-info" :disabled="btnGuardar">
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="btnGuardar"></span>
          <i class="fa fa-save" v-if="!btnGuardar"></i> {{ btnGuardar ? 'Guardando...' : 'Guardar' }}
        </button>
      </div>
    </div>
  </form>
</div>
</template>