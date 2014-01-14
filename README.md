PhLuzia
========

Image Magick Wrapper Library.
Support for Graphics Magick is comming soon. You can configure which library to use through config/module.config.php

Build status
------------
Master branch:

[![Build Status](https://secure.travis-ci.org/renepardon/PhLuzia.png?branch=master)](http://travis-ci.org/renepardon/PhLuzia)

Installation
------------

Ready to use within a ZF2 project. Just clone into **vendor/** directory and link within application config as module.

### Composer

Add the following parts to your **composer.json** file...

    {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/renepardon/PhLuzia.git"
            }
        ],
        "require": {
            "renepardon/PhLuzia": "dev-master"
        }
    }

... and execute:

    $ php composer.phar update

### Git clone

    $ cd /path/to/project
    $ mkdir vendor/renepardon
    $ git clone --recursive https://github.com/renepardon/PhLuzia.git vendor/renepardon/PhLuzia

#### config/application.config.php

    <?php
    return array(
        // This should be an array of module namespaces used in the application.
        'modules' => array(
            'PhLuzia',
        ),
    );

Configuration
-------------

There is a configuration array placed within **module.config.php**. You can edit this configuration or place your own one into the Application's configuration folder.
Modify the default values and switch between Graphicsmagick/Imagemagick.

Usage
-----
```php
<?php
// Retrieve service instance.
$service = $this->serviceManager->get('phluzia');
// Source is the image we want to modify and destination the name of new image.
$service->setSource('/tmp/testimage.jpg')
        ->setDestination('/tmp/testimage_1_' . time() . '.jpg');
// The first call to resize will return an instance of Adapter and the second one call's the resize method.
$service->resize()->resize(150, 200, true);

// Use the same service but set source again, so that we work on a new image.
$service->setSource('/tmp/testimage.jpg')
        ->setDestination('/tmp/testimage_2_' . time() . '.jpg');
$watermarkImage = realpath(dirname(__FILE__) . '/_files/watermark.png');
// This places the watermark image on the top left without transparency.
$this->service->compose()->watermark($watermarkImage, Gravity::NorthWest, 100);
```