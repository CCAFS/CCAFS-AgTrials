<script> 
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("tb_trial_group").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>