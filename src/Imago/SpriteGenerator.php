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


use Imago\Output\FileOutput;
use Imago\Style\CSSStyle;

/**
 * Class SpriteGenerator
 * @package Imago
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class SpriteGenerator
{

    /**
     * @var string[]
     */
    private $files = [];
    /**
     * @var string[]
     */
    private $supportedExtensions = [
        'png',
        'bmp',
        'gif',
        'jpg',
        'jpeg',
    ];
    /**
     * @var FilterInterface[]
     */
    private $filters = [];
    /**
     * @var StyleInterface
     */
    private $style;

    /**
     * @param StyleInterface $style
     */
    public function setStyle(StyleInterface $style)
    {
        $this->style = $style;
    }

    /**
     * @param string $path
     * @throws FileNotSupportedException
     */
    public function addFile($path)
    {
        if (!$this->isAcceptFile($path)) {
            throw new FileNotSupportedException();
        }
        $this->files[] = $path;
    }

    /**
     * @param string $path
     */
    public function addDir($path)
    {
        $oDir = opendir($path);
        try {
            while ($file = readdir($oDir)) {
                $filePath = $path.'/'.$file;
                if ($file === '..' || $file === '.' || !$this->isAcceptFile($filePath)) {
                    continue;
                }
                $this->files[] = $filePath;
            }
        } finally {
            closedir($oDir);
        }
    }

    /**
     * @param string $filePath
     * @param string $cssPath
     * @throws TypeNotSupportedException
     */
    public function save($filePath, $cssPath)
    {
        $style = $this->getStyle($filePath);
        $resource = $this->concat($style);

        $output = new FileOutput($filePath);
        $output->save($resource);

        $style->save($cssPath);
    }

    /**
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @param string $path
     * @return bool
     */
    private function isAcceptFile($path)
    {
        $info = getimagesize($path);

        $type = ltrim($info['mime'], 'image/');

        return in_array($type, $this->supportedExtensions, true);
    }

    /**
     * @param StyleInterface $cssGenerator
     * @return resource
     * @throws TypeNotSupportedException
     */
    private function concat(StyleInterface $cssGenerator)
    {

        $width = 0;
        $height = 0;
        $prepareFiles = [];
        foreach ($this->files as $file) {
            $info = new FileInfo($file);
            $resource = $this->createResource($info);
            $resource = $this->convert($resource, $info);
            $prepareFiles[] = compact('info', 'resource');

            $width += $info->getWidth();
            if ($height < $info->getHeight()) {
                $height = $info->getHeight();
            }
        }
        $container = $this->createContainer($width, $height);

        $x = 0;
        $y = 0;
        foreach ($prepareFiles as $prepareFile) {
            $resource = $prepareFile['resource'];
            /**
             * @var FileInfo $fileInfo
             */
            $fileInfo = $prepareFile['info'];
            imagecopy($container, $resource, $x, $y, 0, 0, $fileInfo->getWidth(), $fileInfo->getHeight());
            $cssGenerator->addFile($fileInfo->getPath(), $fileInfo->getWidth(), $fileInfo->getHeight(), $x * -1, 0);
            $x += $fileInfo->getWidth();
        }

        return $container;

    }

    /**
     * @param int $width
     * @param int $height
     * @return resource
     */
    private function createContainer($width, $height)
    {
        $container = imagecreatetruecolor($width, $height);
        $background = imagecolorallocatealpha($container, 255, 255, 255, 127);
        imagefill($container, 0, 0, $background);
        imagealphablending($container, false);
        imagesavealpha($container, true);

        return $container;
    }

    /**
     * @param FileInfo $fileInfo
     * @return resource
     * @throws TypeNotSupportedException
     */
    private function createResource(FileInfo $fileInfo)
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
            case 'webp':
                return imagecreatefromwebp($fileInfo->getPath());
        }

        throw new TypeNotSupportedException($fileInfo->getType());
    }

    /**
     * @param resource $resource
     * @param FileInfo $fileInfo
     * @return resource
     */
    private function convert($resource, FileInfo $fileInfo)
    {
        foreach ($this->filters as $filter) {
            $resource = $filter->execute($resource, $fileInfo);
        }

        return $resource;
    }

    /**
     * @param string $path
     * @return StyleInterface
     */
    private function getStyle($path)
    {
        if ($this->style) {
            return $this->style;
        }

        $style = new CSSStyle();
        $style->setImagePath($path);

        return $style;
    }

}