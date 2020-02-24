<script src="<?php echo base_url('assets/node_modules/jquery/dist/jquery.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- script src="<?php echo base_url('assets/node_modules/@popperjs/core/dist/umd/popper.min.js') ?>"></script -->
<script src="<?php echo base_url('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="<?php echo base_url('assets/node_modules/axios/dist/axios.min.js') ?>"></script>
<?php if (ENVIRONMENT === 'development'): ?>
  <script src="<?php echo base_url('assets/node_modules/vue/dist/vue.js') ?>"></script>
<?php else: ?>
  <script src="<?php echo base_url('assets/node_modules/vue/dist/vue.min.js') ?>"></script>
<?php endif ?>

<script type="text/javascript">
	var urlBase = '<?php echo base_url("index.php/") ?>';
</script>

<script src="<?php echo base_url('assets/js/componentes.js') ?>"></script>
<script src="<?php echo base_url('assets/js/mixins.js') ?>"></script>

<script src="<?php echo base_url('assets/js/item_actividad.js') ?>"></script>
<script src="<?php echo base_url('assets/js/mdl_actividad.js') ?>"></script>
<script src="<?php echo base_url('assets/js/cronograma.js') ?>"></script>

<script src="<?php echo base_url('assets/js/filtro_actividades.js') ?>"></script>
<script src="<?php echo base_url('assets/js/proyecto_componentes.js') ?>"></script>
<script src="<?php echo base_url('assets/js/proyecto.js') ?>"></script>

<?php $this->load->view('sw'); ?>

</body>
</html>