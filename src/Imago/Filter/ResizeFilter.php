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

/**
 * Class ResizeFilter
 * @package Imago\Filter
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class ResizeFilter implements FilterInterface
{

    /**
     * @var int
     */
    private $width;
    /**
     * @var int
     */
    private $height;

    /**
     * @param $resource
     * @param FileInfo $fileInfo
     * @return resource
     */
    public function execute($resource, FileInfo $fileInfo)
    {
        $width = $this->width;
        if ($width === null) {
            $width = $fileInfo->getWidth();
        }

        $height = $this->height;
        if ($height === null) {
            $height = $fileInfo->getWidth();
        }

        $container = imagecreatetruecolor($width, $height);
        imagealphablending($container, false);
        imagesavealpha($container, true);

        imagecopyresized($container, $resource, 0, 0, 0, 0, $width, $height, $fileInfo->getWidth(), $fileInfo->getHeight());

        $fileInfo->setWidth($width);
        $fileInfo->setHeight($height);
        return $container;

    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }
}