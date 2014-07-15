<feed xmlns="http://www.w3.org/2005/Atom" xmlns:agtrials="http://www.agtrials.org/geoRSS" xmlns:georss="http://www.georss.org/georss">
    <agtrials:name>The Global Agricultural Trial Repository</agtrials:name>
    <agtrials:date><?php echo date('D M d H:i:S T Y') ?></agtrials:date>
    <agtrials:host>agtrials.org</agtrials:host>
    <title type="text">The Global Agricultural Trial Repository</title>
    <link href="http://www.agtrials.org/"/>
    <subtitle type="text">Trial Sites</subtitle>
    <id>agtrials-<?php sha1('agtrials-org') ?></id>
    <?php foreach ($feed as $valor) { ?>
        <entry>
            <id>agtrials-org-<?php echo str_replace(' ', '-', $valor->trlname) . '-' . time(); ?></id>
            <title><?php echo $valor->trlname; ?></title>
            <link href="http://www.agtrials.org/tbtrial/<?php echo $valor->id_trial; ?>"/>
            <published><?php echo date('D M d H:i:S T Y') ?></published>
            <updated><?php echo date('D M d H:i:S T Y') ?></updated>
            <summary><?php echo $valor->trialgroup." - ".$valor->trlname; ?></summary>
            <agtrials:name><?php echo $valor->trlname; ?></agtrials:name>
            <agtrials:trialgroup><?php echo $valor->trialgroup; ?></agtrials:trialgroup>
            <agtrials:contactperson><?php echo $valor->contactperson; ?></agtrials:contactperson>
            <agtrials:country><?php echo $valor->country; ?></agtrials:country>
            <agtrials:trialsite><?php echo $valor->trialsite; ?></agtrials:trialsite>
            <agtrials:cropanimal><?php echo $valor->cropanimal; ?></agtrials:cropanimal>
            <agtrials:varieties><?php echo $valor->trlvarieties; ?></agtrials:varieties>
            <agtrials:variablesmeasured><?php echo $valor->trlvariablesmeasured; ?></agtrials:variablesmeasured>
            <agtrials:fileaccess><?php echo $valor->trlfileaccess; ?></agtrials:fileaccess>
            <agtrials:trialtype><?php echo $valor->trltrialtype; ?></agtrials:trialtype>
            <agtrials:trialrecorddate><?php echo $valor->created_at; ?></agtrials:trialrecorddate>
            <georss:point><?php echo $valor->georsspoint; ?></georss:point>
        </entry>
<?php } ?>
</feed>
