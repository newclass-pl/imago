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

namespace Imago;


use Imago\Filter\CropFilter;
use Imago\Filter\ResizeFilter;

class Converter
{
    /**
     * @var FileInfo
     */
    private $fileInfo;

    /**
     * @var FilterInterface[]
     */
    private $filters = [];

    /**
     * Converter constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->fileInfo = new FileInfo($path);
    }

    public function resizeWidth($width)
    {
        $filter = new ResizeFilter();
        $filter->setWidth($width);
        $this->filters[] = $filter;
    }

    public function resizeHeight($height)
    {
        $filter = new ResizeFilter();
        $filter->setHeight($height);
        $this->filters[] = $filter;
    }

    public function autoCrop()
    {
        $filter = new CropFilter();
        $this->filters[] = $filter;
    }

    public function save($path)
    {

        $resource = $this->execute();

        $parts = explode('.', $path);
        $extension = end($parts);

        $output = fopen($path, 'w');

        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($resource, $output);
                return;
            case 'gif':
                imagegif($resource, $output);
                return;
            case 'png':
                imagepng($resource, $output);
                return;
            case 'bmp':
                imagewbmp($resource, $output);
                return;
        }

        throw new TypeNotSupportedException($extension);
    }

    private function execute()
    {
        $resource = $this->createResource();

        foreach ($this->filters as $filter) {
            $resource = $filter->execute($resource, $this->fileInfo);
        }

        return $resource;

    }

    private function createResource()
    {
        switch ($this->fileInfo->getType()) {
            case 'png';
                return imagecreatefrompng($this->fileInfo->getPath());
            case 'jpg':
            case 'jpeg':
                return imagecreatefromjpeg($this->fileInfo->getPath());
            case 'gif':
                return imagecreatefromgif($this->fileInfo->getPath());
            case 'bmp':
                return imagecreatefromwbmp($this->fileInfo->getPath());
        }

        throw new TypeNotSupportedException($this->fileInfo->getType());
    }


}