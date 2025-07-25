<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DriverRepository;

final class DriverController extends AbstractController
{
    public function __construct(
        private DriverRepository $driverRepo,
        private EntityManagerInterface $em
    ){}

    #[Route('/drivers', name: 'app_driver')]
    public function index(): Response
    {
        return $this->render('driver/index.html.twig', [
            'drivers' => $this->driverRepo->findAll(),
        ]);
    }

    #[Route('/driver/create', name:'.driver.create')]
    public function createDriver(Request $request)
    {
        return $this->render('driver/create.html.twig');
    }
}
