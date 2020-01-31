<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="<?php echo base_url('assets/node_modules/axios/dist/axios.min.js') ?>"></script>
<?php if (ENVIRONMENT === 'development'): ?>
  <script src="<?php echo base_url('assets/node_modules/vue/dist/vue.js') ?>"></script>
<?php else: ?>
  <script src="<?php echo base_url('assets/node_modules/vue/dist/vue.min.js') ?>"></script>
<?php endif ?>
<script src="<?php echo base_url('assets/node_modules/@popperjs/core/dist/umd/popper.min.js') ?>"></script>

<script type="text/javascript">
	var urlBase = '<?php echo base_url("index.php/") ?>';
</script>

<script src="<?php echo base_url('assets/js/componentes.js') ?>"></script>
<script src="<?php echo base_url('assets/js/proyecto_componentes.js') ?>"></script>
<script src="<?php echo base_url('assets/js/proyecto.js') ?>"></script>

<?php $this->load->view('sw'); ?>

</body>
</html>