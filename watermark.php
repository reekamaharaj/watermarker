<?php

use Intervention\Image\ImageManagerStatic as Image;

require 'vendor/autoload.php';

Image::configure(['driver' => 'imagick']);

$watermark = Image::make('watermark.png')->opacity(45)->rotate(45); // Intervention\Image\Image
$artFolder = scandir('fullpageart');
$dot = ['.','..'];
$filesToWatermark = array_diff($artFolder, $dot);

// foreach to watermark each art file
foreach ($filesToWatermark as $index => $fileToWatermark){
    $originalArt = Image::make('fullpageart/' . $fileToWatermark);

    $widthOriginalArt = $originalArt->width();
    $heightOriginalArt = $originalArt->height();
    $newOriginalArtWidth = $widthOriginalArt / 2;
    $newOriginalArtHeight = $newOriginalArtWidth*($heightOriginalArt/$widthOriginalArt);

    $originalArt->resize($newOriginalArtWidth, $newOriginalArtHeight);

    $widthWatermark = $watermark->width();
    $heightWatermark = $watermark->height();
    $newWatermarkWidth = $newOriginalArtWidth / 1.5;
    $newWatermarkHeight = $newWatermarkWidth*($heightWatermark/$widthWatermark);

    $watermark->resize($newWatermarkWidth, $newWatermarkHeight);

    $originalArt->insert($watermark, 'center');
    $originalArt->line(0, 0, $originalArt->width(), $originalArt->height(), function($draw){$draw->width(1.5);});
    $originalArt->line($originalArt->width(), 0, 0, $originalArt->height(), function($draw){$draw->width(1.5);});
    $fileToWatermark = substr($fileToWatermark, 0, -4);
    $originalArt->save('wmart/wm' . $fileToWatermark . '.jpeg');
    echo 'Running file ' . $index . ' of ' . count($filesToWatermark) . PHP_EOL;
}

$smallArtFolder = scandir('smallart');
$smallFilesToWatermark = array_diff($smallArtFolder, $dot);

foreach ($smallFilesToWatermark as $index => $fileToWatermark){
    $originalArt = Image::make('smallart/' . $fileToWatermark);

    $widthOriginalArt = $originalArt->width();
    $heightOriginalArt = $originalArt->height();
    $newOriginalArtWidth = $widthOriginalArt / 1.5;
    $newOriginalArtHeight = $newOriginalArtWidth*($heightOriginalArt/$widthOriginalArt);

    $originalArt->resize($newOriginalArtWidth, $newOriginalArtHeight);

    $widthWatermark = $watermark->width();
    $heightWatermark = $watermark->height();
    $newWatermarkWidth = $newOriginalArtWidth / 2;
    $newWatermarkHeight = $newWatermarkWidth*($heightWatermark/$widthWatermark);

    $watermark->resize($newWatermarkWidth, $newWatermarkHeight);

    $originalArt->insert($watermark, 'center');
    $originalArt->line(0, 0, $originalArt->width(), $originalArt->height(), function($draw){$draw->width(1);});
    $originalArt->line($originalArt->width(), 0, 0, $originalArt->height(), function($draw){$draw->width(1);});
    $fileToWatermark = substr($fileToWatermark, 0, -4);
    $originalArt->save('wmart/wm' . $fileToWatermark . '.jpeg');
    echo 'Running file ' . $index . ' of ' . count($smallFilesToWatermark) . PHP_EOL;
}

