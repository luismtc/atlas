<template id="especifico-ver">
<ul class="list-group">
	<li class="list-group-item">
		<div class="row">
			<div class="col-sm-6">
				<form>
				  <div class="form-row align-items-center">
				    <div class="col-auto my-1">
				      <div class="custom-control custom-checkbox mr-sm-2">
				        <input type="checkbox" class="custom-control-input" id="inputSin" v-model="sin">
				        <label class="custom-control-label" for="inputSin">Sin entregar</label>
				      </div>
				    </div>
				  </div>
				</form>
			</div>
			<div class="col-sm-6 text-right">
				<button 
		          type="button" 
		          class="btn btn-sm btn-outline-dark" 
		          aria-label="Agregar actividad"
		          @click="formActividad = !formActividad"
		        >
		          <i class="fa fa-plus" aria-hidden="true"></i> 
		        </button>
			</div>
		</div>
	</li>
	<li class="list-group-item" v-if="formActividad">
		<actividad-form :especifico="esp.especifico"></actividad-form>
	</li>
	<actividad-item
		v-for="(i, index) in actividades"
		:act="i"
		:detalle="false"
		:key="i.actividad"
	></actividad-item>
</ul>
</template>