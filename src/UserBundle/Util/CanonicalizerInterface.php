<?php

namespace App\UserBundle\Util;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
interface CanonicalizerInterface
{
    /**
     * @param string $string
     *
     * @return string
     */
    public function canonicalize($string);
}
