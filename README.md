README
======

![license](https://img.shields.io/packagist/l/bafs/via.svg?style=flat-square)
![PHP 5.5+](https://img.shields.io/badge/PHP-5.5+-brightgreen.svg?style=flat-square)

What is Imago?
-----------------

Imago is a PHP image converter. Support filters:
- resize
- auto crop

Installation
------------

The best way to install is to use the composer by command:

composer require newclass/imago

composer install

Use example

    use Imago\Converter;

    $converter=new Converter('image.png');
    $converter->resizeWidth(200);
    $converter->resizeHeight(300);
    $converter->autoCrop();
    $converter->save('output.jpg');
