<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\LanguageRepository;
use App\Repository\ProficiencyLevelRepository;
use App\Repository\RoomRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/room')]
class RoomController extends AbstractController
{

    #[Route('/browse', name: 'app_room_browse', methods: ['GET'])]

    public function browse(
        TopicRepository $topicRepository,
        LanguageRepository $languageRepository,
        ProficiencyLevelRepository $proficiencyLevelRepository
    ): Response {
        return $this->render('room/browse.html.twig', [
            'topics' => $topicRepository->findAll(),
            'languages' => $languageRepository->findAll(),
            'proficiencyLevels' => $proficiencyLevelRepository->findAll(),
        ]);
    }
    #[Route('/', name: 'app_room_index', methods: ['GET'])]
    public function index(RoomRepository $roomRepository): Response
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

    #[Route('/{room_id}', name: 'app_room_show', methods: ['GET'])]
    #[ParamConverter('room', options: ['mapping' => ['room_id' => 'room_id']])]
    public function show(Room $room): Response
    {

        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }

    #[Route('/{room_id}/edit', name: 'app_room_edit', methods: ['GET','POST'])]
    #[ParamConverter('room', options: ['mapping' => ['room_id' => 'room_id']])]
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

    #[Route('/{room_id}', name: 'app_room_delete', methods: ['POST'])]
    #[ParamConverter('room', options: ['mapping' => ['room_id' => 'room_id']])]
    public function delete(Request $request, Room $room, RoomRepository $roomRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$room->getRoomId(), $request->request->get('_token'))) {
            $roomRepository->remove($room, true);
        }

        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
    }
}
