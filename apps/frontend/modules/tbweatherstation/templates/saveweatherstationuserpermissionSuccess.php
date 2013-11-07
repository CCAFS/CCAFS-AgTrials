<script> 
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("tb_weatherstation_user").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>