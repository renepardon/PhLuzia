<?php
namespace PhMagick\Adapter;

use PhMagick\PhMagick;

class Enhancements extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Enhancements';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'denoise',
            'sharpen',
            'smooth',
            'saturate',
            'contrast',
            'edges',
        );
    }

    /**
     *
     *
     * @param PhMagick $p
     * @param int $amount
     *
     * @return PhMagick
     */
    public function denoise(PhMagick $p, $amount = 1)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -noise ' . $amount;
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     *
     *
     * @param PhMagick $p
     * @param int $amount
     *
     * @return PhMagick
     */
    public function sharpen(PhMagick $p, $amount = 10)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -sharpen 2x' . $amount;
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     *
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    public function smooth(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -despeckle -despeckle -despeckle ';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     *
     *
     * @param PhMagick $p
     * @param int $amount
     *
     * @return PhMagick
     */
    public function saturate(PhMagick $p, $amount = 200)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -modulate 100,' . $amount;
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     *
     *
     * @param PhMagick $p
     * @param int $amount
     *
     * @return PhMagick
     */
    public function contrast(PhMagick $p, $amount = 10)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -sigmoidal-contrast ' . $amount . 'x50%';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     *
     *
     * @param PhMagick $p
     * @param int $amount
     *
     * @return PhMagick
     */
    public function edges(PhMagick $p, $amount = 10)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -adaptive-sharpen 2x' . $amount;
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}