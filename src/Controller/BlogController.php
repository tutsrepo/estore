<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

 class BlogController extends AbstractController
 {

    private const POSTS = [
        [
            'id'   =>   1,
            'slug'   =>   'hello-world',
            'title'   =>   'Hello World'
        ],
        [
            'id'   =>   2,
            'slug'   =>   'second-post',
            'title'   =>   'This is second post'
        ],
        [
            'id'   =>   3,
            'slug'   =>   'third-post',
            'title'   =>   'This is third post'
        ]
    ];

    /**
     * @Route("/blog",name="blog_list")
     * 
     */    

    public  function list()
    {
        return new JsonResponse(self::POSTS);

    }


    /**
     * @Route("/blog/{id}",name="blog_by_id", requirements={"id"="\d+"})
     * 
     */
    public function post($id)
    {
        return new JsonResponse(
            self::POSTS[array_search($id,array_column(self::POSTS, 'id'))]
        );

    }

    /**
     * @Route("/blog/{slug}",name="blog_by_slug")
     * 
     */
    public function postBySlug($slug)
    {
        return new JsonResponse(
            self::POSTS[array_search($slug,array_column(self::POSTS, 'slug'))]
        );

    }    
 }