<?php
namespace PhMagick\Adapter;

use PhMagick\PhMagick;

class Color extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Color';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'darken',
            'brighten',
            'toGreyScale',
            'invertColors',
            'sepia',
            'autoLevels',
        );
    }

    /**
     * Makes current image darker.
     *
     * @param PhMagick $p
     * @param int $alphaValue
     *
     * @return PhMagick
     */
    function darken(PhMagick $p, $alphaValue = 50)
    {
        $percent = 100 - (int)$alphaValue;

        // Get original file dimensions.
        list ($width, $height) = $p->getInfo();

        $cmd = $p->getBinary('composite');
        $cmd .= ' -blend  ' . $percent . ' ';
        $cmd .= '"' . $p->getSource() . '"';
        $cmd .= ' -size ' . $width . 'x' . $height . ' xc:black ';
        $cmd .= '-matte "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Brightens current image, default: 50%.
     *
     * 100%: white , 0%: original color (no change)
     *
     * @param PhMagick $p
     * @param int $alphaValue
     *
     * @return PhMagick
     */
    function brighten(PhMagick $p, $alphaValue = 50)
    {
        $percent = 100 - (int)$alphaValue;

        // Get original file dimensions.
        list ($width, $height) = $p->getInfo();

        $cmd = $p->getBinary('composite');
        $cmd .= ' -blend  ' . $percent . ' ';
        $cmd .= '"' . $p->getSource() . '"';
        $cmd .= ' -size ' . $width . 'x' . $height . ' xc:white ';
        $cmd .= '-matte "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Convert current image to grey scale.
     *
     * @param PhMagick $p
     * @param int $enhance
     *
     * @return PhMagick
     */
    function toGreyScale(PhMagick $p, $enhance = 2)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -modulate 100,0 ';
        $cmd .= ' -sigmoidal-contrast ' . $enhance . 'x50%';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Inverts the image colors.
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    function invertColors(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $p->getSource() . '"';
        $cmd .= ' -negate ';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Applies sepia filter to current image.
     *
     * @param PhMagick $p
     * @param int $tone
     *
     * @return PhMagick
     */
    function sepia(PhMagick $p, $tone = 90)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -sepia-tone ' . $tone . '% ';
        $cmd .= ' -modulate 100,50 ';
        $cmd .= ' -normalize ';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * autoLevels.
     *
     * Normalization of image.
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    function autoLevels(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -normalize ';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}
