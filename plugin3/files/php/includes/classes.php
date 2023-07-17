<?php
// ========== Imports =========
include_once 'functions.php';

// ==== Activation and Deactivation (Uninstallation is in the functions.php because it needs to be a static function) ====
class OGActivationAndDeactivation {
    // ======== Activation ========
    function activate() {
        $this->registerSettings();
        $this->createCacheFiles();
    }

    // ======== Deactivation ========
    function deactivate()
    {

    }

    // ============ Functions ============
    // A function for registering base settings of the unactivated plugin as activation hook.
    function registerSettings() {
        // ==== Declaring Variables ====
        $settingData = new OGSettingsData();

        // ==== Start of Function ====
        // Registering settings
        foreach ($settingData->settings as $settingName => $settingValue) {
            add_option($settingData->settingPrefix.$settingName, $settingValue);
        }
    }

    function createCacheFiles() {
        // ==== Declaring Variables ====
        # Classes
        $settingsData = new OGSettingsData();

        # Variables
        $cacheFolder = plugin_dir_path(dirname(__DIR__, 1)).$settingsData->cacheFolder;

        // ==== Start of Function ====
        // Creating the cache files
        foreach ($settingsData->cacheFiles as $cacheFile) {
            // Creating the cache folder if it doesn't exist
            if (!file_exists($cacheFolder)) {
                mkdir($cacheFolder, 0777, true);
            }

            // Creating the cache file if it doesn't exist
            if (!file_exists($cacheFolder.$cacheFile)) {
                $file = fopen($cacheFolder.$cacheFile, 'w');
                fwrite($file, '');
                fclose($file);
            }
        }
    }
}

