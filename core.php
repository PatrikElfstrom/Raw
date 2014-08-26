<?php

class Raw_Core {

    var $uploaded_file_ending;
	
	function __construct() {
    
        // Check that the uploaded file is not a special file
        add_filter('wp_handle_upload_prefilter', array( $this, 'check_file_type' ), 1, 1);
        
        // Add raw mimes to allowed mimes
        add_filter('upload_mimes', array( $this, 'add_raw_mimes' ), 1, 1);
        
        // Override wordpress mime to exts function
        add_filter('getimagesize_mimes_to_exts', array( $this, 'mime_to_exts_override' ), 1, 1);
        
        // Generate a thumbnail from the raw file and send it to wordpress
        add_filter('wp_generate_attachment_metadata', array($this, 'onGenerateAttachmentMetadata'), 10, 2);
        
	}
    
    // if the uploaded file ending was not in the special cases array
    // remove the mime_to_exts_override filter (so it doesn't fuck up other files)
    public function check_file_type($file) {
        if(isset($file['name'])) {
            global $uploaded_file_ending;
            $file_name_array = explode( '.', $file['name'] );
            $file_ending = end( $file_name_array );
            $uploaded_file_ending = $file_ending;
            
            $raw_file_types_special = raw()->settings['raw_file_types_special'];
        
            $raw_file_types_special = apply_filters( 'upload_mimes_raw_file_types_special', $raw_file_types_special );
        
            if(!in_array($file_ending, array_keys($raw_file_types_special))) {
                remove_filter( 'getimagesize_mimes_to_exts', array( $this, 'replace_tiff_ext' ), 1 );
            }
        }
        
        return $file;
    }  
        
    // Add raw files so WordPress accepts them.
	public function add_raw_mimes($mimes) {
        
        $raw_file_types = raw()->settings['raw_file_types'];
        
        $raw_file_types = apply_filters( 'upload_mimes_raw_file_types', $raw_file_types );
        
        foreach($raw_file_types as $file_ending => $mime) {
            $mimes[$file_ending] = $mime;
        }
        
        return $mimes;
	}
    
    // Wordpress checks the mime type (with getimagesize()) and sets the file ending to that mime type
    // with files like DNG the mime type is TIFF but the file ending is DNG
    // So wordpress would with this file replace the DNG file ending with TIF
	public function mime_to_exts_override($mimes) {
        $raw_file_types_special = raw()->settings['raw_file_types_special'];
        global $uploaded_file_ending;
        
        $raw_file_types_special = apply_filters( 'upload_mimes_raw_file_types_special', $raw_file_types_special );
        
        foreach($raw_file_types_special as $file_ending => $mime) {
        
            // we do this check since both dng and cr2 has a tiff mime
            if($file_ending == $uploaded_file_ending) {
                $mimes[$mime] = $file_ending;
            }
        }
        
        return $mimes;
	}
    
	public function onGenerateAttachmentMetadata($metadata, $attachment_id) {

        // only generate thumbnail if raw and the attachment has no data
        // this is to prevent a infinite loop
        if ($this->isRaw($attachment_id) && empty($metadata)) {
	        $attachment = get_post( $attachment_id );
        	$attachment_path = get_attached_file($attachment_id);
	        $thumbnail_filename = $attachment->post_title . '.jpg';

            $thumbnail_blob = $this->generateThumbnail($attachment_id);
        	$thumbnail = $this->uploadThumbnail($thumbnail_filename, $thumbnail_blob);

	        if ($thumbnail['error'] === false) {
        		$metadata = wp_generate_attachment_metadata($attachment_id, $thumbnail['file']);
        		update_post_meta($attachment_id, '_original_path', $attachment_path);
	        }
        }

        return $metadata;
    }
    
    private function isRaw($attachment_id) {
        
        $raw_file_types = raw()->settings['raw_file_types'];
        
        $raw_file_types = apply_filters( 'upload_mimes_raw_file_types', $raw_file_types );
        
        return in_array(get_post_mime_type($attachment_id), $raw_file_types);
    }
    
    private function generateThumbnail($attachment_id) {
        $attachment_path = get_attached_file($attachment_id);
        $filetype = wp_check_filetype($attachment_path);
        
        $image = new Imagick($filetype['ext'].':'.$attachment_path);
        $image->setImageFormat('jpg');
        $thumbnail_blob = $image->getImageBlob();
        $image->clear();
        $image->destroy();

        return $thumbnail_blob;
    }
    
    private function uploadThumbnail($filename, $bits) {
        return wp_upload_bits($filename, null, $bits);
    }
}

// initialize
new Raw_Core();

?>
