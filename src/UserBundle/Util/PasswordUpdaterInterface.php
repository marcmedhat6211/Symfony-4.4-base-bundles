<?php

namespace App\UserBundle\Util;

use App\UserBundle\Model\PNUserInterface;

interface PasswordUpdaterInterface
{
    public function hashPassword(PNUserInterface $user);
}