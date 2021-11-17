<?php

namespace App\UserBundle\Doctrine;

use App\UserBundle\Model\PNUserInterface;
use App\UserBundle\Model\UserManager as BaseUserManager;
use App\UserBundle\Util\CanonicalFieldsUpdater;
use App\UserBundle\Util\PasswordUpdaterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
class UserManager extends BaseUserManager
{
    private $em;
    private $class;

    public function __construct(PasswordUpdaterInterface $passwordUpdater, CanonicalFieldsUpdater $canonicalFieldsUpdater, EntityManagerInterface $em, $class)
    {
        parent::__construct($passwordUpdater, $canonicalFieldsUpdater);
        $this->em = $em;
        $this->class = $class;
    }

    /**
     * @return ObjectRepository
     */
    protected function getRepository(): ObjectRepository
    {
        return $this->em->getRepository($this->getClass());
    }

    public function getClass(): string
    {
        if (false !== strpos($this->class, ':')) {
            $metadata = $this->em->getClassMetadata($this->class);
            $this->class = $metadata->getName();
        }

        return $this->class;
    }

    public function deleteUser(PNUserInterface $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function updateUser(PNUserInterface $user, $andFlush = true): void
    {
        $this->updateCanonicalFields($user);
        $this->updatePassword($user);

        $this->em->persist($user);
    }

    public function findUserBy(array $criteria): ?PNUserInterface
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    public function findUsers(): ?array
    {
        return $this->getRepository()->findAll();
    }

    public function reloadUser(PNUserInterface $user): void
    {
        $this->em->refresh($user);
    }
}