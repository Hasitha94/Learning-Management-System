<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsstuid']) == 0) {
    header('location:logout.php');
    exit; // Stop further execution
}

// Function to serve files for download
function output_file($file, $name, $mime_type = '')
{
    // Check if the file exists and is readable
    if (!is_readable($file)) {
        die('File not found!');
    }

    // Get the size of the file
    $size = filesize($file);

    // Decode the file name
    $name = rawurldecode($name);

    // Define known MIME types
    $known_mime_types = array(
        "pdf" => "application/pdf",
        "txt" => "text/plain",
        "html" => "text/html",
        "htm" => "text/html",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "png" => "image/png",
        "jpeg" => "image/jpg",
        "jpg" => "image/jpg",
        "php" => "text/plain"
    );

    // Determine MIME type if not provided
    if ($mime_type == '') {
        $file_extension = strtolower(substr(strrchr($file, "."), 1));
        if (array_key_exists($file_extension, $known_mime_types)) {
            $mime_type = $known_mime_types[$file_extension];
        } else {
            $mime_type = "application/force-download";
        }
    }

    // Clean the output buffer
    @ob_end_clean();

    // Disable zlib output compression
    if (ini_get('zlib.output_compression')) {
        ini_set('zlib.output_compression', 'Off');
    }

    // Set HTTP headers
    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: attachment; filename="' . $name . '"');
    header("Content-Transfer-Encoding: binary");
    header('Accept-Ranges: bytes');
    header("Cache-control: private");
    header('Pragma: private');
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    // Handle partial content requests
    if (isset($_SERVER['HTTP_RANGE'])) {
        list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
        list($range) = explode(",", $range, 2);
        list($range, $range_end) = explode("-", $range);
        $range = intval($range);
        if (!$range_end) {
            $range_end = $size - 1;
        } else {
            $range_end = intval($range_end);
        }
        $new_length = $range_end - $range + 1;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range-$range_end/$size");
    } else {
        $new_length = $size;
        header("Content-Length: " . $size);
    }

    // Transmit file in chunks
    $chunksize = 1 * (1024 * 1024); // Chunk size: 1 MB
    $bytes_send = 0;
    if ($file = fopen($file, 'r')) {
        if (isset($_SERVER['HTTP_RANGE'])) {
            fseek($file, $range);
        }
        while (!feof($file) && (!connection_aborted()) && ($bytes_send < $new_length)) {
            $buffer = fread($file, $chunksize);
            print($buffer);
            flush();
            $bytes_send += strlen($buffer);
        }
        fclose($file);
    } else {
        die('Error - cannot open file.');
    }
    die(); // Terminate script
}

// Set maximum execution time limit to unlimited
set_time_limit(0);

// Get file path and filename from request parameters
$file_path = 'assignments/' . $_REQUEST['f'];
output_file($file_path, '' . $_REQUEST['filename'] . '', 'text/plain');
