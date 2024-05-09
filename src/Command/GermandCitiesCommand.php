<?php

namespace App\Command;

use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Countries;

class GermandCitiesCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:citiesGermany')
            ->setDescription('Fill database with data from API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Vider la table City avant d'insérer de nouvelles données
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('ville', true /* whether to cascade */));

        // Récupérer l'entité du pays correspondant à partir de l'ID du pays (Allemagne)
        $countryRepository = $this->entityManager->getRepository(Countries::class);
        $germany = $countryRepository->find(63); // ID de l'Allemagne

        // Tableau des 50 grandes villes allemandes
        $germanCities = [
            ["nom" => "Berlin", "code" => "10117"],
            ["nom" => "Hambourg", "code" => "20095"],
            ["nom" => "Munich", "code" => "80331"],
            ["nom" => "Cologne", "code" => "50667"],
            ["nom" => "Francfort-sur-le-Main", "code" => "60311"],
            ["nom" => "Stuttgart", "code" => "70173"],
            ["nom" => "Düsseldorf", "code" => "40213"],
            ["nom" => "Dortmund", "code" => "44135"],
            ["nom" => "Essen", "code" => "45127"],
            ["nom" => "Leipzig", "code" => "04109"],
            ["nom" => "Brême", "code" => "28195"],
            ["nom" => "Dresde", "code" => "01067"],
            ["nom" => "Hanovre", "code" => "30159"],
            ["nom" => "Nuremberg", "code" => "90402"],
            ["nom" => "Duisbourg", "code" => "47051"],
            ["nom" => "Bochum", "code" => "44787"],
            ["nom" => "Wuppertal", "code" => "42103"],
            ["nom" => "Bielefeld", "code" => "33602"],
            ["nom" => "Bonn", "code" => "53111"],
            ["nom" => "Münster", "code" => "48143"],
            ["nom" => "Karlsruhe", "code" => "76133"],
            ["nom" => "Mannheim", "code" => "68159"],
            ["nom" => "Augsbourg", "code" => "86150"],
            ["nom" => "Wiesbaden", "code" => "65183"],
            ["nom" => "Gelsenkirchen", "code" => "45879"],
            ["nom" => "Mönchengladbach", "code" => "41061"],
            ["nom" => "Braunschweig", "code" => "38100"],
            ["nom" => "Chemnitz", "code" => "09111"],
            ["nom" => "Kiel", "code" => "24103"],
            ["nom" => "Aix-la-Chapelle", "code" => "52062"],
            ["nom" => "Halle-sur-Saale", "code" => "06108"],
            ["nom" => "Magdebourg", "code" => "39104"],
            ["nom" => "Krefeld", "code" => "47798"],
            ["nom" => "Fribourg-en-Brisgau", "code" => "79098"],
            ["nom" => "Lübeck", "code" => "23552"],
            ["nom" => "Oberhausen", "code" => "46045"],
            ["nom" => "Erfurt", "code" => "99084"],
            ["nom" => "Mayence", "code" => "55116"],
            ["nom" => "Rostock", "code" => "18055"],
            ["nom" => "Kassel", "code" => "34117"],
            ["nom" => "Hagen", "code" => "58095"],
            ["nom" => "Hamm", "code" => "59065"],
            ["nom" => "Saarbrücken", "code" => "66111"],
            ["nom" => "Mülheim-sur-le-Rhin", "code" => "45468"],
            ["nom" => "Potsdam", "code" => "14467"],
            ["nom" => "Ludwigshafen", "code" => "67059"],
            [
                "nom" => "Oldenburg", "code" => "26121"
            ],
            ["nom" => "Leverkusen", "code" => "51373"],
        ];


        // Compter le nombre total de villes insérées
        $totalInserted = 0;

        foreach ($germanCities as $cityData) {
            $city = new Ville();
            $city->setNom($cityData['nom']);
            $city->setCode(intval($cityData['code']));
            $city->setCountries($germany);
            $this->entityManager->persist($city);
            $totalInserted++;
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
