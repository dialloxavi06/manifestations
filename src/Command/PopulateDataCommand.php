<?php

namespace App\Command;

use App\Entity\Commune;
use App\Entity\Departement;
use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:populate:data',
    description: 'Fill database with data from API  ',
)]
class PopulateDataCommand extends Command
{
    protected static $defaultName = 'app:populate:data';
    protected static $defaultDescription = 'Populate database with data from API';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->truncateTables(); // Supprimer les données existantes dans les tables

        ini_set("memory_limit", "-1");

        $client = HttpClient::create();
        $regionsResponse = $client->request('GET', 'https://geo.api.gouv.fr/regions');
        $regionsData = $regionsResponse->toArray();

        foreach ($regionsData as $regionData) {
            $region = new Region();
            $region->setNom($regionData['nom']);
            $region->setCode($regionData['code']);
            $this->entityManager->persist($region);

            $departementsResponse = $client->request('GET', 'https://geo.api.gouv.fr/regions/' . $regionData['code'] . '/departements');
            $departementsData = $departementsResponse->toArray();

            foreach ($departementsData as $departementData) {
                $departement = new Departement();
                $departement->setNom($departementData['nom']);
                $departement->setCode($departementData['code']);
                $departement->setRegion($region);
                $this->entityManager->persist($departement);

                // Récupérer les communes avec population et trier par population
                $communesResponse = $client->request('GET', 'https://geo.api.gouv.fr/departements/' . $departementData['code'] . '/communes');
                $communesData = $communesResponse->toArray();


                // Limiter à 2000 communes
                $communesData = array_slice($communesData, 0, 2000);

                foreach ($communesData as $communeData) {
                    $commune = new Commune();
                    $commune->setNom($communeData['nom']);
                    $commune->setCode($communeData['code']);
                    $commune->setDepartement($departement);
                    $commune->setRegion($region);
                    $this->entityManager->persist($commune);
                }
            }
        }

        $this->entityManager->flush();

        $io = new SymfonyStyle($input, $output);
        $io->success('Data successfully fetched from API and inserted into the database.');

        return Command::SUCCESS;
    }

    protected function truncateTables(): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeStatement($platform->getTruncateTableSQL('commune', true));
        $connection->executeStatement($platform->getTruncateTableSQL('departement', true));
        $connection->executeStatement($platform->getTruncateTableSQL('region', true));
    }
}
