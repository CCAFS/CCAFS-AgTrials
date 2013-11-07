<script>
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("tb_trial_trlvariablesmeasured").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>
