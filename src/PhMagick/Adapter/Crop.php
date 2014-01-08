<?php
namespace PhMagick\Adapter;

use PhMagick\Gravity;
use PhMagick\PhMagick;

class Crop extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Crop';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'crop',
        );
    }

    /**
     * Crop current image.
     *
     * @param PhMagick $p
     * @param $width
     * @param $height
     * @param int $top The Y coordinate for the left corner of the crop rectangule
     * @param int $left The X coordinate for the left corner of the crop rectangule
     * @param string $gravity The initial placement of the crop rectangule
     *
     * @return PhMagick
     */
    public function crop(PhMagick $p, $width, $height, $top = 0, $left = 0, $gravity = Gravity::Center)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' ' . $p->getSource();

        if (($gravity != '') || ($gravity != Gravity::None)) {
            $cmd .= ' -gravity ' . $gravity;
        }

        $cmd .= ' -crop ' . (int)$width . 'x' . (int)$height;
        $cmd .= '+' . $left . '+' . $top;
        $cmd .= ' ' . $p->getDestination();

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}
