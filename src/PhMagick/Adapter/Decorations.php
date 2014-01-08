<?php
namespace PhMagick\Adapter;

use PhMagick\PhMagick;
use PhMagick\TextObject;

class Decorations extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Decorations';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'roundCorners',
            'dropShadow',
            'glow',
            'fakePolaroid',
            'polaroid',
            'border',
        );
    }

    /**
     * Create round corners and apply to current image.
     *
     * @param PhMagick $p
     * @param int $i Radius to use.
     *
     * @return PhMagick
     */
    public function roundCorners(PhMagick $p, $i = 15)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $p->getSource() . '"';
        $cmd .= ' ( +clone  -threshold -1 ';
        $cmd .= "-draw \"fill black polygon 0,0 0,$i $i,0 fill white circle $i,$i $i,0\" ";
        $cmd .= '( +clone -flip ) -compose Multiply -composite ';
        $cmd .= '( +clone -flop ) -compose Multiply -composite ';
        $cmd .= ') +matte -compose CopyOpacity -composite ';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Create a drop shadow on current image.
     *
     * @param PhMagick $p
     * @param string $color
     * @param int $offset
     * @param int $transparency
     * @param int $top
     * @param int $left
     *
     * @return PhMagick
     */
    public function dropShadow(PhMagick $p, $color = '#000000', $offset = 4, $transparency = 60, $top = 4, $left = 4)
    {
        $top = $top > 0 ? '+' . $top : $top;
        $left = $left > 0 ? '+' . $left : $left;

        $cmd = $p->getBinary('convert');
        $cmd .= ' -page ' . $top . $left . ' "' . $p->getSource() . '"';
        $cmd .= ' -matte ( +clone -background "' . $color . '" -shadow ' . $transparency . 'x4+' . $offset . '+' . $offset . ' ) +swap ';
        $cmd .= ' -background none -mosaic ';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Create a glow effect.
     *
     * @param PhMagick $p
     * @param string $color
     * @param int $offset
     * @param int $transparency
     *
     * @return PhMagick
     */
    public function glow(PhMagick $p, $color = '#827f00', $offset = 10, $transparency = 60)
    {
        list ($w, $h) = $p->getInfo($p->getSource());

        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $p->getSource() . '" ';
        $cmd .= '( +clone  -background "' . $color . '"  -shadow ' . $transparency . 'x' . $offset . '-' . ($offset / 4) . '+' . ($offset / 4) . ' ) +swap -background none   -layers merge  +repage  ';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Fake polaroid effect (white border and rotation)
     *
     * @param PhMagick $p
     * @param int $rotate         The Image will be rotated n degrees.
     * @param string $borderColor Drop shadow color.
     * @param string $background  Image background color (use for jpegs or images
     *                            that do not support transparency or you will
     *                            end up with a black background).
     *
     * @return PhMagick
     */
    public function fakePolaroid(PhMagick $p, $rotate = 6, $borderColor = "#fff", $background = "none")
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $p->getSource() . '"';
        $cmd .= ' -bordercolor "' . $borderColor . '"  -border 6 -bordercolor grey60 -border 1 -background  "none"   -rotate ' . $rotate . ' -background  black  ( +clone -shadow 60x4+4+4 ) +swap -background  "' . $background . '"   -flatten';
        $cmd .= ' ' . $p->getDestination();

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Real polaroid efect, supports text
     *
     * @param PhMagick $p
     * @param null $format         Text format for image label.
     * @param int $rotation        The image will be rotated n degrees
     * @param string $borderColor  Polaroid border (usually white)
     * @param string $shaddowColor Drop shadow color.
     * @param string $background   Image background color (use for jpegs or
     *                             images that do not support transparency or
     *                             you will end up with a black background)
     *
     * @return PhMagick
     */
    public function polaroid(PhMagick $p, $format = null, $rotation = 6, $borderColor = "snow", $shaddowColor = "black", $background = "none")
    {
        if ('TextObject' != get_class($format)) {
            $tmp = new TextObject();
            $tmp->setText($format);
            $format = $tmp;
        }

        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $p->getSource() . '"';

        if ($format->getBackground() !== false) {
            $cmd .= ' -background "' . $format->getBackground() . '"';
        }

        if ($format->getColor() !== false) {
            $cmd .= ' -fill "' . $format->getColor() . '"';
        }

        if ($format->getFont() !== false) {
            $cmd .= ' -font ' . $format->getFont();
        }

        if ($format->getFontSize() !== false) {
            $cmd .= ' -pointsize ' . $format->getFontSize();
        }

        if ($format->getGravity() !== false) {
            $cmd .= ' -gravity ' . $format->getGravity();
        }

        if ($format->getText() != '') {
            $cmd .= ' -set caption "' . $format->getText() . '"';
        }

        $cmd .= ' -bordercolor "' . $borderColor . '" -background "' . $background . '" -polaroid ' . $rotation . ' -background "' . $background . '" -flatten ';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Create a border around current image.
     *
     * @param PhMagick $p
     * @param string $borderColor
     * @param string $borderSize
     *
     * @return PhMagick
     */
    public function border(PhMagick $p, $borderColor = "#000", $borderSize = "1")
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $p->getSource() . '"';
        $cmd .= ' -bordercolor "' . $borderColor . '"  -border ' . $borderSize;
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}
