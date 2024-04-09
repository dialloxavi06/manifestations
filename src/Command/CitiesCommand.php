<?php

namespace App\Command;

use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

class CitiesCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:cities')
            ->setDescription('Fill database with data from API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Initialiser la limite de mémoire
        ini_set('memory_limit', '256M');

        // Vider la table Ville avant d'insérer de nouvelles données
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('ville', true /* whether to cascade */));

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://geo.api.gouv.fr/communes');

        $cities = $response->toArray();

        // Compter le nombre total de villes insérées
        $totalInserted = 0;

        // Insérer seulement 2000 villes
        foreach ($cities as $cityData) {
            if ($totalInserted >= 2000) {
                break; // Sortir de la boucle si le nombre total inséré atteint 2000
            }

            $ville = new Ville();
            $ville->setNom($cityData['nom']);
            $ville->setCode(intval($cityData['code']));

            $this->entityManager->persist($ville);
            $totalInserted++;
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
