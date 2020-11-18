let listaActividades = {
  props: {
    actividades: {
      type: Array,
      required: true
    },
    detalle: {
      type: Boolean,
      required: true
    },
    catalogo: {
      type: Object,
      required: true
    }
  },
  mixins: [filtrosActividades],
  template: '#filtro-actividades',
  data: function() {
    return {
      modo: 1,
      expandir: false,
      filtro: {
        semana: null,
        proyecto: null,
        nombre: '',
        responsable: 'todos',
        retorno: false
      },
      bform: {}
    }
  },
  methods: {
    proyecto (item) {
      this.$emit('proyecto', item);
    }
  },
  computed: {
    lista: function() {
      return this.actividades.filter(o => {
        let r = this.filtro.proyecto === null || o.titulo === this.filtro.proyecto;

        if (r) {
          r = (this.filtro.responsable === 'todos' || o.responsable == this.filtro.responsable);
        }

        if (r) { 
          r = (this.filtro.semana === null || o.semana == this.filtro.semana);
        }

        if (r && this.filtro.retorno) {
          r = o.retorno == 1;
        }

        return r;
      })
    }
  },
  components: {
    'actividad-item': appActividadLista,
  }
}
