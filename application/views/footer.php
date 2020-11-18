<script src="<?php echo base_url('assets/js/jquery-3.5.1.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-4.5.3-dist/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/axios.min.js') ?>"></script>
<?php if (ENVIRONMENT === 'development'): ?>
  <script src="<?php echo base_url('assets/js/vue.js') ?>"></script>
<?php else: ?>
  <script src="<?php echo base_url('assets/js/vue.min.js') ?>"></script>
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