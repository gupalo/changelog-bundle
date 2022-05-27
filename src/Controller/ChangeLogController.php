<?php

namespace Gupalo\ChangeLogBundle\Controller;

use App\Entity\Archive;
use App\Repository\ArchiveRepository;
use Doctrine\Persistence\ManagerRegistry;
use Gupalo\ChangeLogBundle\Repository\ChangeLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ChangeLogController extends AbstractController
{
    public function __construct(private readonly ChangeLogRepository $repository)
    {
    }

    #[Route(path: '/change-log', name: 'change_log_list', methods: ['GET'])]
    public function lists(): Response
    {
        return $this->render('@ChangeLog/lists.html.twig', [
            'items' => $this->repository->findAll()
        ]);
    }
}
