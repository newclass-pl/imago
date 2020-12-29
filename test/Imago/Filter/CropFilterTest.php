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
use Imago\Filter\CropFilter;

/**
 * Class ConverterTest
 * @package Test
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class CropFilterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CropFilter
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
        $this->filter = new CropFilter();
        $this->fileInfo = new FileInfo(realpath(__DIR__).'/../../asset/1.png');
        $this->resource = imagecreatefrompng($this->fileInfo->getPath());
    }

    /**
     *
     */
    public function testWidth()
    {

        $output = realpath(__DIR__).'/../../asset/output.png';
        $resource = $this->filter->execute($this->resource, $this->fileInfo);

        $stream = fopen($output, 'w');
        imagepng($resource, $stream);

        $info = getimagesize($output);
        $this->assertEquals('image/png', $info['mime']);
        $this->assertEquals(486, $info[0]);
        $this->assertEquals(255, $info[1]);

    }

}