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
use Imago\TypeNotSupportedException;

/**
 * Class ResizeFilter
 * @package Imago\Filter
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class MergeFilter implements FilterInterface
{
    /**
     * @var resource
     */
    private $resource;
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
    private $positionX;
    /**
     * @var int
     */
    private $positionY;
    /**
     * @var FileInfo
     */
    private $fileInfo;

    /**
     * MergeFilter constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->fileInfo = new FileInfo($path);
        $this->resource = $this->createResource($this->fileInfo);
    }

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
        $x = $this->positionX;
        $y = $this->positionY;

        if (null === $width) {
            $width = $this->fileInfo->getWidth();
        }

        if (null === $height) {
            $height = $this->fileInfo->getHeight();
        }

        if (null === $x) {
            $x = $fileInfo->getWidth() / 2 - $this->fileInfo->getWidth() / 2;
        }

        if (null === $y) {
            $y = $fileInfo->getHeight() / 2 - $this->fileInfo->getHeight() / 2;
        }

        imagecopy($resource, $this->resource, $x, $y, 0, 0, $width, $height);

        imagedestroy($this->resource);
        return $resource;

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

    /**
     * @param int $positionX
     */
    public function setPositionX($positionX)
    {
        $this->positionX = $positionX;
    }

    /**
     * @param int $positionY
     */
    public function setPositionY($positionY)
    {
        $this->positionY = $positionY;
    }

    /**
     * @param FileInfo $fileInfo
     * @return resource
     * @throws TypeNotSupportedException
     */
    private function createResource($fileInfo) //FIXME move to helper
    {
        switch ($fileInfo->getType()) {
            case 'png';
                return imagecreatefrompng($fileInfo->getPath());
            case 'jpg':
            case 'jpeg':
                return imagecreatefromjpeg($fileInfo->getPath());
            case 'gif':
                return imagecreatefromgif($fileInfo->getPath());
            case 'bmp':
                return imagecreatefromwbmp($fileInfo->getPath());
        }

        throw new TypeNotSupportedException($fileInfo->getType());
    }
}