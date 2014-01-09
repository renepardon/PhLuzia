<?php
namespace PhMagick;

// Defines which library to use.
define('PHMAGICK_LIBRARY_IMAGEMAGICK', 'imagemagick');
define('PHMAGICK_LIBRARY_GRAPHICSMAGICK', 'graphicsmagick');

return array(
    'phmagick_library' => PHMAGICK_LIBRARY_IMAGEMAGICK,

    'di' => array(
        'instance' => array(
            
        ),
    ),
);
