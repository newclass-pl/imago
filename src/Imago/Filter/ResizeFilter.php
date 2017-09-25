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
    const RATIO_HEIGHT = 'height';
    const RATIO_WIDTH = 'width';
    /**
     * @var int
     */
    private $width;
    /**
     * @var int
     */
    private $height;
    /**
     * @var string
     */
    private $ratio;

    /**
     * @param resource $resource
     * @param FileInfo $fileInfo
     * @return resource
     * @throws \Exception
     */
    public function execute($resource, FileInfo $fileInfo)
    {
        $width = $this->width;
        $height = $this->height;

        if($this->ratio===null){
            if ($width === null) {
                $width = $fileInfo->getWidth();
            }

            if ($height === null) {
                $height = $fileInfo->getHeight();
            }
        }
        else if ($this->ratio===static::RATIO_WIDTH){
            if(!$width){
                throw new FilterException('Required width value. Use setWidth');
            }
            $ratio=$fileInfo->getHeight()/$fileInfo->getWidth();
            $height=$width*$ratio;
        }
        else if ($this->ratio===static::RATIO_HEIGHT){
            if(!$height){
                throw new FilterException('Required height value. Use setHeight');
            }
            $ratio=$fileInfo->getWidth()/$fileInfo->getHeight();
            $width=$height*$ratio;
        }

        $container = imagecreatetruecolor($width, $height);
        imagealphablending($container, false);
        imagesavealpha($container, true);

        imagecopyresampled($container, $resource, 0, 0, 0, 0, $width, $height, $fileInfo->getWidth(), $fileInfo->getHeight());

        $fileInfo->setWidth($width);
        $fileInfo->setHeight($height);
        imagedestroy($resource);
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

    public function setRatioBy($ratio)
    {
        $this->ratio=$ratio;
    }
}