<?php
// ========== Imports =========
include_once 'functions.php';

// ============ Activation and Deactivation ============
class OGSyncActivationAndDeactivation {
    // ==== Activation ====
    static function activate(): void {
        self::addOptions();
        self::createCacheFiles();
    }
    // ==== Deactivation ====
    static function deactivate(): void {

    }
	// ==== Uninstall ====
	static function uninstall(): void {
		// ================ Start of Function ================
		// ======== Deleting Settings/Options ========
		// Check which settings are registered
		$OGoptions = wp_load_alloptions();

		// only get settings that start with ppOGSync_
		$OGoptions = array_filter($OGoptions, function($key) {
			return str_starts_with($key, OGSyncSettingsData::$settingPrefix);
		}, ARRAY_FILTER_USE_KEY);

		// Deleting all settings in database
		foreach ($OGoptions as $option => $value) {
			delete_option($option);
		}
	}

    // ==== Functions ====
    // A function for registering base settings of the unactivated plugin as activation hook.
    static function addOptions(): void {
        // ==== Start of Function ====
        # Registering settings
        foreach (OGSyncSettingsData::arrOptions() as $settingName => $settingValue) {
            add_option(OGSyncSettingsData::$settingPrefix.$settingName, $settingValue);
        }
    }
    // A function for creating the cache files as activation hook.
    static function createCacheFiles(): void {
        // ==== Declaring Variables ====
        # Classes
        $settingsData = new OGSyncSettingsData();

        # Variables
        $cacheFolder = plugin_dir_path(dirname(__DIR__ )) . $settingsData::$cacheFolder;

        // ==== Start of Function ====
        # Creating the cache files
        foreach ($settingsData::cacheFiles() as $cacheFile) {
            # Creating the cache folder if it doesn't exist
            if (!file_exists($cacheFolder)) {
                mkdir($cacheFolder, 0777, true);
            }

            # Creating the cache file if it doesn't exist
            if (!file_exists($cacheFolder.$cacheFile)) {
                $file = fopen($cacheFolder.$cacheFile, 'w');
                fwrite($file, '');
                fclose($file);
            }
        }
    }
}

