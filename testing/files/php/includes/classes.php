<?php
// ======== Imports ========
include_once('functions.php');

// ========== Classes ==========
class OGTestOffers {
    // ========= Declaring Variables =========
    public $tableNames = ['tbl_OG_wonen', 'ppOG_dataBOG', 'ppOG_dataNieuwbouw'];

    // ============== Start of Class ==============
    function __construct() {
        add_action
    }

    // ============== Functions ==============
    function checkUpdates() {
        // ======== Declaring Variables ========
        $tableNames = $this->tableNames;
        $tableNamesLength = count($tableNames);

        // ============== Start of Function ==============
        print_r($tableNames);
    }
}