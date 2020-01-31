Vue.component('ver-contenido', function(resolve, reject) {
    axios
    .post(location+'/form')
    .then(res => {
        resolve({
            template: res.data,
            data: function() {
                return {
                    mensaje: 'Componente uno'
                }
            },
            methods: {
                cambiar: function() {
                    this.mensaje = 'Se cambio el texto';
                }
            }
        })
    }).catch(error => console.log(error));
})


let otroComponente = function(resolve, reject) {
    axios
    .post(location+'/form')
    .then(res => {
        resolve({
            template: res.data,
            data: function() {
                return {
                    mensaje: 'Componente dos'
                }
            },
            methods: {
                cambiar: function() {
                    this.mensaje = 'Se cambio el texto';
                }
            }
        })
    }).catch(error => console.log(error));
}

var app = new Vue({
    el: '#appcontenido',
    data: {
        form: false
    },
    methods: {
        buscar: function() {
            this.form = true;
        }
    },
    components: {
        'ver-otro': otroComponente
    }
});

