<?php
// Function to download an image from a URL and save it to a specified location
function downloadImage($imageUrl, $savePath) {
    $imageContent = file_get_contents($imageUrl);
    if ($imageContent !== false) {
        file_put_contents($savePath, $imageContent);
        echo "Image downloaded successfully: $savePath\n";
    } else {
        echo "Failed to download image: $imageUrl\n";
    }
}

// Function to get image URLs from a webpage
function getImageUrls($url) {
    $html = file_get_contents($url);
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $imageUrls = array();

    // Find all img tags
    $imgTags = $dom->getElementsByTagName('img');
    foreach ($imgTags as $imgTag) {
        $imageUrl = $imgTag->getAttribute('src');
        // Convert relative URLs to absolute URLs
        if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            $imageUrl = rtrim($url, '/') . '/' . ltrim($imageUrl, '/');
        }
        $imageUrls[] = $imageUrl;
    }

    return $imageUrls;
}

// Main script
if (isset($argv[1])) {
    $url = $argv[1];

    // Get image URLs from the webpage
    $imageUrls = getImageUrls($url);

    // Destination directory to store downloaded images
    $destinationDirectory = getenv('HOME') . '/Desktop/';

    // Download each image
    foreach ($imageUrls as $imageUrl) {
        // Extract filename from URL
        $filename = basename($imageUrl);
        // Set the save path
        $savePath = $destinationDirectory . $filename;
        // Download the image
        downloadImage($imageUrl, $savePath);
    }
} else {
    echo "Please provide a URL as argument.\n";
}
?>