// ============ Data Classes ============
class OGSyncPostTypeData {
    // ============ Begin of Class ============
    public static function customPostTypes(): array {
        // ===== Declaring Variables =====
        # Variables
        $objectAccess = OGSyncLicense::checkPostTypeAccess();
        $customPostTypes = array(
            // Custom Post Type: 'wonen'
            'wonen' => array(
                'post_type_args' => array(
                    // This is just all the data / instructions that WordPress needs to know about the custom post type so that it can work correctly.
                    'labels' => array(
                        // Labels for the custom post type in the WordPress admin
                        'name' => 'OG Wonen Objecten',
                        'singular_name' => 'OG Wonen Object',
                        'add_new' => 'Nieuwe toevoegen',
                        'add_new_item' => 'Nieuw OG Wonen Object toevoegen',
                        'edit_item' => 'OG Wonen Object bewerken',
                        'new_item' => 'Nieuw OG Wonen Object',
                        'view_item' => 'Bekijk OG Wonen Object',
                        'search_items' => 'Zoek naar OG Wonen Objecten',
                        'not_found' => 'Geen OG Wonen Objecten gevonden',
                        'not_found_in_trash' => 'Geen OG Wonen Objecten gevonden in de prullenbak',
                        'parent_item_colon' => '',
                        'menu_name' => 'Wonen'
                    ),
                    'post_type_meta' => array(
                        'meta_box_title' => 'OG Wonen Object',
                        'meta_box_id' => 'og-wonen-object',
                        'meta_box_context' => 'normal',
                        'meta_box_priority' => 'high',
                        'meta_box_fields' => array(
                            'OG Wonen Object' => array(
                                'type' => 'text',
                                'id' => 'og-wonen-object',
                                'name' => 'og-wonen-object',
                                'label' => 'OG Wonen Object',
                                'placeholder' => 'OG Wonen Object',
                                'description' => 'OG Wonen Object',
                                'value' => '',
                                'required' => true
                            )
                        )
                    ),
                    'rewrite' => false,             // Mapped value
                    'public' => true,
                    'seperate_table' => true,
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                    'show_in_menu' => 'pixelplus-og-plugin-aanbod',
                    'taxonomies' => array('category', 'post_tag')
                ),
                'database_tables' => array(
                    'object' => array(
                        # TableName
                        'tableName' => 'tbl_OG_wonen',                              // NON Mapped - Name of the table
                        # Normal fields
                        'ID' => 'object_ObjectTiaraID',                             // Mapped value - ALWAYS Use the TiaraID
                        /*
                        Warning: You can only use one of the separators at the same time.
                        post_title Separators:
                            ; (Semicolon)   - The semi-colon is used to separate the values from each other with ' '
                            | (Pipe)        - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
                            Nothing       - If there is no separator, it will just use the first value. The only variable given in
                        */
                        'post_title' => 'objectDetails_Adres_NL_Straatnaam;objectDetails_Adres_NL_Huisnummer;objectDetails_Adres_NL_HuisnummerToevoeging;objectDetails_Adres_NL_Woonplaats', // Mapped value - Default: Straat;Huisnummer;Huisnummertoevoeging;Woonplaats
                        /*
                        Warning: You can only use one of the separators at the same time.
                        post_name Separators:
                            - (Dash)      - The dash is used to separate the values from each other with '-'
                            | (Pipe)      - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
                            Nothing       - If there is no separator, it will just use the first value. The only variable given in
                         */
                        'post_name' => 'objectDetails_Adres_NL_Straatnaam-objectDetails_Adres_NL_Huisnummer-objectDetails_Adres_NL_HuisnummerToevoeging-objectDetails_Adres_NL_Woonplaats',  // Mapped value - Default: Straat-Huisnummer-Huisnummertoevoeging-Woonplaats
                        'post_content' => 'objectDetails_Aanbiedingstekst',         // Mapped value - Default: De aanbiedingstekst
                        'datum_gewijzigd' => 'datum_gewijzigd',                     // Mapped value - Default: datum_gewijzigd      ; Default value is only for objects without a mapping table within the database
                        'datum_toegevoegd' => 'datum_toegevoegd',                   // Mapped value - Default: datum_toegevoegd     ; Default value is only for objects without a mapping table within the database
                        'objectCode' => 'object_ObjectCode',                        // Mapped value - Default: object_ObjectCode    ; Default value is only for objects without a mapping table within the database

                        # Post fields
                        'media' => array(
                            # TableName
                            'tableName' => 'tbl_OG_media',              // NON Mapped - Name of the table
                            # Normal fields
                            'folderRedirect' => '',                     // FTP Folder name of media from OG Feeds - ALLOWED TO BE EMPTY
                            'search_id' => 'id_OG_wonen',               // NON Mapped value - Default: Can found in OG Feeds media table > Id of Post Type / OG Type
                            'mediaID' => 'media_Id',                    // NON Mapped value - Default: media_Id; Can found in OG Feeds media table > Post Type / OG Type
                            'datum_gewijzigd' => 'datum_gewijzigd',     // Mapped value     - Default: datum_toegevoegd ; Default value is only for objects without a mapping table within the database
                            'datum_toegevoegd' => 'datum_toegevoegd',   // Mapped value     - Default: datum_gewijzigd  ; Default value is only for objects without a mapping table within the database
                            'mediaName' => 'MediaName',                 // Mapped value     - Default: mediaName        ; This one is special. Even in the normal plugin I still have this one mapped within the database in a mapping table. Default value is only for objects without a mapping table within the database
                            'media_Groep' => 'media_Groep',             // Mapped value     - Default: media_Groep      ; Default value is only for objects without a mapping table within the database

                            # Post fields
                            'object_keys' => array(
                                'objectTiara' => 'object_ObjectTiaraID',        // Mapped value - ALWAYS Use the TiaraID
                                'objectVestiging' => 'object_NVMVestigingNR',   // Mapped value - USE the Vestigingsnummer of the OG Object, NOT The media objects.
                            ),

                            # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                            'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
                        ),
                        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array( /* TableName */ 'tableName' => 'og_mappingwonen')
                    ),
                ),
                'templates' => array(
                    'detailPage' => array(
                        'templateName' => 'Wonen Detail Pagina',
                        'templateFile' => 'single-wonen.php'
                    ),
                )
            ),
            // Custom Post Type: 'bog'
            'bog' => array(
                'post_type_args' => array(
                    // This is just all the data / instructions that WordPress needs to know about the custom post type so that it can work correctly.
                    'labels' => array(
                        // Labels for the custom post type in the WordPress admin
                        'name' => 'OG BOG Objecten',
                        'singular_name' => 'OG BOG Object',
                        'add_new' => 'Nieuwe toevoegen',
                        'add_new_item' => 'Nieuw OG BOG Object toevoegen',
                        'edit_item' => 'OG BOG Object bewerken',
                        'new_item' => 'Nieuw OG BOG Object',
                        'view_item' => 'Bekijk OG BOG Object',
                        'search_items' => 'Zoek naar OG BOG Objecten',
                        'not_found' => 'Geen OG BOG Objecten gevonden',
                        'not_found_in_trash' => 'Geen OG BOG Objecten gevonden in de prullenbak',
                        'parent_item_colon' => '',
                        'menu_name' => 'BOG'
                    ),
                    'public' => true,
                    'rewrite' => false,             // Mapped value
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                    'show_in_menu' => 'pixelplus-og-plugin-aanbod',
                    'taxonomies' => array('category', 'post_tag')
                ),
                'database_tables' => array(
                    'object' => array(
                        # TableName
                        'tableName' => 'tbl_OG_bog',                        // NON Mapped - Name of the table
                        # Normal fields
                        'ID' => 'object_ObjectTiaraID',                     // Mapped value - ALWAYS Use the TiaraID
                        /*
                        Warning: You can only use one of the separators at the same time.
                        post_title Separators:
                            ; (Semicolon)   - The semi-colon is used to separate the values from each other with ' '
                            | (Pipe)        - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
                            Nothing       - If there is no separator, it will just use the first value. The only variable given in
                        */
                        'post_title' => 'objectDetails_Adres_Straatnaam;objectDetails_Adres_Huisnummer;objectDetails_Adres_HuisnummerToevoeging;objectDetails_Adres_Woonplaats', // Mapped value - Default: Straat;Huisnummer;Huisnummertoevoeging;Woonplaats
                        /*
						Warning: You can only use one of the separators at the same time.
						post_name Separators:
							- (Dash)      - The dash is used to separate the values from each other with '-'
							| (Pipe)      - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
							Nothing       - If there is no separator, it will just use the first value. The only variable given in
						 */
                        'post_name' => 'objectDetails_Adres_Straatnaam-objectDetails_Adres_Huisnummer-objectDetails_Adres_HuisnummerToevoeging-objectDetails_Adres_Woonplaats',  // Mapped value - Default: Straat-Huisnummer-Huisnummertoevoeging-Woonplaats
                        'post_content' => 'objectDetails_Aanbiedingstekst', // Mapped value - Default: De aanbiedingstekst
                        'datum_gewijzigd' => 'datum_gewijzigd',             // Mapped value - Default: datum_gewijzigd      ; Default value is only for objects without a mapping table within the database
                        'datum_toegevoegd' => 'datum_toegevoegd',           // Mapped value - Default: datum_toegevoegd    ; Default value is only for objects without a mapping table within the database
                        'objectCode' => 'object_ObjectCode',                // Mapped value - Default: object_ObjectCode    ; Default value is only for objects without a mapping table within the database

                        # Post fields
                        'media' => array(
                            # TableName
                            'tableName' => 'tbl_OG_media',              // NON Mapped - Name of the table
                            # Normal fields
                            'folderRedirect' => '',                     // FTP Folder name of media from OG Feeds - ALLOWED TO BE EMPTY
                            'search_id' => 'id_OG_bog',                 // NON Mapped value - Default: Can found in OG Feeds media table > Id of Post Type / OG Type
                            'mediaID' => 'media_Id',                    // NON Mapped value - Default: media_Id; Can found in OG Feeds media table > Post Type / OG Type
                            'datum_toegevoegd' => 'datum_toegevoegd',   // Mapped value     - Default: datum_toegevoegd ; Default value is only for objects without a mapping table within the database
                            'datum_gewijzigd' => 'datum_gewijzigd',     // Mapped value     - Default: datum_gewijzigd  ; Default value is only for objects without a mapping table within the database
                            'mediaName' => 'MediaName',                 // Mapped value     - Default: mediaName        ; This one is special. Even in the normal plugin I still have this one mapped within the database in a mapping table. Default value is only for objects without a mapping table within the database
                            'media_Groep' => 'media_Groep',             // Mapped value     - Default: media_Groep      ; Default value is only for objects without a mapping table within the database

                            # Post fields
                            'object_keys' => array(
                                'objectTiara' => 'object_ObjectTiaraID',        // Mapped value - ALWAYS Use the TiaraID
                                'objectVestiging' => 'object_NVMVestigingNR',   // Mapped value - USE the Vestigingsnummer of the OG Object, NOT The media objects.
                            ),

                            # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                            'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
                        ),
                        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array(/* TableName */ 'tableName' => 'og_mappingbedrijven')
                    ),
                ),
                'templates' => array(
                    'detailPage' => array(
                        'templateName' => 'og-bog-detail',
                        'templateFile' => 'og-bog-detail.php'
                    ),
                )
            ),
            // Custom Post Type: 'nieuwbouw'
            'nieuwbouw' => array(
                'post_type_args' => array(
                    // This is just all the data / instructions that WordPress needs to know about the custom post type so that it can work correctly.
                    'labels' => array(
                        // Labels for the custom post type in the WordPress admin
                        'name' => 'OG Nieuwbouw Objecten',
                        'singular_name' => 'OG Nieuwbouw Object',
                        'add_new' => 'Nieuwe toevoegen',
                        'add_new_item' => 'Nieuw OG Nieuwbouw Object toevoegen',
                        'edit_item' => 'OG Nieuwbouw Object bewerken',
                        'new_item' => 'Nieuw OG Nieuwbouw Object',
                        'view_item' => 'Bekijk OG Nieuwbouw Object',
                        'search_items' => 'Zoek naar OG Nieuwbouw Objecten',
                        'not_found' => 'Geen OG Nieuwbouw Objecten gevonden',
                        'not_found_in_trash' => 'Geen OG Nieuwbouw Objecten gevonden in de prullenbak',
                        'parent_item_colon' => '',
                        'menu_name' => 'Nieuwbouw'
                    ),
                    'public' => true,
                    'rewrite' => false,             // Mapped value
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                    'show_in_menu' => 'pixelplus-og-plugin-aanbod',
                    'taxonomies' => array('category', 'post_tag')
                ),
                'database_tables' => array(
                    'projecten' => array(
                        # TableName
                        'tableName' => 'tbl_OG_nieuwbouw_projecten',                                // NON Mapped - Name of the table
                        # Normal fields
                        'ID' => 'project_ObjectTiaraID',                                            // Mapped value - ALWAYS Use the TiaraID
                        /*
                        Warning: You can only use one of the separators at the same time.
                        post_title Separators:
                            ; (Semicolon)   - The semi-colon is used to separate the values from each other with ' '
                            | (Pipe)        - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
                            Nothing       - If there is no separator, it will just use the first value. The only variable given in
                        */
                        'post_title' => 'project_ProjectDetails_Projectnaam',                       // Mapped value - Default: Projectnaam
                        /*
						Warning: You can only use one of the separators at the same time.
						post_name Separators:
							- (Dash)      - The dash is used to separate the values from each other with '-'
							| (Pipe)      - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
							Nothing       - If there is no separator, it will just use the first value. The only variable given in
						 */
                        'post_name' => 'project_ProjectDetails_Projectnaam',                        // Mapped value - Default: Projectnaam
                        'post_content' => 'project_ProjectDetails_Presentatie_Aanbiedingstekst',    // Mapped value - Default: Presentatie_Aanbiedingstekst
                        'ObjectStatus_database' => 'project_ProjectDetails_Status_ObjectStatus',    // Mapped value - Default: Status_ObjectStatus              ; Default value is only for objects without a mapping table within the database
                        'datum_gewijzigd' => 'datum_gewijzigd',                                     // Mapped value - Default: datum_gewijzigd                  ; Default value is only for objects without a mapping table within the database
                        'datum_toegevoegd' => 'datum_toegevoegd',                                   // Mapped value - Default: datum_toegevoegd                 ; Default value is only for objects without a mapping table within the database
                        'objectCode' => 'project_ObjectCode',                                       // Mapped value
                        'type' => 'project',                                                        // Standard value don't change

                        # Post fields
                        'media' => array(
                            # TableName
                            'tableName' => 'tbl_OG_media',              // NON Mapped - Name of the table
                            # Normal fields
                            'folderRedirect' => '',                     // FTP Folder name of media from OG Feeds - ALLOWED TO BE EMPTY
                            'search_id' => 'id_OG_nieuwbouw_projecten', // NON Mapped value - Default: Can found in OG Feeds media table > Id of Post Type / OG Type
                            'mediaID' => 'media_Id',                    // NON Mapped value - Default: media_Id; Can found in OG Feeds media table > Post Type / OG Type
                            'datum_gewijzigd' => 'datum_gewijzigd',     // Mapped value     - Default: datum_toegevoegd ; Default value is only for objects without a mapping table within the database
                            'datum_toegevoegd' => 'datum_toegevoegd',   // Mapped value     - Default: datum_gewijzigd  ; Default value is only for objects without a mapping table within the database
                            'mediaName' => 'MediaName',                 // Mapped value     - Default: mediaName        ; This one is special. Even in the normal plugin I still have this one mapped within the database in a mapping table. Default value is only for objects without a mapping table within the database
                            'media_Groep' => 'media_Groep',             // Mapped value     - Default: media_Groep      ; Default value is only for objects without a mapping table within the database
                            'mediaTiaraID' => 'object_ObjectTiaraID',   // Mapped value     - ALWAYS Use the TiaraID

                            # Post fields
                            'object_keys' => array(
                                'objectTiara' => 'project_ObjectTiaraID',       // Mapped value - ALWAYS Use the TiaraID
                                'objectVestiging' => 'project_NVMVestigingNR',  // Mapped value - USE the Vestigingsnummer of the OG Object, NOT The media objects.
                            ),

                            # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                            'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
                        ),
                        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array(/* TableName */ 'tableName' => 'og_mappingnieuwbouwprojecten')
                    ),
                    'bouwTypes' => array(
                        # TableName
                        'tableName' => 'tbl_OG_nieuwbouw_bouwTypes',                                // NON Mapped - Name of the table
                        # Normal fields
                        'ID' => 'bouwType_ObjectTiaraID',                                           // Mapped value - ALWAYS Use the TiaraID
                        'id_projecten' => 'id_OG_nieuwbouw_projecten',                              // Mapped value - Default: id_OG_nieuwbouw_projecten ; This is supposed to be the value that indicates the id of the project so it can search towards the porject in certain querys
                        /*
                        Warning: You can only use one of the separators at the same time.
                        post_title Separators:
                            ; (Semicolon)   - The semi-colon is used to separate the values from each other with ' '
                            | (Pipe)        - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
                            Nothing       - If there is no separator, it will just use the first value. The only variable given in
                        */
                        'post_title' => 'bouwType_BouwTypeDetails_Naam|bouwType_ObjectCode',        // Mapped value - Default: Bouwtype Naam|ObjectCode ; The first value sometimes is filled and sometimes not, So I just made it an if statement
                        /*
						Warning: You can only use one of the separators at the same time.
						post_name Separators:
							- (Dash)      - The dash is used to separate the values from each other with '-'
							| (Pipe)      - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
							Nothing       - If there is no separator, it will just use the first value. The only variable given in
						 */
                        'post_name' => 'bouwType_BouwTypeDetails_Naam|bouwType_ObjectCode',         // Mapped value - Default: Bouwtype Naam|ObjectCode ; The first value sometimes is filled and sometimes not, So I just made it an if statement
                        'post_content' => 'bouwType_BouwTypeDetails_Aanbiedingstekst',              // Mapped value - Default: De aanbiedingstekst
                        'ObjectStatus_database' => 'bouwType_BouwTypeDetails_Status_ObjectStatus',  // Mapped value - Default: Status_ObjectStatus              ; Default value is only for objects without a mapping table within the database
                        'datum_gewijzigd' => 'datum_gewijzigd',                                     // Mapped value - Default: datum_gewijzigd                  ; Default value is only for objects without a mapping table within the database
                        'datum_toegevoegd' => 'datum_toegevoegd',                                   // Mapped value - Default: datum_toegevoegd                 ; Default value is only for objects without a mapping table within the database
                        'objectCode' => 'bouwType_ObjectCode',                                      // Mapped value - Default: bouwType_ObjectCode              ; Default value is only for objects without a mapping table within the database
                        'type' => 'bouwtype',                                                       // Standard value - Default: bouwtype                       ; DO NOT CHANGE

                        # Post fields
                        'media' => array(
                            # TableName
                            'tableName' => 'tbl_OG_media',                  // NON Mapped - Name of the table
                            # Normal fields
                            'folderRedirect' => '',                         // FTP Folder name of media from OG Feeds - ALLOWED TO BE EMPTY
                            'search_id' => 'id_OG_nieuwbouw_bouwtypes',     // NON Mapped value - Default: Can found in OG Feeds media table > Id of Post Type / OG Type
                            'mediaID' => 'media_Id',                        // NON Mapped value - Default: media_Id; Can found in OG Feeds media table > Post Type / OG Type
                            'datum_gewijzigd' => 'datum_gewijzigd',         // Mapped value     - Default: datum_toegevoegd ; Default value is only for objects without a mapping table within the database
                            'datum_toegevoegd' => 'datum_toegevoegd',       // Mapped value     - Default: datum_gewijzigd  ; Default value is only for objects without a mapping table within the database
                            'mediaName' => 'MediaName',                     // Mapped value     - Default: mediaName        ; This one is special. Even in the normal plugin I still have this one mapped within the database in a mapping table. Default value is only for objects without a mapping table within the database
                            'media_Groep' => 'media_Groep',                 // Mapped value     - Default: media_Groep      ; Default value is only for objects without a mapping table within the database
                            'mediaTiaraID' => 'object_ObjectTiaraID',       // Mapped value     - ALWAYS Use the TiaraID OF THE MEDIA TABLE

                            # Post fields
                            'object_keys' => array(
                                'objectTiara' => 'bouwType_ObjectTiaraID',      // Mapped value - ALWAYS Use the TiaraID
                                'objectVestiging' => 'bouwType_NVMVestigingNR', // Mapped value - USE the Vestigingsnummer of the OG Object, NOT The media objects.
                            ),

                            # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                            'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
                        ),
                        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array(/* TableName */ 'tableName' => 'og_mappingnieuwbouwbouwtypes')
                    ),
                    'bouwNummers' => array(
                        # TableName
                        'tableName' => 'tbl_OG_nieuwbouw_bouwNummers',                                          // NON Mapped - Name of the table
                        # Normal fields
                        'ID' => 'bouwNummer_ObjectTiaraID',                                                     // Mapped value - ALWAYS Use the TiaraID
                        'id_bouwtypes' => 'id_OG_nieuwbouw_bouwTypes',                                          // Mapped value - Default: id_OG_nieuwbouw_bouwTypes ; This is supposed to be the value that indicates the id of the bouwtype so it can search towards the bouwtype in certain querys
                        'post_title' => 'Adres_Straatnaam;Adres_Huisnummer;Adres_Postcode;Adres_Woonplaats;Adres_HuisnummerToevoeging;bouwNummer_ObjectCode',   // Mapped value - Default: Straat;Huisnummer;Postcode;Woonplaats;Huisnummertoevoeging;ObjectCode
                        'post_name' => 'Adres_Straatnaam-Adres_Huisnummer-Adres_Postcode-Adres_Woonplaats-Adres_HuisnummerToevoeging-bouwNummer_ObjectCode',    // Mapped value - Default: Straat-Huisnummer-Postcode-Woonplaats-Huisnummertoevoeging-ObjectCode
                        'post_content' => 'Aanbiedingstekst',                                                   // Mapped value - Default: De aanbiedingstekst      ; Default value is only for objects without a mapping table within the database
                        'ObjectStatus_database' => 'bouwNummer_ObjectCode',                                     // Mapped value - Default: ObjectCode               ; Default value is only for objects without a mapping table within the database
                        'datum_gewijzigd' => 'datum_gewijzigd',                                                 // Mapped value - Default: datum_gewijzigd          ; Default value is only for objects without a mapping table within the database
                        'datum_toegevoegd' => 'datum_toegevoegd',                                               // Mapped value - Default: datum_toegevoegd         ; Default value is only for objects without a mapping table within the database
                        'objectCode' => 'bouwNummer_ObjectCode',                                                // Mapped value - Default: bouwNummer_ObjectCode    ; Default value is only for objects without a mapping table within the database
                        'type' => 'bouwnummer',                                                                 // Standard value - Default: bouwnummer             ; DO NOT CHANGE

                        # Post fields
                        'media' => array(
                            # TableName
                            'tableName' => 'tbl_OG_media',                  // NON Mapped - Name of the table
                            # Normal fields
                            'folderRedirect' => '',                         // FTP Folder name of media from OG Feeds - ALLOWED TO BE EMPTY
                            'search_id' => 'id_OG_nieuwbouw_bouwnummers',   // NON Mapped value - Default: Can found in OG Feeds media table > Id of Post Type / OG Type
                            'mediaID' => 'media_Id',                        // NON Mapped value - Default: media_Id; Can found in OG Feeds media table > Post Type / OG Type
                            'datum_gewijzigd' => 'datum_gewijzigd',         // Mapped value     - Default: datum_toegevoegd ; Default value is only for objects without a mapping table within the database
                            'datum_toegevoegd' => 'datum_toegevoegd',       // Mapped value     - Default: datum_gewijzigd  ; Default value is only for objects without a mapping table within the database
                            'mediaName' => 'MediaName',                     // Mapped value     - Default: mediaName        ; This one is special. Even in the normal plugin I still have this one mapped within the database in a mapping table. Default value is only for objects without a mapping table within the database
                            'media_Groep' => 'media_Groep',                 // Mapped value     - Default: media_Groep      ; Default value is only for objects without a mapping table within the database
                            'mediaTiaraID' => 'object_ObjectTiaraID',       // Mapped value     - ALWAYS Use the TiaraID OF THE MEDIA TABLE

                            # Post fields
                            'object_keys' => array(
                                'objectTiara' => 'bouwNummer_ObjectTiaraID',        // Mapped value - ALWAYS Use the TiaraID
                                'objectVestiging' => 'bouwNummer_NVMVestigingNR',   // Mapped value - USE the Vestigingsnummer of the OG Object, NOT The media objects.
                            ),

                            # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                            'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
                        ),
                        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array(/* TableName */ 'tableName' => 'og_mappingnieuwbouwbouwnummers')
                    ),
                ),
            ),
            // Custom Post Type: 'alv'
            'alv' => array(
                'post_type_args' => array(
                    // This is just all the data / instructions that WordPress needs to know about the custom post type so that it can work correctly.
                    'labels' => array(
                        // Labels for the custom post type in the WordPress admin
                        'name' => 'OG A&LV Objecten',
                        'singular_name' => 'OG A&LV Object',
                        'add_new' => 'Nieuwe toevoegen',
                        'add_new_item' => 'Nieuw OG A&LV Object toevoegen',
                        'edit_item' => 'OG A&LV Object bewerken',
                        'new_item' => 'Nieuw OG A&LV Object',
                        'view_item' => 'Bekijk OG A&LV Object',
                        'search_items' => 'Zoek naar OG A&LV Objecten',
                        'not_found' => 'Geen OG A&LV Objecten gevonden',
                        'not_found_in_trash' => 'Geen OG A&LV Objecten gevonden in de prullenbak',
                        'parent_item_colon' => '',
                        'menu_name' => 'ALV'
                    ),
                    'public' => true,
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                    'show_in_menu' => 'pixelplus-og-plugin-aanbod',
                    'taxonomies' => array('category', 'post_tag')
                ),
                'database_tables' => array(
                    'object' => array(
                        # TableName
                        'tableName' => 'tbl_OG_alv',                                        // NON Mapped - Name of the table
                        # Normal fields
                        'ID' => 'object_ObjectTiaraID',                                     // Mapped value - ALWAYS Use the TiaraID
                        /*
                        Warning: You can only use one of the separators at the same time.
                        post_title Separators:
                            ; (Semicolon)   - The semi-colon is used to separate the values from each other with ' '
                            | (Pipe)        - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
                            Nothing       - If there is no separator, it will just use the first value. The only variable given in
                        */
                        'post_title' => 'straat;huisnummer;huisnummertoevoeging;plaats',    // Mapped value - Default: Straat;Huisnummer;Huisnummertoevoeging;Plaats
                        /*
                        Warning: You can only use one of the separators at the same time.
                        post_name Separators:
                            - (Dash)      - The dash is used to separate the values from each other with '-'
                            | (Pipe)      - The pipe is used as an if statement, if the first value is empty, then the second value will be used if it exists
                            Nothing       - If there is no separator, it will just use the first value. The only variable given in
                         */
                        'post_name' => 'straat-huisnummer-huisnummertoevoeging-plaats',     // Mapped value - Default: Straat-Huisnummer-Huisnummertoevoeging-Plaats
                        'post_content' => 'aanbiedingstekst',                               // Mapped value - Default: De aanbiedingstekst
                        'datum_gewijzigd' => '',                                            // Mapped value - Default: datum_gewijzigd  ; Default value is only for objects without a mapping table within the database
                        'datum_toegevoegd' => 'ObjectDate',                                 // Mapped value - Default: datum_toegevoegd ; Default value is only for objects without a mapping table within the database
                        'objectCode' => 'ObjectCode',                                       // Mapped value - Default: ObjectCode       ; Default value is only for objects without a mapping table within the database

                        # Post fields
                        'media' => array(
                            # TableName
                            'tableName' => 'tbl_OG_media',
                            # Normal fields
                            'search_id' => 'id_OG_bog',
                            'mediaID' => 'media_Id',                // Mapped value
                            'datum_gewijzigd' => 'MediaUpdated',
                            'mediaName' => 'MediaName',
                            'media_Groep' => 'MediaType',

                            # Post fields
                            'object_keys' => array(
                                'objectTiara' => '_id',
                                'objectVestiging' => 'ObjectVerstigingsNummer',
                            ),
                            # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                            'mapping' => array(
                                # TableName
                                'tableName' => 'og_mappingmedia',
                            )
                        ),
                        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        'mapping' => array(
                            # TableName
                            'tableName' => 'og_mappingbedrijven',
                        ),
                    ),
                )
            )
        );

