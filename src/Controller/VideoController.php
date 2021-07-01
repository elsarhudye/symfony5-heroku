<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class VideoController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('video/index.html.twig', [
            'controller_name' => 'VideoController',
        ]);
    }

    #[Route('/video/add', name: 'video_add')]
    public function add(Request $request): Response
    {

        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('video/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
