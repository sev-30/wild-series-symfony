<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**

 * @Route("/programs", name="program_")

 */
class ProgramController extends AbstractController
{
   

      /**
  
       * Show all rows from Program’s entity

       * @Route("/", name="index")
  
       * @return Response A response instance
  
       */
  
      public function index(): Response
  
      {
  
           $programs = $this->getDoctrine()
  
               ->getRepository(Program::class)
  
               ->findAll();
  
  
           return $this->render('program/index.html.twig', ['programs' => $programs]);
      }

     /**
        * @Route("/programs/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="program_show")
     */

     public function show(int $id): Response

     {
        return $this->render('program/show.html.twig', ['id' => $id]);
     }

}

