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

/**
 * Class FileInfo
 * @package Imago
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FileInfo
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
     * @var string
     */
    private $mime;
    /**
     * @var string
     */
    private $type;
    /**
     * @return string
     */
    private $path;

    /**
     * FileInfo constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $info = getimagesize($path);
        $this->width = $info[0];
        $this->height = $info[1];
        $this->mime = $info['mime'];
        $this->type = $this->detectType($this->mime);
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $mime
     * @return string
     */
    private function detectType($mime)
    {
        return ltrim($mime, 'image/');
    }

    /**
     * @param int $width
     * @return FileInfo
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @param int $height
     * @return FileInfo
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

}