<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Subject;
use App\Entity\Comments;
use App\Entity\Like;


use App\Repository\SubjectRepository;
use App\Repository\CommentsRepository;
use App\Repository\LikeRepository;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;





final class FrontController extends AbstractController
{
    #[Route('/front', name: 'app_front')]
    public function index(SubjectRepository $subject): Response
    {

        $allSubjects = $subject->findAll();
        //admin peut voir les sujets signalés et non signalés
        if($this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            return $this->render('front/index.html.twig', [
                'controller_name' => 'FrontController',
                'subjects' => $allSubjects,
    
            ]);
        }else{
            //retourner les sujets non signalés
            $subjectsNotReported = $subject->findBy(['isReported' => false]);
            return $this->render('front/index.html.twig', [
                'controller_name' => 'FrontController',
                'subjects' => $subjectsNotReported,
            ]);
        }
        
    }

    #[Route('/report/{$id}', name: 'subject_report')]
    public function report(SubjectRepository $subject , Request $request,EntityManagerInterface $entityManager)
    {
        $reportedSubjects = $request->get('id');
        $subjectSelected = $subject->find($reportedSubjects);
        $subjectSelected->setIsReported(true);
        $entityManager->persist($subjectSelected);
        $entityManager->flush();
        return $this->redirectToRoute('app_front');
    }

    #[Route('/show/{$id}', name: 'subject_show')]
    public function show(SubjectRepository $subject , Request $request,EntityManagerInterface $entityManager) : Response
    {

        $user = $this->getUser();
        $subjectSelected = $request->get('id');
        $subjectDetail = $subject->find($subjectSelected);
        $admin=0;
        if($this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            $admin=1;
        }
        return $this->render('front/detail.html.twig', [
            'controller_name' => 'FrontController',
            'subject' => $subjectDetail,
            'admin' => $admin,
            'user' => $user ,
        ]);
      
    }

    #[Route('/comment/{$id}', name: 'comment_create')]
    public function CommentCreate(CommentsRepository $commentRepo ,SubjectRepository $subject , Request $request,EntityManagerInterface $entityManager) : Response
    {

        $comment = New Comments();
        $subjectSelected = $request->get('id');
      
        $content=$request->get('comment_content');
        $user = $this->getUser();
        $comment->setContent($content);
        $comment->setSubject($subject->find($subjectSelected));
        $comment->addIdUser($user);
        
        $entityManager->persist($comment);
        $entityManager->flush();
        

        return $this->redirectToRoute('app_front');


    }

    #[Route('/comment/remove/{$id}', name: 'comment_remove')]
    public function CommentRemove(CommentsRepository $commentRepo ,SubjectRepository $subject , Request $request,EntityManagerInterface $entityManager) : Response
    {
        $comment = New Comments();
        $comment = $commentRepo->find($request->get('id'));
        $entityManager->remove($comment);
        $entityManager->flush();
        return $this->redirectToRoute('app_front');
    }

    #[Route('/like/add/{$id}', name: 'like_add')]
    public function like_add(LikeRepository $likeRepo ,SubjectRepository $subject , Request $request,EntityManagerInterface $entityManager) : Response
    {
        $like = new Like();

        $subjectSelected = $subject->find($request->get('id'));
        $user = $this->getUser(); 
        $like->setIdSubject($subjectSelected);
        $like->setIdUser($user);
        $like->setIsLiked(1);
        $entityManager->persist($like);
        $entityManager->flush();
        return $this->redirectToRoute('app_front');

    }

    #[Route('/like/remove/{$id}', name: 'like_remove')]
    public function like_remove(LikeRepository $likeRepo ,SubjectRepository $subject , Request $request,EntityManagerInterface $entityManager) : Response
    {
        $user = $this->getUser(); 
        $like =  $likeRepo->find($user);
        $entityManager->remove($like);
        $entityManager->flush();
        return $this->redirectToRoute('app_front');
    }

    





}
