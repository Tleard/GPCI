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
     * @return Collection|User[]
     */
    public function findAll(): Collection
    {
        return new ArrayCollection($this->adminRepository->findAll());
    }

}