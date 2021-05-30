<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Category;
/**

 * @Route("/categories", name="category_")

 */
class CategoryController extends AbstractController
{

        /**

       * @Route("/categories/", name="category_index")
  
       */
  
      public function index(): Response
  
      {
  
           $categories = $this->getDoctrine()  
           ->getRepository(Category::class)
           ->findAll();
           
           return $this->render('category/index.html.twig', ['categories' => $categories]);
      }
       /**

         * @Route("/categories/{categoryName}", name="category_show")
         * @return Response

         */

        public function show(string $categoryName):Response
        {
  
           $category = $this->getDoctrine()
           ->getRepository(Category::class)
           ->findOneBy(['name' => $categoryName]);

  
           if (!$category) {
  
          throw $this->createNotFoundException(
  
              'Error 404 no category found.'
           );
           }
  
           $programs = $this->getDoctrine()
           ->getRepository(Program::class)
           ->findBy(['category' => $category->getId()], ['id' => 'DESC'], 3);
   
           return $this->render('category/show.html.twig', [
  
          'programs' => $programs,
  
            ]);
        }
  
}