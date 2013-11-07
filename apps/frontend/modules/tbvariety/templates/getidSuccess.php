<script>
    getid();
    function getid(){
        id = parent.document.getElementById('tb_trial_id_crop').value;
        if(id != ''){
            location.replace("<?php echo url_for('@list_variety', true); ?>?id_crop=" + id);
        }else{
            alert('*** IMPORTANT *** \n\n Before adding a variety, specify the crop!');
            parent.document.getElementById('autocomplete_tb_trial_id_crop').focus();
            self.parent.tb_remove();
        }
    }
</script>
