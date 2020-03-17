let listaActividades = {
  props: {
    actividades: {
      type: Array,
      required: true
    },
    detalle: {
      type: Boolean,
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
        nombre: '',
        responsable: 'todos'
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
        let r = o.titulo.toLowerCase().includes(this.filtro.nombre.toLowerCase());

        if (r) {
          r = (this.filtro.responsable === 'todos' || o.responsable == this.filtro.responsable);
        }

        if (r) { 
          r = (this.filtro.semana === null || o.semana == this.filtro.semana);
        }

        return r;
      })
    }
  },
  components: {
    'actividad-item': appActividadLista,
  }
}
