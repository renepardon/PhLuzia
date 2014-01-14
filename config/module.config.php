<?php

namespace PhLuzia;

/**
 * How does GraphicsMagick differ from ImageMagick? (Copied from
 * http://www.graphicsmagick.org/FAQ.html)
 *
 * GraphicsMagick is originally based on (forked from) ImageMagick 5.5.2 in
 * November 2002, from the version distributed by ImageMagick Studio LLC, which
 * is itself forked in August 1999 from ImageMagick developed by E. I. du Pont
 * de Nemours and Company starting in 1992. Other than utilities being executed
 * as sub-commands of the 'gm' command, the command-line syntax and programming
 * APIs remain entirely upward compatible with ImageMagick 5.5.2. A better
 * question might be "How does ImageMagick differ from ImageMagick?" since
 * ImageMagick continues to alter and evolve its interfaces so they are no
 * longer completely compatible with earlier versions. While GraphicsMagick also
 * adds new features, it does so in a way which assures that existing features
 * work as they did before. ImageMagick focuses on adding new functionality and
 * features and has dramatically mutated several times since the fork.
 *
 * GraphicsMagick maintains a stable release branch, maintains a detailed
 * ChangeLog, and maintains a stable source repository with complete version
 * history so that changes are controlled, and changes between releases are
 * accurately described. GraphicsMagick provides continued support for a
 * release branch. ImageMagick does not offer any of these things.
 *
 * Since GraphicsMagick is more stable, more time has been spent optimizing and
 * debugging its code.
 *
 * GraphicsMagick is much smaller than ImageMagick and has dramatically fewer
 * dependencies on external libraries. For example, on the FreeBSD operating
 * system, a fully-featured install of GraphicsMagick depends on 36 libraries
 * whereas ImageMagick requires 64. GraphicsMagick's installation footprint
 * is 3-5X smaller than ImageMagick.
 *
 * GraphicsMagick is usually faster than ImageMagick. The baseline execution
 * overhead for simple commands is much lower, and GraphicsMagick is also
 * more efficient at dealing with large images.
 *
 */
// Defines which library to use.
define('PHLUZIA_LIBRARY_IMAGEMAGICK', 'imagemagick');
define('PHLUZIA_LIBRARY_GRAPHICSMAGICK', 'graphicsmagick');

return array(
    'phluzia' => array(
        /**
         * Decide which library to use. We use the faster and more
         * lightweight GraphicsMagick library per default.
         */
        'library' => PHLUZIA_LIBRARY_IMAGEMAGICK,

        /**
         * This array contains default configuration options for the PhLuzia
         * service/library.
         */
        'defaults' => array(
            // @todo move configurable options (defaults) from implementation to
            // this configuration. For example the image quality, default sizes, etc.
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'phluzia' => 'PhLuzia\Service\PhLuziaFactory',
        ),
    ),
);
