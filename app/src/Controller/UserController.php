<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use App\Repository\UserRepository;
use Doctrine\DBAL\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Alias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Route('/user')]
class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, userRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
 
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
 
        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
 
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
 
        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }
 
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

/*    
    #[Route('/user')]
    public function request(Request $request)
    {
        
        $connection = $this->getConnection();

        $tableExists = $this->executeRequest("SELECT * FROM information_schema.tables WHERE table_schema = 'symfony' AND table_name = 'user' LIMIT 1;", $connection);
        if (empty($tableExists)) {
            $this->executeRequest("CREATE TABLE user (id int, data varchar(255))", $connection);
            $this->executeRequest("INSERT INTO user(id, data) values(1, 'Barack - Obama - White House')", $connection);
            $this->executeRequest("INSERT INTO user(id, data) values(1, 'Britney - Spears - America')", $connection);
            $this->executeRequest("INSERT INTO user(id, data) values(1, 'Leonardo - DiCaprio - Titanic')", $connection);
        }
        
        if ($request->getMethod() == "GET") {
            $id = $request->get("id");
            $action = $request->get("action");

            if ($action == "delete") {
                $this->executeRequest("DELETE FROM user WHERE id = " . $id, $connection);
            }
        } else if ($request->getMethod() == "POST") {
            $firstname = $request->get("firstname");
            $lastname = $request->get("lastname");
            $address = $request->get("address");

            $this->executeRequest("INSERT INTO user(id, data) values(" . time() . ", '" . $firstname . " - " . $lastname . " - " . $address . "');", $connection);
        }

        $users = $this->executeRequest("SELECT * FROM user;", $connection);

        return $this->render('user.html.twig', [
            'obj' => $request->getMethod(),
            'users' => $users
        ]);
    }



    private function getConnection()
    {
        $connectionParams = [
            'dbname' => 'symfony',
            'user' => 'symfony',
            'password' => '',
            'host' => 'docker.for.mac.localhost',
            'port' => '3306',
            'driver' => 'pdo_mysql',
        ];
        return DriverManager::getConnection($connectionParams);
    }

    private function executeRequest($sql, $connection)
    {
        $stmt = $connection->prepare($sql);
        return $stmt->executeQuery()->fetchAllAssociative();
    }
*/


}