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

namespace Test;

use Imago\FileInfo;
use Imago\Filter\ResizeCanvasFilter;
use PHPUnit_Framework_TestCase;

/**
 * Class ConverterTest
 * @package Test
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class ResizeCanvasFilterTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ResizeCanvasFilter
     */
    private $filter;
    /**
     * @var FileInfo
     */
    private $fileInfo;
    /**
     * @var resource
     */
    private $resource;

    /**
     *
     */
    public function setUp()
    {
        $this->filter = new ResizeCanvasFilter();
        $this->fileInfo = new FileInfo(realpath(__DIR__).'/../../asset/1.png');
        $this->resource = imagecreatefrompng($this->fileInfo->getPath());
    }

    /**
     *
     */
    public function testWidth()
    {

        $output = realpath(__DIR__).'/../../asset/output.png';
        $this->filter->setWidth(1000);
        $resource = $this->filter->execute($this->resource, $this->fileInfo);

        $stream = fopen($output, 'w');
        imagepng($resource, $stream);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);
        $this->assertEquals(1000, $info[0]);
        $this->assertEquals(270, $info[1]);

    }

    /**
     *
     */
    public function testHeight()
    {

        $output = realpath(__DIR__).'/../../asset/output.png';
        $this->filter->setHeight(1000);
        $resource = $this->filter->execute($this->resource, $this->fileInfo);

        $stream = fopen($output, 'w');
        imagepng($resource, $stream);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);
        $this->assertEquals(500, $info[0]);
        $this->assertEquals(1000, $info[1]);

    }

    /**
     *
     */
    public function testTopLeftMode()
    {

        $output = realpath(__DIR__).'/../../asset/output.png';
        $this->filter->setWidth(1000);
        $this->filter->setHeight(1000);
        $this->filter->setPositionTopLeft();
        $resource = $this->filter->execute($this->resource, $this->fileInfo);

        $stream = fopen($output, 'w');
        imagepng($resource, $stream);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);

    }

    /**
     *
     */
    public function testTopRightMode()
    {

        $output = realpath(__DIR__).'/../../asset/output.png';
        $this->filter->setWidth(1000);
        $this->filter->setHeight(1000);
        $this->filter->setPositionTopRight();
        $resource = $this->filter->execute($this->resource, $this->fileInfo);

        $stream = fopen($output, 'w');
        imagepng($resource, $stream);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);

    }

    /**
     *
     */
    public function testBottomLeftMode()
    {

        $output = realpath(__DIR__).'/../../asset/output.png';
        $this->filter->setWidth(1000);
        $this->filter->setHeight(1000);
        $this->filter->setPositionBottomLeft();
        $resource = $this->filter->execute($this->resource, $this->fileInfo);

        $stream = fopen($output, 'w');
        imagepng($resource, $stream);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);

    }

    /**
     *
     */
    public function testBottomRightMode()
    {

        $output = realpath(__DIR__).'/../../asset/output.png';
        $this->filter->setWidth(1000);
        $this->filter->setHeight(1000);
        $this->filter->setPositionBottomRight();
        $resource = $this->filter->execute($this->resource, $this->fileInfo);

        $stream = fopen($output, 'w');
        imagepng($resource, $stream);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);

    }

    /**
     *
     */
    public function testCustomPosition()
    {

        $output = realpath(__DIR__).'/../../asset/output.png';
        $this->filter->setWidth(1000);
        $this->filter->setHeight(1000);
        $this->filter->setPosition(300, 200);
        $resource = $this->filter->execute($this->resource, $this->fileInfo);

        $stream = fopen($output, 'w');
        imagepng($resource, $stream);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);
    }

    /**
     *
     */
    public function testCenterPosition()
    {

        $output = realpath(__DIR__).'/../../asset/output.png';
        $this->filter->setWidth(1000);
        $this->filter->setHeight(1000);
        $this->filter->setPositionCenter();
        $resource = $this->filter->execute($this->resource, $this->fileInfo);

        $stream = fopen($output, 'w');
        imagepng($resource, $stream);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);
    }

}