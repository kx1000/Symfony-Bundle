<?php

namespace Cron\CronBundle\Controller;

use Cron\CronBundle\Cron\Manager;
use Cron\CronBundle\Entity\CronJob;
use Cron\CronBundle\Form\CronJobType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CronJobController extends AbstractController
{
    const FLASH_NOTICE = 'notice';

    private $cronManager;

    public function __construct(Manager $cronManager)
    {
        $this->cronManager = $cronManager;
    }

    /**
     * @Route("/cron", name="cron_index", methods={"GET"})
     */
    public function index(): Response
    {

        return $this->render('@CronCron/CronJob/index.html.twig', [
            'cron_jobs' => $this->cronManager->listJobs(),
        ]);
    }

    /**
     * @Route("/cron/{id}/ennable", name="cron_enable", methods={"GET"})
     */
    public function enable(CronJob $cronJob): RedirectResponse
    {
        $cronJob->setEnabled(true);
        $this->cronManager->saveJob($cronJob);

        $this->addFlash(
            self::FLASH_NOTICE,
            'Cron job "' . $cronJob->getName() . '" has been enabled.'
        );

        return $this->redirectToRoute('cron_index');
    }

    /**
     * @Route("/cron/{id}/disable", name="cron_disable", methods={"GET"})
     */
    public function disable(CronJob $cronJob): RedirectResponse
    {
        $cronJob->setEnabled(false);
        $this->cronManager->saveJob($cronJob);

        $this->addFlash(
            self::FLASH_NOTICE,
            'Cron job "' . $cronJob->getName() . '" has been disabled.'
        );

        return $this->redirectToRoute('cron_index');
    }

    /**
     * @Route("/cron/{id}/edit", name="cron_edit", methods={"GET", "POST"})
     */
    public function edit(CronJob $cronJob, Request $request): Response
    {
        $form = $this->createForm(CronJobType::class, $cronJob);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->cronManager->saveJob($cronJob);

            $this->addFlash(
                self::FLASH_NOTICE,
                'Cron job "' . $cronJob->getName() . '" has been saved.'
            );

            return $this->redirectToRoute('cron_index');
        }

        return $this->render('@CronCron/CronJob/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cron/new", name="cron_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $cronJob = new CronJob();
        $form = $this->createForm(CronJobType::class, $cronJob);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->cronManager->saveJob($cronJob);

            $this->addFlash(
                self::FLASH_NOTICE,
                'Cron job "' . $cronJob->getName() . '" has been created.'
            );

            return $this->redirectToRoute('cron_index');
        }

        return $this->render('@CronCron/CronJob/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
