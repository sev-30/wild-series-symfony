<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Actor;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;

/**

 * @Route("/actors", name="actor_")

 */
class ActorController extends AbstractController
{
        /**
         * @Route("/", name="index")
         */
        public function index(ActorRepository $actorRepository): Response
        {
            return $this->render('actor/index.html.twig', [
                'actors' => $actorRepository->findAll(),
            ]);
        }
   
     /**
     * @Route("/{id}", name="actor_show", methods={"GET"})
     * @return Response
     */
    public function show(Actor $actor): Response
    {
        
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }

}