<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Courses;
use AppBundle\Entity\Group;
use AppBundle\Repository\CoursesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class CoursesManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CoursesRepository
     */
    private $coursesRepository;

    public function __construct(EntityManagerInterface $entityManager, CoursesRepository $coursesRepository)
    {
        $this->entityManager = $entityManager;
        $this->coursesRepository = $coursesRepository;
    }

    /**
     * @return Courses[]|array
     */
    public function findAll()
    {
        return $this->coursesRepository->findAll();
    }

    /**
     * @param Courses $courses
     * @param bool|null $flush
     */
    public function createOrUpdate(Courses $courses, ?bool $flush = true): void
    {
        /** @var int|null $id */
        $id = $courses->getId();

        /**
         * Si id null, alors c'est une création
         */
        if ($id === null) {
            $this->entityManager->persist($courses);
        }
        if ($flush === true) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param Courses $courses
     */
    public function delete(Courses $courses): void
    {
        $this->entityManager->remove($courses);
        $this->entityManager->flush();
    }
}