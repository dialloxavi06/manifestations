<?php

namespace App\Command;

use App\Entity\Countries;
use App\Entity\Region;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:region',
    description: 'Fill database with German regions',
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
        $this->setDescription('Fill database with German regions');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $regionsData = [
            ['nom' => 'Baden-Württemberg', 'code' => 'DE-BW'],
            ['nom' => 'Bayern', 'code' => 'DE-BY'],
            ['nom' => 'Berlin', 'code' => 'DE-BE'],
            ['nom' => 'Brandenburg', 'code' => 'DE-BB'],
            ['nom' => 'Bremen', 'code' => 'DE-HB'],
            ['nom' => 'Hamburg', 'code' => 'DE-HH'],
            ['nom' => 'Hessen', 'code' => 'DE-HE'],
            ['nom' => 'Mecklenburg-Vorpommern', 'code' => 'DE-MV'],
            ['nom' => 'Niedersachsen', 'code' => 'DE-NI'],
            ['nom' => 'Nordrhein-Westfalen', 'code' => 'DE-NW'],
            ['nom' => 'Rheinland-Pfalz', 'code' => 'DE-RP'],
            ['nom' => 'Saarland', 'code' => 'DE-SL'],
            ['nom' => 'Sachsen', 'code' => 'DE-SN'],
            ['nom' => 'Sachsen-Anhalt', 'code' => 'DE-ST'],
            ['nom' => 'Schleswig-Holstein', 'code' => 'DE-SH'],
            ['nom' => 'Thüringen', 'code' => 'DE-TH'],
        ];

        $country = $this->entityManager->getRepository(Countries::class)->find(63); // Assurez-vous que l'ID du pays est correct

        foreach ($regionsData as $regionData) {
            $existingRegion = $this->entityManager->getRepository(Region::class)->findOneBy(['code' => $regionData['code']]);

            if (!$existingRegion) {
                $region = new Region();
                $region->setNom($regionData['nom']);
                $region->setCode($regionData['code']);
                $region->setPays($country);

                $this->entityManager->persist($region);
            } else {
                $io->note(sprintf('Region %s already exists, skipping.', $regionData['nom']));
            }
        }

        $this->entityManager->flush();

        $io->success('German regions successfully inserted into the database.');

        return Command::SUCCESS;
    }
}
