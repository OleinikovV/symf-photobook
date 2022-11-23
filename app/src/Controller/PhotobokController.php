<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Photobook;
use App\Form\PhotobookType;
use App\Repository\PhotobookRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PhotobokController extends AbstractController
{
    #[Route('/photobook/create')]
    public function create(Request $request, PhotobookRepository $repository)
    {
        $form = $this->createForm(PhotobookType::class, $repository->getEmptyEntity());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($form->getData(), true);

            return $this->redirectToRoute('site_index');
        }
        
        return $this->renderForm('photobook/form.html.twig', ['action' => 'create', 'form' => $form]);
    }

    #[Route('/photobook/update/{id<\d+>}')]
    public function update(Photobook $photobook, Request $request, PhotobookRepository $repository)
    {
        $form = $this->createForm(PhotobookType::class, $photobook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($form->getData(), true);

            return $this->redirectToRoute('full_photo_list', ['id' => $photobook->getId()]);
        }
        
        return $this->renderForm('photobook/form.html.twig', ['action' => 'update', 'form' => $form]);
    }

    #[Route('/', name: 'site_index')]
    public function index(PhotobookRepository $repository)
    {
        $model = $repository->getEmptyEntity();

        $entities = $repository->findAll();
        return $this->render('photobook/list.html.twig', ['entities' => $entities]);
    }

    #[Route('/photobook/delete/{id<\d+>}')]
    public function delete(Photobook $photobook, PhotobookRepository $repository, FileUploader $service)
    {
        $repository->remove($photobook, true);

        return $this->redirectToRoute('site_index');
    }
}
