<?php

namespace App\Command;

use App\Entity\Staedte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Countries;
use Symfony\Component\Console\Attribute\AsCommand;






#[AsCommand(
    name: 'app:citiesGermany',
    description: 'Fill database with German regions',
)]
class GermandCitiesCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private HttpClientInterface $httpClient;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient, private ParameterBagInterface $parameterBag)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:citiesGermany')
            ->setDescription('Fill database with data from API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Obtenez le répertoire du projet
        $projectDir = $this->parameterBag->get('kernel.project_dir');

        // Construisez le chemin vers le fichier JSON
        $json = $projectDir . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'de.json';
        // Charger les données depuis le fichier JSON
        $data = json_decode(file_get_contents($json), true);

        $country = $this->entityManager->getRepository(Countries::class)->find(63); // Assurez-vous que l'ID du pays est correct

        // Parcourir les données
        foreach ($data as $cityData) {
            // Créer une nouvelle entité Staedte
            $city = new Staedte();
            $city->setNom($cityData['city']);
            $city->setCode($cityData['admin_name']);
            // Ajouter l'entité à l'EntityManager
            $city->setPays($country);

            // Persister l'entité
            $this->entityManager->persist($city);
        }


        // Sauvegarder les entités dans la base de données
        $this->entityManager->flush();

        $output->writeln('Database filled successfully.');

        return Command::SUCCESS;
    }
}
