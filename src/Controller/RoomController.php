<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{

    #[Route('/room', name: 'app_room_index')]
    public function index(RoomRepository $roomRepository,): Response
    {

        $rooms = $roomRepository->findAll();
        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }
    #[Route('/new', name: 'app_room_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RoomRepository $roomRepository): Response
    {
        $room = new Room();
        $room->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roomRepository->save($room, true);

            $this->addFlash('success', 'Room created successfully!');
            return $this->redirectToRoute('app_room_index');
        }

        return $this->render('room/room.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_room_show', methods: ['GET'])]
    public function show(Room $room): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_room_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Room $room, RoomRepository $roomRepository): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roomRepository->save($room, true);
            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/edit.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_room_delete', methods: ['POST'])]
    public function delete(Request $request, Room $room, RoomRepository $roomRepository): Response
    {
        // CSRF token protection
        if ($this->isCsrfTokenValid('delete'.$room->getRoomId(), $request->request->get('_token'))) {
            $roomRepository->remove($room, true);
        }

        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
    }
}