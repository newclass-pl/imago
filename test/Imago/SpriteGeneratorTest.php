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
use Imago\Filter\CropFilter;
use Imago\SpriteGenerator;

/**
 * Class SpriteGeneratorTest
 * @package Test
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class SpriteGeneratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SpriteGenerator
     */
    private $spriteGenerator;

    /**
     *
     */
    public function setUp(){
        $this->spriteGenerator=new SpriteGenerator();
        $this->spriteGenerator->addFile(realpath(__DIR__).'/../asset/1.png');
        $this->spriteGenerator->addDir(realpath(__DIR__).'/../asset/sprite');
    }

    /**
     *
     */
    public function testSave(){

        $outputImage=realpath(__DIR__).'/../asset/output_sprite.png';
        $outputCss=realpath(__DIR__).'/../asset/output.css';
        $this->spriteGenerator->save($outputImage,$outputCss);

        $info=getimagesize($outputImage);
        $this->assertEquals('image/png',$info['mime']);
        $this->assertEquals(2188,$info[0]);
        $this->assertEquals(1024,$info[1]);

    }

    /**
     *
     */
    public function testFilter(){
        $outputImage=realpath(__DIR__).'/../asset/output_sprite.png';
        $outputCss=realpath(__DIR__).'/../asset/output.css';
        $this->spriteGenerator->addFilter(new CropFilter());
        $this->spriteGenerator->save($outputImage,$outputCss);

        $info=getimagesize($outputImage);
        $this->assertEquals('image/png',$info['mime']);
        $this->assertEquals(2172,$info[0]);
        $this->assertEquals(1023,$info[1]);

    }

}