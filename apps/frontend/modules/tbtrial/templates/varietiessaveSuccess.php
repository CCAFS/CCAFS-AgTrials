<script>
    saveAndClose();
function saveAndClose(){
    parent.document.getElementById("varieties").value = "<?php echo $name ?>";
    parent.document.getElementById("VariablesMeasureds").innerHTML  = "<?php echo html_entity_decode($html, ENT_QUOTES, 'UTF-8') ?>";
    self.parent.tb_remove();
    window.parent.ChangeList();
    if(window.parent.$('#varieties').attr('value') != '')
        window.parent.$('#Div_varieties_list_Clear').show();
    else
        window.parent.$('#Div_varieties_list_Clear').hide();
}
</script>