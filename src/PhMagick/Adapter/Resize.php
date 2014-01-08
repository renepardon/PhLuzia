<?php
namespace PhMagick\Adapter;

use PhMagick\PhMagick;

class Resize extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Resize';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'resize',
            'resizeExactly',
            'onTheFly',
        );
    }

    /**
     * Resize current image.
     *
     * @param PhMagick $p
     * @param $width
     * @param int $height
     * @param bool $exactDimentions
     *
     * @return PhMagick
     */
    public function resize(PhMagick $p, $width, $height = 0, $exactDimentions = false)
    {
        $modifier = $exactDimentions ? '!' : '>';

        // If $width or $height == 0 then we want to resize to fit one measure.
        // If any of them is sent as 0 resize will fail because we are trying to resize to 0 px.
        $width = $width == 0 ? '' : $width;
        $height = $height == 0 ? '' : $height;

        $cmd = $p->getBinary('convert');
        $cmd .= ' -scale "' . $width . 'x' . $height . $modifier;
        $cmd .= '" -quality ' . $p->getImageQuality();
        $cmd .= ' -strip ';
        $cmd .= ' "' . $p->getSource() . '" "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Tries to resize an image to the exact size wile mantaining aspect ratio,
     * the image will be cropped to fit the measures.
     *
     * @param PhMagick $p
     * @param $width
     * @param $height
     *
     * @return PhMagick
     */
    public function resizeExactly(PhMagick $p, $width, $height)
    {
        // Requires Crop plugin.
        $p->addAdapter(new Crop());

        list($w, $h) = $p->getInfo($p->getSource());

        if ($w > $h) {
            $h = $height;
            $w = 0;
        } else {
            $h = 0;
            $w = $width;
        }

        return $p->resize($w, $h)->crop($width, $height);
    }

    /**
     * Creates a thumbnail of an image if it doesn't exists.
     *
     * @param PhMagick $p
     * @param $imageUrl             The iamge URI
     * @param $width
     * @param $height
     * @param bool $exactDimentions If false: resizes the image to the exact
     *                              porportions (aspect ratio not preserved).
     *                              If true: preserves aspect ratio, only
     *                              resises if image is bigger than specified measures
     * @param string $webPath
     * @param string $physicalPath
     *
     * @return string The thumbnail URI
     */
    public function onTheFly(PhMagick $p, $imageUrl, $width, $height, $exactDimentions = false, $webPath = '', $physicalPath = '')
    {
        // Convert web path to physical.
        $basePath = str_replace($webPath, $physicalPath, dirname($imageUrl));
        $sourceFile = $basePath . '/' . basename($imageUrl);;

        // Naming the new thumbnail.
        $thumbnailFile = $basePath . '/' . $width . '_' . $height . '_' . basename($imageUrl);

        $p->setSource($sourceFile);
        $p->setDestination($thumbnailFile);

        if (!file_exists($thumbnailFile)) {
            $p->resize($p, $width, $height, $exactDimentions);
        }

        if (!file_exists($thumbnailFile)) {
            // If there was an error, just use original file.
            $thumbnailFile = $sourceFile;
        }

        // Returning the thumbnail url.
        return str_replace($physicalPath, $webPath, $thumbnailFile);
    }
}