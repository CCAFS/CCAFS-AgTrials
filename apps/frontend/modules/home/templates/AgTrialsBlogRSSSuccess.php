<feed xmlns="http://www.w3.org/2005/Atom" xmlns:agtrials="http://www.agtrials.org/AgTrialsBlogRSS" xmlns:georss="http://www.georss.org/georss">
    <agtrials:name>AgTrials Blog</agtrials:name>
    <agtrials:date><?php echo date('D M d H:i:S T Y') ?></agtrials:date>
    <agtrials:host>agtrials.org</agtrials:host>
    <title type="text">AgTrials Blog</title>
    <link href="http://www.agtrials.org/"/>
    <subtitle type="text">AgTrials Blog</subtitle>
    <id>agtrials-<?php sha1('agtrials-org') ?></id>
    <?php foreach ($feedblog as $valor) {
            $posted = "Posted: ".date("M jS, Y",strtotime($valor['post_date']))." | by {$valor['user']}";
            $post_content = html_entity_decode($valor['post_content']);
            $strfin = strpos($post_content, ". ") + 1;
            $summary = $posted." | ".substr($post_content, 0, $strfin);
    ?>
        <entry>
            <id>agtrials-org-<?php echo str_replace(' ', '-', $valor['post_title']) . '-' . time(); ?></id>
            <title><?php echo $valor['post_title']; ?></title>
            <link href="http://gisweb.ciat.cgiar.org/trialsitesblog/?p=<?php echo $valor['id']; ?>"/>
            <published><?php echo date('D M d H:i:S T Y') ?></published>
            <updated><?php echo date('D M d H:i:S T Y') ?></updated>
            <summary><?php echo $summary; ?></summary>
            <agtrials:name><?php echo $valor['post_title']; ?></agtrials:name>
        </entry>
<?php } ?>
</feed> 
