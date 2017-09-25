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
 * Class ResizeCanvasFilter
 * @package Imago\Filter
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class ResizeCanvasFilter implements FilterInterface
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
     * @var int
     */
    private $positionMode;
    /**
     * @var int
     */
    private $positionX;
    /**
     * @var int
     */
    private $positionY;

    const POSITION_CENTER=1;
    const POSITION_TOP_LEFT=2;
    const POSITION_TOP_RIGHT=3;
    const POSITION_BOTTOM_LEFT=4;
    const POSITION_BOTTOM_RIGHT=5;
    const POSITION_CUSTOM=6;

    public function __construct()
    {
        $this->positionMode=self::POSITION_CENTER;
    }

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
            $height = $fileInfo->getHeight();
        }

        $container = imagecreatetruecolor($width, $height);
        imagealphablending($container, false);
        imagesavealpha($container, true);

        $black = imagecolorallocatealpha($container, 0, 0, 0,127);//TODO detect background color from orig image
        imagefill($container,0,0,$black);


        list($positionX,$positionY)=$this->getPosition($fileInfo,$width,$height);

        imagecopy($container, $resource, $positionX, $positionY, 0, 0, $fileInfo->getWidth(), $fileInfo->getHeight());

        $fileInfo->setWidth($width);
        $fileInfo->setHeight($height);
        imagedestroy($resource);
        return $container;

    }

    /**
     * @param int $x
     * @param int $y
     */
    public function setPosition($x,$y)
    {
        $this->positionX = $x;
        $this->positionY=$y;
        $this->positionMode=self::POSITION_CUSTOM;
    }

    /**
     *
     */
    public function setPositionTopLeft()
    {
        $this->positionMode=self::POSITION_TOP_LEFT;
    }

    /**
     *
     */
    public function setPositionTopRight()
    {
        $this->positionMode=self::POSITION_TOP_RIGHT;
    }

    /**
     *
     */
    public function setPositionBottomLeft()
    {
        $this->positionMode=self::POSITION_BOTTOM_LEFT;
    }

    /**
     *
     */
    public function setPositionBottomRight()
    {
        $this->positionMode=self::POSITION_BOTTOM_RIGHT;
    }

    /**
     *
     */
    public function setPositionCenter()
    {
        $this->positionMode=self::POSITION_CENTER;
    }

    /**
     * @param int $width
     */
    public function setWidth($width){
        $this->width=$width;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    private function getPosition(FileInfo $fileInfo,$width,$height)
    {
        switch ($this->positionMode){
            case self::POSITION_CENTER:
                $x=$width/2-$fileInfo->getWidth()/2;
                $y=$height/2-$fileInfo->getHeight()/2;
                return [$x,$y];
            case self::POSITION_TOP_LEFT:
                $x=0;
                $y=0;
                return [$x,$y];
            case self::POSITION_TOP_RIGHT:
                $x=$width-$fileInfo->getWidth();
                $y=0;
                return [$x,$y];
            case self::POSITION_BOTTOM_LEFT:
                $x=0;
                $y=$height-$fileInfo->getHeight();
                return [$x,$y];
            case self::POSITION_BOTTOM_RIGHT:
                $x=$width-$fileInfo->getWidth();
                $y=$height-$fileInfo->getHeight();
                return [$x,$y];
            case self::POSITION_CUSTOM:
                $x=$this->positionX;
                $y=$this->positionY;
                return [$x,$y];
        }

        throw new \Exception('Not Supported mode '.$this->positionMode);
    }

}