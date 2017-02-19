README
======

![license](https://img.shields.io/packagist/l/bafs/via.svg?style=flat-square)
![PHP 5.5+](https://img.shields.io/badge/PHP-5.5+-brightgreen.svg?style=flat-square)

What is Imago?
-----------------

Imago is a PHP library to convert image and generate sprite. Support filters:
- resize
- auto crop

Installation
------------

The best way to install is to use the composer by command:

composer require newclass/imago

composer install

Use converter example
------------

    use Imago\Converter;

    $converter=new Converter('image.png');
    $converter->resizeWidth(200);
    $converter->resizeHeight(300);
    $converter->autoCrop();
    $converter->save('output.jpg');

Use sprite generator example
------------
    use Imago\Filter\CropFilter;
    use Imago\SpriteGenerator;

    $spriteGenerator=new SpriteGenerator();
    $spriteGenerator->addFile('file.jpg');
    $spriteGenerator->addDir('dir_with_images');
    $this->spriteGenerator->addFilter(new CropFilter());
    $this->spriteGenerator->save('output_image.png','output.css');
