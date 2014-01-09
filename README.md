PhMagick
========

Image Magick Wrapper Library.
Support for Graphics Magick is comming soon. You can configure which library to use through config/module.config.php

Build status
------------
Master branch:

[![Build Status](https://secure.travis-ci.org/renepardon/PhMagick.png?branch=master)](http://travis-ci.org/renepardon/PhMagick)

Installation
------------

Ready to use within a ZF2 project. Just clone into **vendor/** directory and link within application config as module.

### Composer

Add the following parts to your **composer.json** file...

    {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/renepardon/PhMagick.git"
            }
        ],
        "require": {
            "renepardon/PhMagick": "dev-master"
        }
    }

... and execute:

    $ php composer.phar update

### Git clone

    $ cd /path/to/project
    $ mkdir vendor/renepardon
    $ git clone --recursive https://github.com/renepardon/PhMagick.git vendor/renepardon/PhMagick

#### config/application.config.php

    <?php
    return array(
        // This should be an array of module namespaces used in the application.
        'modules' => array(
            'PhMagick',
        ),
    );

Usage
-----

    <?php
    use PhMagick/PhMagick;

    // ...

    $phmagick = new PhMagick('/tmp/image.jpg', '/tmp/newimage.jpg');
    $phmagick->setAdapters(array('decorations', 'resize'));
    $phmagick->resizeExactly(450, 200);
    $phmagick->polaroid('test label goes here', 13);

This usage is deprecated. The next solution will be implemented soon:

    <?php
    use PhMagick/PhMagick;

    // ...

    $phmagick = new PhMagick('/tmp/image.jpg', '/tmp/newimage.jpg');
    $phmagick->resize->resizeExactly(450, 200);
    $phmagick->decoration->polaroid('test label goes here', 13);