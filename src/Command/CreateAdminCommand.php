<?php

namespace App\Command;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create a new administrator account.'
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $helper = $this->getHelper('question');

        $email = trim((string) $helper->ask(
            $input,
            $output,
            new Question('Email: ')
        ));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $output->writeln('<error>Invalid email address.</error>');
            return Command::FAILURE;
        }

        $existingUser = $this->entityManager
            ->getRepository(Utilisateur::class)
            ->findOneBy(['email' => $email]);

        if ($existingUser !== null) {
            $output->writeln('<error>This email is already registered.</error>');
            return Command::FAILURE;
        }

        $firstName = trim((string) $helper->ask(
            $input,
            $output,
            new Question('First name: ')
        ));

        $lastName = trim((string) $helper->ask(
            $input,
            $output,
            new Question('Last name: ')
        ));

        $birthDateInput = trim((string) $helper->ask(
            $input,
            $output,
            new Question('Birth date (YYYY-MM-DD): ')
        ));

        $birthDate = \DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $birthDateInput
        );

        if (
            $birthDate === false ||
            $birthDate->format('Y-m-d') !== $birthDateInput
        ) {
            $output->writeln('<error>Invalid birth date.</error>');
            return Command::FAILURE;
        }

        $phone = trim((string) $helper->ask(
            $input,
            $output,
            new Question('Phone: ')
        ));

        $passwordQuestion = new Question('Password: ');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);

        $password = $helper->ask(
            $input,
            $output,
            $passwordQuestion
        );

        if (!is_string($password) || strlen($password) < 12) {
            $output->writeln(
                '<error>Password must contain at least 12 characters.</error>'
            );
            return Command::FAILURE;
        }

        $user = new Utilisateur();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setBirthDate($birthDate);
        $user->setPhone($phone);
        $user->setRoles(['ROLE_ADMIN']);

        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $password)
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln(
            '<info>Administrator account created successfully.</info>'
        );

        return Command::SUCCESS;
    }
}
