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
      previa: false,
      form: {
        subtitulo: null,
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
  watch: {
    verComentarios: function(actual, anterior) {
      if (actual) {
        this.getBitacora();
      }
    }
  },
  components: { comentario, 'actividad-form': appFormActividad }
}