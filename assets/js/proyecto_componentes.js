let appFormProyecto = {
  template: '#form-proyecto',
  data: function() {
    return {
      form: {
        titulo:null,
        descripcion:null,
        responsable:null,
        propietario:null
      },
      listaUsuarios: null
    }
  },
  created: function() {
    axios
    .get(urlBase + 'conf/get_usuarios')
    .then(response => {
      this.listaUsuarios = response.data.usuarios;
    });
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
  props: { esp: Object },
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
  props: ['proyecto'],
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
  data: function() {
    return {
      form: {
        ifdel: null,
        ifal: null
      },
      actividades: []
    }
  },
  methods: {
    buscar: function() {
      axios
      .get(urlBase + 'indicador/buscar', {params:this.form})
      .then(r => {
        this.actividades = r.data.actividades;
        google.charts.setOnLoadCallback(this.cumplimiento);
      })
    },
    cumplimiento: function() {
      let total = this.actividades.length;
      let hechos = this.actividades.filter(o => { 
        return ( o.entrega !== null )
      }).length;
      let cumplen = this.actividades.filter(o => { 
        return ( o.cumple == 1 )
      }).length;

      var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['Proyectos', parseInt((hechos / total)*100)],
        ['Iteración', parseInt((cumplen / hechos)*100)]
      ]);

      var options = {
        width: 800, height: 200,
        redFrom: 0, redTo: 89,
        yellowFrom:90, yellowTo: 94,
        greenFrom: 95, greenTo: 100,
        minorTicks: 5
      };

      var chart = new google.visualization.Gauge(document.getElementById('graficas'));

      chart.draw(data, options);
    }
  },
  created: function() {
    google.charts.load('current', {packages: ['corechart', 'gauge']});
  }
}