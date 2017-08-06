<?php

use Intervention\Image\ImageManagerStatic as Image;

require 'vendor/autoload.php';

Image::configure(['driver' => 'imagick']);

$watermark = Image::make('watermark.png')->opacity(45)->rotate(45); // Intervention\Image\Image
$artfolder = scandir('art');
$dot = ['.','..'];
$filestowatermark = array_diff($artfolder, $dot);

// foreach to watermark each art file
foreach ($filestowatermark as $index => $filetowatermark){
    $originalArt = Image::make('art/' . $filetowatermark);

    $widthOriginalArt = $originalArt->width();
    $widthWatermark = $watermark->width();
    $heightWatermark = $watermark->height();
    $newWatermarkWidth = $widthOriginalArt / 1.5;
    $newWatermarkHeight = $newWatermarkWidth*($heightWatermark/$widthWatermark);

    $watermark->resize($newWatermarkWidth, $newWatermarkHeight);

    $originalArt->insert($watermark, 'center');
    $originalArt->line(0, 0, $originalArt->width(), $originalArt->height(), function($draw){$draw->width(3);});
    $originalArt->line($originalArt->width(), 0, 0, $originalArt->height(), function($draw){$draw->width(3);});
    $originalArt->save('wmart/wm' . $filetowatermark);
    echo 'Running file ' . $index . ' of ' . count($filestowatermark) . PHP_EOL;
}


