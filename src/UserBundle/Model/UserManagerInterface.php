<?php

namespace App\UserBundle\Model;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
interface UserManagerInterface
{
    /**
     * @return PNUserInterface
     */
    public function createUser(): PNUserInterface;

    /**
     * @param PNUserInterface $user
     */
    public function deleteUser(PNUserInterface $user): void;

    /**
     * @param array $criteria
     * @return PNUserInterface|null
     */
    public function findUserBy(array $criteria): ?PNUserInterface;

    /**
     * @param string $username
     * @return PNUserInterface|null
     */
    public function findUserByUsername(string $username): ?PNUserInterface;

    /**
     * @param string $email
     * @return PNUserInterface|null
     */
    public function findUserByEmail(string $email): ?PNUserInterface;

    /**
     * @param string $usernameOrEmail
     * @return PNUserInterface|null
     */
    public function findUserByUsernameOrEmail(string $usernameOrEmail): ?PNUserInterface;

    /**
     * @param string $token
     * @return PNUserInterface|null
     */
    public function findUserByConfirmationToken(string $token): ?PNUserInterface;

    /**
     * Returns the user's fully qualified class name.
     * @return string
     */
    public function getClass(): string;

    /**
     * @param PNUserInterface $user
     */
    public function updateUser(PNUserInterface $user, $andFlush = true): void;

    /**
     * @return ?array
     */
    public function findUsers(): ?array;

    /**
     * @param PNUserInterface $user
     */
    public function reloadUser(PNUserInterface $user): void;

    /**
     * @param PNUserInterface $user
     */
    public function updateCanonicalFields(PNUserInterface $user): void;

    /**
     * @param PNUserInterface $user
     */
    public function updatePassword(PNUserInterface $user): void;
}