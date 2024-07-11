<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * This route has a greedy pattern and is defined first.
     */
    #[Route('/blog/{slug}', name: 'blog_show')]
    public function show(string $slug): Response
    {
        // Example blog post data
        $post = [
            'title' => 'Sample Blog Post',
            'slug' => $slug,
            'content' => 'This is a sample blog post content.',
        ];

        return $this->render('blog/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * This route could not be matched without defining a higher priority than 0.
     */
    #[Route('/blog/list', name: 'blog_list', priority: 2)]
    public function list(): Response
    {
        // Example list of blog posts
        $posts = [
            ['title' => 'Post 1', 'slug' => 'post-1'],
            ['title' => 'Post 2', 'slug' => 'post-2'],
            ['title' => 'Post 3', 'slug' => 'post-3'],
        ];

        return $this->render('blog/list.html.twig', [
            'posts' => $posts,
        ]);
    }
}
