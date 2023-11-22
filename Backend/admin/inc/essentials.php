<?php
//frontend purpose data
define('SITE_URL', 'http://34.143.182.143:8080/'); 
define('ABOUT_IMG_PATH', SITE_URL.'assets/images/about/');
define('CAROUSEL_IMG_PATH', SITE_URL.'assets/images/carousel/');
define('FACILITIES_IMG_PATH', SITE_URL.'assets/images/facilities/');
define('ROOMS_IMG_PATH', SITE_URL.'assets/images/rooms/');
define('USERS_IMG_PATH', SITE_URL.'assets/images/users/');

//backend upload process needs this date_add
define('UPLOAD_IMAGE_PATH', SITE_URL.'/assets/images/');
define('ABOUT_FOLDER','about/');
define('CAROUSEL_FOLDER','carousel/');
define('FACILITIES_FOLDER','facilities/');
define('ROOM_FOLDER','rooms/');
define('USERS_FOLDER','users/');

$GLOBALS['frontendImagePath'] = 'http://34.143.182.143:8080/assets/images/';

    function adminLogin(){
        session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
            header("location: index.php");
            echo"<script>
                window.location.href='index.php';
            </script>";
            exit;
        }
    }
    function redirect($url){
        echo"<script>
        window.location.href='$url';
            </script>";
            exit;
        
    }
    function alert($type,$msg){
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert " role="alert">
                <strong class="me-3">$msg</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }

    function uploadImage($image, $folder){
        $valid_mime = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        $img_mime = $image['type'];
        if (!in_array($img_mime, $valid_mime)) {
            return 'inv_img'; // Invalid image mime or format
        } else if (($image['size'] / (1024 * 1024)) > 2) {
            return 'inv_size'; // Invalid size greater than 2
        }else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111, 99999).".$ext";
            $img_path = $GLOBALS['frontendImagePath'].$folder.$rname;
            if(move_uploaded_file($image['tmp_name'], $img_path)){
                return $rname;
            }else{
                return 'upd_failed';
            }
        }
    }
    function deleteImage($image, $folder) {
        $imagePath = UPLOAD_IMAGE_PATH . $folder . $image;
        if (file_exists($imagePath) && unlink($imagePath)) {
            return true; // Successfully deleted
        } else {
            return false; // Failed to delete
        }
    }  
    
    function uploadSVGImage($image, $folder){
        $valid_mime = ['image/svg+xml'];
        $img_mime = $image['type'];
        if (!in_array($img_mime, $valid_mime)) {
            return 'inv_img'; // Invalid image mime or format
        } else if (($image['size'] / (1024 * 1024)) > 1) {
            return 'inv_size'; // Invalid size greater than 1
        }else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111, 99999).".$ext";
            $img_path = $GLOBALS['frontendImagePath'].$folder.$rname;
            if(move_uploaded_file($image['tmp_name'], $img_path)){
                return $rname;
            }else{
                return 'upd_failed';
            }
        }
    }

    function uploadUserImage($image){

        $valid_mime = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        $img_mime = $image['type'];
        if (!in_array($img_mime, $valid_mime)) {
            return 'inv_img'; // Invalid image mime or format
 
        }else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111, 99999).".jpeg";
            $img_path = $GLOBALS['frontendImagePath'].USERS_FOLDER.$rname;

            if($ext == 'png' || $ext == 'PNG') {
                $img = imagecreatefrompng($image['tmp_name']);
            }
            else if ($ext == 'webp' || $ext == 'WEBP') {
                $img = imagecreatefromwebp($image['tmp_name']);
            }
            else {
                $img = imagecreatefromjpeg($image['tmp_name']);
            }


            if(imagejpeg($img,$img_path,75)){
                return $rname;
            }else{
                return 'upd_failed';
            }
        }

    }
?>

