<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Form\ProgramType;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;

/**

 * @Route("/programs", name="program_")

 */
class ProgramController extends AbstractController
{
    
    /**
     * The controller for the category add form
     *
     * @Route("/new", name="new")
     */

   public function new(Request $request) : Response

   {

       // Create a new Program Object

       $program = new Program();

       // Create the associated Form

       $form = $this->createForm(ProgramType::class, $program);

       // Get data from HTTP request

       $form->handleRequest($request);
   
       // Was the form submitted ?

       if ($form->isSubmitted() && $form->isValid())  {

           // Deal with the submitted data
           // Get the Entity manager
           $entityManager = $this->getDoctrine()->getManager();

            // Persist Category Object

            $entityManager->persist($program);

             // Flush the persisted object

            $entityManager->flush();

            // Finally redirect to programs list

            return $this->redirectToRoute('program_index');

        }

            // Render the form

             return $this->render('program/new.html.twig', ["form" => $form->createView()]);

        }


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

         * Getting a program by id

         *

         * @Route("/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
         * @Route("/{program_id}", name="show", methods={"GET"}, requirements={"program_id"="\d+"})
        * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})    
         * @return Response
        */   

      public function show(Program $program):Response
      {

        $seasons = $this->getDoctrine()
        
        ->getRepository(Season::class)
        
        ->findBy(['program' => $program]);

         if (!$program) {

        throw $this->createNotFoundException(

            'No program with id : '.$program.' found in program\'s table.'
         );
         }



     return $this->render('program/show.html.twig', [
         'program' => $program, 
         'seasons' => $seasons,
     ]);
    }
        /**
         * @Route("/{programId}/seasons/{seasonId}", name="season_show", methods={"GET"}, requirements={"programId"="\d+","seasonId"="\d+"})
          * @Route("/{program_id}/seasons/{season_id}", name="season_show", methods={"GET"}, requirements={"program_id"="\d+","season_id"="\d+"})
        * * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})
        * * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "id"}})
        * @return Response
        */

         public function showSeason(Program $program, Season $season): Response
        {
          
            $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy(['season' => $season]);

            if (!$program) {
                throw $this->createNotFoundException(
                    'No program with id : ' . $program . ' found in program\'s table.'
                );
            }
            if (!$season) {
                throw $this->createNotFoundException(
                    'No program with id : ' . $season . ' found in seasons\'s table.'
                );
            }

            return $this->render('program/season_show.html.twig', [
            'program' => $program, 
            'season' => $season,
            'episodes' => $episodes,
            ]);
        }
        /**
        * @Route("/{program_id}/seasons/{season_id}/episodes/{episode_id}", name="episode_show", methods={"GET"}, 
        * requirements={"program_id"="\d+","season_id"="\d+", "episode_id"="\d+"})
        * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})
        * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "id"}})
        * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episode_id": "id"}})
        * @return Response
        */

    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {

        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]);
    }
}

