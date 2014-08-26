#Raw

Raw enables you to upload RAW image files to WordPress with thumbnail support and without loosing or damaging the RAW file. Currently supporting DNG, CR2 and NEF. Filters allows you to add support for more file types.

##Description

Raw enables you to upload RAW image files straight from your DSLR to WordPress.
Once the RAW image has been uploaded, Raw will create a JPEG copy and WordPress will then generate all thumbnails.

Raw currently suppors DNG, CR2 and NEF out of the box but filters allows you to add support for more file types.

* Upload RAW image files like .DNG, .CR2 and .NEF
* Thumbnail support

Raw requires the PHP module ImageMagic (http://php.net/manual/book.imagick.php) to convert the RAW files to jpeg.

###Filters
* *upload_mimes_raw_file_types_special*  
Add special cases where the MIME type is not the same as the file ending.
For example DNG has the TIFF MIME type.

* *add_raw_mimes*  
Add or remove supported RAW file types.

##Tested on

Ubuntu 13.10 and WordPress 3.9.2

##Installation

1. Upload `raw` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

##Frequently Asked Questions

###Which file formats does Raw support?

Raw supports DNG, CR2 and NEF out of the box. But you can use filters to add other formats.

###How do I know if I have ImageMagic?

Raw will tell you if ImageMagic is installed or not

###How do I install ImageMagic?

Contact your web hosting company.

Ubuntu/Debian:  
  `sudo apt-get install php5-imagick`  
  `sudo service apache2 reload`

##Changelog

**0.1** - *First version*