        // ===== Start of Construct =====
        foreach ($customPostTypes as $postType => $postTypeArgs) {
            if (!in_array($postType, $objectAccess)) {
                // Deleting it out of the array
                unset($customPostTypes[$postType]);
            }
        }
        // Returning the array
        return $customPostTypes;
    }
}
class OGSyncColorScheme {
    // ================ Declaring Variables ================
    public array $mainColors = array(
        'light' => 3,
        'modern' => 1,
        'coffee' => 2,
        'ectoplasm' => 2,
        'midnight' => 3,
        'ocean' => 2,
        'sunrise' => 2,
        '80s-kid' => 1,
        'adderley' => 2,
        'aubergine' => 3,
        'blue' => 1,
        'contrast-blue' => 0,
        'cruise' => 3,
        'flat' => 2,
        'kirk' => 0,
        'lawn' => 3,
        'modern-evergreen' => 3,
        'primary' => 3,
        'seashore' => 3,
        'vinyard' => 3
    );

    // ================ Begin of Class ================
    function returnColor(): string
    {
        // ======== Declaring Variables ========
        global $_wp_admin_css_colors;
        $OGSyncColorScheme = get_user_option('admin_color');

        // ======== Start of Function ========
        foreach ($this->mainColors as $key => $value) {
            if ($key == $OGSyncColorScheme) {
                return $_wp_admin_css_colors[$OGSyncColorScheme]->colors[$this->mainColors[$key]];
            }
        }
        return $_wp_admin_css_colors['fresh']->colors[2];
    }
}
class OGSyncSettingsData {
	// ============ Declare Variables ============
	// Strings
	public static string $settingPrefix = 'ppOGSync_'; // This is the prefix for all the settings used within the OG Plugin
	public static string $cacheFolder = 'caches/'; // This is the folder where all the cache files are stored within the server/ftp

	// Arrays
	private static array $apiURLs = [
		'license' => 'https://og-feeds2.pixelplus.nl/api/validate.php',
		'syncTimes' => 'https://og-feeds2.pixelplus.nl/api/latest.php'
	];
	private static array $cacheFiles = [
		'licenseCache' => 'licenseCache.json', // This is the cache file for the checking the Licence key
	];
	private static array $arrOptions = [
		# ======== OG Admin Settings ========
		# ==== Licentie ====
		/* Setting Name */'licenseKey' => /* Default Value */   '', // License Key
	];
	private static array $adminSettings = [
		// Settings 1
		/* Option Group= */ 'ppOGSync_adminOptions' => [
			// General information
			'settingPageSlug' => 'ppOGSync-plugin-settings',
			// Sections
			'sections' => [
				// Section 1 - Licentie section
				/* Section Title= */'Licentie' => [
					'sectionID' => 'ppOGSync_SectionLicence',
					'sectionCallback' => 'htmlLicenceSection',
					// Fields
					'fields' => [
						// Field 1 - Licentie sleutel
						/* Setting Field Title= */'Licentie Sleutel' => [
							'fieldID' => 'ppOGSync_licenseKey',
							'fieldCallback' => 'htmlLicenceKeyField',
						]
					]
				],
			]
		],
	];

	// ============ Getters ============
	public static function apiURLs(): array {
		return self::$apiURLs;
	}
	public static function cacheFiles(): array {
		return self::$cacheFiles;
	}
	public static function arrOptions(): array {
		return self::$arrOptions;
	}
	public static function adminSettings(): array {
		return self::$adminSettings;
	}

	// ============ PHP Functions ============
	// ==== Sanitize Functions ====
	public function sanitize_checkboxes($input): string {
		// ======== Declaring Variables ========
		# Vars
		$strOutput = '';
		foreach ($input as $key => $value) {
			$strOutput .= "$key:$value;";
		}

		// ======== Start of Function ========
        # Return with last character removed
		return substr($strOutput, 0, -1);
	}
	public function sanitize_imageField($input) {
		// ======== Start of Function ========
		# Putting in 'testing' table to test
		return $input;
	}

	// ============ HTML Functions ============
	// ======== Admin Options ========
	// Sections
	static function htmlLicenceSection(): void { ?>
        <p>De licentiesleutel die de plugin activeert</p>
	<?php }
	// Fields
	static function htmlLicenceKeyField(): void {
		// ===== Declaring Variables =====
		// Vars
		$licenseKey = get_option(self::$settingPrefix.'licenseKey');

		// ===== Start of Function =====
		// Check if licenseKey is empty
		echo("<input type='text' name='".self::$settingPrefix."licenseKey' value='".esc_attr($licenseKey)."'");
		if ($licenseKey == '') {
			// Display a message
			echo('Het veld is nog niet ingevuld.');
		}
	}
}
class OGSyncMapping {
	// ================ Constructor ================
	function __construct() {

	}

