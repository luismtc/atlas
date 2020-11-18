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
    },
    catalogo: {
      type: Object,
      required: true
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
        descripcion: null
      },
      fagregar: false,
      btnGuardar: false,
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
  props: {
    act: {
      type: Object,
      required: false
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
  template: '#lista-actividad',
  data: function() {
    return {
      ruta: urlBase + 'actividad',
      formActividad: false,
      form: {
        comentario:null,
        accion: 1,
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
    actBitacora: function() {
      this.formComentario = false;
      this.ecom = true;

      axios
      .post(this.ruta+'/set_bitacora/'+this.act.actividad, this.form)
      .then(r => {
        let en = r.headers['content-type'].split(';')

        if (en[0] == 'application/json') {
          if (r.data.exito == 1) {
            this.form.comentario = null;
            this.form.accion = 1;
            this.form.responde = null;

            if (r.data.bitacora) {
              this.listaBitacora = r.data.bitacora;
              this.bcantidad = this.listaBitacora.length;
            }
            
            if (r.data.entrega) {
              this.act.entrega = r.data.entrega;
              this.act.cumple =  r.data.cumple;
            }

            this.verComentarios = true;
          } else {
            alert(r.data.mensaje);
          }
        } else {
          alert('Sesión caducada');
        }

        this.ecom = false;
      });
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
    },
    acciones () {
      return this.catalogo.acciones.filter(obj => {
        return this.act.editar == 1 ? true : obj.editar == 0
      })
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