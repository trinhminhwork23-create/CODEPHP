<?php

$dir = dirname(__DIR__) . '/public/img/rooms';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

$images = [
    1 => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', // Panorama 1
    2 => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80', // Panorama 2
    3 => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800&q=80', // Panorama 3
    4 => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&q=80', // Panorama 4
    5 => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80', // Mountain 1
    6 => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=800&q=80', // Mountain 2
    7 => 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=800&q=80', // Mountain 3
    8 => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80', // Mountain 4
    9 => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=800&q=80', // Deluxe 1
    10 => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80', // Deluxe Valley 1
    11 => 'https://images.unsplash.com/photo-1606046604972-77cc76aee944?w=800&q=80', // Deluxe Valley 2
    12 => 'https://images.unsplash.com/photo-1521783988139-89397d761dce?w=800&q=80', // Deluxe Valley 3
    13 => 'https://images.unsplash.com/photo-1611891487122-2075b962442f?w=800&q=80', // Deluxe Valley 4
    14 => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=800&q=80', // Nest Villa 1
    15 => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=800&q=80', // Nest Villa 2
    16 => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80', // Nest Villa 3
    17 => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=800&q=80', // Nest Villa 4
];

echo "Starting download of 17 luxury resort room images...\n";

foreach ($images as $id => $url) {
    $dest = $dir . "/room_{$id}.jpg";
    echo "Downloading room_{$id}.jpg from {$url} ... ";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($data !== false && $statusCode === 200) {
        file_put_contents($dest, $data);
        echo "SUCCESS!\n";
    } else {
        echo "FAILED (Status: {$statusCode}, Error: {$error}). Trying fallback...\n";
        // Fallback to copy an existing room image if it exists
        $fallbackSource = dirname(__DIR__) . "/public/img/room/room-" . (($id % 6) + 1) . ".jpg";
        if (file_exists($fallbackSource)) {
            copy($fallbackSource, $dest);
            echo "Copied local room-" . (($id % 6) + 1) . ".jpg as fallback.\n";
        } else {
            echo "No fallback available.\n";
        }
    }
}

echo "Image download script completed.\n";
