<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    | Supported: "gd", "imagick"
    */
    'driver' => \Intervention\Image\Drivers\Gd\Driver::class, // GD is safer on Windows/WAMP

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    | Optional settings for image processing.
    */
    'options' => [
        'autoOrientation' => true,    // Rotate images according to EXIF
        'decodeAnimation' => true,    // Keep animated GIFs
        'blendingColor' => 'ffffff',  // Background color for transparent images
        'strip' => false,             // Keep or remove EXIF metadata
    ],

];
