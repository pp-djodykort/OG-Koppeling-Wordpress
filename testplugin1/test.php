<?php
class OGOffers {
    // ==== Start of Class ====
    function __construct() {
        $this->examinePosts();
    }

    // ======== Functions ========
    // This function is for getting the column info and putting that as meta data in the custom post types.
    function createPost($typeObjects ,$object) {
        // ======== Declaring Variables ========
        # Variables
        $post_data = [
            'post_title' => '',
            'post_content' => '',
            'post_status' => 'draft',
            'post_type' => ''
        ];
        switch ($typeObjects) {
            case 'wonen':
                $post_data['post_title'] = $object->objectDetails_Adres_NL_Straatnaam.' '.$object->objectDetails_Adres_NL_Huisnummer;
                $post_data['post_content'] = $object->objectDetails_Aanbiedingstekst;
                $post_data['post_type'] = 'wonen';
                break;
            case 'bog':
                $post_data['post_title'] = $object->objectDetails_Adres_Straatnaam.' '.$object->objectDetails_Adres_Huisnummer;
                $post_data['post_content'] = $object->objectDetails_Aanbiedingstekst;
                $post_data['post_type'] = 'bog';
                break;
            case 'nieuwbouw':
                $post_data['post_type'] = 'nieuwbouw';
                break;
            case 'alv':
                $post_data['post_type'] = 'alv';
                break;
        }

        // ======== Start of Function ========
        $postID = wp_insert_post($post_data);

        # Adding the meta data
        foreach ($object as $key => $value) {
            add_post_meta($postID, $key, $value);
        }
        # Adding the meta data for the images

        # Publishing the post
        wp_update_post(array('ID' => $postID, 'post_status' => 'publish'));
    }

    function overwritePost($typeObjects, $object, $postID) {
        // ======== Declaring Variables ========
        $post_data = [
            'ID' => $postID,
            'post_title' => '',
            'post_content' => ''
        ];

        switch ($typeObjects) {
            case 'wonen':
                $post_data['post_title'] = $object->objectDetails_Adres_NL_Straatnaam.' '.$object->objectDetails_Adres_NL_Huisnummer;
                $post_data['post_content'] = $object->objectDetails_Aanbiedingstekst;
                break;
            case 'bog':
                $post_data['post_title'] = $object->objectDetails_Adres_Straatnaam.' '.$object->objectDetails_Adres_Huisnummer;
                $post_data['post_content'] = $object->objectDetails_Aanbiedingstekst;
                break;
            case 'nieuwbouw':

                break;
            case 'alv':

                break;
        }

        // ======== Start of Function ========
        # Overwriting the post data
        wp_update_post(array(
            'post_title' => $object->objectDetails_Adres_NL_Straatnaam.' '.$object->objectDetails_Adres_NL_Huisnummer,
            'post_content' => $object->objectDetails_Aanbiedingstekst
        ));

        # Overwriting the meta data
        foreach ($object as $key => $value) {
            update_post_meta($postID, $key, $value);
        }
    }

    function checkPosts($objects, $typeObjects) {
        foreach ($objects as $object) {
            // ==== Declaring Variables ====
            # Classes
            // WP Query with metadata
            $postData = new WP_Query(array(
                'post_type' => $typeObjects,
                'meta_key' => 'object_ObjectTiaraID',
                'meta_value' => $object->object_ObjectTiaraID
            ));
            # Variables
            // Post
            $postExists = $postData->have_posts();

            if ($postExists) {
                $dateUpdatedPost = $postData->posts[0]->datum_gewijzigd;
            }
            // Object
            $tiaraID = $object->object_ObjectTiaraID;
            $dateUpdatedObject = $object->datum_gewijzigd;

            // ==== Start of Function ====
            // Check if the object is already in the posts
            if ($postExists) {
                // Check if the object is updated
                if ($dateUpdatedPost != $dateUpdatedObject) {
                    // Overwrite the post
                    $this->overwritePost($object, $postData->posts[0]->ID);
                    adminNotice('success', 'The object with the Tiara ID: '.$tiaraID.' is now overwritten.<br/>');
                }
                else {
                    adminNotice('success', 'The object with the Tiara ID: '.$tiaraID.' is already up to date.<br/>');
                }
            }

            else {
                $this->createPost($typeObjects ,$object);
                adminNotice('success', 'The object with the Tiara ID: '.$tiaraID.' is created.<br/>');
            }
        }
    }

    function examinePosts() {
        // ======== Declaring Variables ========
        # Classes
        global $wpdb;
        $settingsData = new OGSettingsData();

        # Variables
        // Getting the column info from the database
        $wonenObjects = $wpdb->get_results('SELECT * FROM `tbl_OG_wonen`');
        $bogObjects = $wpdb->get_results('SELECT * FROM `ppOG_dataBOG`');
        $nieuwbouwObjects = $wpdb->get_results('SELECT * FROM `ppOG_dataNieuwbouw`');

        // ======== Start of Function ========
        // ======= Wonen =======
        // Looping through them and putting them into the post type wonen
        $this->checkPosts($wonenObjects, 'wonen');

        // ======= BOG =======
        // Looping through them and putting them into the post type wonen
        $this->checkPosts($bogObjects, 'bog');
    }
}