<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Group;
use AppBundle\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class GroupManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(EntityManagerInterface $entityManager, GroupRepository $groupRepository)
    {
        $this->entityManager = $entityManager;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @return Collection|Group[]
     */
    public function findAll(): Collection
    {
        return new ArrayCollection($this->groupRepository->findAll());
    }

    /**
     * @param Group $group
     * @param bool|null $flush
     */
    public function createOrUpdate(Group $group, ?bool $flush = true): void
    {
        /** @var int|null $id */
        $id = $group->getId();

        /**
         * Si id null, alors c'est une création
         */
        if ($id === null) {
            $this->entityManager->persist($group);
        }
        if ($flush === true) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param Group $group
     */
    public function delete(Group $group): void
    {
        $this->entityManager->remove($group);
        $this->entityManager->flush();
    }
}