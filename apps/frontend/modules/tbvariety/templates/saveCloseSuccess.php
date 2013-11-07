<script>
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("tb_trial_trlvarieties").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>
