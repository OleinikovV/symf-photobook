<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Photobook;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PhotoController extends AbstractController
{
    #[Route('/photo/add/{id<\d+>}')]
    public function add(Photobook $photobook, Request $request, PhotoRepository $repository, FileUploader $service)
    {
        /** @var Photo $photo */
        $photo = $repository->getEmptyEntity();
        $photobook->addPhoto($photo);

        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
            $photo->setFolder($service->getDirecory($file))
                ->setName($service->getName($file))
                ->setExtension($service->getExtension($file));

            $repository->save($photo, true);
            $service->upload($file, $photo);

            return $this->redirectToRoute('full_photo_list', ['id' => $photobook->getId()]);
        }
        
        return $this->renderForm('photo/form.html.twig', ['action' => 'create', 'form' => $form]);
    }

    #[Route('/photo/delete/{id<\d+>}')]
    public function delete(Photo $photo, PhotoRepository $repository)
    {
        $parentEntityId = $photo->getPhotobookId()->getId();

        $repository->remove($photo, true);

        return $this->redirectToRoute('full_photo_list', ['id' => $parentEntityId]);
    }

    #[Route('/photo/list/{id<\d+>}', name: 'full_photo_list')]
    public function list(Photobook $photobook)
    {
        return $this->renderForm('photo/list.html.twig', ['photobook' => $photobook, 'photoList' => []]);
    }
}
