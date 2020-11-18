let filtrosActividades = {
	data: function() {
		return {
			responsables: [],
			semanas: [],
			dias: [],
			proyectos: []
		}
	},
	created: function() {
		this.cargarFiltros()
	}, 
	methods: {
		cargarFiltros () {
			for (var i = this.actividades.length - 1; i >= 0; i--) {
				let tmp = {
					id: this.actividades[i].responsable,
					nombre: this.actividades[i].nresponsable
				}

				if (this.responsables.filter(o => { return o.id === tmp.id }).length === 0) {
					this.responsables.push(tmp);
				}

				let s = parseInt(this.actividades[i].semana);

				if (!this.semanas.includes(s)) {
					this.semanas.push(s);
				}

				this.semanas.sort(function(a, b){return a - b});

				let p = this.actividades[i].titulo;

				if (!this.proyectos.includes(p)) {
					this.proyectos.push(p);
				}

				this.proyectos.sort(function(a, b){return a - b});
			}
		}
	}
}