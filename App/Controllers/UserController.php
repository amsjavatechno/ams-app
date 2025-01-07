<?php
// src/Controller/BlogController.php
namespace AmsApp\App\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
//#[Route('/blog', name: 'blog_list')]
public function index(): Response
{
    return $this->render('public/index.php');
}
}