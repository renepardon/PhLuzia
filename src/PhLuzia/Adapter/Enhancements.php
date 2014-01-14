<?php

namespace PhLuzia\Adapter;

use PhLuzia\Command;
use PhLuzia\Service\PhLuzia;

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
 * @package    PhLuzia/Adapter
 * @author     Christoph, René Pardon <christoph@renepardon.de>
 * @copyright  2014 by Christoph, René Pardon
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt
 * @version    1.0
 * @link       https://github.com/renepardon/PhLuzia
 * @since      2013-01-09
 */
class Enhancements extends AdapterAbstract
{
    /**
     * Removes noise like Photoshop does.
     *
     * @param int $amount
     *
     * @return PhLuzia
     */
    public function denoise($amount = 1)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-noise %d', $amount)
            ->addOption('-background "none" "%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Sharpening is a the computer graphics algorithm that is most often see
     * on TV shows and movies. Picture the police force 'cleaning up' a
     * 'zoomed in' photo of a licence plate of a bank robbers car, or the face
     * of a man on a fuzzy shop camera video, and you see what I mean.
     *
     * @param int $amount
     *
     * @return PhLuzia
     */
    public function sharpen($amount = 10)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-sharpen 2x%d', $amount)
            ->addOption('-background "none" "%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Chip the edges within current image.
     *
     * @return PhLuzia
     */
    public function smooth()
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-despeckle -despeckle -despeckle')
            ->addOption('-background "none" "%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Change saturation of current image through provided amount for the
     * saturation.
     *
     * A saturation of '0' will produce a grayscale image. The gray however
     * mixes all three color channels equally, as defined by the HSL
     * colorspace, as such does not produce a true 'intensity' grayscale.
     *
     * @param int $amount
     *
     * @return PhLuzia
     */
    public function saturate($amount = 200)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-modulate 100,%d', $amount)
            ->addOption('-background "none" "%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * The result is a non-linear, smooth contrast change (a 'Sigmoidal Function'
     * in mathematical terms) over the whole color range, preserving the white
     * and black colors, much better for photo color adjustments.
     *
     * The exact formula from the paper is very complex, and even has a mistake,
     * but essentially requires with two adjustment values. A threshold level
     * for the contrast function to center on (typically centered at '50%'),
     * and a contrast factor ('10' being very high, and '0.5' very low).
     *
     * @param int $amount The contrast factor. ('10' being very high, and '0.5'
     *                    very low)
     *
     * @return PhLuzia
     */
    public function contrast($amount = 10)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-sigmoidal-contrast %dx50%%', $amount)
            ->addOption('-background "none" "%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     *
     *
     * @param int $amount
     *
     * @return PhLuzia
     */
    public function adaptiveSharpen($amount = 10)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-adaptive-sharpen 2x%d', $amount)
            ->addOption('-background "none" "%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Extract only the edges of image.
     *
     * @param int $edge
     *
     * @return PhLuzia
     */
    public function edges($edge = 2)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"', $this->service->getSource());
        $cmd->addOption('-colorspace gray')
            ->addOption('-edge %d', $edge)
            ->addOption('-background black')
            ->addOption('-flatten')
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }
}