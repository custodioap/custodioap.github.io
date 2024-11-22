<?php

// Check if the 'file' and 'path' GET parameters are set
if (isset($_GET['file']) && isset($_GET['path'])) {
    $file = $_GET['file'] . '.pdf';
    $path = $_GET['path'];
    $fullfile = $path . $file;

    // Check if the file exists
    if (file_exists($fullfile)) {
        // Set headers for file download
        header('Content-Type: application/pdf'); // Correct MIME type for PDF
        header('Content-Disposition: attachment; filename="' . urlencode($file) . '"'); 
        header('Content-Length: ' . filesize($fullfile));
        header('Cache-Control: private, no-store, no-cache, must-revalidate'); // Avoid caching issues

        // Flush output buffer before reading the file
        flush(); 

        // Open file and output its content
        $fp = fopen($fullfile, 'rb');
        if ($fp) {
            while (!feof($fp)) {
                echo fread($fp, 65536); // Read and output the file in chunks
                flush(); // Flush the output buffer
            }
            fclose($fp);
        } else {
            // If the file couldn't be opened, display an error
            echo 'Error opening file for download.';
        }
    } else {
        // If the file doesn't exist, display an error message
        echo 'File not found.';
    }
} else {
    // If 'file' or 'path' parameters are missing, display an error message
    echo 'Invalid parameters.';
}

?>