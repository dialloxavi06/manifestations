<?php

namespace App\Command;

use App\Entity\Countries;
use App\Entity\Pays;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;


class PaysCommand extends Command
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setName('app:pays')
            ->setDescription('Fill database with data from API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Définir la limite de mémoire
        ini_set('memory_limit', '256M');



        $io = new SymfonyStyle($input, $output);

        $client = HttpClient::create();
        $totalInserted = 0;
        $offset = 0;
        $limit = 100; // Nombre d'enregistrements à récupérer à la fois

        // Boucle pour récupérer les données par lots jusqu'à atteindre 2500
        while ($totalInserted < 2500) {
            $response = $client->request('GET', 'https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/curiexplore-pays/records?limit=' . $limit . '&offset=' . $offset);
            $paysData = $response->toArray();

            // Vérifier si aucune donnée n'est retournée
            if (empty($paysData['results'])) {
                break;
            }

            // Insérer les données dans la base de données
            foreach ($paysData['results'] as $paysData) {
                $pays = new Countries();
                $pays->setNom($paysData['name_en']);
                $pays->setCodeIso($paysData['iso3']);

                $this->entityManager->persist($pays);
                $totalInserted++;
            }

            $offset += $limit; // Mettre à jour l'offset pour la prochaine requête
        }

        $this->entityManager->flush();

        $io->success('Nombre total de pays insérés : ' . $totalInserted);

        return Command::SUCCESS;
    }
}
