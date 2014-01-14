<?php

namespace PhMagick;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * Image manipulation library.
 *
 * This library can be used for easy image manipulation with
 * Image Magick/Graphics Magick.
 *
 * PHP version 5
 *
 * LICENSE: GPL-3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    PhMagick
 * @category   Test
 * @author     Christoph, René Pardon <christoph@renepardon.de>
 * @copyright  2014 by Christoph, René Pardon
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt
 * @version    1.0
 * @link       https://github.com/renepardon/PhMagick
 * @since      2013-01-09
 */
class PhMagick extends TestCase
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var ConfigurationFactory
     */
    protected $factory;

    /**
     * @var \PhMagick\Service\PhMagick
     */
    protected $service;

    /**
     * @var string
     */
    protected $sourceImage = '';

    /**
     * Initialize service manager with Config service and PhMagick service.
     *
     * {@inheritDoc}
     */
    public function setUp()
    {
        global $moduleConfig;

        $this->serviceManager = new ServiceManager();
        $this->serviceManager->setService('Config', $moduleConfig);
        $this->serviceManager->setFactory('phmagick', 'PhMagick\Service\PhMagickFactory');

        $this->service = $this->serviceManager->get('phmagick');

        $this->sourceImage = realpath(dirname(__FILE__) . '/_files/testimage.jpg');
    }

    public function tearDown()
    {
        // Cleanup test files :)
        foreach (glob("/tmp/testimage*") as $file) {
            // @unlink($file); // @todo uncomment !!
        }
    }

    public function testResizeImage()
    {
        $target = '/tmp/testimage_resize_' . time() . '.png';
        $this->service->setSource($this->sourceImage)
                      ->setDestination($target);

        $this->service->resize()->resize(150, 200);

        list($width, $height) = getimagesize($target);

        $this->assertEquals(150, $width);
        $this->assertEquals(94, $height);
    }

    public function testResizeExactly()
    {
        $target = '/tmp/testimage_resizeExactly_' . time() . '.png';
        $this->service->setSource($this->sourceImage)
                      ->setDestination($target);

        $this->service->resize()->resizeExactly(150, 150);

        list($width, $height) = getimagesize($target);

        $this->assertEquals(240, $width);
        $this->assertEquals(150, $height);
    }

    public function testCrop()
    {
        $target = '/tmp/testimage_crop_' . time() . '.png';
        $this->service->setSource($this->sourceImage)
            ->setDestination($target);

        $this->service->crop()->crop(200, 350, 10, 10, Gravity::Center);

        list($width, $height) = getimagesize($target);

        $this->assertEquals(200, $width);
        $this->assertEquals(350, $height);
    }

    public function testConversionBetweenFileTypes()
    {
        $targetPdf = '/tmp/testimage_converted_' . time() . '.pdf';
        $targetTiff = '/tmp/testimage_converted_' . time() . '.tiff';

        $this->service->setSource($this->sourceImage)
            ->setDestination($targetPdf);

        $this->service->convert()->convert();

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $this->assertEquals('application/pdf', $finfo->file($targetPdf));

        $this->service->setSource($this->sourceImage)
            ->setDestination($targetTiff);

        $this->service->convert()->convert();

        $this->assertEquals('image/tiff', $finfo->file($targetTiff));
    }
}