<?php

namespace App\Command;

use App\Entity\Countries;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Region;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Departement;


#[AsCommand(
    name: 'app:region',
    description: 'Fill database with data from API',
)]
class RegionCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Fill database with data from API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://geo.api.gouv.fr/regions');
        $regionsData = $response->toArray();

        $country = $this->entityManager->getRepository(Countries::class)->find(55);

        foreach ($regionsData as $regionData) {
            // Créer une nouvelle instance de l'entité Region et définir ses propriétés
            $region = new Region();
            $region->setNom($regionData['nom']);
            $region->setCode($regionData['code']);
            $region->setPays($country);
            // Persistez l'entité dans la base de données
            $this->entityManager->persist($region);
            // Récupérer les départements pour cette région
            $departementsResponse = $client->request('GET', 'https://geo.api.gouv.fr/regions/' . $regionData['code'] . '/departements');
            $departementsData = $departementsResponse->toArray();

            foreach ($departementsData as $departementData) {
                // Créer une nouvelle instance de l'entité Departement et définir ses propriétés
                $departement = new Departement();
                $departement->setNom($departementData['nom']);
                $departement->setCode($departementData['code']);
                // Associer le département à la région
                $departement->setRegion($region);
                // Persistez l'entité dans la base de données
                $this->entityManager->persist($departement);
            }
        }

        // Exécuter les opérations d'écriture dans la base de données
        $this->entityManager->flush();

        $io = new SymfonyStyle($input, $output);
        $io->success('Data successfully fetched from API and inserted into the database.');

        return Command::SUCCESS;
    }
}
