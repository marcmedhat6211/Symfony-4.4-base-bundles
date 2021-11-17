<?php

namespace App\UserBundle\Util;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
class Canonicalizer implements CanonicalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function canonicalize($string)
    {
        if (null === $string) {
            return;
        }

        $encoding = mb_detect_encoding($string);
        return $encoding
            ? mb_convert_case($string, MB_CASE_LOWER, $encoding)
            : mb_convert_case($string, MB_CASE_LOWER);
    }
}
