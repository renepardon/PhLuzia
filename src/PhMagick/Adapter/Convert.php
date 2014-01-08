<?php
namespace PhMagick\Adapter;

use PhMagick\PhMagick;

class Convert extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Convert';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'convert',
        );
    }

    /**
     * Converts from one format to another.
     *
     * Use the convert program to convert between image formats as well as
     * resize an image, blur, crop, despeckle, dither, draw on, flip, join,
     * re-sample, and much more. See Command Line Processing for advice on how
     * to structure your convert command or see below for example usages of
     * the command.
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    public function convert(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -quality ' . $p->getImageQuality();
        $cmd .= ' "' . $p->getSource() . '"  "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}
