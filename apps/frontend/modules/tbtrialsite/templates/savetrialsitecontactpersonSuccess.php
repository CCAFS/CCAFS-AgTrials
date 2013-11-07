<script> 
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("contactperson").value = "<?php echo $name ?>";
        self.parent.tb_remove();
    }
</script>