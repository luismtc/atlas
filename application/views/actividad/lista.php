<template id="lista-actividad">
<li class="list-group-item">
	<actividad-form :act="act" v-if="formActividad"></actividad-form>
	<div class="row">
		<div class="col-sm-7">
			<strong>{{ act.nresponsable }}</strong> 
			<small class="text-muted">{{ act.compromiso }}</small>
			<span 
				class="font-weight-bold"
				:style="{color:act.cuando==1?'#187a91':'#d81717'}" 
				v-if="act.cuando < 3 && act.entrega === null"
			>{{ act.cuando==1?'VIVO VIVO':'VAS TARDE' }}</span>
		</div>
		<div class="col-sm-5 text-right">
			<span 
				:style="{color:act.cumple==1?'#2bcc98':'red'}" 
				v-if="act.entrega !== null">Entregada</span>
			<a 
				href="javascript:;" 
				class="text-muted" 
				v-if="act.entrega === null"
				@click.prevent="formActividad = !formActividad"
				aria-label="Editar actividad"
			>
				<i class="fa fa-edit"></i>
			</a>
		</div>
	</div>
	<div v-html="act.descripcion"></div>
	<div v-if="detalle == true">
		<a 
			href="javascript:;" 
			style="color: #0972e3;" 
			title="Título del proyecto" 
			@click.prevent="getProyecto">{{ act.titulo }}</a>
		<small title="Específico">{{ act.nespecifico }}</small>
	</div>
	<div>
		<button 
			type="button" 
			class="btn btn-sm btn-outline-info rounded-circle" 
			:class="{active: formComentario}"
			v-if="act.entrega === null"
			aria-label="Comentar"
			@click="formComentario = !formComentario">
			<i class="far fa-comment" aria-hidden="true"></i>
		</button>
		<button 
			type="button" 
			class="btn btn-sm btn-outline-dark rounded-circle" 
			v-if="act.entrega === null"
			aria-label="Entregar"
			@click="actBitacora(2, this)">
			<i class="fa fa-check" v-if="!ecom"></i>
			<span 
				class="spinner-border spinner-border-sm" 
				role="status" 
				v-if="ecom"
				aria-hidden="true"></span>
			<span class="sr-only" v-if="ecom">Loading...</span>
		</button>
		<span class="text-muted" v-if="act.entrega !== null">{{ act.entrega }} (Entrega)</span>
		<a href="javascript:;" class="pull-right text-muted" @click.prevent="verComentarios = !verComentarios">
			{{ act.comentarios }} comentarios
		</a>
	</div>
	<div v-if="verComentarios" class="mt-2 p-2">
		<comentario 
			v-for="(i, index) in listaBitacora" 
			:com="i" 
			:key="i.id"
			v-on:comentar="responder"
			:index="index">
		</comentario>
	</div>
	<div v-if="formComentario" class="mt-2">
		<form @submit.prevent="actBitacora(1)">
			<input
				type="text"
				style="background-color: #525252; color: #1cdede;"
				class="form-control form-control-mono"
				v-model="form.comentario"
				placeholder="Enter para enviar comentario">
		</form>
	</div>
</li>
</template>

<template id="ver-comentario">
<div class="media mb-2" style="font-size: 0.75em;">
  <img class="mr-3" :src="com.user_picture" alt="User Image" style="height: 38px;">
  <div class="media-body">
    <p class="m-0">
    	{{ com.nalias }} 
    	<span class="text-muted">
    		<a href="#" @click.prevent="$emit('comentar', com.id)">Responder</a>
    	</span>
    	<span class="text-muted pull-right">{{ com.fecha }}</span>
    </p>
    {{ com.comentario }}
  </div>
</div>
</template>