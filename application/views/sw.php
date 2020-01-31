<script type="text/javascript">
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register("<?php echo base_url('sw.js') ?>");
  });
}
</script>