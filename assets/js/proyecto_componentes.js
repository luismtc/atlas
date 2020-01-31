let comentario = {
  props: ['com'],
  template: '#ver-comentario'
}

let appFormActividad = {
  props: { 
    especifico: {
      type: String,
      required: false
    },
    act: {
      type: Object,
      required: false
    }
  },
  template: '#form-actividad',
  data: function() {
    return {
      ruta: urlBase + 'actividad',
      url: '',
      form: {
        responsable: null,
        compromiso: null,
        horas: 1,
        descripcion: null,
        notificar: false
      },
      fagregar: false,
      btnGuardar: false,
      listaUsuarios: null,
      toolbar: {
        'font-styles': false,
        'emphasis': true,
        'link': false,
        'image': false,
        'lists': true,
        'blockquote': false
      }
    }
  },
  created: function() {
    if (this.act) {
      for (i in this.act) {
        if (this.form.hasOwnProperty(i)) {
          this.form[i] = this.act[i];
        }
      }
    }

    axios
    .get(urlBase + 'conf/get_usuarios')
    .then(response => {
      this.listaUsuarios = response.data.usuarios;
    });
  },
  methods: {
    guardarActividad: function(e) {
      this.btnGuardar = true;

      if (this.act) {
        this.url = this.act.especifico+'/'+this.act.actividad;
      } else {
        this.url = this.especifico;
      }

      axios
      .post(this.ruta+'/guardar/'+this.url, this.form)
      .then(r => {
        if (r.data.exito == 1) {
          this.$parent.formActividad = false;

          if (this.act) {
            for (i in r.data.actividad) {
              if (this.act.hasOwnProperty(i)) {
                this.act[i] = r.data.actividad[i];
              }
            }
          } else {
            this.$parent.getActividades();
          }
        } else {
          this.btnGuardar = false;
          alert(r.data.mensaje);
          // toastr["error"](r.data.mensaje);
        }
      });
    }
  }
}

let appActividadLista = {
  props: ['act', 'detalle'],
  template: '#lista-actividad',
  data: function() {
    return {
      ruta: urlBase + 'actividad',
      formActividad: false,
      form: {
        comentario:null,
        accion:null,
        responde:null
      },
      formComentario: false,
      listaBitacora: [],
      verComentarios: false,
      bcantidad: 0,
      ecom: false
    }
  },
  methods: {
    getBitacora: function() {
      axios
      .get(this.ruta+'/get_bitacora/'+this.act.actividad)
      .then(response => {
        if (response.data.length > 0) {
          this.listaBitacora = response.data;
          this.bcantidad = this.listaBitacora.length;
        } else {
          this.listaBitacora = [];
          this.bcantidad = 0;
        }
      });
    },
    responder: function(b) {
      this.formComentario = !this.formComentario;
      this.form.responde = this.formComentario ? b : null;
    },
    actBitacora: function(accion) {
      this.form.accion = accion;
      let seguir = true;

      if (accion == 2) {
        seguir = confirm('¿Seguro?');
      }

      if (seguir) {
        this.formComentario = false;
        this.ecom = true;

        axios
        .post(this.ruta+'/set_bitacora/'+this.act.actividad, this.form)
        .then(r => {
          let en = r.headers['content-type'].split(';')

          if (en[0] == 'application/json') {
            if (r.data.exito == 1) {
              this.form.comentario = null;
              this.form.accion = null;
              this.form.responde = null;

              if (r.data.bitacora) {
                this.listaBitacora = r.data.bitacora;
                this.bcantidad = this.listaBitacora.length;
              }
              
              if (r.data.entrega) {
                this.act.entrega = r.data.entrega;
                this.act.cumple =  r.data.cumple;
              }

              if (accion == 1) { this.verComentarios = true; }
            } else {
              alert(r.data.mensaje);
              
              if (accion == 2) {
                this.form.comentario = null;
              }
            }
          } else {
            alert('Sesión caducada');
          }

          this.ecom = false;
        });
      } else {
        this.form.comentario = null;
      }
    },
    getProyecto: function() {
      axios
      .get(urlBase + 'proyecto/buscar', { params: { producto: this.act.producto } })
      .then(r => {
        this.$emit('proyecto', r.data.productos[0]);
      })
    }
  },
  computed: {
    comentarios: function() {
      return this.listaBitacora.filter(ob => {
        return ob.responde == null;
      });
    }
  },
  components: { comentario, 'actividad-form': appFormActividad }
}

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
      actualEspecifico: null,
      listaEspecificos: [],
      formEspecifico: false,
      descEspecifico: null,
      formActividad: false,
      fagregar: false
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
    }
  },
  created: function() {
    this.getEspecificos();
  },
  components: {
    'especifico-ver': especifico,
    'form-actividad': appFormActividad,
    'lista-actividad': appActividadLista
  }
}

let indicador = {
  template: '#ver-indicador',
  data: function() {
    return {
      ruta: urlBase + 'indicador',
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
      .get(this.ruta + 'buscar', {params:this.form})
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