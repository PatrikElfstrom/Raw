=== Plugin Name ===
Contributors: rcane
Tags: raw image, raw, dng, nef, cr2, photo, image, photograph, DSLR, upload
Requires at least: 3.0
Tested up to: 3.9.2
Stable tag: 0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Raw enables you to upload RAW image files straight from your DSLR to WordPress with thumbnail support and without loosing or damaging the RAW file.

== Description ==

Raw enables you to upload RAW image files straight from your DSLR to WordPress.
Once the RAW image has been uploaded, Raw will create a JPEG copy and WordPress will then generate all thumbnails.

<h4>Features:</h4>

* Upload RAW images like DNG, CR2 and NEF to WordPress

* Works just like if you uploaded a JPEG.

* Generates a copy for all thumbnail sizes

Raw currently supports DNG, CR2 and NEF out of the box but filters allows you to add support for more RAW image types.

Raw requires the PHP module ImageMagic (http://php.net/manual/book.imagick.php) to convert the RAW files to jpeg.

== Tested on ==

Ubuntu 13.10 and WordPress 3.9.2

== Installation ==

1. Upload `raw` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Which RAW image formats does Raw support? =

Raw supports DNG, CR2 and NEF out of the box. But you can use filters to add other formats.

= How do I know if I have ImageMagic? =

Raw will tell you if ImageMagic is not installed

= How do I install ImageMagic? =

Contact your web hosting company.

If you have your own server:

Ubuntu/Debian:  

1. `sudo apt-get install php5-imagick`  
2. `sudo service apache2 reload`

= Filter: upload_mimes_raw_file_types_special =

Add special cases where the MIME type is not the same as the file ending.  
For example DNG has the TIFF MIME type.

= Filter: add_raw_mimes =

Add or remove supported RAW file types.

== Changelog ==

= 0.2 =
* Cleaned up the code and fixed descriptions

= 0.1 =
* First version
