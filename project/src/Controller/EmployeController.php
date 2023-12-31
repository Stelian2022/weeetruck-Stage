<?php

namespace App\Controller;

use App\Form\TicketType;
use App\Repository\TicketRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use App\Entity\Ticket;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'employe')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        return $this->render('Employe/index.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('employe/tickets', name: 'indexTicketEmploye', methods: ['GET'])]
    public function indexTicket(TicketRepository $ticketRepository, Security $security): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $security->getUser();

        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            throw new AccessDeniedException('Utilisateur non connecté.');
        }

        // Récupérer les tickets de l'utilisateur connecté 
        if ($user) {
            // Récupérer l'adresse e-mail de l'utilisateur connecté
            $email = $user->getUserIdentifier();

            // Utiliser l'adresse e-mail pour récupérer les tickets correspondants
            $tickets = $ticketRepository->findByEmail($email);

            return $this->render('Employe/Tickets/index.html.twig', [
                'tickets' => $tickets,
            ]);
        }
    }






    #[Route('employe/tickets/new', name: 'newTicketEmploye', methods: ['GET', 'POST'])]
    public function new(Request $request, TicketRepository $ticketRepository, Security $security): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            // $ticket->setEntreprise($entreprise);
            $imageFile = $form->get('imageFilename')->getData();

            if ($imageFile) {
                $newFilename = md5(uniqid()) . '.' . $imageFile->guessExtension();

                // Move the uploaded file to a directory
                $imageFile->move(
                    $this->getParameter('image_directory'), // Define this parameter in your config/services.yaml file
                    $newFilename
                );

                $ticket->setImageFilename($newFilename);
            }
            $ticketRepository->save($ticket, true);

            return $this->redirectToRoute('indexTicketEmploye', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Employe/Tickets/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }
    #[Route('employe/tickets/{id}', name: 'showTicketEmploye', methods: ['GET'])]
    public function show(Ticket $ticket, Security $security): Response
    {
        $user = $security->getUser();
        return $this->render('Employe/Tickets/show.html.twig', [
            'ticket' => $ticket,
            'user' => $user
        ]);
    }

    #[Route('employe/tickets/{id}', name: 'deleteTicketEmploye', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ticket->getId(), $request->request->get('_token'))) {
            $ticketRepository->remove($ticket, true);
        }

        return $this->redirectToRoute('indexTicketEmploye', [], Response::HTTP_SEE_OTHER);
    }
}
