# newImage
Description - PHP Class to create a new image from another.
This class does not save the new image in a folder, only shows real time in the browser.
Ideal for creating small images (thumbnails) on websites, e-commerces and product catalogs.
 
To use:
$newImage = new newImage();
<img src="<?php echo $newImage->create('/home/ricardo/shell.png', '450', '450'); ?>" />