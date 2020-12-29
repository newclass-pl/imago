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

/**
 * Interface StyleInterface
 * @package Imago
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
interface StyleInterface
{
    /**
     * @param string $path
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     */
    public function addFile($path, $width, $height, $x, $y);

    /**
     * @param string $path
     */
    public function save($path);
}