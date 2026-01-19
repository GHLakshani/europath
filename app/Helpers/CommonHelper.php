<?php

use App\Models\Language;
use App\Models\ContactUs;
use App\Models\Subsidiariesmodal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Models\Land;
use App\Models\House;
use Illuminate\Support\Facades\Response;


if (!function_exists('activate_menu')) {
    function activate_menu($controller) {
        $currentRoute = request()->route()->getName();
        // dd($currentRoute);
        return ($currentRoute == $controller) ? 'active' : '';
    }
}

if (!function_exists('get_meta')) {
    function get_meta($page) {
        // Query the database for meta tags based on the controller name
        $metaTags = DB::table('meta_tags')
            ->where('page_name', $page)
            ->first();

        // Return the result as a collection (or an array if you need it as such)
        return $metaTags;
    }
}

if (!function_exists('inner_page_header')) {
    function inner_page_header($page) {
        $banner = DB::table('inner_headers')
            ->where('route_name', $page)
            ->first();

        return $banner;
    }
}

if (!function_exists('get_contact_details')) {
    function get_contact_details() {
        return ContactUs::first();
    }
}

if (!function_exists('sanitize_title')) {
    function sanitize_title($title)
    {
        // Convert to lowercase
        $title = strtolower($title);

        // Custom removals
        $title = str_replace(['%', '?', '°', '"', "'", '“', '”', '’', '‘', '–', '—'], '', $title);

        // Replace spaces with dashes
        $title = str_replace(' ', '-', $title);

        // Remove any remaining unwanted special characters except dashes and alphanumerics
        $title = preg_replace('/[^a-zA-Z0-9\-]/', '', $title);

        // Replace multiple dashes with a single dash
        $title = preg_replace('/-+/', '-', $title);

        // Trim dashes from the beginning and end
        $title = trim($title, '-');

        return $title;
    }
}

if (!function_exists('reverse_sanitize_title')) {
    function reverse_sanitize_title($title)
    {
        // Replace dashes with spaces
        $title = str_replace('-', ' ', $title);

        return $title;
    }
}

if (!function_exists('resizeImage')) {
    function resizeImage($sourcePath, $width, $height) {
        if (!file_exists($sourcePath)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        // Get file size in bytes
        $fileSize = filesize($sourcePath);

        // If file size is 1MB or less, return original image
        if ($fileSize <= 1048576) { // 1MB = 1048576 bytes
            return Response::file($sourcePath, [
                'Content-Type' => mime_content_type($sourcePath),
                'Cache-Control' => 'public, max-age=86400', // Cache for 1 day
                'Content-Disposition' => 'inline; filename="' . basename($sourcePath) . '"'
            ]);
        }

        // Get original image dimensions and type
        list($originalWidth, $originalHeight, $imageType) = getimagesize($sourcePath);

        $newImage = imagecreatetruecolor($width, $height);

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $originalImage = imagecreatefromjpeg($sourcePath);
                $mimeType = 'image/jpeg';
                break;
            case IMAGETYPE_PNG:
                $originalImage = imagecreatefrompng($sourcePath);
                $mimeType = 'image/png';
                break;
            case IMAGETYPE_GIF:
                $originalImage = imagecreatefromgif($sourcePath);
                $mimeType = 'image/gif';
                break;
            default:
                return response()->json(['error' => 'Unsupported image type'], 400);
        }

        // Resize the image
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

        // Create a buffer to store the image
        ob_start();
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($newImage, null, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($newImage);
                break;
            case IMAGETYPE_GIF:
                imagegif($newImage);
                break;
        }
        $imageData = ob_get_clean();

        imagedestroy($newImage);
        imagedestroy($originalImage);

        // Return resized image with headers
        return Response::make($imageData, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
            'Content-Disposition' => 'inline; filename="resized-image.' . image_type_to_extension($imageType, false) . '"'
        ]);
    }
}

if (!function_exists('get_career')) {
    function get_career($id) {

        $sql = "SELECT
            vacancies.*
            FROM
            vacancies
            WHERE
            id = ?";

        $data = DB::select($sql, [$id]);

        // Return the result as a collection (or an array if you need it as such)
        return  $data = $data[0] ?? null;
    }
}
