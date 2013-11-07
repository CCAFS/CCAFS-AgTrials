<div> 
    <script language="javascript">
        function callprogress(vValor,vFila,vTotal){
            document.getElementById("getprogress").innerHTML = vValor;
            document.getElementById("getprogressrecord").innerHTML = vFila+'/'+vTotal+' Records';
            document.getElementById("getProgressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';
        }

        function counter(vGrabados,vErrores){
            document.getElementById("recorded").innerHTML = vGrabados;
            document.getElementById("recorderror").innerHTML = vErrores;
        }
        function errores(vError){
            obj = document.getElementById("error");
            obj.style.display = 'block';
            document.getElementById("errores").innerHTML = vError;
        }
        function mostrar() {
            obj = document.getElementById("errores");
            obj.style.display = (obj.style.display=='none') ? 'block' : 'none';
            document.getElementById("view").innerHTML = (obj.style.display=='none') ? 'View errors' : 'Hide errors';
        }
        function FinishedProcess(){
            document.getElementById("FinishedProcess").innerHTML = 'Process Finished Successfully';
        }
    </script>
    <style type="text/css">
        .ProgressBar { width: 22em; height: 3.5em; border: 1px solid black; background: #CEDAC0; display: block; }
        .ProgressBarText { width: 20em; height: 3.5em; position: absolute; font-size: 13px; color: #000000; font-family: Verdana; font-weight:bold; text-align: center; font-weight: normal; }
        .ProgressBarFill { height: 3.5em; background: #86A273; display: block; overflow: visible; }
        .FinishedProcess { font-size: 13px; color: red; font-family: Verdana; font-weight:bold; text-align: center;}
    </style>
    <tr>
        <td>
            <div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
                <div class="fg-toolbar ui-widget-header ui-corner-all">
                    <h1>Batch Upload <?php echo $Modulo; ?></h1>
                </div>
                <table class="Forma">
                    <tr class="TRTDCenter">
                        <td class="TRTDCenter"><font color='#0000A0' face='Verdana' size='2'><B>*** Information Processing <?php echo $Modulo; ?> Template File ***</B></font></td>
                    </tr>
                    <tr><td></td></tr>
                    <tr class="TRTDCenter">
                        <td class="TRTDCenter">
                            <div class="ProgressBar TRTDCenter">
                                <div class="ProgressBarText TRTDCenter">
                                    <b><span class="TRTDCenter" id="getprogress"></span>&nbsp;% Completed</b></br>
                                    <span class="TRTDCenter" id="getprogressrecord"></span>
                                </div>
                                <div class="TRTDCenter" id="getProgressBarFill"></div>
                            </div>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr class="TRTDCenter">
                        <td class="TRTDCenter">
                            <ul>
                                <li><font color='#000000' face='Verdana' size='2'>Recorded Records: <b><span id="recorded"></span></b></font></li>
                            </ul>
                        </td>
                    </tr>
                    <tr class="TRTDCenter">
                        <td class="TRTDCenter">
                            <ul>
                                <li><font color='#000000' face='Verdana' size='2'>Records with error: <b><span id="recorderror"></span></b></font></li>
                            </ul>
                        </td>
                    </tr>
                    <tr class="TRTDCenter">
                        <td class="TRTDCenter">
                            <span id="error" style="display:none;">
                                <img src='/images/view-icon.png'> <a href="#" id="view" onclick = "mostrar(); return false">View errors</a>
                                <div id="errores" style="display:none; overflow:auto; width:800px; height:330px; align:left; border:1px;"></div>
                            </span>
                        </td>
                    </tr>

                    <tr><td>&nbsp;</td></tr>
                    <tr class="TRTDCenter">
                        <td class="TRTDCenter">
                            <div class="FinishedProcess" id="FinishedProcess"><img src='/images/loading.gif'><br><font color='#0000A0' face='Verdana'>Processing may take a few minutes, wait a moment. <br> Don't close the window during the process.</font></div>
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