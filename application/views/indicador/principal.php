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
					aria-label="Fecha al" aria-describedby="inputAl"
				>
				<div class="input-group-append">
					<span class="input-group-text" id="inputAl">Al</span>
					<button
						type="submit"
						class="btn btn-sm btn-primary pl-4 pr-4"
						:disabled="buscando"
					>
						<span 
							class="spinner-border spinner-border-sm" 
							role="status" 
							aria-hidden="true" 
							v-if="buscando"
						></span>
					<i class="fa fa-search" v-else></i>
					</button>
				</div>
			</div>
		</form>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-check" v-for="i in proyectos" :key="i">
					<input 
						class="form-check-input" 
						type="checkbox" 
						:value="i" 
						:id="i"
						v-model="filtro.proyecto"
					>
					<label class="form-check-label" :for="i">
						{{ i }}
					</label>
				</div>
			</div>
			<div class="col-sm-9 bg-light border rounded pt-3 pb-0">
				<div class="row" v-for="i in graficas" :key="i.nombre">
					<div class="col-sm-3">
						<a 
							href="#tablaResumen" 
							class="font-weight-bold text-decoration-none"
							@click.prevent="tipoResumen = i.nombre"
						>
							{{ i.nombre }}
						</a>
					</div>
					<div class="col-sm-9">
						<div class="progress mb-3" style="height: 35px;">
							<div 
								class="progress-bar" 
								role="progressbar" 
								:style="{ width: i.porcentaje + '%' }"
								:aria-valuenow="i.porcentaje" 
								aria-valuemin="0" 
								aria-valuemax="100"
							>{{ i.porcentaje + ' %' }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body border-top bg-light" v-if="verActividad">
		<div class="row">
			<div class="offset-sm-2 col-sm-8">
				<button 
					type="button" 
					class="btn btn-sm btn-secondary mb-2" 
					@click="verActividad = false"
				>
					<i class="fa fa-arrow-left"></i> Regresar
				</button>
				<actividad-item
					:act="actual"
					:detalle="false"
					:catalogo="catalogo"
				></actividad-item>
			</div>
		</div>
	</div>
	<div 
		class="table-responsive" 
		v-if="tipoResumen !== '' && !verActividad" 
		id="tablaResumen"
	>
		<table class="table table-sm table-hover table-dark">
			<thead>
				<tr class="table-active">
					<th colspan="6" class="text-center">{{ tipoResumen }}</th>
				</tr>
				<tr>
					<th scope="col"></th>
					<th scope="col">Proyecto</th>
					<th scope="col">Específico</th>
					<th scope="col">Actividad</th>
					<th scope="col">Compromiso</th>
					<th scope="col">Responsable</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(i, key) in listaResumen" :key="i.actividad">
					<td scope="row">{{ key + 1 }}</td>
					<td>{{ i.titulo }}</td>
					<td>{{ i.nespecifico }}</td>
					<td>
						<a 
							href="javascript:;" 
							class="text-danger"
							@click.prevent="actual = i; verActividad = true;"
						>{{ i.subtitulo }}</a>
					</td>
					<td>{{ i.compromiso }}</td>
					<td>{{ i.nombre }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</template>