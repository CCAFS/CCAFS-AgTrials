<script> 
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("tb_trialsite_user").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>