var appProyecto = new Vue({
  el: '#contenidoProyecto',
  data: {
    form: {
      titulo: null,
      pendientes: true
    },
    filtro: {
      nombre: '',
      responsable: 'todos'
    },
    responsables: [],
    listaProductos: null,
    proyecto: null,
    listaPendientes: [],
    pMensaje: '',
    actual: null,
    anterior: null,
    menu: [
      {valor:1, titulo:'Filtrar proyectos pendientes', icono: 'fa fa-filter', href: false},
      {valor:0, titulo:'Buscar proyecto', icono: 'fa fa-search', href: false},
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
      this.actual = 1;

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
      this.pMensaje = 'Cargando...';
      this.actual = 2;
      
      axios
      .get(urlBase+'actividad/pendiente')
      .then(r => {
        this.listaPendientes = r.data;
        
        if (this.listaPendientes.length ==  0) {
          this.pMensaje = 'Sin pendientes.';
        } else {
          for (var i = this.listaPendientes.length - 1; i >= 0; i--) {
            let tmp = {
              id: this.listaPendientes[i].responsable,
              nombre: this.listaPendientes[i].nresponsable
            }

            if (this.responsables.filter(o => { return o.id === tmp.id }).length === 0) {
              this.responsables.push(tmp);
            }
          }
        }
      });
    },
    retorno: function() {
      this.actual = this.anterior;
    }
  },
  created: function() {
    this.verPendientes();
  },
  computed: {
    pendientes: function() {
      return this.listaPendientes.filter(o => {
        let n = o.titulo.toLowerCase().includes(this.filtro.nombre.toLowerCase());
        let r = (this.filtro.responsable === 'todos' || o.responsable == this.filtro.responsable);

        return (n && r);
      })
    }
  },
  components: {
    'ver-proyecto': appVerProyecto,
    'form-proyecto': appFormProyecto,
    'pendiente': appActividadLista,
    'indicador': indicador
  },
  watch: {
    actual: function(valor, anterior) {
      this.anterior = anterior;
      
      if (valor == 1 && anterior != 0) {
        this.verProyectoPendiente();
      } else if (valor == 2) {
        this.verPendientes();
      }
    }
  }
});