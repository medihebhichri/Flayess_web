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

#[Route('/projects')]
class ProjectsController extends AbstractController
{
#[Route('/', name: 'app_projects_index', methods: ['GET'])]
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

    return $this->render('projects/index.html.twig', [
        'projects' => $projects,
        'categories' => $categories, // Pass categories to the template
    ]);
}

#[Route('/new', name: 'app_projects_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response {
    $project = new Projects();
    $form = $this->createForm(ProjectsType::class, $project);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('image')->getData();

        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->getClientOriginalExtension();

            try {
                $imageFile->move($this->getParameter('projects_directory'), $newFilename);
                $project->setImage($newFilename);
            } catch (FileException $exception) {
                // Handle the exception if something goes wrong
            }
        }

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->redirectToRoute('app_projects_index');
    }

    return $this->render('projects/new.html.twig', [
        'project' => $project,
        'form' => $form->createView(),
    ]);
}

    #[Route('/{id}', name: 'app_projects_show', methods: ['GET'])]
    public function show(Projects $project): Response
    {
        return $this->render('projects/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_projects_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projects $project, ObjectManager $objectManager): Response // Change EntityManagerInterface to ObjectManager
    {
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectManager->flush();

            return $this->redirectToRoute('app_projects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projects/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projects_delete', methods: ['POST'])]
    public function delete(Request $request, Projects $project, ObjectManager $objectManager): Response // Change EntityManagerInterface to ObjectManager
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $objectManager->remove($project);
            $objectManager->flush();
        }

        return $this->redirectToRoute('app_projects_index', [], Response::HTTP_SEE_OTHER);
    }
}