	// ================ Begin of Class ================
    function cleanupObjects($OGTableRecord): mixed {
	    foreach ($OGTableRecord as $OGTableRecordKey => $OGTableRecordValue) {
		    # Check if the value is empty and if so remove the whole key from the OBJECT
		    if ($OGTableRecordValue == '' or $OGTableRecordValue == NULL or $OGTableRecordValue == 'NULL') {
			    unset($OGTableRecord->{$OGTableRecordKey});
		    }
	    }

        # Return the cleaned up OBJECT
        return $OGTableRecord;
    }
    function mapMetaData($OGTableRecord, $databaseKeysMapping, $locationCodes=[], $databaseKeys=[]) {
        if (!empty($databaseKeysMapping)) {
            // ======== Declaring Variables ========
            # Classes
            global $wpdb;

            # Vars
            $mappingTable = $wpdb->get_results("SELECT * FROM `{$databaseKeysMapping['tableName']}`", ARRAY_A);
            // ========================= Start of Function =========================
            // ================ Cleaning the Tables/Records ================
            # Getting rid of all the useless and empty values in the OBJECT
            $OGTableRecord = $this->cleanupObjects($OGTableRecord);
            # Getting rid of all the useless and empty values in the MAPPING TABLE
            foreach ($mappingTable as $mappingKey => $mappingTableValue) {
                # Check if the value is empty and if so remove the whole key from the OBJECT
                if (is_null($mappingTableValue['pixelplus']) or empty($mappingTableValue['pixelplus'])) {
                    unset($mappingTable[$mappingKey]);
                }
            }

            // ================ Mapping the Data ================
            foreach ($mappingTable as $mappingKey => $mappingValue) {
                // ==== Checking conditional ====
                if (str_starts_with($mappingValue['pixelplus'], '(') and str_ends_with($mappingValue['pixelplus'], ')')) {
                    // ==== Declaring Variables ====
                    $strTrimmedKey = trim($mappingValue['pixelplus'], '()');
                    $arrExplodedKey = explode('|', $strTrimmedKey);
                    $boolResult = false;

                    // ==== Start of Function ====
                    # Step 1: Looping through all the keys
                    foreach ($arrExplodedKey as $arrExplodedKeyValue) {
                        # Step 2: Check if the key even isset or empty in OG Record
                        if (isset($OGTableRecord->{$arrExplodedKeyValue}) and !empty($OGTableRecord->{$arrExplodedKeyValue})) {
                            # Step 3: Change the mapping table's value to just one key instead of making the the key an array/conditional
                            $mappingTable[$mappingKey]['pixelplus'] = $arrExplodedKeyValue;
                            $boolResult = true;
                        }
                    }
                    # Step 4: Check if the result is false and if so unset the whole key from the mapping table
                    if (!$boolResult) {
                        unset($mappingTable[$mappingKey]);
                    }
                }
                // ==== Checking concatinations ====
	            if (str_starts_with($mappingValue['pixelplus'], '{') and str_ends_with($mappingValue['pixelplus'], '}')) {
		            // ==== Declaring Variables ====
		            # Vars
		            $strTrimmedKey = trim($mappingValue['pixelplus'], '{}');
		            $arrExplodedKey = explode('+', $strTrimmedKey);
		            $arrExplodedKeyMinus = explode('-', $strTrimmedKey);
		            $strResult = '';

		            # Bools
		            $boolTrimSpaces = False;

		            // ==== Start of Function ====
		            # Step 1: Looping through all the keys
		            foreach($arrExplodedKey as $arrExplodedKeyValue) {
			            # Step 2: Checking if there are any special character at the beginning and or end of the key
			            if (str_starts_with($arrExplodedKeyValue, '~') and str_ends_with($arrExplodedKeyValue, '~')) {
				            # Step 3: Remove the ~ from the value and all the spaces. And then adding it to strResult
				            $boolTrimSpaces = True;

				            # Removing the ~ from the value
				            $arrExplodedKeyValue = trim($arrExplodedKeyValue, '~');
			            }

			            # Step 2: Check if the key even isset or empty in OG Record
			            if (isset($OGTableRecord->{$arrExplodedKeyValue}) and !empty($OGTableRecord->{$arrExplodedKeyValue})) {
				            # Step 4: Adding it to strResult
				            $strResult .= $boolTrimSpaces ? str_replace(' ', '', $OGTableRecord->{$arrExplodedKeyValue}).' ' : $OGTableRecord->{$arrExplodedKeyValue}.' ';
			            }
		            }
		            foreach($arrExplodedKeyMinus as $arrExplodedKeyValue) {
			            # Step 2: Check if the key even isset or empty in OG Record
			            if (isset($OGTableRecord->{$arrExplodedKeyValue}) and !empty($OGTableRecord->{$arrExplodedKeyValue})) {
				            # Step 3: Add the value to the result string
				            $strResult .= $OGTableRecord->{$arrExplodedKeyValue}.'-';
			            }
		            }
		            # Step 5: Putting it in the mapping table as a default value
		            $mappingTable[$mappingKey]['pixelplus'] = "'".rtrim($strResult, ' -')."'";
	            }

                // ==== Checking the statuses ====
                if (str_starts_with($mappingValue['pixelplus'], '$') and str_ends_with($mappingValue['pixelplus'], '$')) {
                    // ==== Declaring Variables ====
                    # Vars
                    $strTrimmedKey = trim($mappingValue['pixelplus'], '$');
                    $arrExplodedKey = explode('|', $strTrimmedKey);

                    // ==== Start of Function ====
                    // if has more than 1 key
                    if (count($arrExplodedKey) > 1) {
                        # Step 1: Checking the value
                        if (isset($OGTableRecord->{$arrExplodedKey[0]}) and !empty($OGTableRecord->{$arrExplodedKey[0]})) {
                            switch (strtolower(end($arrExplodedKey))) {
                                case 'sold': {
                                    // ==== Start of Function ====
                                    # If the value is verkocht then put it to 1
                                    $mappingTable[$mappingKey]['pixelplus'] = (strtolower($OGTableRecord->{$arrExplodedKey[0]} == 'verkocht') ? "'1'" : "'0'");
                                    break;
                                }
                                case 'prijs': {
                                    // ==== Start of Function ====
                                    $mappingTable[$mappingKey]['pixelplus'] = ($OGTableRecord->{$arrExplodedKey[0]} > 0) ? "'1'" : "'0'";
                                    break;
                                }
                                case 'onderhoudswaardering': {
                                    # Remove all weird characters, change to space then to lowercase and then UpperCase the first letter
                                    $mappingTable[$mappingKey]['pixelplus'] = "'".ucfirst(strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $OGTableRecord->{$arrExplodedKey[0]})))."'";

                                    # Removing the old record
                                    unset($OGTableRecord->{$arrExplodedKey[0]});
                                    break;
                                }
                            }
                        }
                    }
                }

                // ==== Checking arrays ====
                if (str_starts_with($mappingValue['pixelplus'], '[') and str_ends_with($mappingValue['pixelplus'], ']')) {
                    // ==== Declaring Variables ====
                    # Vars
                    $strTrimmedKey = trim($mappingValue['pixelplus'], '[]');
                    $arrExplodedKey = explode(',', $strTrimmedKey);
                    $strResult = '';

                    // ==== Start of Function ====
                    if (!empty($arrExplodedKey)) {
                        # Step 1: Looping through all the keys
                        foreach($arrExplodedKey as $arrExplodedKeyValue) {
                            # Step 2: Check if the key even isset or empty in OG Record
                            if (isset($OGTableRecord->{$arrExplodedKeyValue}) and !empty($OGTableRecord->{$arrExplodedKeyValue})) {
                                # Getting all the value's from that record
                                $explodedRecord = explode(',', $OGTableRecord->{$arrExplodedKeyValue});

                                # Step 3: Looping through all the values
                                foreach ($explodedRecord as $explodedRecordValue) {
                                    # Step 4: Removing the brackets from the value
                                    $explodedRecordValue = trim($explodedRecordValue, '[]');
                                    $strResult .= $explodedRecordValue.', ';
                                }
                                # Step 5: Removing the old key
                                if ($strResult != '') {
                                    unset($OGTableRecord->{$arrExplodedKeyValue});
                                }
                            }
                        }
                        # Step 6: Putting it in the mapping table as a default value
                        $mappingTable[$mappingKey]['pixelplus'] = "'".ucfirst(strtolower(rtrim($strResult, ', ')."'"));

                    }
                }

                // ==== Checking location codes ====
                if (str_starts_with($mappingValue['pixelplus'], '<') and str_ends_with($mappingValue['pixelplus'], '>')) {
                    // ==== Declaring Variables ====
                    # Vars
                    $strTrimmedKey = trim($mappingValue['pixelplus'], '<>');

                    // ==== Start of Function ====
                    if (!empty($strTrimmedKey)) {
                        # Step 1: Getting the value from the OG Record

                        # Step 2: Checking if the value is empty
                        if (isset($OGTableRecord->{$strTrimmedKey}) and !empty($OGTableRecord->{$strTrimmedKey})) {
                            # Step 3: Check if it's a number or a string
                            if (is_numeric($OGTableRecord->{$strTrimmedKey})) {
                                # Step 4: Checking if the value is in the locationCodes array
                                $key = array_search($OGTableRecord->{$strTrimmedKey}, $locationCodes[0]);
                                if ($key !== false) {
                                    # Step 5: setting the key as the value
                                    $OGTableRecord->{$mappingTable[$mappingKey]['vanherk']} = $locationCodes[1][$key];
                                }
                            }
                            else {
                                # Step 4: Checking if the value is can be converted to a datetime
                                $datetime = strtotime($OGTableRecord->{$strTrimmedKey});
                                if ($datetime !== false) {
                                    # Step 5: Adding it to the OG Record
                                    $OGTableRecord->{$mappingTable[$mappingKey]['vanherk']} = $datetime;
                                }
                            }
                        }
                    }
                }

                // ==== Checking the total buildnumbers/buildtypes ====
                if (str_starts_with($mappingValue['pixelplus'], '^') and str_ends_with($mappingValue['pixelplus'], '^')) {
                    // ==== Declaring Variables ====
                    # Vars
                    $strTrimmedKey = trim($mappingValue['pixelplus'], '^');

                    // ==== Start of Function ====
                    if (!empty($strTrimmedKey)) {
                        // ==== Declaring Variables ====
                        # Vars
                        $projectID = $OGTableRecord->{$databaseKeys[0]['media']['search_id']} ?? $OGTableRecord->id ?? '0';

                        // ==== Start of Function ====
                        if ($strTrimmedKey == 'bouwtypes') {
                            # Step 1: Getting the count of bouwtypes in the database
                            $count = $wpdb->get_var("SELECT COUNT(*) FROM {$databaseKeys[1]['tableName']} WHERE {$databaseKeys[0]['media']['search_id']} = $projectID");

                            # Step 2: Adding the count to the OG Record
                            $OGTableRecord->{$mappingTable[$mappingKey]['vanherk']} = $count;
                        }
                        if ($strTrimmedKey == 'bouwnummers') {
                            # Step 1: Getting the count of bouwnummers in the database
                            $count = $wpdb->get_var("SELECT COUNT(*) FROM {$databaseKeys[2]['tableName']} WHERE {$databaseKeys[0]['media']['search_id']} = $projectID");

                            # Step 2: Adding the count to the OG Record
                            $OGTableRecord->{$mappingTable[$mappingKey]['vanherk']} = $count;
                        }
                    }
                }

                // ==== Checking the objecttype ====
                if (str_starts_with($mappingValue['pixelplus'], '*') and str_ends_with($mappingValue['pixelplus'], '*')) {
                    // ==== Declaring Variables ====
                    # Vars
                    $strTrimmedKey = trim($mappingValue['pixelplus'], '*');
                    $arrExplodedKey = explode('|', $strTrimmedKey);

                    // ==== Start of Function ====
                    if (!empty($arrExplodedKey)) {
                        # Step 1: Checking if the key isset in the OG Record
                        if (isset($OGTableRecord->{$arrExplodedKey[0]}) and !empty($OGTableRecord->{$arrExplodedKey[0]})) {
                            # Step 2: Set it as the value
                            $OGTableRecord->{$mappingTable[$mappingKey]['vanherk']} = $arrExplodedKey[1];

                            # Step 3: Removing the old key
                            unset($OGTableRecord->{$arrExplodedKey[0]});
                        }
                        else {
                            # Setting the value to the second key
                            $OGTableRecord->{$mappingTable[$mappingKey]['vanherk']} = end($arrExplodedKey);
                        }
                    }
                }
            }
            # Looping through the mapping table with the updated values
            foreach ($mappingTable as $mappingValue) {
                // ======== Checking default values ========
                if (str_starts_with($mappingValue['pixelplus'], "'") and str_ends_with($mappingValue['pixelplus'], "'")) {
                    // ==== Declaring Variables ====
                    # Vars
                    $strTrimmedKey = trim($mappingValue['pixelplus'], "'");

                    // ==== Start of Function ====
                    # Step 1: Making a new key with the value of the old key
                    $OGTableRecord->{$mappingValue['vanherk']} = $strTrimmedKey;
                    # Step 2: Removing the old key
                    unset($OGTableRecord->{$mappingValue['pixelplus']});
                }
            }


