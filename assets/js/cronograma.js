Vue.component('cronograma-lista', {
	props: {
		actividades: {
			type: Array,
			required: true
		},
		expandir: {
			type: Boolean,
			required: true
		}
	},
	mixins: [filtrosActividades],
	template: '#tabla-cronograma',
	data: function() {
	    return {
	    	tmpActual: null,
	    	showMdl: false,
	    	totalDias: 0,
	    	diasSemana: [
	    		{numero:'2', letra:'L'},
	    		{numero:'3', letra:'M'},
	    		{numero:'4', letra:'M'},
	    		{numero:'5', letra:'J'},
	    		{numero:'6', letra:'V'}
	    	],
	    	filtro: {
	    		semana: null,
	    		nombre: '',
	    		responsable: 'todos'
	    	}
	    }
	},
	created: function() {
		this.totalDias = (this.semanas.length * 5);
	},
	methods: {
		ver (idx) {
			this.tmpActual = this.actividades[idx];
			this.showMdl = true;
		}
	}
})