<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Form\EmployesType;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployesController extends AbstractController
{

    #[route('/', name: 'home')] 
    public function index(): Response
    {
        return $this->render('entreprise/index.html.twig', []);
    }

    #[Route('/employes/modifier/{id}', name: 'modifier')]
    #[Route('/employes/ajout', name:'ajouter')]
    public function ajout(Request $global, EntityManagerInterface $manager, Employes $employe = null) 
    {
        if ($employe == null)
        {
            
            $employe = new Employes;
        }
        
        $form = $this->createForm(EmployesType::class, $employe);
        
        $form->handleRequest($global);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($employe);
            $manager->flush();
            
            return $this->redirectToRoute('employes');
        }
        
        return $this->render('employes/form.html.twig', [
            'formEmployes' => $form,
            'editMode' => $employe->getId() !== null,
        ]);
        
            return $this->render('employes/form.html.twig', [
                
            ]);
    }


   
    #[Route('/employes', name: 'employes')]
    public function gestion(EmployesRepository $repo): Response
    {
        $employes = $repo->findAll();
        return $this->render('employes/index.html.twig', [
            'employes' => $employes,
        ]);

      
    }
    

    #[Route('/blog/supprimer/{id}', name: 'supprimer')]
    public function supprimer(Employes $employes, EntityManagerInterface $manager)
    {
       $manager->remove($employes);
       $manager->flush();
       return $this->redirectToRoute('employes');
    }

   
}