            # Direct matches
            foreach ($OGTableRecord as $OGTableRecordKey => $OGTableRecordValue) {
                foreach ($mappingTable as $mappingValue) {
                    // ==== Checking direct match ====
                    if ($OGTableRecordKey == $mappingValue['pixelplus']) {
                        # Making a new key with the value of the old key
                        $OGTableRecord->{$mappingValue['vanherk']} = $OGTableRecordValue;
                        # Removing the old key
                        unset($OGTableRecord->{$OGTableRecordKey});
                    }
                }
            }
        }
        else {
            // ================ Cleaning the Tables/Records ================
            # Getting rid of all the useless and empty values in the OBJECT
            $OGTableRecord = $this->cleanupObjects($OGTableRecord);
        }

        // ================ Returning the Object ================
        # Return the object
        return $OGTableRecord;
    }
}

// ========== Inactivated/Activated state of Plugin ==========
class OGSyncLicense {
    // ============ Declaring Variables ============
    # Nulls
    private static $licenseDataCache = null;

    # Strings
    private static string $PluginError_Ophaalfout = '#OGSync-Ophaalfout: Er is iets fout gegaan bij het ophalen van de licentie gegevens. Neem contact op met PixelPlus.';
    private static string $PluginError_Ongeldig = '#OGSync-Ongeldig: De licentie is ongeldig. Neem contact op met PixelPlus.';
    private static string $PluginError_Unknown = '#OGSync-Unknown: Er is iets fout gegaan bij het ophalen van de licentie gegevens. Neem contact op met PixelPlus.';
    private static string $PluginError_NotActivated = '#OGSync-NotActivated: De licentie is niet geactiveerd. Voer de licentie in en activeer de plugin.';

    // ============ Functions ============
    # Function to fetch the Licence data from the API
    private static function fetchLicenseData($url): mixed {
        // ==== Getting the JSON from the API ====
        $jsonData = OGSyncTools::getJSONFromAPI($url);

        if (is_wp_error($jsonData)) {
            return $jsonData;
        }

        // ==== Start of IF ====
        if (isset($jsonData['message']) and $jsonData['message'] == 'Authentication token is not set!') {
            return ['success' => false, 'message' => 'Authentication token is not set!'];
        }

        return $jsonData;
    }

    # Function to check the license and adminNotice the things that don't work
    private static function checkLicense(): mixed {
        // If the license data is already fetched, return it
        if (self::$licenseDataCache !== null) {
            return self::$licenseDataCache;
        }

        // ======== Declaring Variables ========
        # Cache
        $cacheFile = plugin_dir_path(dirname(__DIR__)) . OGSyncSettingsData::$cacheFolder . OGSyncSettingsData::cacheFiles()['licenseCache'];

        # API
        $url = OGSyncSettingsData::apiURLs()['license'];
        $qArgs = !empty(get_option(OGSyncSettingsData::$settingPrefix.'licenseKey')) ? "?token=".get_option(OGSyncSettingsData::$settingPrefix.'licenseKey') : '';

        // ======== Start of Function ========
        // If cache file doesn't exist, create it if the license is valid
        if (!file_exists($cacheFile)) {
            // ==== Declaring Variables IF ====
            # Vars
            $cacheData = self::fetchLicenseData($url . $qArgs);

            // ==== Start of IF ====
            if (is_wp_error($cacheData)) {
                OGSyncTools::adminNotice('error', self::$PluginError_Ophaalfout);
            }
            elseif (isset($cacheData['success']) and $cacheData['success']) {
                file_put_contents($cacheFile, json_encode($cacheData));
            }
            elseif (isset($cacheData['success']) and $cacheData['message'] == 'Invalid authentication token!') {
                OGSyncTools::adminNotice('error', self::$PluginError_Ongeldig);
            }
            elseif (isset($cacheData['message']) and $cacheData['message'] == 'Authentication token is not set!') {
                OGSyncTools::adminNotice('error', self::$PluginError_NotActivated);
            }
            else {
                OGSyncTools::adminNotice('error', self::$PluginError_Unknown);
            }
        }
        else {
            // ==== Declaring Variables ELSE ====
            // If cache file exists, fetch data from the cache
            $cacheData = json_decode(file_get_contents($cacheFile), true);

            // ==== Start of ELSE ====
            // Check if the data is stale (older than an hour) and needs to be updated
            if ((time() - filemtime($cacheFile)) >= 3600 || empty($cacheData)) {
                $cacheData = self::fetchLicenseData($url . $qArgs);

                // ==== Start of IF ====
                if (is_wp_error($cacheData)) {
                    OGSyncTools::adminNotice('error', "#OGSync Plugin Error: Er is iets fout gegaan bij het ophalen van de licentie gegevens. Neem contact op met PixelPlus.");
                }
                elseif (isset($cacheData['success']) and $cacheData['success']) {
                    file_put_contents($cacheFile, json_encode($cacheData));
                }
                elseif (isset($cacheData['message']) and $cacheData['message'] == 'Invalid authentication token!') {
                    OGSyncTools::adminNotice('error', self::$PluginError_Ongeldig);
                }
                elseif (isset($cacheData['message']) and $cacheData['message'] == 'Authentication token is not set!') {
                    OGSyncTools::adminNotice('error', self::$PluginError_NotActivated);
                }
                else {
                    OGSyncTools::adminNotice('error', self::$PluginError_Unknown);
                }
            }
        }

        // After fetching the license data, store it in the static cache variable
        self::$licenseDataCache = $cacheData;

        return $cacheData;
    }

    # Function to check if the plugin is activated or not
    public static function checkActivation(): bool {
        $jsonData = self::checkLicense();

        // ======== Start of Function ========
        # Checking if the license is valid
        if (is_wp_error($jsonData)) {
            return False;
        }
        elseif (isset($jsonData['success']) and $jsonData['success']) {
            return True;
        }
        else {
            return False;
        }
    }

    # Function to check the post type access
    public static function checkPostTypeAccess(): array {
        // ==== Start of Function ====
        $objectAccess = self::checkLicense();

	    // Return the array
        return $objectAccess['data']['types'] ?? [];
    }
}
class OGSyncMenus
{
    // ======== Constructor ========
    function __construct()
    {
        // Creating the Menu's / Custom Post Types
        add_action('admin_menu', [__CLASS__, 'createMenus']);
        // Registering all the needed settings for the plugin
        add_action('admin_init', [__CLASS__, 'registerSettings']);
        // Updating the permalinks
        add_action('init', function() {
	        // ======== Start of Function ========
	        // Permalinks
	        flush_rewrite_rules();
        });
    }

    // ======== Creating menu's ========
    public static function createMenus(): void {
        // ======= Declaring Variables =======
		# Vars
        $boolPluginActivated = OGSyncLicense::checkActivation();
		if ($boolPluginActivated) {
			$postTypeData = OGSyncPostTypeData::customPostTypes();
			$objectAccess = OGSyncLicense::checkPostTypeAccess();
		}

        // Making the Global Settings Page
        add_menu_page(
            'Admin Settings',
            'OG Sync Settings',
            'manage_options',
            'ppOGSync-plugin-settings',
            [__CLASS__, 'HTMLOGAdminSettings'],
            'dashicons-admin-generic',
            101
        );
        add_submenu_page(
            'pixelplus-og-plugin-settings',
            'Algemeen',
            'Algemeen',
            'manage_options',
            'ppOGSync-plugin-settings',
            [__CLASS__, 'HTMLOGAdminSettings']
        );

        // ======= When Plugin is activated =======
        if ($boolPluginActivated) {
            // ======== Post Types ========
            // ==== OG Settings ====
            // Submenu Items based on the OG Post Types for in the OG Settings
            foreach ($postTypeData as $postType => $postTypeArray) {
                if (in_array($postType, $objectAccess)) {
                    $name = $postTypeArray['post_type_args']['labels']['menu_name'];
                    // Creating submenu for in the OG Settings
                    add_submenu_page(
                        'pixelplus-og-plugin-settings',
                        $name,
                        $name,
                        'manage_options',
                        'pixelplus-og-plugin-settings-' . strtolower($name),
                        [__CLASS__, 'HTMLOGAdminSettings'.$name]
                    );
                }
            }

            // ==== Items OG Admin ====
            // Menu Item: OG Dashboard
            add_menu_page(
                'Admin Dashboard',
                'OG Admin Dashboard',
                'manage_options',
                'pixelplus-og-plugin',
                [__CLASS__, 'HTMLOGAdminDashboard'],
                'dashicons-plus-alt',
                100);
            // First sub-menu item name change
            add_submenu_page(
                'pixelplus-og-plugin',
                'Admin Dashboard',
                'Dashboard',
                'manage_options',
                'pixelplus-og-plugin',
                [__CLASS__, 'HTMLOGAdminDashboard']);

            // ==== Items OG Aanbod ====
            // Menu Item: OG Aanbod Dashboard
            add_menu_page(
                'OG Aanbod',
                'OG Aanbod',
                'manage_options',
                'pixelplus-og-plugin-aanbod',
                [__CLASS__, 'HTMLOGAanbodDashboard'],
                'dashicons-admin-multisite',
                40);
            // First sub-menu item name change
            add_submenu_page(
                'pixelplus-og-plugin-aanbod',
                'Aanbod Dashboard',
                'Dashboard',
                'manage_options',
                'pixelplus-og-plugin-aanbod',
                [__CLASS__, 'HTMLOGAanbodDashboard'],
                0
            );
        }
    }

