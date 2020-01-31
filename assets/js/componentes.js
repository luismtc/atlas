Vue.component('select2', {
    template: `<select 
                class="form-control"
                v-bind:multiple="multiple">
            </select>`,
    props: {
        options: {
            Object
        },
        value: null,
        multiple: {
            Boolean,
            default: false
        },
        indice: null,
        campo: null
    },
    data() {
        return {
            select2data: []
        }
    },
    mounted() {
        this.formatOptions()
        let vm = this
        let select = $(this.$el)
        select.select2({
            width: '100%',
            allowClear: true,
            data: this.select2data
        }).on('change', function () {
            vm.$emit('input', select.val())
        });

        if (this.value) {
            select.val(this.value).trigger('change')
        }
    },
    methods: {
        formatOptions() {
            this.select2data = [];

            if (!this.multiple) {
                this.select2data.push({
                    id: '',
                    text: '----------'
                });
            }

            if (this.indice != null &&
                this.campo != null) {
                for (let key in this.options) {
                    this.select2data.push({
                        id: this.options[key][this.indice],
                        text: this.options[key][this.campo]
                    })
                }
            } else {
                this.select2data = this.options;
            }
        },
        actualizarValor() {
            if (this.multiple) {
                if ([...this.value].sort().join(",") !== [...$(this.$el).val()].sort().join(",")) {
                    $(this.$el).val(this.value).trigger('change');
                }
            } else {
                $(this.$el)
                .val(this.value)
                .trigger('change');
            }
        }
    },
    watch: {
        options: function() {
            this.formatOptions();
            $(this.$el).empty().select2({data:this.select2data, width:'100%'});
            this.actualizarValor();
        },
        value: function() {
            this.actualizarValor();
        }
    },
    destroyed: function () {
        $(this.$el).off().select2('destroy')
    }
});

Vue.component('wysihtml5', {
    props: ['value', 'toolbar'],
    template: `<textarea class="form-control">{{value}}</textarea>`,
    mounted: function () {
        let vm = this
        let params = {
            'events': {
                'change': function() {
                    vm.$emit('input', this.getValue())
                }
            }
        };

        if (this.toolbar) {
            params['toolbar'] = this.toolbar;
        }

        $(vm.$el).wysihtml5(params);
    },
    watch: {
      value: function(valor) {
        $('iframe').contents().find('.wysihtml5-editor').html(valor);
      }
    }
});

Vue.component('ckeditor', {
    props: ['value', 'toolbar'],
    template: `<textarea></textarea>`,
    mounted: function () {
        let vm = this
        let params = {
            'events': {
                'change': function() {
                    vm.$emit('input', this.getValue())
                }
            }
        };

        if (this.toolbar) {
            params['toolbar'] = this.toolbar;
        }

        CKEDITOR.replace(vm.$el)
    }
});