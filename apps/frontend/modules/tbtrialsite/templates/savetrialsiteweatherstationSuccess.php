<script> 
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("tb_trialsite_weatherstation").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>