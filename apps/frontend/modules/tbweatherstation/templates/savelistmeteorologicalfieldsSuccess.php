<script>
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("meteorologicalfields").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>