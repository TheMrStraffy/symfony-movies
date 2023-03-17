<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private $movieRepository;
    

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/movies', name: 'app_movie')]
    public function index(): Response
    {
        // findAll() - SELECT * FROM movies;
        // find(2) - SELECT * FROM movies WHERE id = 2;
        // findBy() - SELECT * FROM movies ORDER BY id DESC
        // findOneBy() - SELECT * FROM movies WHERE id = 6 AND title = 'The Dark Knight' ORDER BY id DESC
        // count() - SELECT COUNT() from movies
        // getClassName() - to show the entity we get it from
        $repository = $this->em->getRepository(Movie::class);
        $movies = $repository->findAll();
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'movies'=> $movies
        ]);
    }

    #[Route('/movies/create', name:'app_movie_create')]
    public function create(Request $request): Response
    {
        $movie = new Movie;
        $form = $this->createForm(MovieFormType::class, $movie);
        // dd($form);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $newMovie = $form->getData();

            $imagePath = $form->get('imagePath')->getData();
            if($imagePath){
                $newFileName = uniqid() .'.' . $imagePath->guessExtension();

                try{
                $imagePath->move(
                $this->getParameter('kernel.project_dir') . '/public/images', $newFileName
                );
                } catch(FileException $e) {
                return new Response($e->getMessage());
                }
                $newMovie->setImagePath('/images/'. $newFileName);
            }
            $this->em->persist($newMovie);
            $this->em->flush();

            return $this->redirectToRoute('app_movie');
        }
        return $this->render('movie/create.html.twig',[
           'controller_name'=>'MovieController',
           'form'=> $form->createView()
            
        ]);
    }

    #[Route('/movies/{id}/edit', name:'app_movie_edit')]
    public function edit($id, Request $request): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movie = $repository->find($id);
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        $imagePath = $form->get('imagePath')->getData();

        if($form->isSubmitted() && $form->isValid()){
            if($imagePath){
                if($movie->getImagePath() !== null){
                    if(file_exists(
                        $this->getParameter('kernel.project_dir') . $movie->getImagePath())){
                            $this->getParameter('kernel.project_dir') . $movie->getImagePath();

                            $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                            try{
                                $imagePath->move(
                                $this->getParameter('kernel.project_dir') . '/public/images', $newFileName
                                );
                                } catch(FileException $e) {
                                return new Response($e->getMessage());
                                }
                            $movie->setImagePath('/images/' . $newFileName);
                            $this->em->flush();

                            return $this->redirectToRoute('app_movie');
                        }
                }
            } else{
                $movie->setTitle($form->get('title')->getData());
                $movie->setReleaseYear($form->get('releaseYear')->getData());
                $movie->setDescription($form->get('description')->getData());

                $this->em->flush();
                return $this->redirectToRoute('app_movie');
            }
        }

        return $this->render('movie/edit.html.twig', [
            'controller_name'=>'MovieController',
            'movie'=>$movie ,
            'form'=> $form->createView()
        ]);

    }

    #[Route('/movies/{id}/delete', methods:['GET', 'DELETE'], name:'app_movie_delete')]
    public function delete($id): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movie = $repository->find($id);
        $this->em->remove($movie);
        $this->em->flush();

        return $this->redirectToRoute('app_movie');
    }

    #[Route('/movies/{id}', methods:['GET'] , name: 'app_movie_show')]
    public function detail($id): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movie = $repository->find($id);
        return $this->render('movie/show.html.twig',[
            'controller_name' => 'MovieController',
            'movie'=> $movie
        ]);
    }

}
