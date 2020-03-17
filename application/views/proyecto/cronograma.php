<template id="tabla-cronograma">
<div class="table-responsive">
	<table class="table table-sm">
		<thead class="thead-dark">
			<tr>
				<th scope="col" colspan="4"></th>
				<th 
					scope="col" 
					colspan="5" 
					class="text-center" 
					v-for="(i, index) in semanas"
				>{{ 'S'+i }}</th>
			</tr>
			<tr>
				<th scope="col">Proyecto</th>
				<th scope="col">Específico</th>
				<th scope="col">Actividad</th>
				<th scope="col">Responsable</th>
				<template v-for="s in semanas">
					<th v-for="d in diasSemana" scope="col">{{ d.letra }}</th>
				</template>
			</tr>
		</thead>
		<tbody>
			<tr 
				v-for="(i, index) in actividades" 
				:index="index" 
				:key="i.actividad"
			>
				<td>{{ i.titulo }}</td>
				<td>{{ i.nespecifico }}</td>
				<td 
					class="text-wrap"  
					style="max-width: 250px;"
				>
					<a href="javascript:;" @click="ver(index)" :id="'act_'+i.actividad">{{i.subtitulo}}</a>
				</td>
				<td>{{ i.nresponsable }}</td>
				<template v-for="s in semanas">
					<template v-for="d in diasSemana">
						<td 
							v-if="i.semana == s && d.numero == i.dia"
							:class="[(i.entrega == null ? 'bg-warning' : (i.cumple == 1 ? 'bg-success' : 'bg-danger')), 'cronograma']"
						></td>
						<td :class="{'semana-actual': (i.semana_actual == s)}" v-else></td>
					</template>
				</template>
			</tr>
		</tbody>
	</table>
	<mdl-actividad 
		v-if="showMdl" 
		:actividad="tmpActual" 
		@close="showMdl = false"
	></mdl-actividad>
</div>
</template>
