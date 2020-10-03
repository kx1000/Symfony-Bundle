<?php

namespace Cron\CronBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CronJobController extends AbstractController
{
    /**
     * @Route("/cron", name="cron_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('@CronCron/CronJob/index.html.twig', [
            'controller_name' => 'CronJobController',
        ]);
    }
}
