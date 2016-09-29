<?php

/**
 * @author Ricardo de Carvalho <skapitao@gmail.com>
 * @link www.ricardodecarvalho.com
 * @copyright (c) 2016 Ricardo de Carvalho
 * @license The MIT License (MIT)
 * 
 * Description - PHP Class to create a new image from another.
 * This class does not save the new image in a folder, only shows real time in the browser.
 * Ideal for creating small images (thumbnails) on websites, e-commerces and product catalogs.
 * 
 * To use:
 * $newImage = new newImage();
 * <img src="<?php echo $newImage->create('/home/ricardo/shell.png', '450', '450'); ?>" />
 * 
 */

class NewImage {

  private $file;
  private $width;
  private $height;
  private $width_original;
  private $height_original;
  private $type;
  private $volume_original;
  private $volume_new;
  private $image_identifier;
  private $image;
  private $quality;
  private $gif = false;
  private $jpg = false;
  private $png = false;

  public function create($file, $width = '100', $height = '100', $quality = 100) {
    $this->setStandard($file, $width, $height, $quality);
    $this->baseline();
    $this->volumeOriginal();
    $this->volumeNew();
    $this->setSizeGuide();
    $this->setResolution();
    $this->setType();
    $this->imageCopyResampled();
    $this->output();
    imagedestroy($this->image_identifier);
    imagedestroy($this->image);
  }

  private function setStandard($file, $width, $height, $quality) {
    $this->file = $file;
    $this->width = $width;
    $this->height = $height;
    $this->quality = $quality;
    return null;
  }

  private function baseline() {
    list($this->width_original, $this->height_original, $this->type) = getimagesize($this->file);
    return null;
  }

  private function volumeOriginal() {
    $this->volume_original = ($this->width_original / $this->height_original);
    return null;
  }

  private function volumeNew() {
    $this->volume_new = $this->width / $this->height;
    return null;
  }

  private function setSizeGuide() {
    if ($this->volume_new > $this->volume_original) {
      $this->width = $this->height * $this->volume_original;
    } else {
      $this->height = $this->width / $this->volume_original;
    }
    return null;
  }

  private function setResolution() {
    $this->image_identifier = imagecreatetruecolor($this->width, $this->height);
    return null;
  }

  private function setType() {
    switch ($this->type) {
      case 1:
        $this->gif = true;
        $this->image = imagecreatefromgif($this->file);
        break;
      case 2:
        $this->jpg = true;
        $this->image = imagecreatefromjpeg($this->file);
        break;
      case 3:
        $this->png = true;
        $this->image = imagecreatefrompng($this->file);
        break;
    }
    return null;
  }

  private function imageCopyResampled() {
    imagecopyresampled(
        $this->image_identifier, $this->image, 0, 0, 0, 0, $this->width, $this->height, $this->width_original, $this->height_original);
    return null;
  }

  private function output() {
    if (isset($this->gif)) {
      header("Content-type: image/gif");
      imagegif($this->image_identifier, null, $this->quality);
    }
    if (isset($this->jpg)) {
      header("Content-type: image/jpeg");
      imagejpeg($this->image_identifier, null, $this->quality);
    }
    if (isset($this->png)) {
      header("Content-type: image/png");
      imagepng($this->image_identifier);
    }
    return null;
  }

}
