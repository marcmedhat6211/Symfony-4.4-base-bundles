<?php

namespace App\UserBundle\Model;

use App\UserBundle\Util\CanonicalFieldsUpdater;
use App\UserBundle\Util\PasswordUpdaterInterface;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
abstract class UserManager implements UserManagerInterface
{
    private $passwordUpdater;
    private $canonicalFieldsUpdater;

    public function __construct(PasswordUpdaterInterface $passwordUpdater, CanonicalFieldsUpdater $canonicalFieldsUpdater)
    {
        $this->passwordUpdater = $passwordUpdater;
        $this->canonicalFieldsUpdater = $canonicalFieldsUpdater;
    }

    public function createUser(): PNUserInterface
    {
        $class = $this->getClass();

        return new $class;
    }

    public function findUserByEmail(string $email): PNUserInterface
    {
        return $this->findUserBy(['emailCanonical' => $this->canonicalFieldsUpdater->canonicalizeEmail($email)]);
    }

    public function findUserByUsername(string $username): PNUserInterface
    {
        return $this->findUserBy(['usernameCanonical' => $this->canonicalFieldsUpdater->canonicalizeEmail($username)]);
    }

    public function findUserByUsernameOrEmail(string $usernameOrEmail): PNUserInterface
    {
        if (preg_match('/^.+\@\S+\.\S+$/', $usernameOrEmail)) {
            $user = $this->findUserByEmail($usernameOrEmail);
            if (null !== $user) {
                return $user;
            }
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    public function findUserByConfirmationToken(string $token): PNUserInterface
    {
        return $this->findUserBy(['confirmationToken' => $token]);
    }

    public function updateCanonicalFields(PNUserInterface $user): void
    {
        $this->canonicalFieldsUpdater->updateCanonicalFields($user);
    }

    public function updatePassword(PNUserInterface $user): void
    {
        $this->passwordUpdater->hashPassword($user);
    }
}