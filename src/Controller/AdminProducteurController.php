<?php

namespace App\Controller;

use App\Entity\Producteur;
use App\Form\ProducteurType;
use App\Repository\ProducteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/producteur')]
class AdminProducteurController extends AbstractController
{
	private $producteurRepository;
	
	public function __construct(ProducteurRepository $producteurRepository)
	{
		$this->producteurRepository = $producteurRepository;
	}
	
    #[Route('/', name: 'app_admin_producteur')]
    public function index(): Response
    {
        return $this->render('admin_producteur/index.html.twig', [
            'producteurs' => $this->producteurRepository->findAll(),
        ]);
    }
	
	#[Route('/liste', name:'app_admin_producteur_liste')]
	public function liste(Request $request, ProducteurRepository  $producteurRepository, PaginatorInterface $paginator): Response
	{
		$donne = $producteurRepository->findAll();
		$producteurs = $paginator->paginate(
			$donne,
			$request->query->getInt('page', 1),
			5
		);
		
		return $this->render('admin_producteur/liste.html.twig',[
			'producteurs' => $producteurs
		]);
	}
	
	#[Route('/{matricule}/validation', name:'app_admin_producteur_validation')]
	public function validation(Request $request, Producteur $producteur, ProducteurRepository $producteurRepository): Response
	{
		
		$producteur->setStatut(true);
		
		$producteurRepository->add($producteur, true);
		
		$this->addFlash('success', "Le producteur ".$producteur->getNom().' '.$producteur->getPrenoms()." a été validé avec succès!");
		
		return $this->render('admin_producteur/validation.html.twig', [
			'producteur' => $producteur,
		]);
	}
}
