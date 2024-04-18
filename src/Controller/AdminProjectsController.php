<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProjectsRepository;
use App\Entity\Projects;
use App\Form\ProjectsType;
use Doctrine\Persistence\ObjectManager; // Import ObjectManager
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
class AdminProjectsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    #[Route('/admin_projects', name: 'admin_app_projects_index', methods: ['GET'])]
    public function index(Request $request, ProjectsRepository $projectsRepository, CategoriesRepository $categoryRepository): Response
    {
        $searchTerm = $request->query->get('search');
        $categoryId = $request->query->get('category');
        $status = $request->query->get('status');
        $sortOption = $request->query->get('sort');
        $uniqueSellingPointsMax = $request->query->get('uniqueSellingPointsMax');
        $uniqueSellingPointsMax = $uniqueSellingPointsMax !== null ? (int) $uniqueSellingPointsMax : null;
    
        
        if (null !== $categoryId && is_numeric($categoryId)) {
            $categoryId = (int) $categoryId;
        } else {
            $categoryId = null; // Ensure it falls back to null if not set or not a numeric value
        }
        $projects = $projectsRepository->findByFilters($searchTerm, $categoryId, $status, $sortOption, $uniqueSellingPointsMax);
    
        $categories = $categoryRepository->findAll(); // Fetch all categories
    
        return $this->render('admin_projects/index.html.twig', [
            'projects' => $projects,
            'categories' => $categories, // Pass categories to the template
        ]);
    }
    
        #[Route('/admin-{id}', name: 'admin_app_projects_show', methods: ['GET'])]
        public function show(Projects $project): Response
        {
            return $this->render('admin_projects/show.html.twig', [
                'project' => $project,
            ]);
        }
    
        #[Route('/admin-{id}/update-state', name: 'admin_app_projects_update_state', methods: ['POST'])]
        public function updateState(Request $request, Projects $project, ObjectManager $objectManager): Response
        {
            $action = $request->request->get('action');
        
            if ($action === 'validate') {
                $project->setState('approved');
            } elseif ($action === 'reject') {
                $project->setState('disapproved');
            }
        
            $objectManager->persist($project);
            $objectManager->flush();
        
            return $this->redirectToRoute('admin_app_projects_index', [], Response::HTTP_SEE_OTHER);
        }
        
    
        #[Route('/admin-{id}', name: 'admin_app_projects_delete', methods: ['POST'])]
        public function delete(Request $request, Projects $project, ObjectManager $objectManager): Response // Change EntityManagerInterface to ObjectManager
        {
            if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
                $objectManager->remove($project);
                $objectManager->flush();
            }
    
            return $this->redirectToRoute('admin_app_projects_index', [], Response::HTTP_SEE_OTHER);
        }
}
