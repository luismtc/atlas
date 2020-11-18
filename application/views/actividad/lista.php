<template id="lista-actividad">
<li class="list-group-item">
	<actividad-form
		v-if="formActividad" 
		:act="act" 
		:catalogo="catalogo"
	></actividad-form>
	<div v-else>
		<div class="row">
			<div class="col-sm-7">
				<strong>{{ act.nombre }} {{ act.apellidos }}</strong> 
				<small class="text-muted">{{ act.compromiso }}</small>
				<span 
					class="font-weight-bold"
					:style="{color:act.cuando==1?'#187a91':'#d81717'}" 
					v-if="act.cuando < 3 && act.entrega === null"
				>{{ act.cuando==1?'VIVO VIVO':'VAS TARDE' }}</span>
			</div>
			<div class="col-sm-5 text-right">
				<a 
					href="javascript:;" 
					class="text-muted" 
					v-if="act.editar == 1"
					@click.prevent="formActividad = !formActividad"
					aria-label="Editar actividad"
				>
					<i class="fa fa-edit"></i>
				</a>
				<span 
					:style="{color:act.cumple==1?'#2bcc98':'red'}" 
					v-else
				>{{ act.entrega !== null ? 'Entregada':'' }}</span>
			</div>
		</div>
		<div>
			<p class="mb-0"><strong>{{ act.subtitulo }}</strong>:</p>
			<p v-html="act.descripcion"></p>	
		</div>
		<div class="row">
			<div class="col">
				<a 
					href="javascript:;" 
					v-if="detalle == true"
					style="color: #0972e3;" 
					title="Título del proyecto" 
					@click.prevent="getProyecto"
				>{{ act.titulo }}</a>
				<small title="Título del proyecto" v-else>{{ act.titulo }}</small> 
				<span class="fa fa-arrow-right"></span> 
				<small title="Específico">{{ act.nespecifico }}</small>
			</div>
			<div class="col text-right">
				<span 
					class="badge badge-danger" 
					v-if="act.retorno == 1"
				>Retorno</span>
				<span 
					class="badge badge-success" 
					v-if="act.cerrada == 1"
				>Cerrada</span>
			</div>
		</div>
		<div>
			<button 
				type="button" 
				class="btn btn-sm btn-outline-info rounded-circle" 
				:class="{active: formComentario}"
				v-if="act.entrega === null || (act.editar == 1 && act.cerrada == 0)"
				aria-label="Comentar"
				@click="formComentario = !formComentario">
				<i class="far fa-comment" aria-hidden="true"></i>
			</button>
			<span class="text-muted" v-if="act.entrega !== null">{{ act.entrega }} (Entrega)</span>
			<a 
				href="javascript:;" 
				class="pull-right text-muted" 
				@click.prevent="verComentarios = !verComentarios"
			>
				{{ act.comentarios }} comentarios
			</a>
		</div>
		<div v-if="formComentario || verComentarios" class="mt-3 card bg-light">
			<form 
				@submit.prevent="actBitacora" 
				class="card-body p-2"
				v-if="formComentario"
			>
				<div class="form-group mb-1">
					<input 
						type="text" 
						style="background-color: #525252; color: #1cdede;"
						v-model="form.comentario"
						class="form-control form-control-mono form-control-lg" 
						aria-label="Texto para comentario"
						placeholder="Comentario"
					>
				</div>

				<div class="form-group mb-0">
					<div class="input-group">
						<select 
							class="custom-select" 
							v-model="form.accion" 
							:required="true"
						>
							<option 
								v-for="i in acciones" 
								:value="i.id"
							>{{ i.descripcion }}</option>
						</select>
						<div class="input-group-append">
							<button 
								class="btn btn-outline-secondary" 
								type="submit" 
								id="button-addon2"
							><i class="far fa-paper-plane"></i> Enviar</button>
						</div>
					</div>
				</div>
			</form>
			<div 
				class="card-body" 
				v-if="formComentario && form.comentario !== null" 
				v-html="form.comentario"
			></div>
			<ul class="list-group list-group-flush">
				<li 
					class="list-group-item"
					v-for="(i, index) in listaBitacora" 
					:key="i.id"
				>
					<div class="row">
						<div class="col-sm-8">
							<strong>{{ i.nombre }} {{ i.apellidos }}</strong> <small><span class="text-muted">{{ i.fecha }}</span></small>
						</div>
						<div class="col-sm-4 text-right">
							<span class="badge badge-secondary">{{ i.naccion }}</span>
						</div>
					</div>
					<p class="mb-0">{{ i.comentario }}</p>
				</li>
			</ul>
		</div>
	</div>
</li>
</template>

<template id="ver-comentario">
<div class="media mb-2" style="font-size: 0.75em;">
  <img class="mr-3" :src="com.user_picture" alt="User Image" style="height: 38px;">
  <div class="media-body">
    <p class="m-0">
    	{{ com.nombre }} {{ com.apellidos }}
    	<span class="text-muted">
    		<a href="#" @click.prevent="$emit('comentar', com.id)">Responder</a>
    	</span>
    	<span class="text-muted pull-right">{{ com.fecha }}</span>
    </p>
    {{ com.comentario }}
  </div>
</div>
</template>