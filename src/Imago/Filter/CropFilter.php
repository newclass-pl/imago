<?php
/**
 * Imago: Image converter
 * Copyright (c) NewClass (http://newclass.pl)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the file LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) NewClass (http://newclass.pl)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Imago\Filter;


use Imago\FileInfo;
use Imago\FilterInterface;

class CropFilter implements FilterInterface
{

    public function execute($resource, FileInfo $fileInfo)
    {
        list($x1, $x2, $y1, $y2) = $this->getPoint($fileInfo, $resource);

        $newWidth = $fileInfo->getWidth() - $x1 - ($fileInfo->getWidth() - $x2);
        $newHeight = $fileInfo->getHeight() - $y1 - ($fileInfo->getHeight() - $y2);

        $newSource = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($newSource, false);
        imagesavealpha($newSource, true);
        imagecopy($newSource, $resource, 0, 0, $x1, $y1, $newWidth, $newHeight);
        var_dump($newWidth);
        $fileInfo->setWidth($newWidth);
        $fileInfo->setHeight($newHeight);

        return $newSource;
    }

    private function getPoint(FileInfo $fileInfo, $resource)
    {

        //x1
        for ($i = 0; $i < $fileInfo->getWidth(); $i++) {
            for ($j = 0; $j < $fileInfo->getHeight(); $j++) {
                $color = imagecolorat($resource, $i, $j);
                $transparency = ($color >> 24) & 0x7F;
                if ($transparency !== 127) {
                    break 2;
                }
            }
        }

        $x1 = $i;

        //x2
        for ($i = $fileInfo->getWidth() - 1; $i > 0; $i--) {
            for ($j = 0; $j < $fileInfo->getHeight() - 1; $j++) {
                $color = imagecolorat($resource, $i, $j);
                $transparency = ($color >> 24) & 0x7F;
                if ($transparency !== 127) {
                    break 2;
                }
            }
        }

        $x2 = $i;

        //y1
        for ($i = 0; $i < $fileInfo->getHeight(); $i++) {
            for ($j = 0; $j < $fileInfo->getWidth(); $j++) {
                $color = imagecolorat($resource, $j, $i);
                $transparency = ($color >> 24) & 0x7F;
                if ($transparency !== 127) {
                    break 2;
                }
            }
        }

        $y1 = $i;

        //y2
        for ($i = $fileInfo->getHeight() - 1; $i > 0; $i--) {
            for ($j = 0; $j < $fileInfo->getWidth(); $j++) {
                $color = imagecolorat($resource, $j, $i);
                $transparency = ($color >> 24) & 0x7F;
                if ($transparency !== 127) {
                    break 2;
                }
            }
        }

        $y2 = $i;

        return [$x1, $x2, $y1, $y2];

    }
}