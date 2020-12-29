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
 * Interface FilterInterface
 * @package Imago
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
interface FilterInterface
{
    /**
     * @param resource $resource
     * @param FileInfo $fileInfo
     * @return resource
     */
    public function execute($resource, FileInfo $fileInfo);
}