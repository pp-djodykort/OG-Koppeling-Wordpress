<?php
// ======== Imports ========
include_once('functions.php');

// ========== Classes ==========
class authentication
{
    public $authTokens = array(
        "44003_BOG-Makelaars" => "fde7837a-b98a-476e-bc2f-ffe5eef6bbae",
        "935006_Makelaars-Wonen-Zoekopdracht" => "dbd550af-fc6e-4e6b-b8ed-ae818850ab23",
        "onbekend_Makelaars-Wonen-Zoekopdracht" => "5c5a305c-ef8e-44d4-93f8-6fe8a4746beb",
        "903925_Makelaars-Wonen-Zoekopdracht" => "2eae52b1-0e6e-4364-b2bf-1a71f3410f65",
        "935100_Makelaars-Wonen-Zoekopdracht" => "737bbc97-2ffd-4966-baf3-2e974cc5e515",
        "907368_Makelaars-Wonen-Zoekopdracht" => "4cf5b99f-1cda-41f4-bd97-42d49acbfc3c",
        "903926_Makelaars-Wonen-Zoekopdracht" => "5c2737fd-a618-4eb1-aaf3-41799dd8fdcb",
        "938059_BOG-Makelaars" => "42e31ad4-0b25-4b6c-960e-599d09e676d5",
        "935526_Makelaars-Wonen-Zoekopdracht" => "2c586fe8-88ab-4999-9591-8333ecf763ea",
        "44003_Makelaars-Nieuwbouw" => "f0a43e14-913a-433b-b6af-e99a9066570e",
        "903925_BOG-Makelaars" => "69179624-b9c8-4358-bc40-e074c1dfd7e7",
        "903926_BOG-Makelaars" => "48b3a1fb-75e3-4132-ae86-44c119726b4c",
        "935526_Makelaars-Nieuwbouw" => "dc6826a9-8c3d-4451-971e-1849245c2997",
        "935526_BOG-Makelaars" => "231529c9-9e2c-4f4e-b00c-93007fc822c9",
        "44003_Makelaars-Wonen-Zoekopdracht" => "e2ed5b0a-d544-409b-aa06-7f3a875c2403",
        "903925_Makelaars-Nieuwbouw" => "047247da-11c4-420e-bf79-4ad676956f42"
    );

    public $urlExtensions = array(
        "BOG-Makelaars" => "/bog/v1/objecten",
        "Makelaars-Wonen-Zoekopdracht" => "/wonen/v1/objecten",
        "Makelaars-Nieuwbouw" => "/nieuwbouw/v1/projecten"
    );

}

class getOGDataFromRealworks {
    function getData() {
        $auth = new authentication();
        foreach ($auth->authTokens as $key => $authToken)
        {
            $keyArray = explode("_", $key);
            foreach ($auth->urlExtensions as $key2 => $urlExtension)
            {
                if ($keyArray[1] == $key2)
                {
                    echo ("Got JSON ".$key.":<br/>");
                    $projects = getProjects($urlExtension, $authToken);
                    saveToJSON($projects, $key);
                    break;
                }
            }
        }
    }
    function __construct() {
        $this->getData();
    }
}