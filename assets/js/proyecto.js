var appProyecto = new Vue({
  el: '#contenidoProyecto',
  data: {
    catalogo: {},
    form: {
      titulo: null,
      pendientes: true
    },
    bform: {pendiente:true},
    listaProductos: [],
    proyecto: null,
    actividades: [],
    pMensaje: '',
    actual: 2,
    anterior: null,
    expandir: false,
    menu: [
      {valor:1, titulo:'Buscar proyecto', icono: 'fa fa-search', href: false},
      {valor:4, titulo:'Crear proyecto', icono: 'fa fa fa-plus', href: false},
      {valor:2, titulo:'Mis pendientes', icono: 'fa fa-tasks', href: false},
      {valor:5, titulo:'Indicadores', icono: 'fa fa-chart-bar', href: false},
      {valor:6, titulo:'Salir', icono: 'fa fa-sign-out-alt', href: urlBase+'sesion/salir'}
    ]
  },
  methods: {
    modal: function(i) {
      this.actividad = i;
    },
    verProyectoPendiente: function() {
      this.form.titulo = null;
      this.form.pendientes = true;
      this.buscarProyecto();
    },
  	buscarProyecto: function() {
      axios
      .get(urlBase+'proyecto/buscar', {params: this.form})
      .then(response => {
        this.listaProductos = response.data.productos;
      });
  	},
    verProyecto: function(item) {
      this.actual = 3;
      this.proyecto = item;
    },
    verPendientes: function() {
      this.actividades = [];
      this.pMensaje = 'Cargando...';
      
      axios
      .get(urlBase+'actividad/pendiente', {params:this.bform})
      .then(r => {
        this.actividades = r.data;
        
        if (this.actividades.length ==  0) {
          this.pMensaje = 'Sin pendientes.';
        }
      });
    },
    retorno: function() {
      this.actual = this.anterior;
    }
  },
  created () {
    axios
    .get(urlBase+'conf/get_catalogo')
    .then(response => {
      this.catalogo = response.data;
    });
  },
  components: {
    'ver-proyecto': appVerProyecto,
    'form-proyecto': appFormProyecto,
    'actividad-item': appActividadLista,
    'indicador': indicador,
    'filtro-actividades': listaActividades
  },
  watch: {
    actual: function(valor, anterior) {
      this.anterior = anterior;
    }
  }
});