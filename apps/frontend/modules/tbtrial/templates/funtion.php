<?php

function select_from_table($name,$table,$idtable,$nametable,$wheretable,$valor) {
    $QUERY00 = Doctrine_Query::create()
                    ->select("$idtable AS id, ($nametable) AS name")
                    ->from("$table")
                    //->where("TG.trgrtrialgrouprecordstatus = 'Open'")
                    ->orderBy("$nametable");
    //echo $QUERY00->getSqlQuery();
    $Resultado00 = $QUERY00->execute();
    $OPTION = "<OPTION VALUE=''></OPTION>";
    foreach ($Resultado00 AS $fila) {
        $selected = "";
        if($fila['id'] == $valor)
            $selected = "selected";
        $OPTION .= "<OPTION VALUE='{$fila['id']}' $selected>{$fila['name']}</OPTION>";
    }
    $HTML = "<SELECT NAME='$name' id='$name' SIZE='1'>";
    $HTML .= $OPTION;
    $HTML .= "</SELECT>";
    return $HTML;
}
?>