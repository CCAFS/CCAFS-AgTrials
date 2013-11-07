<div> 
    <tr>
        <td>
            <div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
                <div class="fg-toolbar ui-widget-header ui-corner-all">
                    <h1>Batch Upload <?php echo $Modulo; ?> (Error Exceeds the maximum allowed records)</h1>
                </div>
                <table class="Forma">
                    <tr><td>&ensp;</td></tr>
                    <tr>
                        <td>
                            <fieldset>
                                <legend>&ensp;<b>Error</b>&ensp;</legend>
                                <span><img src='/images/attention-icon.png'><b><?php echo $Modulo; ?> Template File:</b> Exceeds the maximum allowed records <?php echo "($TotalRecord / $MaxRecordsFile)"; ?></span><br>
                            </fieldset>
                        </td>
                    </tr>
                    <tr><td>&ensp;</td></tr>
                    <tr>
                        <td>
                            <fieldset>
                                <legend>&ensp;<b>Remember</b>&ensp;</legend>
                                <span><img src='/images/attention-icon.png'> Templates Files must have <b>.xls</b> extension and must be smaller than <b><?php echo $MaxSizeFile; ?> MB</b> maximum size </span><br>
                                <span><img src="/images/attention-icon.png"> Max. <b><?php echo $MaxRecordsFile; ?> Records</b> for Template File</span><br>
                                <span><img src="/images/attention-icon.png"> Exact number of columns <b>'<?php echo $Cols; ?>'</b> for Template File</span>
                            </fieldset>
                        </td>
                    </tr>
                    <tr><td>&ensp;</td></tr>
                    <tr class="TRTDCenter">
                        <td class="TRTDCenter">
                            <button class="Buttons" onclick='window.history.back()' title='Close' name='Close' type='button'><img src='/images/delete.png'> <b>Close</b></button>
                        </td>
                    </tr>
                    <tr><td>&ensp;</td></tr>
                </table>
            </div>
        </td>
    </tr>
</div>