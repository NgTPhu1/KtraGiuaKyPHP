<?php
class ImageProcessor {
    // Directory for storing images
    private static $imageDir = 'public/images/';
    
    /**
     * Save image from base64 string
     * @param string $base64String Base64 string
     * @param string $prefix File name prefix
     * @return string Saved file name or null if failed
     */
    public static function saveBase64Image($base64String, $prefix = '') {
        // Check if the string is in base64 format
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            $imageType = $matches[1];
            $base64Data = substr($base64String, strpos($base64String, ',') + 1);
            $decodedImage = base64_decode($base64Data);
            
            if ($decodedImage === false) {
                return null;
            }
            
            // Create a random file name with prefix
            $filename = $prefix . '_' . uniqid() . '.' . $imageType;
            $filepath = BASE_PATH . '/' . self::$imageDir . $filename;
            
            // Create directory if it doesn't exist
            if (!file_exists(BASE_PATH . '/' . self::$imageDir)) {
                mkdir(BASE_PATH . '/' . self::$imageDir, 0755, true);
            }
            
            // Save the file
            if (file_put_contents($filepath, $decodedImage)) {
                return $filename;
            }
        }
        
        return null;
    }
    
    /**
     * Delete image
     * @param string $filename File name to delete
     * @return bool File deletion result
     */
    public static function deleteImage($filename) {
        if (!$filename) return true;
        
        $filepath = BASE_PATH . '/' . self::$imageDir . $filename;
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        
        return false;
    }
}
?>
