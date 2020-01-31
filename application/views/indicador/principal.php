<template id="ver-indicador">
<div class="card">
	<div class="card-header">
		<form @submit.prevent="buscar">
			<div class="input-group input-group-sm">
				<div class="input-group-prepend">
					<button
					type="button"
					class="btn btn-sm btn-secondary pl-4 pr-4"
					@click="$emit('regresar')">
					<i class="fa fa-arrow-left"></i>
					</button>
					<span class="input-group-text" id="inputFdel">Del</span>
				</div>
				<input
				type="date"
				class="form-control"
				v-model="form.ifdel"
				aria-label="Fecha del" aria-describedby="inputFdel">
				<input
				type="date"
				class="form-control"
				v-model="form.ifal"
				aria-label="Fecha al" aria-describedby="inputAl">
				<div class="input-group-append">
					<span class="input-group-text" id="inputAl">Al</span>
					<button
					type="submit"
					class="btn btn-sm btn-primary pl-4 pr-4">
					<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
	<div class="card-body">
		<div id="graficas"></div>
	</div>
</div>
</template>