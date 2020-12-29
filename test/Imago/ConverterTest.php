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

use Imago\Converter;

/**
 * Class ConverterTest
 * @package Test
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class ConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Converter
     */
    private $converter;

    /**
     *
     */
    public function setUp()
    {
        $this->converter = new Converter(realpath(__DIR__).'/../asset/1.png');
    }

    /**
     *
     */
    public function testSaveJPG()
    {

        $output = realpath(__DIR__).'/../asset/output.jpg';
        $this->converter->resizeWidth(100);
        $this->converter->resizeHeight(200);
        $this->converter->save($output);

        $info = getimagesize($output);
        $this->assertEquals('image/jpeg', $info['mime']);

    }

    /**
     *
     */
    public function testSavePNG()
    {

        $output = realpath(__DIR__).'/../asset/output.png';
        $this->converter->resizeWidth(100);
        $this->converter->resizeHeight(200);
        $this->converter->save($output);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);

    }

    /**
     *
     */
    public function testSaveBMP()
    {

        $output = realpath(__DIR__).'/../asset/output.bmp';
        $this->converter->resizeWidth(100);
        $this->converter->resizeHeight(200);
        $this->converter->save($output);

        $info = getimagesize($output);
        $this->assertEquals('image/vnd.wap.wbmp', $info['mime']);

    }

    /**
     *
     */
    public function testSaveGIF()
    {

        $output = realpath(__DIR__).'/../asset/output.gif';
        $this->converter->resizeWidth(100);
        $this->converter->resizeHeight(200);
        $this->converter->save($output);

        $info = getimagesize($output);
        $this->assertEquals('image/gif', $info['mime']);

    }

    /**
     *
     */
    public function testSaveWebp()
    {
        $output = realpath(__DIR__).'/../asset/output.webp';
        $this->converter->resizeWidth(100);
        $this->converter->resizeHeight(200);
        $this->converter->save($output);

        $info = getimagesize($output);
        $this->assertEquals('image/webp', $info['mime']);

    }

    /**
     *
     */
    public function testResizeWidth()
    {
        $output = realpath(__DIR__).'/../asset/output.jpg';
        $this->converter->resizeWidth(2000);

        $this->converter->save($output);
        $info = getimagesize($output);
        $this->assertEquals(2000, $info[0]);

    }

    /**
     *
     */
    public function testResizeHeight()
    {
        $output = realpath(__DIR__).'/../asset/output.jpg';
        $this->converter->resizeHeight(2000);

        $this->converter->save($output);
        $info = getimagesize($output);
        $this->assertEquals(2000, $info[1]);

    }

    /**
     *
     */
    public function testGetWidth()
    {
        $this->assertEquals(500, $this->converter->getWidth());
    }

    /**
     *
     */
    public function testGetHeight()
    {
        $this->assertEquals(270, $this->converter->getHeight());
    }

    /**
     *
     */
    public function testAutoCrop()
    {
        $output = realpath(__DIR__).'/../asset/output.png';
        $this->converter->autoCrop();

        $this->converter->save($output);
        $info = getimagesize($output);
        $this->assertEquals(486, $info[0]);
        $this->assertEquals(255, $info[1]);

    }

}