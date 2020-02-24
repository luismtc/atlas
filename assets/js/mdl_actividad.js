Vue.component('mdl-actividad', {
    props: {
        actividad: {
            type: Object,
            required: true
        }
    },
    template: `
    <div class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" id="mdlActividad">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Actividad</h5>
            <button 
              type="button" 
              class="close" 
              aria-label="Close" 
              data-dismiss="modal" 
              @click="$emit('close')"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul class="list-group p-0">
              <actividad-item :act="actividad" :detalle="false"></actividad-item>
            </ul>
          </div>
        </div>
      </div>
    </div>
    `,
    mounted () {
      $(this.$el).modal();
    },
    components: {
        'actividad-item': appActividadLista,
    }
})