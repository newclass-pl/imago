README
======

![license](https://img.shields.io/packagist/l/bafs/via.svg?style=flat-square)
![PHP 5.5+](https://img.shields.io/badge/PHP-5.5+-brightgreen.svg?style=flat-square)

What is Imago?
-----------------

Imago is a PHP library to convert image and generate sprite. Support filters:
- resize
- auto crop
- resize canvas

Installation
------------

The best way to install is to use the composer by command:

composer require newclass/imago

composer install

Use converter example
------------

    use Imago\Converter;
    use Imago\Filter\ResizeFilter;

    $converter=new Converter('image.png');
    $filter=new ResizeFilter();
    $filter->setWidth(200);
    $filter->setHeight(300);
    $converter->addFilter($filter);
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
