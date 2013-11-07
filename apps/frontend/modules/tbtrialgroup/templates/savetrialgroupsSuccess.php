<script> 
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("trialgroups").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>