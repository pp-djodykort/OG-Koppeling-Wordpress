<?php
// ======= Imports =======

// ============== Functions ==============
function getProjects($extension, $rwAuthToken) {
    // ==== Declaring Variables ====
    $base_url = "https://api.realworks.nl";

    $context = stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n".
                "Authorization: rwauth ".$rwAuthToken
        )
    ));
    // ==== Start of Program ====
    $projects = file_get_contents(($base_url . $extension), false, $context);
    json_decode($projects, true);

    return $projects;
}


function saveToJSON($varJSON, $fileName) {
    $fp = fopen("./files/json/".$fileName.".json", 'w');
    fwrite($fp, $varJSON);
    fclose($fp);
}