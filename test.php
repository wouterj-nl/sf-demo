<?php

require __DIR__.'/vendor/autoload.php';

var_dump(array_map(function ($r) {
    $r['description'] = trim(implode("\n ", array_slice($r, -6)));

    return $r;
}, \AppBundle\Util\Csv::parse(<<<EOT
"NL19RABO0146643925","EUR","20151103","D","25.95","","","20151103","ba","","HiziHair Oostermeent HUIZEN","Betaalautomaat 16:15 pasnr. 003","","","","","","",""
"NL19RABO0146643925","EUR","20151104","D","3.94","","","20151104","bc","","ALBERT HEIJN 1077 EINDHOVEN","Betaalautomaat 12:45 pasnr. 003","","","","","","",""
EOT
        , ['rekeningnummer_houder', 'muntsoort', 'rentedatum', 'bij_af', 'bedrag', 'tegenrekening', 'tegenrekeninghouder', 'boekdatum', 'boekcode', null, 'desc1', 'desc2', 'desc3', 'desc4', 'desc5', 'desc6'])
));
