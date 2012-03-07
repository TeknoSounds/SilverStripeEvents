<?php
    class OriginalImage extends Image {
        function generateEventListingImage($gd) {
            try {
                return $gd->resizeRatio(100,200);
            } catch (Exception $e) {}
        }
    }
