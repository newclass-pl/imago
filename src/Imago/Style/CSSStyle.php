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
namespace Imago\Style;


use Imago\StyleInterface;

/**
 * Class CSSStyle
 * @package Imago\Style
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class CSSStyle implements StyleInterface
{

    /**
     * @var mixed[][]
     */
    private $files=[];
    /**
     * @var string
     */
    private $imagePath;

    /**
     * @param string $path
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     */
    public function addFile($path, $width,$height, $x, $y){
        $this->files[]=compact('path','width','height','x','y');
    }

    /**
     * @param string $path
     */
    public function setImagePath($path){
        $this->imagePath=$path;
    }

    /**
     * @param string $path
     */
    public function save($path){
        $code='';
        $classes=[];
        foreach($this->files as $file){
            $code.=$this->generateBegin($file,$classes);
            $code.=$this->generateBody($file);
            $code.=$this->generateEnd();
        }

        file_put_contents($path,$code);
    }

    /**
     * @param string $text
     * @return string
     */
    public function slug($text)
    {
        //FIXME not supported for all location

        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        $text = preg_replace('~[^-\w]+~', '', $text);

        $text = trim($text, '-');

        $text = preg_replace('~-+~', '-', $text);

        $text = strtolower($text);

        if (empty($text)) {
            return '';
        }

        return $text;
    }

    /**
     * @param string $slug
     * @param string[] $classes
     * @return string
     */
    private function getUniqueName($slug, $classes)
    {
        foreach($classes as $class){
            if($slug!==$class){
                continue;
            }
            return $this->getUniqueName($slug.'_',$classes);
        }

        return $slug;
    }

    /**
     * @param mixed[] $file
     * @param string[] $classes
     * @return string
     */
    private function generateBegin($file, $classes)
    {
        $fileName=pathinfo($file['path'],PATHINFO_FILENAME);
        $className=$this->getUniqueName($this->slug($fileName),$classes);
        $classes[]=$className;

        return ".".$className."{\n";
    }

    /**
     * @param mixed[] $file
     * @return string
     */
    private function generateBody(array $file)
    {
        $code="";

        $code.="    background: url('".$this->imagePath."') no-repeat\n";
        $code.="    background-position: ".$file['x']."px ".$file['y']."\n";
        $code.="    width: ".$file['width']."px;\n";
        $code.="    height: ".$file['height']."px;\n";
        $code.="    display: inline-block;\n";

        return $code;
    }

    /**
     * @return string
     */
    private function generateEnd()
    {
        return "}\n\n";
    }
}