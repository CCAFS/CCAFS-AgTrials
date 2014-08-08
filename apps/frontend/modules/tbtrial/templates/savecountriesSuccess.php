<script>
    parent.document.getElementById("countries").value = "<?php echo $name ?>";
    self.parent.tb_remove();
    window.parent.ChangeList();
    if (window.parent.$('#countries').attr('value') != '')
        window.parent.$('#Div_countries_list_Clear').show();
    else
        window.parent.$('#Div_countries_list_Clear').hide();
</script>