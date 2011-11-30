<?php
class OriginalImage extends Image {
   function generateEventListingImage($gd) {
      return $gd->resizeRatio(100,200);
   }
}
