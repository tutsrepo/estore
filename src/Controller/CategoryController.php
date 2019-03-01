<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

 class CategoryController extends AbstractController
 {

    /**
     * @Route("/category/list",name="category_list", methods={"GET"})
     * 
     */    

    public  function list()
    {

        $repository = $this->getDoctrine()->getRepository(Category::class);
        $items = $repository->findAll();

        return $this->json(
            [
                'data'=> array_map(function (Category $item) {
                    return $this->generateUrl('category_by_id', ['id'=> $item->getId()]);
                },$items)
            ]);
    } 


    /**
     * @Route("/category/{id}",name="category_by_id", requirements={"id"="\d+"}, methods={"GET"} )
     * 
     */
    public function GetCategory($id)
    {
        return $this->json($this->getDoctrine()->getRepository(Category::class)->find($id));

    }    

     /**
     * @Route("category/add",name="category_add", methods={"POST"})
     * 
     */
    public function AddCategory(Request $request)
    {
        /** @var $serializer $serializer */
        $serializer = $this->get('serializer');

        $cagetoryPost = $serializer->deserialize($request->getContent(), Category::class, 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($cagetoryPost);
        $em->flush();
        
        return $this->json($cagetoryPost);


    }    
    
    
    /**
     * @Route("/category/{id}",name="delete_category",  methods={"DELETE"}, requirements={"id"="\d+"})
     * 
     */
    public function DeleteCategory(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return $this->json(
            ['msg'=> "Category Deleted Successfully"]
        );
    }        
 }