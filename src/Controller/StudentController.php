<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function new(Request $request): Response
{
    $student = new Student();
    $form = $this->createForm(StudentType::class, $student);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($student);
        $entityManager->flush();

        return $this->redirectToRoute('student_index');
    }

    return $this->render('student/new.html.twig', [
        'student' => $student,
        'form' => $form->createView(),
    ]);
}
/**
 * @Route("/students", name="student_index")
 */
public function index(): Response
{
    $students = $this->getDoctrine()
        ->getRepository(Student::class)
        ->findAll();

    return $this->render('student/index.html.twig', [
        'students' => $students,
    ]);
}
/**
 * @Route("/students/{id}/edit", name="student_edit")
 */
public function edit(Request $request, Student $student): Response
{
    $form = $this->createForm(StudentType::class, $student);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('student_index');
    }
}
}
