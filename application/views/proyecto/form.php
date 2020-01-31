<template id="form-proyecto">
<div class="card">
  <div class="card-header">
    Formulario Proyecto
  </div>
  <div class="card-body">
    <form @submit.prevent="guardarProyecto" autocomplete="off">
      <div class="form-group row">
        <label for="inputTitulo" class="col-sm-2 col-form-label">Título</label>
        <div class="col-sm-10">
          <input type="text" v-model="form.titulo" class="form-control" required="required" id="inputTitulo">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputDescripcion" class="col-sm-2 col-form-label">Descripción</label>
        <div class="col-sm-10">
          <input type="text" v-model="form.descripcion" class="form-control" required="required" id="inputDescripcion">
        </div>
      </div>
      <div class="form-group row">
        <label for="selectResponsable" class="col-sm-2 col-form-label">Responsable</label>
        <div class="col-sm-4">
          <select v-model="form.responsable" class="form-control" required="required" id="selectResponsable">
            <option value="">------</option>
            <option v-for="item in listaUsuarios" v-bind:value="item.id">{{ item.nombre }} {{ item.apellidos }}</option>
          </select>
        </div>
        <label for="selectPropietario" class="col-sm-2 col-form-label">Propietario</label>
        <div class="col-sm-4">
          <select v-model="form.propietario" class="form-control" required="required" id="selectPropietario">
            <option value="">------</option>
            <option v-for="item in listaUsuarios" v-bind:value="item.id">{{ item.nombre }} {{ item.apellidos }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-12 text-right">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Guardar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
</template>