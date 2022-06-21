<?php

namespace App\Controller;

use App\Entity\Producteur;
use App\Form\ProducteurType;
use App\Repository\ProducteurRepository;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/producteur')]
class ProducteurController extends AbstractController
{
	/**
	 * @var Utility
	 */
	private $utility;
	
	public function __construct(Utility $utility)
	{
		$this->utility = $utility;
	}
	
    #[Route('/', name: 'app_producteur_index', methods: ['GET'])]
    public function index(ProducteurRepository $producteurRepository): Response
    {
        return $this->render('producteur/index.html.twig', [
            'producteurs' => $producteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_producteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProducteurRepository $producteurRepository): Response
    {
        $producteur = new Producteur();
        $form = $this->createForm(ProducteurType::class, $producteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			
			$mediaFile = $form->get('media')->getData();
			if ($mediaFile){
				$media = $this->utility->upload($mediaFile, 'profil');
				$producteur->setMedia($media);
			}
			$producteur->setMatricule($this->utility->matricule());
			
            $producteurRepository->add($producteur, true);

            return $this->redirectToRoute('app_producteur_show', ['matricule'=>$producteur->getMatricule()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('producteur/new.html.twig', [
            'producteur' => $producteur,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_producteur_show', methods: ['GET'])]
    public function show(Producteur $producteur): Response
    {
        return $this->render('producteur/show.html.twig', [
            'producteur' => $producteur,
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_producteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Producteur $producteur, ProducteurRepository $producteurRepository): Response
    {
        $form = $this->createForm(ProducteurType::class, $producteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
	
	        $mediaFile = $form->get('media')->getData();
	        if ($mediaFile){
		        $media = $this->utility->upload($mediaFile, 'profil');
				if ($producteur->getMedia()) $this->utility->removeUpload($mediaFile, 'profil');
		        $producteur->setMedia($media);
	        }
			
            $producteurRepository->add($producteur, true);

            return $this->redirectToRoute('app_producteur_show', ['matricule'=> $producteur->getMatricule()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('producteur/edit.html.twig', [
            'producteur' => $producteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_producteur_delete', methods: ['POST'])]
    public function delete(Request $request, Producteur $producteur, ProducteurRepository $producteurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producteur->getId(), $request->request->get('_token'))) {
            $producteurRepository->remove($producteur, true);
        }

        return $this->redirectToRoute('app_producteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
