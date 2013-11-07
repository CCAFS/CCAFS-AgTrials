<script>
    updateAndClose();
    function updateAndClose(){
        parent.document.getElementById("tb_trial_id_trialgroup").value = "<?php echo $id ?>";
        parent.document.getElementById("autocomplete_tb_trial_id_trialgroup").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>
