<script> 
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("tb_trial_user").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>