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
        ini_set('memory_limit', '512M');

        // Vider la table Ville avant d'insérer de nouvelles données
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('ville', true /* whether to cascade */));

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://geo.api.gouv.fr/communes');

        $cities = $response->toArray();

        // Définir la taille du lot pour l'insertion
        $batchSize = 1000;

        // Compter le nombre total de villes insérées
        $totalInserted = 0;

        foreach (array_chunk($cities, $batchSize) as $chunk) {
            $this->entityManager->beginTransaction();
            try {
                foreach ($chunk as $cityData) {
                    $ville = new Ville();
                    $ville->setNom($cityData['nom']);
                    $ville->setCode(intval($cityData['code']));
                    $this->entityManager->persist($ville);
                    $totalInserted++;
                }

                $this->entityManager->flush();
                $this->entityManager->commit();
            } catch (\Throwable $e) {
                $this->entityManager->rollback();
                throw $e;
            }
        }

        return Command::SUCCESS;
    }
}
