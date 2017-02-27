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

namespace Imago\Output;


use Imago\OutputInterface;
use Imago\TypeNotSupportedException;

/**
 * Class FileOutput
 * @package Imago\Output
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FileOutput implements OutputInterface
{

    /**
     * @var string
     */
    private $path;

    /**
     * FileOutput constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param resource $resource
     * @return void
     * @throws TypeNotSupportedException
     */
    public function save($resource)
    {
        $extension = pathinfo($this->path,PATHINFO_EXTENSION);

        $output = fopen($this->path, 'w');

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
}