// ==== Data Classes ====
class OGPostTypeData {
    // ============ Begin of Class ============
    function customPostTypes() {
        // ===== Declaring Variables =====
        # Classes
        $license = new OGLicense();

        # Variables
        $objectAccess = $license->checkPostTypeAccess();
        $customPostTypes = array(
            // Post Type 1
	        // Post Type 1
	        /* post_type */'wonen' => array(
		        'post_type_args' => array(
			        'labels' => array(
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
				        'tableName' => 'tbl_OG_wonen',
				        # Normal fields
                        'ID' => 'object_ObjectTiaraID',                              // Mapped value
				        'post_title' => 'objectDetails_Adres_NL_Straatnaam;objectDetails_Adres_NL_Huisnummer;objectDetails_Adres_NL_HuisnummerToevoeging;objectDetails_Adres_NL_Woonplaats', // Mapped value
				        'post_name' => 'objectDetails_Adres_NL_Straatnaam-objectDetails_Adres_NL_Huisnummer-objectDetails_Adres_NL_HuisnummerToevoeging-objectDetails_Adres_NL_Woonplaats',  // Mapped value
				        'post_content' => 'objectDetails_Aanbiedingstekst',       // Mapped value
				        'datum_gewijzigd' => 'datum_gewijzigd',             // Mapped value
				        'datum_toegevoegd' => 'datum_toegevoegd',           // Mapped value
				        'objectCode' => 'object_ObjectCode',                // Mapped value

				        # Post fields
				        'media' => array(
					        # TableName
					        'tableName' => 'tbl_OG_media',
					        # Normal fields
					        'folderRedirect' => '',                     // Mapped value CAN BE EMPTY
					        'search_id' => 'id_OG_wonen',               // NON Mapped value
					        'mediaID' => 'media_Id',                    // NON Mapped value
					        'datum_gewijzigd' => 'datum_gewijzigd',     // Mapped value
					        'datum_toegevoegd' => 'datum_toegevoegd',   // Mapped value
					        'mediaName' => 'MediaName',                 // Mapped value
					        'media_Groep' => 'media_Groep',             // Mapped value

					        # Post fields
					        'object_keys' => array(
						        'objectTiara' => 'object_ObjectTiaraID',
						        'objectVestiging' => 'object_NVMVestigingNR',
					        ),

					        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
					        'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
				        ),
				        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array( /* TableName */ 'tableName' => 'og_mappingwonen')
			        ),
		        )
	        ),
	        // Post Type 2
	        /* post_type */'bog' => array(
		        'post_type_args' => array(
			        'labels' => array(
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
				        'tableName' => 'tbl_OG_bog',
				        # Normal fields
				        'ID' => '_id',
				        'post_title' => 'objectDetails_Adres_Straatnaam;objectDetails_Adres_Huisnummer;objectDetails_Adres_HuisnummerToevoeging;objectDetails_Adres_Woonplaats', // Mapped value
				        'post_name' => 'objectDetails_Adres_Straatnaam-objectDetails_Adres_Huisnummer-objectDetails_Adres_HuisnummerToevoeging-objectDetails_Adres_Woonplaats',  // Mapped value
				        'post_content' => 'objectDetails_Aanbiedingstekst',       // Mapped value
				        'datum_gewijzigd' => 'datum_gewijzigd',             // Mapped value
				        'datum_toegevoegd' => 'datum_toegevoegd',           // Mapped value
				        'objectCode' => 'object_ObjectCode',                // Mapped value

				        # Post fields
				        'media' => array(
					        # TableName
					        'tableName' => 'tbl_OG_media',
					        # Normal fields
					        'folderRedirect' => '',                     // Mapped value CAN BE EMPTY
					        'search_id' => 'id_OG_bog',                 // NON Mapped value
					        'mediaID' => 'media_Id',                    // NON Mapped value
					        'datum_toegevoegd' => 'datum_toegevoegd',   // Mapped value
					        'datum_gewijzigd' => 'datum_gewijzigd',        // Mapped value
					        'mediaName' => 'MediaName',                 // Mapped value
					        'media_Groep' => 'media_Groep',               // Mapped value

					        # Post fields
					        'object_keys' => array(
						        'objectTiara' => 'object_ObjectTiaraID',
						        'objectVestiging' => 'object_NVMVestigingNR',
					        ),

					        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
					        'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
				        ),
				        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array(/* TableName */ 'tableName' => 'og_mappingbedrijven')
			        ),
		        )
	        ),
	        // Post Type 3
	        /* post_type */'nieuwbouw' => array(
		        'post_type_args' => array(
			        'labels' => array(
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
				        'tableName' => 'tbl_OG_nieuwbouw_projecten',
				        # Normal fields
				        'ID' => 'project_ObjectTiaraID',                                            // Mapped value
				        'post_title' => 'project_ProjectDetails_Projectnaam',                       // Mapped value if needed
				        'post_name' => 'project_ProjectDetails_Projectnaam',                        // Mapped value
				        'post_content' => 'project_ProjectDetails_Presentatie_Aanbiedingstekst',    // Mapped value
				        'ObjectStatus_database' => 'project_ProjectDetails_Status_ObjectStatus',    // Mapped value
				        'datum_gewijzigd' => 'datum_gewijzigd',                                     // Mapped value
				        'datum_toegevoegd' => 'datum_toegevoegd',                                   // Mapped value
				        'objectCode' => 'project_ObjectCode',                                       // Mapped value
				        'type' => 'project',                                                        // Standard value don't change

				        # Post fields
				        'media' => array(
					        # TableName
					        'tableName' => 'tbl_OG_media',
					        # Normal fields
					        'folderRedirect' => '',                     // Mapped value CAN BE EMPTY
					        'search_id' => 'id_OG_nieuwbouw_projecten',
					        'mediaID' => 'media_Id',                // Mapped value
					        'datum_gewijzigd' => 'datum_gewijzigd',     // Mapped value
					        'datum_toegevoegd' => 'datum_toegevoegd',   // Mapped value
					        'mediaName' => 'MediaName',
					        'media_Groep' => 'media_Groep',             // Mapped value

					        # Post fields
					        'object_keys' => array(
						        'objectTiara' => 'project_ObjectTiaraID',
						        'objectVestiging' => 'project_NVMVestigingNR',
					        ),

					        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
					        'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
				        ),
				        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array(/* TableName */ 'tableName' => 'og_mappingnieuwbouwprojecten')
			        ),
			        'bouwTypes' => array(
				        # TableName
				        'tableName' => 'tbl_OG_nieuwbouw_bouwTypes',
				        # Normal fields
				        'ID' => '_id',                                                              // Mapped value
				        'id_projecten' => 'id_OG_nieuwbouw_projecten',                              // Mapped value
				        'post_title' => 'bouwType_BouwTypeDetails_Naam|bouwType_ObjectCode',        // Mapped value if needed | is for seperating values (OR statement)
				        'post_name' => 'bouwType_BouwTypeDetails_Naam|bouwType_ObjectCode',         // Mapped value
				        'post_content' => 'bouwType_BouwTypeDetails_Aanbiedingstekst',              // Mapped value
				        'ObjectStatus_database' => 'bouwType_BouwTypeDetails_Status_ObjectStatus',  // Mapped value
				        'datum_gewijzigd' => 'datum_gewijzigd',                                     // Mapped value
				        'datum_toegevoegd' => 'datum_toegevoegd',                                   // Mapped value
				        'objectCode' => 'bouwType_ObjectCode',                                      // Mapped value
				        'type' => 'bouwtype',                                                       // Standard value don't change

				        # Post fields
				        'media' => array(
					        # TableName
					        'tableName' => 'tbl_OG_media',
					        # Normal fields
					        'folderRedirect' => '',                         // Mapped value CAN BE EMPTY
					        'search_id' => 'id_OG_nieuwbouw_bouwtypes',     // NON Mapped value
					        'mediaID' => 'media_Id',                        // NON Mapped value
					        'datum_gewijzigd' => 'datum_gewijzigd',         // Mapped value
					        'datum_toegevoegd' => 'datum_toegevoegd',       // Mapped value
					        'mediaName' => 'MediaName',                     // Mapped value
					        'media_Groep' => 'media_Groep',                 // Mapped value

					        # Post fields
					        'object_keys' => array(
						        'objectTiara' => 'bouwType_ObjectTiaraID',
						        'objectVestiging' => 'bouwType_NVMVestigingNR',
					        ),

					        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
					        'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
				        ),
				        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array(/* TableName */ 'tableName' => 'og_mappingnieuwbouwbouwtypes')
			        ),
			        'bouwNummers' => array(
				        # TableName
				        'tableName' => 'tbl_OG_nieuwbouw_bouwNummers',
				        # Normal fields
				        'ID' => 'bouwNummer_ObjectTiaraID',                                                                          // Mapped value
				        'id_bouwtypes' => 'id_OG_nieuwbouw_bouwTypes',                                          // Mapped value
				        'post_title' => 'Adres_Straatnaam;Adres_Huisnummer;Adres_Postcode;Adres_Woonplaats;Adres_HuisnummerToevoeging;bouwNummer_ObjectCode',    // Mapped value if needed | is for seperating values (OR statement)
				        'post_name' => 'Adres_Straatnaam-Adres_Huisnummer-Adres_Postcode-Adres_Woonplaats-Adres_HuisnummerToevoeging-bouwNummer_ObjectCode',  // Mapped value
				        'post_content' => 'Aanbiedingstekst',                                                   // Mapped value
				        'ObjectStatus_database' => 'bouwNummer_ObjectCode',                                     // NON Mapped value
				        'datum_gewijzigd' => 'datum_gewijzigd',                                                 // Mapped value
				        'datum_toegevoegd' => 'datum_toegevoegd',                                               // Mapped value
				        'objectCode' => 'bouwNummer_ObjectCode',                                                // Mapped value
				        'type' => 'bouwnummer',                                                                 // Standard value don't change

				        # Post fields
				        'media' => array(
					        # TableName
					        'tableName' => 'tbl_OG_media',
					        # Normal fields
					        'folderRedirect' => '',                         // Mapped value CAN BE EMPTY
					        'search_id' => 'id_OG_nieuwbouw_bouwnummers',   // NON Mapped value
					        'mediaID' => 'media_Id',                        // NON Mapped value
					        'datum_gewijzigd' => 'datum_gewijzigd',         // Mapped value
					        'datum_toegevoegd' => 'datum_toegevoegd',       // Mapped value
					        'mediaName' => 'MediaName',                     // Mapped value
					        'media_Groep' => 'media_Groep',                 // Mapped value

					        # Post fields
					        'object_keys' => array(
						        'objectTiara' => 'bouwNummer_ObjectTiaraID',
						        'objectVestiging' => 'bouwNummer_NVMVestigingNR',
					        ),

					        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
					        'mapping' => array(/* TableName */ 'tableName' => 'og_mappingmedia')
				        ),
				        # Only if mapping is neccesary uncomment the following lines and fill in the correct table name
                        // 'mapping' => array(/* TableName */ 'tableName' => 'og_mappingnieuwbouwbouwnummers')
			        ),
		        )
	        ),
            // Post Type 4
            /* post_type */'alv' => array(
                'post_type_args' => array(
                    'labels' => array(
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
		                'tableName' => 'tbl_OG_alv',
		                # Normal fields
		                'ID' => '_id',
		                'post_title' => 'straat;huisnummer;huisnummertoevoeging;plaats', // Mapped value
		                'post_name' => 'straat-huisnummer-huisnummertoevoeging-plaats',  // Mapped value
		                'post_content' => 'aanbiedingstekst',       // Mapped value
		                'datum_gewijzigd' => 'ObjectUpdated',       // Mapped value
		                'datum_toegevoegd' => 'ObjectDate',         // Mapped value
		                'objectCode' => 'ObjectCode',               // Mapped value

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
class WPColorScheme {
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
        $WPColorScheme = get_user_option('admin_color');
        $boolResult = false;

        // ======== Start of Function ========
        foreach ($this->mainColors as $key => $value) {
            if ($key == $WPColorScheme) {
                return $_wp_admin_css_colors[$WPColorScheme]->colors[$this->mainColors[$key]];
            }
        }
        return $_wp_admin_css_colors['fresh']->colors[2];
    }
}
class OGSettingsData {
    // ============ Declare Variables ============
    // Strings
    public $settingPrefix = 'ppOG_'; // This is the prefix for all the settings used within the OG Plugin
    public $cacheFolder = 'caches/'; // This is the folder where all the cache files are stored within the server/ftp
    // Arrays
    public array $apiURLs = [
        'license' => 'https://og-feeds2.pixelplus.nl/api/validate.php',
        'syncTimes' => 'https://og-feeds2.pixelplus.nl/api/latest.php'
    ];

    public array $cacheFiles = [
        'licenseCache' => 'licenseCache.json', // This is the cache file for the checking the Licence key
    ];

    public array $settings = [
        /* Setting Name */'licenseKey' => /* Default Value */       '',     // License Key
    ];
    public array $adminSettings = [
        // Settings 1
        /* Option Group= */ 'ppOG_AdminOptions' => [
            // General information
            'settingPageSlug' => 'pixelplus-og-plugin-settings',
            // Sections
            'sections' => [
                // Section 1 - Licentie section
                /* Section Title= */'Licentie' => [
                    'sectionID' => 'ppOG_SectionLicence',
                    'sectionCallback' => 'htmlLicenceSection',
                    // Fields
                    'fields' => [
                        // Field 1 - Licentie sleutel
                        /* Setting Field Title= */'Licentie Sleutel' => [
                            'fieldID' => 'ppOG_licenseKey',
                            'fieldCallback' => 'htmlLicenceKeyField',
                        ]
                    ]
                ]
            ]
        ]
    ];

    // ============ HTML Functions ============
    // Sections
    function htmlLicenceSection(): void { ?>
        <p>De licentiesleutel die de plugin activeert</p>
    <?php }
    // Fields
    function htmlLicenceKeyField(): void {
        // ===== Declaring Variables =====
        // Vars
        $licenseKey = get_option($this->settingPrefix.'licenseKey');

        // ===== Start of Function =====
        // Check if licenseKey is empty
        if ($licenseKey == '') {
            // Display a message
            echo('De licentiesleutel is nog niet ingevuld.');
        }
        echo(" <input type='text' name='".$this->settingPrefix."licenseKey' value='".esc_attr($licenseKey)."' ");
    }
}
class OGMapping {
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

					// ==== Start of Function ====
					# Step 1: Looping through all the keys
					foreach($arrExplodedKey as $arrExplodedKeyValue) {
						# Step 2: Check if the key even isset or empty in OG Record
						if (isset($OGTableRecord->{$arrExplodedKeyValue}) and !empty($OGTableRecord->{$arrExplodedKeyValue})) {
							# Step 3: Add the value to the result string
							$strResult .= $OGTableRecord->{$arrExplodedKeyValue}.' ';
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
									if (strtolower($OGTableRecord->{$arrExplodedKey[0]}) == 'verkocht') {
										$mappingTable[$mappingKey]['pixelplus'] = '1';
									}
									else {
										# Ignore the value
										unset($mappingTable[$mappingKey]);
									}
								}
								case 'ObjectKoop': {
									if (strtolower($OGTableRecord->{$arrExplodedKey[0]}) == 'vrij op naam') {
										$mappingTable[$mappingKey]['pixelplus'] = '1';
									}
									else {
										# Put the value back in
										$mappingTable[$mappingKey]['pixelplus'] = $OGTableRecord->{$arrExplodedKey[0]};
									}
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
							$count = $wpdb->get_var("SELECT COUNT(*) FROM {$databaseKeys[1]['tableName']} WHERE {$databaseKeys[0]['media']['search_id']} = {$projectID}");

							# Step 2: Adding the count to the OG Record
							$OGTableRecord->{$mappingTable[$mappingKey]['vanherk']} = $count;
						}
						if ($strTrimmedKey == 'bouwnummers') {
							# Step 1: Getting the count of bouwnummers in the database
							$count = $wpdb->get_var("SELECT COUNT(*) FROM {$databaseKeys[2]['tableName']} WHERE {$databaseKeys[0]['media']['search_id']} = {$projectID}");

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

// ========== Inactivated state of Plugin ==========
class OGLicense {
    // ============ Functions ============
    function checkLicense(): mixed {
        // ============= Declaring Variables =============
        # Classes
        $settingData = new OGSettingsData();

        # Cache
        $cacheFile = plugin_dir_path(dirname(__DIR__, 1)) . $settingData->cacheFolder . $settingData->cacheFiles['licenseCache'];
        $cacheData = null;

        # API
        $url = $settingData->apiURLs['license'];
        $qArgs = "?token=".get_option($settingData->settingPrefix.'licenseKey');

        // ================ Start of Function =============
        // Checking if our cache file exists AND if the modification time is less than 1 hour
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 3600) {
            // Getting the data from the cache file
            $cacheData = json_decode(file_get_contents($cacheFile), true);

            // Checking if the data['success'] == True. If so then return otherwise check the API if anything changed by any chance
            if (isset($cacheData['success']) && ($cacheData['success'] == true)) {
                return $cacheData;
            }
            else {
                // Getting the data from API
                $cacheData = getJSONFromAPI($url.$qArgs);
                // Saving the data to the cache file
                file_put_contents($cacheFile, json_encode($cacheData));

                // Checking if the data['success'] == True. If so then return otherwise return the data
                if (isset($cacheData['success']) && ($cacheData['success'] == true)) {
                    $string = "";
                    foreach ($cacheData['data']['types'] as $value) {
                        $string .= $value.';';
                    }
                }
                return $cacheData;
            }
        }
        else {
            // Getting the data from API
            $cacheData = getJSONFromAPI($url.$qArgs);

            // Checking and updating the og types
            if (isset($cacheData['success']) && ($cacheData['success'] == true)) {
                $string = "";
                foreach ($cacheData['data']['types'] as $value) {
                    $string .= $value.';';
                }
            }
            // Saving the data to the cache file
            file_put_contents($cacheFile, json_encode($cacheData));
            return $cacheData;
        }

    }

    // A function for registering base settings of the unactivated plugin as activation hook.
    function checkActivation() {
        // ======== Declaring Variables ========
        $jsonData = $this->checkLicense();

        // ======== Start of Function ========
        // Checking if the license is valid
        if (isset($jsonData['success']) && $jsonData['success'] == true) {
            return True;
        }
        else {
            adminNotice('error', "De licentie is niet actief!");
            return False;
        }
    }

    // A function to see, which OG Post types the user has access to
    function checkPostTypeAccess(): array {
        // ==== Declaring Variables ====
        # Classes
        $settingData = new OGSettingsData();

        // ==== Start of Function ====
        $objectAccess = $this->checkLicense();

        // Check if data exists
        if (isset($objectAccess['data']['types'])) {
            $objectAccess = $objectAccess['data']['types'];
        }
        else {
            $objectAccess = [];
        }
        // Return the array
        return $objectAccess;
    }
}
class OGPages
{
    function __construct()
    {
        // Creating the Pages / Custom Post Types
        add_action('admin_menu', array($this, 'createPages'));
        // Registering all the needed settings for the plugin
        add_action('admin_init', array($this, 'registerSettings'));
        // Updating the permalinks
        add_action('init', function() {
            flush_rewrite_rules();
        });
    }

    // ======== Create Settings Page ========
    function createPages(): void {
        // ======= Declaring Variables =======
        // Classes
        $license = new OGLicense();
        $postTypeData = new OGPostTypeData();
        $postTypeData = $postTypeData->customPostTypes();
        // Vars
        $boolPluginActivated = $license->checkActivation();
        $objectAccess = $license->checkPostTypeAccess();

        // Making the Global Settings Page
        add_menu_page(
            'Admin Settings',
            'OG Settings',
            'manage_options',
            'pixelplus-og-plugin-settings',
            array($this, 'HTMLOGAdminSettings'),
            'dashicons-admin-generic',
            101
        );
        add_submenu_page(
            'pixelplus-og-plugin-settings',
            'Algemeen',
            'Algemeen',
            'manage_options',
            'pixelplus-og-plugin-settings',
            array($this, 'HTMLOGAdminSettings')
        );

        // ======= When Plugin is activated =======
        if ($boolPluginActivated) {
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
                        array($this, 'HTMLOGAdminSettings'.$name)
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
                array($this, 'HTMLOGAdminDashboard'),
                'dashicons-plus-alt',
                100);
            // First sub-menu item name change
            add_submenu_page(
                'pixelplus-og-plugin',
                'Admin Dashboard',
                'Dashboard',
                'manage_options',
                'pixelplus-og-plugin',
                array($this, 'HTMLOGAdminDashboard'));

            // ==== Items OG Aanbod ====
            // Menu Item: OG Aanbod Dashboard
            add_menu_page(
                'OG Aanbod',
                'OG Aanbod',
                'manage_options',
                'pixelplus-og-plugin-aanbod',
                array($this, 'HTMLOGAanbodDashboard'),
                'dashicons-admin-multisite',
                40);
            // First sub-menu item name change
            add_submenu_page(
                'pixelplus-og-plugin-aanbod',
                'Aanbod Dashboard',
                'Dashboard',
                'manage_options',
                'pixelplus-og-plugin-aanbod',
                array($this, 'HTMLOGAanbodDashboard'),
                0
            );
        }
    }
    // ==== Register Settings ====
    function registerSettings(): void {
        // ==== Vars ====
        $settings = new OGSettingsData();

        // ==== Start of Function ====
        // Setting sections and use the OGSettingsData adminSettings data
        foreach($settings->adminSettings as $optionGroup => $optionArray) {
            // Settings for on settings page
            foreach ($optionArray['sections'] as $sectionTitle => $sectionArray) {
                // Creating the Section
                add_settings_section(
                    $sectionArray['sectionID'],
                    $sectionTitle,
                    array($settings, $sectionArray['sectionCallback']),
                    $optionArray['settingPageSlug'],
                );
                foreach ($sectionArray['fields'] as $fieldTitle => $fieldArray) {
                    // Creating the Field
                    add_settings_field(
                        $fieldArray['fieldID'],
                        $fieldTitle,
                        array($settings, $fieldArray['fieldCallback']),
                        $optionArray['settingPageSlug'],
                        $sectionArray['sectionID'],
                    );
                    // Registering the Field
                    register_setting($optionGroup, $fieldArray['fieldID']);
                }
            }
        }
    }

    // ============ HTML ============
    // OG Admin
    function HTMLOGAdminDashboard(): void {
        // ======== Declaring Variables ========
        # Classes
        $settingData = new OGSettingsData();
        $postTypeData = new OGPostTypeData();
        $wpColorScheme = new WPColorScheme();

        # Variables
        $postTypeData = $postTypeData->customPostTypes();

        $url = $settingData->apiURLs['syncTimes'];
        $qArgs = "?token=".get_option($settingData->settingPrefix.'licenseKey');
        $lastSyncTimes = json_decode(wp_remote_get($url.$qArgs)['body'], true);

        $buttonColor = $wpColorScheme->returnColor();

        // ======== Start of Function ========
        # Checking if the API request is successful
        if (isset($lastSyncTimes['success']) && $lastSyncTimes['success'] == true) {
            adminNotice('success', 'De laatste syncs zijn succesvol opgehaald.');
            $lastSyncTimes = $lastSyncTimes['data'];
        }
        else {
            $lastSyncTimes = false;
        }

        # HTML
        htmlHeader('OG Admin Dashboard');
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
        htmlFooter('OG Admin Dashboard');}
    // OG Admin Settings
    function HTMLOGAdminSettings(): void { htmlHeader('OG Admin Settings - Algemeen');
        $settingsData = new OGSettingsData();
        ?>
        <form method="post" action="options.php">
            <?php settings_fields($settingsData->settingPrefix.'AdminOptions');
            do_settings_sections('pixelplus-og-plugin-settings');
            hidePasswordByName($settingsData->settingPrefix.'licenseKey');
            submit_button('Opslaan', 'primary', 'submit_license');
            ?>
        </form>
        <?php htmlFooter('OG Admin Settings - Licentie');}
    function HTMLOGAdminSettingsWonen() { htmlHeader('OG Admin Settings - Wonen'); ?>

        <?php htmlFooter('OG Admin Settings - Wonen');}
    function HTMLOGAdminSettingsBOG() { htmlHeader('OG Admin Settings - BOG'); ?>

        <?php htmlFooter('OG Admin Settings - BOG');}
    function HTMLOGAdminSettingsNieuwbouw() { htmlHeader('OG Admin Settings - Nieuwbouw'); ?>

        <?php htmlFooter('OG Admin Settings - Nieuwbouw');}
    function HTMLOGAdminSettingsALV() { htmlHeader('OG Admin Settings - A&LV'); ?>

        <?php htmlFooter('OG Admin Settings - A&LV');}
    // OG Aanbod
    function HTMLOGAanbodDashboard(): void { htmlHeader('OG Aanbod Dashboard'); ?>
        <p>dingdong bishass</p>
        <?php htmlFooter('OG Aanbod Dashboard');}
}

// ========== Fully activated state of the plugin ==========
class OGPostTypes {
	// ==== Declaring Variables ====

	// ==== Start of Class ====
	function __construct() {
		# Creating the post types
		add_action('init', array($this, 'createPostTypes'));

		# Checking the post migration
//		add_action('init', array($this, 'checkMigrationPostTypes'));
	}

	// =========== Functions ===========
	function createPostTypes(): void {
		// ==== Declaring Variables ====
		// Classes
		$postTypeData = new OGPostTypeData();
		$postTypeData = $postTypeData->customPostTypes();

		// ==== Start of Function ====

		// Create the OG Custom Post Types (if the user has access to it)
		foreach($postTypeData as $postType => $postTypeArray) {
			register_post_type($postType, $postTypeArray['post_type_args']);
		}
	}
	# This function is for checking if the post types are migrated to different tables / metadata tables
	function checkMigrationPostTypes(): void {
		// ==== Declaring Variables ====
		# Classes
		global $wpdb;
		$postTypeData = new OGPostTypeData();
		$postTypeData = $postTypeData->customPostTypes();

		# Variables
		$defaultPrefix = "wp_cpt_";
		$sqlCheck = "SHOW TABLES LIKE '{$defaultPrefix}";

		// ==== Start of Function ====
		// Checking
		foreach ($postTypeData as $postType => $postTypeArray) {
			// Preparing the statement
			$result = $wpdb->get_results("{$sqlCheck}{$postType}'");

			if (empty($result)) {
				// Migrating the data
				adminNotice('error', 'Please migrate the '.strtoupper($postType).' custom post type to the new table structure using the CPT Tables Plugin.');
			}
		}
	}
}
class OGOffers {
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
		else {
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
		$OGMapping = new OGMapping();

		# Variables
		$databaseKeysMedia = $databaseKey['media'];
		$postTypeName = !empty($databaseKeysMedia['folderRedirect']) ? $databaseKeysMedia['folderRedirect'] : $postTypeName;
		$mime_type_map = [
			'jpg' => 'image/jpeg',
			'png' => 'image/png',
			'pdf' => 'application/pdf',
		];
		$mime_type_map2 = [
			'Video' => 'video/mp4',
			'Connected_partner' => 'application/unknown',
		];
		$guid_url = get_site_url();

		$mediaObjects = $wpdb->get_results("SELECT * FROM `{$databaseKeysMedia['tableName']}` WHERE `{$databaseKeysMedia['search_id']}` = $OGobject->id");

		// ============ Start of Function ============
		foreach ($mediaObjects as $mediaObject) {
			// ======== Declaring Variables ========
			# Mapping the data
			$mediaObject = $OGMapping->mapMetaData($mediaObject, ($databaseKeysMedia['mapping'] ?? []));
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
			$post_mime_type = $mime_type_map[$mediaObject->{'bestands_extensie'}] ?? $mime_type_map2[$mediaObject->{$databaseKeysMedia['media_Groep']}] ?? 'unknown';
			$media_url = "og_media/{$postTypeName}_{$OGobject->{$databaseKeysMedia['object_keys']['objectVestiging']}}_{$OGobject->{$databaseKeysMedia['object_keys']['objectTiara']}}/{$OGobject->{$databaseKeysMedia['object_keys']['objectTiara']}}_{$mediaObject->{$databaseKey['ID']}}.$mediaObject->bestands_extensie";
			$post_data = [
				'post_content' => '',
				'post_title' => "{$mediaObject->{$databaseKey['ID']}}-{$mediaObject->bestandsnaam}",
				'post_excerpt' => strtoupper($mediaObject->{$databaseKeysMedia['media_Groep']}),
				'post_status' => 'inherit',
				'comment_status' => 'open',
				'ping_status' => 'closed',
				'post_name' => "{$mediaObject->{$databaseKey['ID']}}-{$mediaObject->bestandsnaam}",
				'post_parent' => $postID,
				'guid' => "{$guid_url}/$media_url",
				'menu_order' => $mediaObject->{'media_volgorde'},
				'post_type' => 'attachment',
				'post_mime_type' => $post_mime_type,
			];
			$post_meta = [
				'_wp_attached_file' => $media_url,
				'file_url' => $media_url,
				'_wp_attachment_metadata' => '',
				'ObjectCode' => $OGobject->{$databaseKey['objectCode']},
				'MediaType' => strtoupper($mediaObject->{$databaseKeysMedia['media_Groep']}),
				'MediaName' => $mediaObject->{$databaseKeysMedia['mediaName']},
				'MediaUpdated' => $mediaObject->{$databaseKeysMedia['datum_gewijzigd']},
				'_wp_attachment_image_alt' => '',
				'_id' => $mediaObject->{$databaseKey['ID']},
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

	function createPost($postTypeName, $OGobject, $databaseKey, $parentPostID='') {
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
		$ogMapping = new OGMapping();

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
		$OGMapping = new OGMapping();

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
			$OGBouwnummer = $OGMapping->mapMetaData($OGBouwnummer, ($databaseKeys[2]['mapping'] ?? []), $locationCodes, $databaseKeys);
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
		$OGMapping = new OGMapping();

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
			$OGBouwtype = $OGMapping->mapMetaData($OGBouwtype, ($databaseKeys[1]['mapping'] ?? []), $locationCodes, $databaseKeys);
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
		$OGMapping = new OGMapping();
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
			$OGProject = $OGMapping->mapMetaData($OGProject, ($databaseKeys[0]['mapping'] ?? []), $locationCodes, $databaseKeys);

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
		$OGMapping = new OGMapping();
		# Variables
		$locationCodes = $this->getLocationCodes();
		$objectIDs = [];

		// ============ Start of Function ============
		# Creating/Updating the posts
		foreach ($OGobjects as $OGobject) {
			// ======== Declaring Variables ========
			# ==== Variables ====
			# Remapping the object
			$OGobject = $OGMapping->mapMetaData($OGobject, ($databaseKey['mapping'] ?? []), $locationCodes);

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
		$postTypeData = new OGPostTypeData();

		# Variables
		date_default_timezone_set('Europe/Amsterdam');
		$beginTime = time();
		$postTypeData = $postTypeData->customPostTypes();
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
			'name' => 'OGOffers',
			# convert to megabytes
			'memoryUsageMax' => $maxMemoryUsage,
			'memoryUsage' => $memoryUsage,
			'datetime' => date('Y-m-d H:i:s', $beginTime),
			'duration' => round((time() - $beginTime) / 60, 2)
		]);
	}
}