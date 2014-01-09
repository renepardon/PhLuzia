PhMagick
========

Image Magick Wrapper Library

Installation
============

Ready to use within a ZF2 project. Just clone into Vendor directory and link within application config as loaded module.

Usage
=====

    <?php
    use PhMagick/PhMagick;

    // ...

    $phmagick = new PhMagick('/tmp/image.jpg', '/tmp/newimage.jpg');
    $phmagick->setAdapters(array('decorations', 'resize'));
    $phmagick->resizeExactly(450, 200);
    $phmagick->polaroid('test label goes here', 13);