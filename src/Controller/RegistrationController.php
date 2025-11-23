<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Language;
use App\Entity\ProficiencyLevel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }

        $languages = $em->getRepository(Language::class)->findAll();
        $proficiencyLevels = $em->getRepository(ProficiencyLevel::class)->findAll();

        if ($request->isMethod('POST')) {
            $username = trim((string) $request->request->get('username'));
            $email = trim((string) $request->request->get('email'));
            $plainPassword = (string) $request->request->get('password');
            $nativeLanguageId = (int) $request->request->get('nativeLanguage');
            $targetLanguageId = (int) $request->request->get('targetLanguage');
            $proficiencyLevelId = (int) $request->request->get('proficiencyLevel');

            // Basic validation
            if (!$username || !$email || !$plainPassword || !$nativeLanguageId || !$targetLanguageId || !$proficiencyLevelId) {
                $this->addFlash('error', 'All fields are required.');
                return $this->redirectToRoute('app_register');
            }

            // Check email uniqueness
            if ($em->getRepository(User::class)->findOneBy(['email' => $email])) {
                $this->addFlash('error', 'Email is already in use.');
                return $this->redirectToRoute('app_register');
            }

            // Fetch related entities
            $nativeLanguage = $em->getRepository(Language::class)->find($nativeLanguageId);
            $targetLanguage = $em->getRepository(Language::class)->find($targetLanguageId);
            $proficiencyLevel = $em->getRepository(ProficiencyLevel::class)->find($proficiencyLevelId);

            if (!$nativeLanguage || !$targetLanguage || !$proficiencyLevel) {
                $this->addFlash('error', 'Invalid language or proficiency selection.');
                return $this->redirectToRoute('app_register');
            }

            // Create user
            $user = new User();
            $user->setUsername($username)
                ->setEmail($email)
                ->setFullName($username)
                ->setRole('LEARNER')
                ->setNativeLanguage($nativeLanguage->getName())
                ->setTargetLanguage($targetLanguage->getName())
                ->setProficiencyLevel($proficiencyLevel->getLevelName());

            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Registration successful. You can now log in.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
            'languages' => $languages,
            'proficiencyLevels' => $proficiencyLevels,
        ]);
    }
}
