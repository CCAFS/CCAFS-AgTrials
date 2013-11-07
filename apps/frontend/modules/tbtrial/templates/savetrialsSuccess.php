<script> 
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("trials").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>