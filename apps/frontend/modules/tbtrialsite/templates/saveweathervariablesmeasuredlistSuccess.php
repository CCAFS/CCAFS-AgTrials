<script> 
    saveAndClose();
    function saveAndClose(){
        parent.document.getElementById("variablesmeasured<?php echo $fila ?>").value = "<?php echo $weathervariablesmeasuredlist ?>";
        self.parent.tb_remove();
    }
</script>