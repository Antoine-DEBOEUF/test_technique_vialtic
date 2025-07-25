<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DriverRepository;
use App\Entity\Driver;
use App\Form\DriverType;
use Symfony\Component\HttpFoundation\RedirectResponse;

#Route de la page d'accueil où sont actuellement listés les chauffeurs de l'entreprise

#[Route('', 'drivers')]
final class DriverController extends AbstractController
{
    public function __construct(
        private DriverRepository $driverRepo,
        private EntityManagerInterface $em
    ){}

#Liste des chauffeurs

    #[Route('', name: '.index')]
    public function index(): Response
    {
        return $this->render('driver/index.html.twig', [
            'drivers' => $this->driverRepo->findAll(),
        ]);
    }

#Création d'un profil chauffeur

    #[Route('/driver/create', name:'.create', methods:['GET', 'POST'])]
    public function createDriver(Request $request): Response|RedirectResponse
    {
        {
            $driver = new Driver;
            $form = $this->createForm(DriverType::class, $driver);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $this->em->persist($driver);
                $this->em->flush();

                $this->addFlash('success', 'Le profil du chauffeur a bien été ajouté');

                return $this->redirectToRoute('drivers.index');
            }
        }
        return $this->render('driver/create.html.twig', ['form' => $form]);
    }

#Modification d'un profil chauffeur

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Driver $driver, Request $request): Response|RedirectResponse
    {
        if (!$driver)
            {
                $this->addFlash('error', 'Profil chauffeur non trouvé');
                return $this->redirectToRoute('index');
            }

            $form = $this->createForm(DriverType::class, $driver);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $this->em->persist($driver);
                $this->em->flush();

                $this->addFlash('success', 'Profil du chauffeur modifié');

                return $this->redirectToRoute('drivers.index');
            }

            $driverId = $driver->getId();
            return $this->render('driver/edit.html.twig', 
            [
                'driver' => $this->driverRepo->findOneById($driverId),
             'form' => $form
            ]);
    }

#Suppression d'un profil chauffeur

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?driver $driver, Request $request): RedirectResponse
    {
        if (!$driver)
            {
                $this->addFlash('error', 'Profil chauffeur non trouvé');
                return $this->redirectToRoute('index');
            }
        if ($this->isCsrfTokenValid('delete' . $driver->getId(), $request->request->get('token')))
        {
            $this->em->remove($driver);
            $this->em->flush();

            $this->addFlash('success', 'Profil du chauffeur supprimé');
        }
        else {
            $this->addFlash('error', 'token CSRF invalide');
        }
        return $this->redirectToRoute('drivers.index');
    }
}