	// ==== Option functions ====
	static function createCheckboxes($input, $checkBoxName, $label): void {
		if ($input[1] == '0') {
			echo("<input type='hidden' name='$checkBoxName' value='0' checked>");
			echo("<input type='checkbox' name='$checkBoxName' value='1'>$label<br>");
		}
        elseif ($input[1] == '0f') {
			echo("<input type='hidden' name='$checkBoxName' value='0f' checked>");
			echo("<input type='checkbox' name='$checkBoxName' value='0f' disabled>$label<br>");
		}
        elseif ($input[1] == '1f') {
			echo("<input type='hidden' name='$checkBoxName' value='1f' checked>");
			echo("<input type='checkbox' name='$checkBoxName' value='1f' checked disabled>$label<br>");
		}
		else {
			echo("<input type='hidden' name='$checkBoxName' value='0' checked>");
			echo("<input type='checkbox' name='$checkBoxName' value='1' checked>$label<br>");
		}
	}
    static function createCheckboxField($fieldArray, $strOption): void {
        // ===== Declaring Variables ====
	    $arrExplodedOption = explode(';', $strOption);

	    // ===== Start of Function =====
	    # Loop through the exploded array
	    if (!empty($arrExplodedOption)) {
		    foreach ($arrExplodedOption as $value) {
			    // ==== Declaring Variables ====
			    # Vars
			    $explodedValue = explode(':', $value);
			    if (empty($explodedValue)) continue;

			    # Checkboxes
			    $checkBoxName = "{$fieldArray['fieldID']}[$explodedValue[0]]"; // Append index to the checkbox name
			    $label = preg_replace('/(?<! )[A-Z]/', ' $0', $explodedValue[0]);

			    // ==== Start of Loop ====
			    self::createCheckboxes($explodedValue, $checkBoxName, $label);
		    }
	    }
    }
    static function createTextField($fieldID, $strOption): void {
	    // ===== Declaring Variables ====
        $value = esc_attr($strOption);

	    // ===== Start of Function =====
	    // Check if licenseKey is empty
	    echo("<input type='text' name='$fieldID' value='$value'");
    }
	static function createImageField($fieldArray, $strOption): void {
		// ========== Declaring Variables =========
		# Vars
		$strTrimmedOption = basename($strOption) ?? '';

		// ========== Start of Function ==========
		# Initialize media enqueue
		wp_enqueue_media();

		// ===== Displaying the Image =====
		echo("
        <br/>
        <table class='form-table'>
            <tr>
                <th>
                    <!-- Border -->
                    <img style='padding: 2px; border: 1px solid rgba(0, 0, 0, 0.1);' id='{$fieldArray['fieldID']}_logoPreview' src='$strOption' width='115' alt='⠀Niks gekozen' />
                    <p id='{$fieldArray['fieldID']}_Text' style='font-size: 14px;'>$strTrimmedOption</p>
                </th>
                
                <td>
                    <input type='hidden' id='{$fieldArray['fieldID']}_URL' name='{$fieldArray['fieldID']}' value='$strOption'/>
                    <input type='button' id='{$fieldArray['fieldID']}_upload' class='button button-primary' value='Selecteer Logo'/>
                    <input type='button' id='{$fieldArray['fieldID']}_remove' class='button button-secondary' value='Verwijder Logo'/>
                </td>
            </tr>
        </table>
        <br/>
        ");

		// ===== Script =====
		# Script - Select Button
		echo( "<script>
            jQuery(document).ready(function($){
                // ======== Declaring Variables ========
                // Query Selectors
                const logoPreview = $('#{$fieldArray['fieldID']}_logoPreview');
                const logoURL = $('#{$fieldArray['fieldID']}_URL');
                const logoText = $('#{$fieldArray['fieldID']}_Text');
                
                // CSS
                const logoPadding = '1px';
                const logoBorder = '1px solid rgba(0, 0, 0, 0.2)';
                
                // ======== Functions ========
                // Check if the source is found or not
                if (logoURL.val() === '' || logoURL.val() === undefined) {
                    // Border
                    logoPreview.css('border', 'none');
                }
                
                // ==== Select Button ====
                $('#{$fieldArray['fieldID']}_upload').click(function(e) {
                    e.preventDefault();
                    const custom_uploader = wp.media({
                        title: 'Custom Image',
                        button: {
                            text: 'Use this image'
                        },
                        // Set this to true to allow multiple files to be selected
                        multiple: false
                        
                    }).on('select', function() {
                        // ===== Declaring Variables =====
                        const attachment = custom_uploader.state().get('selection').first().toJSON();
                        
                        // ==== Updating the logo preview ====
                        // Attachement URL
                        logoPreview.attr('src', attachment.url);
                        // CSS
                        logoPreview.css('padding', logoPadding);
                        logoPreview.css('border', logoBorder);
                        
                        // ==== Updating the logo URL ====
                        logoURL.val(attachment.url);
                        
                        logoText.text(attachment.url.split('/').reverse()[0]);
                    }).open();
                });
                
                // ==== Remove Button ====
                $('#{$fieldArray['fieldID']}_remove').click(function(e) {
                    e.preventDefault();
                    
                    // ===== Declaring Variables =====
                    // ==== Updating the logo preview ====
                    // Attachement URL
                    logoPreview.attr('src', '');
                    // CSS
                    logoPreview.css('padding', logoPadding);
                    logoPreview.css('border', 'none');
                    // Text
                    logoText.text('');
                    
                    // ==== Updating the logo URL ====
                    logoURL.val('');
                });
            });
        </script>" );
	}

    // ==== Register Settings ====
	public static function registerSettings(): void {
		// ==== Declaring Variables ====
		# Vars
		$boolPluginActivated = OGSyncLicense::checkActivation();

		// ==== Start of Function ====
		# Setting sections and use the OGSyncSettingsData adminSettings data
		foreach(OGSyncSettingsData::adminSettings() as $optionGroup => $optionArray) {
			# Settings for on settings page
			foreach ($optionArray['sections'] as $sectionTitle => $sectionArray) {
				# Checking if this section has the permission to be created
				if (!empty($sectionArray['permission']) && $sectionArray['permission'] == 'plugin_activated' && !$boolPluginActivated) continue;

				# Creating the Section
				add_settings_section(
					$sectionArray['sectionID'],
					$sectionTitle,
					!empty($sectionArray['sectionCallback']) ? "OGSyncSettingsData::{$sectionArray['sectionCallback']}" : function () {

					},
					$optionArray['settingPageSlug'],
				);
				foreach ($sectionArray['fields'] as $fieldTitle => $fieldArray) {
					// Creating the Field
					add_settings_field(
						$fieldArray['fieldID'],
						$fieldTitle,
						!empty($fieldArray['fieldCallback']) ? "OGSyncSettingsData::{$fieldArray['fieldCallback']}" : function () use ($fieldArray) {
							// ======== Declaring Variables ========
							// Vars
							$strOption = get_option($fieldArray['fieldID']);

							// ======== Start of Function ========
							# Checking if this needs to be a checkbox or textfield
							if (!empty($fieldArray['sanitizeCallback'])) {
								switch ($fieldArray['sanitizeCallback']) {
									case 'sanitize_checkboxes':
										self::createCheckboxField($fieldArray, $strOption);
										break;
									case 'sanitize_imageField':
										self::createImageField($fieldArray, $strOption);
										break;
									default:
										break;
								}
							}
							else {
								self::createTextField($fieldArray['fieldID'], $strOption);
							}
						},
						$optionArray['settingPageSlug'],
						$sectionArray['sectionID'],
					);
					// Registering the Field
					register_setting($optionGroup, $fieldArray['fieldID'], !empty($fieldArray['sanitizeCallback']) ? "OGSyncSettingsData::{$fieldArray['sanitizeCallback']}" : '');
				}
			}
		}
	}

    // ============ HTML ============
    // OG Sync Admin
    static function HTMLOGAdminDashboard(): void {
        // ======== Declaring Variables ========
        # Classes
        $OGSyncColorScheme = new OGSyncColorScheme();

        # Variables
        $postTypeData = OGSyncPostTypeData::customPostTypes();

        $url = OGSyncSettingsData::apiURLs()['syncTimes'];
        $qArgs = "?token=".get_option(OGSyncSettingsData::$settingPrefix.'licenseKey');
        $lastSyncTimes = json_decode(wp_remote_get($url.$qArgs)['body'], true);

        $buttonColor = $OGSyncColorScheme->returnColor();

        // ======== Start of Function ========
        # Checking if the API request is successful
        if (isset($lastSyncTimes['success']) and $lastSyncTimes['success']) {
            OGSyncTools::adminNotice('success', 'De laatste syncs zijn succesvol opgehaald.');
            $lastSyncTimes = $lastSyncTimes['data'];
        }
        else {
            $lastSyncTimes = false;
        }

        # HTML
        OGSyncTools::htmlAdminHeader('OG Admin Dashboard');
        echo("
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col' style='border-right: solid 1px black'>
    
                    </div>
                    <div class='col'>
                        <h2 class='text-center'>Statistieken</h2>
    
                        <!-- Table to show when the last syncs have been -->
                        <table class='table table-striped table-bordered'>
                            <thead class='thead-dark'>
                                <tr>
                                    <th scope='col'>Post Type</th>
                                    <th scope='col'>Laatste Sync</th>
                                </tr>
                            </thead>
                            <tbody>");
                                foreach ($postTypeData as $postType => $postTypeArray) {
                                    echo(
                                        "<tr>
                                            <td>".$postTypeArray['post_type_args']['labels']['menu_name']."</td>
                                            <td>".($lastSyncTimes[$postType] ?? 'Nog niet gesynchroniseerd')."</td>
                                        </tr>"
                                    );
                                }
                      echo("</tbody>
                    </div>
                </div>
            </div>
        ");
        OGSyncTools::htmlAdminFooter('OG Admin Dashboard');}
    // OG Site Admin Settings
    static function HTMLOGAdminSettings(): void {OGSyncTools::htmlAdminHeader('OG Admin Settings - Algemeen'); ?>
        <form method="post" action="options.php">
            <?php settings_fields(OGSyncSettingsData::$settingPrefix.'adminOptions');
            do_settings_sections('ppOGSync-plugin-settings');
            OGSyncTools::hidePasswordByName(OGSyncSettingsData::$settingPrefix.'licenseKey');
            submit_button('Opslaan', 'primary', 'submit_license');
            ?>
        </form>
    <?php OGSyncTools::htmlAdminFooter('OG Admin Settings - Algemeen');}

    // OG Aanbod
    static function HTMLOGAanbodDashboard(): void { OGSyncTools::htmlAdminHeader('OG Aanbod Dashboard'); ?>
        <p>dingdong bishass</p>
        <?php OGSyncTools::htmlAdminFooter('OG Aanbod Dashboard');}

    // OG Detailpage
    function HTMLOGDetailPageWonen() { ?>

    <?php }
}

// ========== Fully activated state of the plugin ==========
class OGSyncPostTypes {
	// ======== Declaring Variables ========

	// ======== Start of Class ========
	function __construct() {
		# Creating the post types
		add_action('init', array($this, 'createPostTypes'));

		# Checking the post migration
//		add_action('init', array($this, 'checkMigrationPostTypes'));
	}

	// =========== Functions ===========
	function createPostTypes(): void {
		// ======== Declaring Variables ========
        # Vars
        $templateFolder = plugin_dir_path(dirname(__DIR__)) . 'php/templates/';

		// ======== Start of Function ========
		# Create the OG Custom Post Types (if the user has access to it)
		foreach(OGSyncPostTypeData::customPostTypes() as $postType => $postTypeArray) {
			register_post_type($postType, $postTypeArray['post_type_args']);
		}
	}
}
class OGSyncOffers {
	// ================ Start of Class ================
	function __construct() {
		# Use this one if it is going to be run on the site itself.
//		 add_action('admin_init', array($this, 'examinePosts'));

		# Use this one if it is going to be a cronjob.
		$this->examinePosts();
	}

	// ================ Functions ================
	function getNames($post_data, $object, $databaseKey) {
		# ======== Post Title ========
		// Check if the post_title contains '|' or ';' to determine if to concatenate or just use one
        if (str_contains($databaseKey['post_title'], '|' ) ) {
            $postTitle = explode('|', $databaseKey['post_title']);
            $title = $postTitle[0];

            # Check the first one if it is empty, if it is, use the second one
            if (!empty($object->{$title})) {
                $post_data['post_title'] = $object->{$title};
            }
            else {
                $post_data['post_title'] = $object->{$postTitle[1]};
            }
        }
        elseif (str_contains($databaseKey['post_title'], ';')) {
            $postTitle = explode(';', $databaseKey['post_title']);
            $processedTitles = [];

            # Loop through the titles and check if they are empty, if they are, skip them
            foreach ($postTitle as $title) {
                $objectTitle = $object->{$title} ?? '';

                # Check if the title is uppercase, if it is, make it lowercase
                if (!empty($objectTitle)) {
                    if ($objectTitle == strtoupper($objectTitle)) {
                        $objectTitle = ucfirst(strtolower($objectTitle));
                    }
                    $processedTitles[] = $objectTitle;
                }
            }
            $post_data['post_title'] = implode(' ', $processedTitles);
        }
        else {
            # If there are no separators just think of it as one title and one variable
            $post_data['post_title'] = ucfirst(strtolower($object->{$databaseKey['post_title']} ?? ''));
        }

		# ======== Post Name ========
		if (str_contains($databaseKey['post_name'], '-')) {
			$arrPostNames = explode('-', $databaseKey['post_name']);
			$arrProcessedPostNames = [];

			# Loop through the post names and check if they are empty, if they are, skip them
			foreach ($arrPostNames as $postName) {
				$objectPostName = $object->{$postName} ?? '';

				# Check if the post name is uppercase, if it is, make it lowercase
				if (!empty($objectPostName)) {
					if ($objectPostName == strtoupper($objectPostName)) {
						$objectPostName = ucfirst(strtolower($objectPostName));
					}
					$arrProcessedPostNames[] = $objectPostName;
				}
			}
			$post_data['post_name'] = implode('-', $arrProcessedPostNames);
		}
        elseif (str_contains($databaseKey['post_name'], '|')) {
			$postTitle = explode('|', $databaseKey['post_name']);
			$title = $postTitle[0];

			# Check the first one if it is empty, if it is, use the second one
			if (!empty($object->{$title})) {
				$post_data['post_name'] = strtolower($object->{$title});
			}
			else {
				$post_data['post_name'] = strtolower($object->{$postTitle[1]});
			}
		}
		else {
			$post_data['post_name'] = strtolower($object->{$databaseKey['post_name'] ?? ''});
		}

		$post_data['post_name'] = sanitize_title($post_data['post_name']);

		# ======== Post Content ========
		$post_data['post_content'] = $object->{$databaseKey['post_content']} ?? '';

		# Return the post_data
		return $post_data;
	}
	function getLocationCodes(): array {
		// ================ Declaring Variables ================
		# ==== Variables ====
		# Shit
		$strColumnName = 'location_afdelingscode';
		$strAfdelingName = 'location_api_name';
		$arrAfdelingcodes = [];
		$arrAfdelingNames = [];

		# Query
		$locationPosts = new WP_Query([
			'post_type' => 'location',
			'posts_per_page' => -1,
			'post_status' => 'any',
		]);
		$locationsExist = $locationPosts->have_posts();

		// ================ Start of Function ================
		if ($locationsExist) {
			# Getting the afdelingscodes and shoving them in an array
			foreach ($locationPosts->posts as $locationPost) {
				if (!isset($locationPost->{$strColumnName})) {continue;}
				$arrAfdelingcodes[] = $locationPost->{$strColumnName};
				$arrAfdelingNames[] = $locationPost->{$strAfdelingName};
			}
		}

		// Return it back
		return [$arrAfdelingcodes, $arrAfdelingNames];
	}

    function updateMedia($postID, $postTypeName, $OGobject, $databaseKey): void {
        // ============ Declaring Variables ============
        # Classes
        global $wpdb;
        $OGSyncMapping = new OGSyncMapping();

        # Variables
        $databaseKeysMedia = $databaseKey['media'];
	    $mediaTiaraIDName = !empty($databaseKeysMedia['mediaTiaraID']) ? $databaseKeysMedia['mediaTiaraID'] : $databaseKey['ID'];
	    $postTypeName = !empty($databaseKeysMedia['folderRedirect']) ? $databaseKeysMedia['folderRedirect'] : $postTypeName;
        $mime_type_map = [
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
            'mp4' => 'video/mp4',
        ];
        $mime_type_map2 = [
            'Video' => 'video/mp4',
        ];
        $guid_url = get_site_url();

        $mediaObjects = $wpdb->get_results("SELECT * FROM `{$databaseKeysMedia['tableName']}` WHERE `{$databaseKeysMedia['search_id']}` = $OGobject->id");

        // ============ Start of Function ============
        foreach ($mediaObjects as $mediaObject) {
            // ======== Declaring Variables ========
            # Mapping the data
            $mediaObject = $OGSyncMapping->mapMetaData($mediaObject, ($databaseKeysMedia['mapping'] ?? []));
            $mediaQuery = new WP_Query([
                'post_type' => 'attachment',
                'meta_key' => $databaseKeysMedia['mediaName'],
                'meta_value' => $mediaObject->{$databaseKeysMedia['mediaName']},
                'posts_per_page' => -1,
                'post_status' => 'any',
            ]);
            $mediaExists = $mediaQuery->have_posts();

            // Object last updated
            $objectLastUpdated = $OGobject->{$databaseKey['datum_gewijzigd']} ?? $OGobject->{$databaseKey['datum_toegevoegd']};

            # Vars
	        $mediaTiaraID = $mediaObject->{$mediaTiaraIDName};
            $boolIsConnectedPartner = $mediaObject->{$databaseKeysMedia['media_Groep']} == 'Connected_partner';
            $post_mime_type = $mime_type_map[$mediaObject->{'bestands_extensie'}] ?? $mime_type_map2[$mediaObject->{$databaseKeysMedia['media_Groep']}] ?? 'unknown';
            $media_url = "og_media/{$postTypeName}_{$OGobject->{$databaseKeysMedia['object_keys']['objectVestiging']}}_{$OGobject->{$databaseKeysMedia['object_keys']['objectTiara']}}/{$OGobject->{$databaseKeysMedia['object_keys']['objectTiara']}}_{$mediaTiaraID}.$mediaObject->bestands_extensie";
            $post_data = [
                'post_content' => '',
                'post_title' => "{$mediaObject->{$mediaTiaraIDName}}-$mediaObject->bestandsnaam",
                'post_excerpt' => strtoupper($mediaObject->{$databaseKeysMedia['media_Groep']}),
                'post_status' => 'inherit',
                'comment_status' => 'open',
                'ping_status' => 'closed',
                'post_name' => "{$mediaObject->{$mediaTiaraIDName}}-$mediaObject->bestandsnaam",
                'post_parent' => $postID,
                'guid' => $boolIsConnectedPartner ? $mediaObject->media_URL : "$guid_url/$media_url",
                'menu_order' => $mediaObject->{'media_volgorde'},
                'post_type' => 'attachment',
                'post_mime_type' => $post_mime_type,
            ];
            $post_meta = [
                '_wp_attached_file' => $boolIsConnectedPartner ? $mediaObject->media_URL : $media_url,
                'file_url' => $boolIsConnectedPartner ? $mediaObject->media_URL : $media_url,
                '_wp_attachment_metadata' => '',
                $databaseKey['objectCode'] => $OGobject->{$databaseKey['objectCode']},
                $databaseKeysMedia['media_Groep'] => strtoupper($mediaObject->{$databaseKeysMedia['media_Groep']}),
                $databaseKeysMedia['mediaName'] => $mediaObject->{$databaseKeysMedia['mediaName']},
                $databaseKeysMedia['datum_gewijzigd'] => $mediaObject->{$databaseKeysMedia['datum_gewijzigd']},
                $databaseKeysMedia['datum_toegevoegd'] => $mediaObject->{$databaseKeysMedia['datum_toegevoegd']},
                '_wp_attachment_image_alt' => '',
                $mediaTiaraIDName => $mediaObject->{$mediaTiaraIDName},
            ];
            // ======== Start of Function ========
            # Checking if the media exists
            if ($mediaExists) {
                // ==== Declaring Variables ====
                # Getting post meta
                $postLastUpdated = $mediaQuery->post->MediaUpdated;

                // ==== Start of Function ====
                if ($postLastUpdated != $objectLastUpdated) {
                    // Updating the media
                    $post_data['ID'] = $mediaQuery->post->ID;
                    wp_update_post($post_data);

                    // Updating the meta data
                    foreach ($post_meta as $key => $value) {
                        update_post_meta($mediaQuery->post->ID, $key, $value);
                        wp_set_object_terms($mediaQuery->post->ID, $value, $key);
                    }
                }
            }
            else {
                // Creating the media
                $mediaID = wp_insert_post($post_data);

                // Adding the meta data
                foreach ($post_meta as $key => $value) {
                    add_post_meta($mediaID, $key, $value);
                    wp_set_object_terms($mediaID, $value, $key);
                }
            }
        }
    }

	function createPost($postTypeName, $OGobject, $databaseKey, $parentPostID=''): WP_Error|int {
		// ============ Declaring Variables ===========
		# Variables
		$post_data = [
			'post_type' => $postTypeName,
			'post_parent' => $parentPostID,
			'post_title' => '',
			'post_name' => '',
			'post_content' => '',
			'post_status' => 'draft'
		];
		$post_data = $this->getNames($post_data, $OGobject, $databaseKey);

		// ============ Start of Function ============
		# Creating the post
		$postID = wp_insert_post($post_data);
		foreach ($OGobject as $key => $value) {
			add_post_meta($postID, $key, $value);
		}

		# Adding meta data for images
		$this->updateMedia($postID, $postTypeName, $OGobject, $databaseKey);

		# Publishing the post
		wp_publish_post($postID);

		# Returning the postID
		return $postID;
	}
	function updatePost($postTypeName, $postID, $OGobject, $databaseKey, $parentPostID=''): void {
		// ======== Declaring Variables ========
		# Classes

		# Vars
		$post_data = [
			'ID' => $postID,
			'post_title' => '',
			'post_parent' => $parentPostID,
			'post_content' => ''
		];
		$post_data = $this->getNames($post_data, $OGobject, $databaseKey);

		// ======== Start of Function ========
		# Overwriting the post
		wp_update_post($post_data);

		$this->updateMedia($postID, $postTypeName, $OGobject, $databaseKey);

		# Updating the post meta
		foreach ($OGobject as $key => $value) {
			update_post_meta($postID, $key, $value);
		}
	}
	function deleteUnneededPosts($postTypeName, $databaseKeysObject, $objectIDs, $type=''): void {
		if (empty($objectIDs)) {return;}
		// ======== Declaring Variables ========
		# Variables
		$posts = new WP_Query([
			'post_type' => $postTypeName,
			'posts_per_page' => -1,
			'post_status' => 'any',
			'meta_key' => 'type',
			'meta_value' => $type
		]);
		// ======== Start of Function ========
		# Getting all the post IDs from the meta data
		foreach ($posts->posts as $post) {
			// ==== Declaring Variables ====
			# Getting the post ID
			$postTiara = $post->{$databaseKeysObject['ID']};

			// ==== Rest of loop ====
			# Checking if the post is in the database
			if (!in_array($postTiara, $objectIDs)) {
				# Delete the post
				wp_delete_post($post->ID, true);

				# Deleting every post with this as parent post
				$childPosts = new WP_Query(([
					'post_type' => $postTypeName,
					'posts_per_page' => -1,
					'post_parent' => $post->ID,
					'post_status' => 'any',
				]));
				foreach ($childPosts->posts as $childPost) {
					wp_delete_post($childPost->ID, true);

					# Deleting every post with this as parent post
					$childchildPosts = new WP_Query(([
						'post_type' => $postTypeName,
						'posts_per_page' => -1,
						'post_parent' => $post->ID,
						'post_status' => 'any',
					]));
					foreach ($childchildPosts->posts as $childchildPost) {
						wp_delete_post($childchildPost->ID, true);
					}
				}
				echo('Deleted post: ' . $post->ID . '<br/>');
			}
		}
	}

	function checkMedia($mediaDatabaseKeys): void {
		// ============ Declaring Variables ============
		# Classes
		global $wpdb;

		# Variables
		$mediaObjects = $wpdb->get_results("SELECT * FROM {$mediaDatabaseKeys['tableName']}");

		// ============ Start of Function ============
		# Looping through the media objects
		foreach($mediaObjects as $mediaObject) {
			# Checking if the media exists
			$mediaQuery = new WP_Query([
				'post_type' => 'attachment',
				'posts_per_page' => -1,
				'post_status' => 'any',
				'meta_key' => $mediaDatabaseKeys['id'],
				'meta_value' => $mediaObject->id
			]);

		}

	}

	function checkBouwnummersPosts($postTypeName, $parentPostID, $OGBouwtype, $databaseKeys): array {
		// ======== Declaring Variables ========
		# Classes
		global $wpdb;
		$OGSyncMapping = new OGSyncMapping();

		# Variables
		$OGBouwtypeID = $OGBouwtype->id;
		$locationCodes = $this->getLocationCodes();
		$objectIDs = [];

		$OGBouwnummers = $wpdb->get_results("SELECT * FROM {$databaseKeys[2]['tableName']} WHERE {$databaseKeys[2]['id_bouwtypes']} = $OGBouwtypeID");

		// ======== Start of Function ========
		# Looping through the bouwnummers
		foreach ($OGBouwnummers as $OGBouwnummer) {
			# Checking if this OG bouwnummer is valid and if not just skip it.
			if (isset( $OGBouwnummer->{$databaseKeys[2]['ObjectStatus_database']} ) and $OGBouwnummer->{$databaseKeys[2]['ObjectStatus_database']} == '' ) {
				continue;
			}

			// ======== Declaring Variables ========
			# Variables
			$OGBouwnummer = $OGSyncMapping->mapMetaData($OGBouwnummer, ($databaseKeys[2]['mapping'] ?? []), $locationCodes, $databaseKeys);
			# Post - Bouwnummer
			$postData = new WP_Query([
				'post_type' => $postTypeName,
				'meta_key' => $databaseKeys[2]['ID'],
				'meta_value' => $OGBouwnummer->{$databaseKeys[2]['ID']},
				'post_parent' => $parentPostID,
				'posts_per_page' => -1,
				'post_status' => 'any',
			]);
			$bouwNummerExisted = $postData->have_posts();

			if ($bouwNummerExisted) {
				$postID = $postData->post->ID;
				$dateUpdatedPost = $postData->post->{$databaseKeys[2]['datum_gewijzigd']} ?? $postData->post->{$databaseKeys[2]['datum_toegevoegd']};
			}

			# Database - Bouwnummer
			$dateUpdatedDatabase = $OGBouwnummer->{$databaseKeys[2]['datum_gewijzigd']} ?? $OGBouwnummer->{$databaseKeys[2]['datum_toegevoegd']};

			// ======== Rest of loop ========
			# Checking if post exists
			if ($bouwNummerExisted) {
				// Checking if the bouwtype is updated
				if ($dateUpdatedPost != $dateUpdatedDatabase) {
					$this->updatePost($postTypeName, $postID, $OGBouwnummer, $databaseKeys[2], $parentPostID);
					echo("Updated Nieuwbouw bouwnummer: $postID<br/>");
				}
			}
			else {
				// Creating the post
				$postID = $this->createPost($postTypeName, $OGBouwnummer, $databaseKeys[2], $parentPostID);
				echo("Created Nieuwbouw bouwnummer: $postID<br/>");
			}

			# Adding the post ID to the array
			$objectIDs[] = $OGBouwnummer->{$databaseKeys[2]['ID']};
		}

		// Returning the objectIDs
		return $objectIDs;
	}
	function checkBouwtypesPosts($postTypeName, $parentPostID, $OGProject, $databaseKeys): array {
		// ======== Declaring Variables ========
		# Classes
		global $wpdb;
		$OGSyncMapping = new OGSyncMapping();

		# Variables
		$OGProjectID = $OGProject->id;
		$locationCodes = $this->getLocationCodes();
		$objectIDs = [];
		$bouwnummerIds = [];

		$OGBouwtypes = $wpdb->get_results("SELECT * FROM {$databaseKeys[1]['tableName']} WHERE {$databaseKeys[1]['id_projecten']} = $OGProjectID");

		// ======== Start of Function ========
		# Looping through the bouwtypes
		foreach ($OGBouwtypes as $OGBouwtype) {
			# Checking if this OG bouwtype is valid and if not just skip it.
			if ( isset( $OGBouwtype->{$databaseKeys[1]['ObjectStatus_database']} ) and $OGBouwtype->{$databaseKeys[1]['ObjectStatus_database']} == '' ) {
				continue;
			}

			// ======== Declaring Variables ========
			$OGBouwtype = $OGSyncMapping->mapMetaData($OGBouwtype, ($databaseKeys[1]['mapping'] ?? []), $locationCodes, $databaseKeys);
			# Post - Bouwtype
			$postData = new WP_Query([
				'post_type' => $postTypeName,
				'meta_key' => $databaseKeys[1]['ID'],
				'meta_value' => $OGBouwtype->{$databaseKeys[1]['ID']},
				'post_parent' => $parentPostID,
				'posts_per_page' => -1,
				'post_status' => 'any'
			]);
			$bouwTypeExisted = $postData->have_posts();

			if ($bouwTypeExisted) {
				$postID = $postData->post->ID;
				$dateUpdatedPost = $postData->post->{$databaseKeys[1]['datum_gewijzigd']} ?? $postData->post->{$databaseKeys[1]['datum_toegevoegd']};
			}

			# Database - Bouwtype
			$dateUpdatedObject = $OGBouwtype->{$databaseKeys[1]['datum_gewijzigd']} ?? $OGBouwtype->{$databaseKeys[1]['datum_toegevoegd']};
			// ======== Rest of loop ========
			# Checking if the post exists
			if ($bouwTypeExisted) {
				// Checking if the post is updated
				if ($dateUpdatedPost != $dateUpdatedObject) {
					// Updating/overwriting the post
					$this->updatePost($postTypeName, $postID, $OGBouwtype, $databaseKeys[1], $parentPostID);
					echo("Updated Nieuwbouw bouwtype: {$postID}<br/>");
				}
			}
			else {
				// Creating the post
				$postID = $this->createPost($postTypeName, $OGBouwtype, $databaseKeys[1], $parentPostID);
				echo("Created Nieuwbouw bouwtype: {$postID}<br/>");
			}

			# Adding the postID to the array
			$objectIDs = array_merge($objectIDs, [$OGBouwtype->{$databaseKeys[1]['ID']}]);
			# Checking the children (bouwnummers)
			$bouwnummerIds = array_merge($bouwnummerIds, $this->checkBouwnummersPosts($postTypeName, $postID, $OGBouwtype, $databaseKeys));
		}

		# Returning the objectIDs
		return [$objectIDs, $bouwnummerIds];
	}
	function checkNieuwbouwPosts($postTypeName, $databaseKeys): void {
		# ============ Declaring Variables ============
		# Classes
		global $wpdb;
		$OGSyncMapping = new OGSyncMapping();
		# Variables
		$projectIds = [];
		$locationCodes = $this->getLocationCodes();
		$OGProjects = $wpdb->get_results("SELECT * FROM {$databaseKeys[0]['tableName']}");
		# Removing every null out of the objects so Wordpress won't get crazy.
		foreach ($OGProjects as $key => $object) {
			foreach ($object as $key2 => $value) {
				if ($value == 'null' or $value == 'NULL' or $value == null) {
					$OGProjects[$key]->{$key2} = '';
				}
			}
		}

		# ============ Start of Function ============
		# ==== Looping through the objects ====
		foreach ($OGProjects as $OGProject) {
			# Checking if this OG project is valid and if not just skip it.
			if (isset($OGProject->{$databaseKeys[0]['ObjectStatus_database']}) AND $OGProject->{$databaseKeys[0]['ObjectStatus_database']} == '') {
				continue;
			}

			// ======== Declaring Variables ========
			# Remapping the object
			$OGProject = $OGSyncMapping->mapMetaData($OGProject, ($databaseKeys[0]['mapping'] ?? []), $locationCodes, $databaseKeys);

			# Post - Project
			$postData = new WP_Query([
				'post_type' => $postTypeName,
				'meta_key' => $databaseKeys[0]['ID'],
				'meta_value' => $OGProject->{$databaseKeys[0]['ID']},
				'posts_per_page' => -1,
				'post_status' => 'any',
			]);
			$projectExisted = $postData->have_posts();

			if ($projectExisted) {
				$postID = $postData->post->ID;
				$dateUpdatedPost = $postData->post->{$databaseKeys[0]['datum_gewijzigd']} ?? $postData->post->{$databaseKeys[0]['datum_toegevoegd']};
			}
			# Database - Project
			$dateUpdatedObject = $OGProject->{$databaseKeys[0]['datum_gewijzigd']} ?? $OGProject->{$databaseKeys[0]['datum_toegevoegd']};

			// ======== Start of Function ========
            			# Checking if the project exists
			if ($projectExisted) {
				// Checking if the post is updated
				if ($dateUpdatedPost != $dateUpdatedObject) {
					// Updating/overwriting the post
					$this->updatePost($postTypeName, $postID, $OGProject, $databaseKeys[0]);
					echo("Updated Nieuwbouw project: {$postID}<br/>");
				}
			}
			else {
				// Creating the post
				$postID = $this->createPost($postTypeName, $OGProject, $databaseKeys[0]);
				echo("Created Nieuwbouw project: {$postID}<br/>");
			}

			# Adding the postID to the array
			$projectIds[] = $OGProject->{$databaseKeys[0]['ID']};
			# Checking the child-posts
			$arrayIds = $this->checkBouwtypesPosts($postTypeName, $postID, $OGProject, $databaseKeys);
		}

		# ==== Deleting the unneeded posts ====
		# Projects
//		$this->deleteUnneededPosts($postTypeName, $databaseKeys[0], $projectIds, $databaseKeys[0]['type']);

		# Bouwtypes
//		$this->deleteUnneededPosts($postTypeName, $databaseKeys[1], $arrayIds[0] ?? [], $databaseKeys[1]['type']);

		# Bouwnummers
//		$this->deleteUnneededPosts($postTypeName, $databaseKeys[2], $arrayIds[1] ?? [], $databaseKeys[2]['type']);
		echo('Nieuwbouw Projecten klaar!<br/>');
	}

	function checkNormalPosts($postTypeName, $OGobjects, $databaseKey): void {
		// ============ Declaring Variables ============
		# Classes
		$OGSyncMapping = new OGSyncMapping();
		# Variables
		$locationCodes = $this->getLocationCodes();
		$objectIDs = [];

		// ============ Start of Function ============
		# Creating/Updating the posts
		foreach ($OGobjects as $OGobject) {
			// ======== Declaring Variables ========
			# ==== Variables ====
			# Remapping the object
			$OGobject = $OGSyncMapping->mapMetaData($OGobject, ($databaseKey['mapping'] ?? []), $locationCodes);

			$postData = new WP_Query([
				'post_type' => $postTypeName,
				'meta_key' => $databaseKey['ID'],
				'meta_value' => $OGobject->{$databaseKey['ID']},
				'posts_per_page' => -1,
				'post_status' => 'any',
			]);
			$postExists = $postData->have_posts();

			if ($postExists) {
				$dateUpdatedPost = $postData->post->{$databaseKey['datum_gewijzigd']};
			}
			# Database dateUpdated
			$dateUpdatedObject = $OGobject->{$databaseKey['datum_gewijzigd']} ?? $OGobject->{$databaseKey['datum_toegevoegd']};
			// ======== Start of Function ========
			if ($postExists) {
				// Checking if the post is updated
				if ($dateUpdatedPost != $dateUpdatedObject) {
					// Echo the fact that this is happening
					echo("Updating {$postTypeName} object: {$postData->post->ID}<br/>");
					// Updating/overwriting the post
					$this->updatePost($postTypeName, $postData->post->ID, $OGobject, $databaseKey);
				}
			}
			else {
				// Creating the post
				$postID = $this->createPost($postTypeName, $OGobject, $databaseKey);
				echo("Created {$postTypeName} object: {$postID}<br/>");
			}

			# Adding the object ID to the array
			$objectIDs[] = $OGobject->{$databaseKey['ID']};
		}

		# Deleting the posts that are not in the array
//		$this->deleteUnneededPosts($postTypeName, $databaseKey, $objectIDs);
	}

	function examinePosts(): void {
		// ============ Declaring Variables ============
		# Classes
		global $wpdb;

		# Variables
		date_default_timezone_set('Europe/Amsterdam');
		$beginTime = time();
		$postTypeData = OGSyncPostTypeData::customPostTypes();
		// ============ Start of Function ============
		# ==== Checking all the post types ====
		foreach ($postTypeData as $postTypeName => $postTypeArray) {
//			if ($postTypeName == 'wonen' or $postTypeName == 'bedrijven') {continue;}

			// ======== Declaring Variables ========
			$boolIsNieuwbouw = !isset($postTypeArray['database_tables']['object']);

			if ($boolIsNieuwbouw) {
				# OG objects
				$databaseKeys[0] = $postTypeArray['database_tables']['projecten'];
				$databaseKeys[1] = $postTypeArray['database_tables']['bouwTypes'];
				$databaseKeys[2] = $postTypeArray['database_tables']['bouwNummers'];
			}
			else {
				# OG objects
				$databaseKeys[0] = $postTypeArray['database_tables']['object'];
			}

			// ======== Start of Loop ========
			echo("<h1>".$postTypeName."</h1>");
			if ($boolIsNieuwbouw) {
				$this->checkNieuwbouwPosts($postTypeName, $databaseKeys);
			}
			else {
				foreach ($databaseKeys as $databaseKey) {
					$OGobjects = $wpdb->get_results("SELECT * FROM {$databaseKey['tableName']}");

					# Removing every null out of the objects so Wordpress won't get crazy.
					foreach ($OGobjects as $key => $object) {
						foreach ($object as $key2 => $value) {
							if ($value == 'null' or $value == 'NULL' or $value == null) {
								$OGobjects[$key]->{$key2} = '';
							}
						}
					}

					if (!empty($OGobjects)) {
						$this->checkNormalPosts($postTypeName, $OGobjects, $databaseKey);
					}
				}
			}
		}

		// Putting in the database how much memory it ended up gusing maximum from bytes to megabytes
		$maxMemoryUsage = (memory_get_peak_usage(true) / 1024 / 1024);
		$memoryUsage = (memory_get_usage(true) / 1024 / 1024);
		$wpdb->insert('cronjobs', [
			'name' => 'OGSyncOffers',
			# convert to megabytes
			'memoryUsageMax' => $maxMemoryUsage,
			'memoryUsage' => $memoryUsage,
			'datetime' => date('Y-m-d H:i:s', $beginTime),
			'duration' => round((time() - $beginTime) / 60, 2)
		]);
	}
}