<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use AppBundle\Repository\AdminRepository;
use AppBundle\Repository\ClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class ClassManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ClassRepository
     */
    private $classRepository;

    public function __construct(EntityManagerInterface $entityManager, ClassRepository $classRepository)
    {
        $this->entityManager = $entityManager;
        $this->classRepository = $classRepository;
    }

    /**
     * @return Collection|User[]
     */
    public function findAll(): Collection
    {
        return new ArrayCollection($this->classRepository->findAll());
    }

    /**
     * @param User $user
     * @param bool|null $flush
     */
    public function createOrUpdate(User $user, ?bool $flush = true): void
    {
        /** @var int|null $id */
        $id = $user->getId();

        /**
         * Si id null, alors c'est une création
         */
        if ($id === null) {
            $this->entityManager->persist($user);
            #TODO SwiftMailer
        }
        if ($flush === true) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param User $user
     */
    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}