<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Model;

/**
 * Titles.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
final class Titles
{
    const MRS = 'mrs';
    const MISS = 'miss';
    const MISTER = 'mr';

    /**
     * Returns the list of titles.
     *
     * @return array 
     */    
    public static function getTitles()
    {
        return array(
            static::MRS    => 'mrs',
            static::MISS   => 'miss',
            static::MISTER => 'mr',
        );
    }
}