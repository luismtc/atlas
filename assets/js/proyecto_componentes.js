let appFormProyecto = {
  template: '#form-proyecto',
  props: {
    catalogo: {
      type: Object,
      required: true
    }
  },
  data: function() {
    return {
      form: {
        titulo:null,
        descripcion:null,
        responsable:null,
        propietario:null
      }
    }
  },
  methods: {
    guardarProyecto: function() {
      if (confirm('¿Seguro?')) {
        axios
        .post(urlBase+'/proyecto/guardar', this.form)
        .then(response => {
          if (response.data.exito == 1) {
            this.$parent.verProyecto(response.data.producto);
          } else {
            toastr["error"](response.data.mensaje);
          }
        });
      }
    }
  }
}

let especifico = {
  template: '#especifico-ver',
  props: { 
    esp: {
      type: Object,
      required: true
    },
    catalogo: {
      type: Object,
      required: true
    }
  },
  data: function() {
    return {
      formActividad: false,
      lista: [],
      sin: false
    }
  },
  methods: {
    getActividades: function() {
      axios
      .get(urlBase + 'especifico/get_actividad/'+this.esp.especifico)
      .then(r => {
        if (r.data.actividades) {
          this.lista = r.data.actividades;
        }
      });
    }
  },
  created: function() {
    this.getActividades();
  },
  computed: {
    actividades: function() {
      if (this.sin) {
        return this.lista.filter(o => { return o.entrega === null });
      } else {
        return this.lista;
      }
    }
  },
  watch: {
    esp: function(actual, anterior) {
      if (actual !== anterior) {
        this.lista = [];
        this.getActividades();
      }
    }
  },
  components: {
    'actividad-item': appActividadLista,
    'actividad-form': appFormActividad
  }
}

let appVerProyecto = {
  props: {
    proyecto: {
      type: Object,
      required: true
    },
    catalogo: {
      type: Object,
      required: true
    }
  },
  template: '#ver-proyecto',
  data: function() {
    return {
      opcion: 1,
      expandir: false,
      actualEspecifico: null,
      listaEspecificos: [],
      formEspecifico: false,
      descEspecifico: null,
      formActividad: false,
      fagregar: false,
      actividades: [],
      ancho: 'col-sm-8'
    }
  },
  methods: {
    guardarEspecifico: function(e) {
      if (this.descEspecifico == null) {
        toastr["warning"]('Ingrese una descripción');
      } else {
        var datos = new FormData();
        datos.append("descripcion", this.descEspecifico);

        axios
        .post(urlBase+'proyecto/gespecifico/'+this.proyecto.producto, datos)
        .then(response => {
          if (response.data.exito == 1) {
            this.formEspecifico = false;
            this.descEspecifico = null;
            this.getEspecificos();
          }
        });
      }
    },
    getEspecificos: function() {
      axios
      .get(urlBase+'proyecto/especifico', {
        params: {
          producto: this.proyecto.producto
        }
      })
      .then(response => {
        if (response.data.especificos) {
          this.listaEspecificos = response.data.especificos;
          this.fagregar = response.data.fagregar;
        }
      });
    },
    verEspecifico: function(idx) {
      this.actualEspecifico = this.listaEspecificos[idx];
      this.opcion = 2;
      // this.getActividades();
    },
    getPendientes: function() {
      this.opcion = 3; 
      this.actualEspecifico = null;
      axios
      .get(urlBase+'proyecto/get_actividad/'+this.proyecto.producto, {params:{pendiente:true}})
      .then(r => {
        this.actividades = r.data;
      })
    }
  },
  created: function() {
    this.getEspecificos();
  },
  watch: {
    expandir (actual, anterior) {
      this.ancho = actual ? 'col-sm-12' : 'col-sm-8';
    }
  },
  components: {
    'especifico-ver': especifico,
    'form-actividad': appFormActividad,
    'lista-actividad': appActividadLista,
    'filtro-actividades': listaActividades
  }
}

let indicador = {
  template: '#ver-indicador',
  props: {
    catalogo: {
      type: Object,
      required: true
    }
  },
  mixins: [filtrosActividades],
  data: function() {
    return {
      tipoResumen: '',
      verActividad: false,
      actual: {},
      form: {
        ifdel: null,
        ifal: null
      },
      filtro: {
        proyecto: []
      },
      actividades: [],
      buscando: false
    }
  },
  methods: {
    buscar: function() {
      this.buscando = true;
      this.actividades = [];
      this.proyectos = [];

      axios
      .get(urlBase + 'indicador/buscar', {params:this.form})
      .then(r => {
        this.actividades = r.data.actividades;
        this.cargarFiltros();
        this.filtro.proyecto = [...this.proyectos];
        this.buscando = false;
      })
      .catch(e => {
        alert(e);
        this.buscando = false;
      })
    }
  },
  computed: {
    lista () {
      return this.actividades.filter(obj => {
        return this.filtro.proyecto.includes(obj.titulo);
      });
    },
    graficas () {
      if (this.lista.length) {
        let total = this.lista.length;
        let hechos = this.lista.filter(o => { 
          return ( o.entrega !== null )
        }).length;
        let cumplen = this.lista.filter(o => { 
          return ( o.cumple == 1 )
        }).length;
        let retorno = this.lista.filter(o => { 
          return ( o.retorno == 1 )
        }).length;
        let cerrada = this.lista.filter(o => { 
          return ( o.cerrada == 1 )
        }).length;

        return [
          {nombre:'Proyectos', porcentaje: parseInt((hechos / total)*100)},
          {nombre:'Iteración', porcentaje: parseInt((cumplen / hechos)*100)},
          {nombre:'Retornos', porcentaje: parseInt((retorno / hechos)*100)},
          {nombre:'Cerradas', porcentaje: parseInt((cerrada / hechos)*100)},
        ];
      } else {
        return [];
      }
    },
    listaResumen () {
      return this.lista.filter(obj => {
        switch (this.tipoResumen) {
          case 'Proyectos':
            return obj.entrega === null;
          case 'Iteración':
            return obj.cumple == 0;
          case 'Retornos':
            return obj.retorno == 1;
          case 'Cerradas':
            return obj.cerrada == 0;
          default:
            return false;
        }
      })
    }
  },
  components: {
    'actividad-item': appActividadLista
  }
}