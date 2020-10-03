<?php

namespace Cron\CronBundle\Controller;

use Cron\CronBundle\Entity\CronJobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CronJobController extends AbstractController
{
    /**
     * @Route("/cron", name="cron_index", methods={"GET"})
     */
    public function index(CronJobRepository $cronJobRepository)
    {

        return $this->render('@CronCron/CronJob/index.html.twig', [
            'cron_jobs' => $cronJobRepository->findAll(),
        ]);
    }
}
