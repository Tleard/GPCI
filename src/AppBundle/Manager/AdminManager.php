<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use AppBundle\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class AdminManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var AdminRepository
     */
    private $adminRepository;

    public function __construct(EntityManagerInterface $entityManager, AdminRepository $adminRepository)
    {
        $this->entityManager = $entityManager;
        $this->adminRepository = $adminRepository;
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
    public function delete(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * @return Collection|User[]
     */
    public function findAll()
    {
        return $this->adminRepository->findAll();
    }

}