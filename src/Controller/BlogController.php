<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    //* une route est définie par 2 arguments : son chemin (/blog) dans l'url et son nom (app_blog)
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
        //* render() permet d'afficher le contenu d'un template. Elle va chercher directement dans le dossier template
    }

    #[Route('/', name:'home')]
    public function home() : Response
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenu sur mon blog',
            'age' => 28,
        ]);
        // * dans le render en deuxième argument on peut envoyer des données dans la vue (twig) sous forme de tableau avec indice => valeur
        //* l'indice étant le nom de la variable dans le fichier twig et valeur sa valeur réel
    }

    #[Route('/blog/ajout', name:"blog_ajout")]
    public function form() : Response
    {
        $article = new Article;

        $form = $this->createForm(ArticleType::class);
        
        return $this->render('blog/form.html.twig', [
            'formArticle' => $form
        ]);
    }
}
