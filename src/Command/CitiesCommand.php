<?php

namespace App\Command;

use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Countries;

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


        // Récupérer l'entité du pays correspondant à partir de l'ID du pays (France)
        $countryRepository = $this->entityManager->getRepository(Countries::class);
        $france = $countryRepository->find(55); // ID de la France

        // Récupérer les 500 plus grandes villes de la France
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://geo.api.gouv.fr/communes', [
            'query' => [
                'fields' => 'nom,code',
                'limit' => 500,
                'order' => 'population',
                'sort' => 'desc',
                'boost[]' => 'population',
            ]
        ]);

        $citiesFrance = $response->toArray();

        // Compter le nombre total de villes insérées
        $totalInserted = 0;

        foreach ($citiesFrance as $cityData) {
            $city = new Ville();
            $city->setNom($cityData['nom']);
            $city->setCode(intval($cityData['code']));
            $city->setCountries($france); // Associer la ville à la France

            $this->entityManager->persist($city);
            $totalInserted++;
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
