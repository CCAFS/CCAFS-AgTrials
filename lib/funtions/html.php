<?php

//FUNCIONES DE CODIGO HTML
function HTML_FileError($MaxRecordsFile, $MaxSizeFile) {
    $HTML = "<table align='center'>";
    $HTML .= "<tr><td><font color='#0000A0' face='Verdana' size='2'><B align='center'> **** Error Upload Template File ****</B></font></td></tr>";
    $HTML .= "<tr align='center'><td align='center'>&ensp;</td></tr>";
    $HTML .= "<td>";
    $HTML .= "<fieldset>";
    $HTML .= "<legend align='left'>&ensp;<b>Remember</b>&ensp;</legend>";
    $HTML .= "<span><img src='/images/attention-icon.png'> Only is permitted Template File with extension <b>.xls</b> and <b>$MaxSizeFile MB</b> Max. size</span><br>";
    $HTML .= "<span><img src='/images/attention-icon.png'> Max. <b>$MaxRecordsFile Records</b> for Template File</span>";
    $HTML .= "</fieldset>";
    $HTML .= "</td>";
    $HTML .= "<tr align='center'><td align='center'>&ensp;</td></tr>";
    $HTML .= "<tr><td align='center'><button onclick='self.parent.tb_remove()' title='Close' name='Close' type='button'><img src='/images/delete.png'> <b>Close</b></button></td></tr>";
    $HTML .= "</table>";
    return $HTML;
}

function HTML_Body() {
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">
   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
   <meta name=\"title\" content=\"The Global Agricultural Trial Repository - CGIAR - CCAFS - CIAT\" />
   <meta name=\"description\" content=\"The Global Agricultural Trial Repository - CGIAR - CCAFS - CIAT\" />
   <meta name=\"keywords\" content=\"Trials, Sites, Bibliography, CGIAR, CCAFS, CIAT\" />
   <meta name=\"language\" content=\"en\" />
   <meta name=\"robots\" content=\"index, follow\" />
   <title>The Global Agricultural Trial Repository - CGIAR - CCAFS - CIAT</title>
   <html>
   <head>
         <script language=\"javascript\">
           //Creo una función que imprimira en la hoja el valor del porcentanje asi como el relleno de la barra de progreso
           function callprogress(vValor,vFila,vTotal){
               document.getElementById(\"getprogress\").innerHTML = vValor;
               document.getElementById(\"getprogressrecord\").innerHTML = vFila+'/'+vTotal+' Records';
               document.getElementById(\"getProgressBarFill\").innerHTML = '<div class=\"ProgressBarFill\" style=\"width: '+vValor+'%;\"></div>';
           }

           function counter(vGrabados,vErrores){
               document.getElementById(\"recorded\").innerHTML = vGrabados;
               document.getElementById(\"recorderror\").innerHTML = vErrores;
           }

           function errores(vError){
               obj = document.getElementById(\"error\");
               obj.style.display = 'block';
               document.getElementById(\"errores\").innerHTML = vError;
           }

           function mostrar() {
             obj = document.getElementById(\"errores\");
             obj.style.display = (obj.style.display=='none') ? 'block' : 'none';
             document.getElementById(\"view\").innerHTML = (obj.style.display=='none') ? 'View errors' : 'Hide errors';
           }

           function FinishedProcess(){
               document.getElementById(\"FinishedProcess\").innerHTML = '>>> Finished Process <<<';
           }
       </script>

       <style type=\"text/css\">
           .ProgressBar { width: 16em; border: 1px solid black; background: #CEDAC0; height: 2em; display: block; }
           .ProgressBarText { position: absolute; font-size: 13px; color: #000000; font-family: Verdana; font-weight:bold; width: 19.5em; text-align: center; font-weight: normal; }
           .ProgressBarFill { height: 100%; background: #86A273; display: block; overflow: visible; }
           .FinishedProcess { font-size: 13px; color: red; font-family: Verdana; font-weight:bold; text-align: center;}
       </style>
   </head>
   <body>
       <table align='center'>
           <tr align='center'>
               <td align='center'><font color='#0000A0' face='Verdana' size='2'><B align='center'>*** Information of Batch Upload Process ***</B></font></td>
           </tr>
           <tr align='center'>
               <td align='center'></td>
           </tr>
           <tr align='center'>
               <td align='center'>
                   <div class=\"ProgressBar\">
                       <div class=\"ProgressBarText\"><b>
                           <span id=\"getprogress\"></span>&nbsp;% Completed</b><BR>
                           <span id=\"getprogressrecord\"></span>
                       </div>
                       <div id=\"getProgressBarFill\"></div>
                   </div>
               </td>
           </tr>
           <tr align='center'>
               <td align='center'>
                   <li><font color='#000000' face='Verdana' size='2'>Records Recorded: <b><span id=\"recorded\"></span></b></li>
               </td>
           </tr>
           <tr align='center'>
               <td align='center'>
                   <li><font color='#000000' face='Verdana' size='2'>Records with Errors: <b><span id=\"recorderror\"></span></b></li>
               </td>
           </tr>
           <tr align='center'>
               <td align='center'>
                   <span id=\"error\" style=\"display:none;\">
                       <a href=\"#\" id=\"view\" onclick = \"mostrar(); return false\">View Errors</a>
                       <div id=\"errores\" style=\"display:none; overflow-x:scroll; overflow-y: scroll; width:800px; height:290px; align:left; border:1px;\"></div>
                   </span>
               </td>
           </tr>
           <tr align='center'><td align='center'></td></tr>
           <tr align='center'><td align='center'>
           <div class=\"FinishedProcess\" id=\"FinishedProcess\"><img src='/images/loading.gif'><br><font color='#0000A0' face='Verdana'>Processing may take a few minutes, wait a moment. <br> Don't close the window during the process.</font></div>
           </td></tr>
           <tr align='center'><td align='center'></td></tr>
           <tr align='center'>
               <td align='center'>
                   <button onclick='self.parent.tb_remove()' title='Close' name='Close' type='button'><img src='/images/delete.png'> <b>Close</b></button>
               </td>
           </tr>
       </table>
   </body>
                            </html>
                            ";
}

?>