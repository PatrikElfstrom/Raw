<?php
/*
Plugin Name: Raw
Plugin URI: http://patrikelfstrom.se/project/raw/
Description: Raw enables you to upload RAW image files to WordPress with thumbnail support and without loosing or damaging the RAW file. Currently supporting DNG, CR2 and NEF. Filters allows you to add support for more file types.
Version: 0.2
Author: Patrik Elfström
Author URI: http://patrikelfstrom.se/
Copyright: Patrik Elfström
Text Domain: raw
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Raw') ) {

    class Raw {
        
        // vars
        var $settings;
        
        // A dummy constructor to ensure raw is only initialized once
        function __construct() {
            /* Do nothing here */
        }
        
        // Initialize: The real constructor to initialize raw
        function initialize() {
        
            global $wp_settings_errors;
            
            // vars
            $this->settings = array(
            
                // options
                'raw_file_types'	=> array(
                    'DNG' => 'image/AdobeRawDNG',
                    'CR2' => 'image/x-canon-cr2',
                    'NEF' => 'image/x-nikon-nef'
                ),
                
                // This is to tell wordpress that just because the MIME is tiff
                // doesn't mean that the file ending is tif
                'raw_file_types_special' => array(
                    'DNG' => 'image/tiff',
                    'CR2' => 'image/tiff',
                    'NEF' => 'image/tiff'
                )
            );
                
            // admin
            if( is_admin() ) {
        
                // check that imagick is installed
                if (!extension_loaded('imagick')) {
                    
                    add_action( 'admin_notices', function() {
                        ?>
                        <div class="error">
                            <p><?php printf(__( 'The PHP module %sImageMagic%s is required for Raw to work.', 'raw' ), '<a target="_blank" href="http://php.net/manual/book.imagick.php">', '</a>');  ?></p>
                        </div>
                        <?php
                    });
                    
                } else {
                    
                    require_once('core.php');
                    
                }
                
            }
            
        }
        
    }

    function raw() {

        global $raw;
        
        if( !isset($raw) ) {
        
            $raw = new Raw();
            
            $raw->initialize();
            
        }
        
        return $raw;
    }

    // initialize
    raw();

}

?>
