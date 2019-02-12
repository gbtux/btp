<?php

namespace App\Command;

use App\Entity\Article;
use App\Entity\FamilleArticle;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportRichardsonCommand extends Command
{
    protected static $defaultName = 'app:import:richardson';

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * AnonymepUserCreateCommand constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Import des tarifs de RICHARDSON')
            ->addArgument('file', InputArgument::REQUIRED, 'Fichier excel des tarifs')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument('file');

        if ($file) {
            $io->note(sprintf('Fichier import: %s', $file));
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            try{
                $spreadsheet = $reader->load($file);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                array_shift($sheetData);
                //TODO : supprimer la premiere ligne --> en-tete
                $nbInject = 0;
                foreach ($sheetData as $ligne) {
                    if(null !== $ligne[0]){
                        $article = new Article();
                        $article->setCode($ligne[0]);
                        $article->setCle($ligne[1]);
                        $famille = $this->manager->getRepository('App:FamilleArticle')->findOneBy(['code' => $ligne[2]]);
                        if(! $famille) {
                            $famille = new FamilleArticle();
                            $famille->setCode($ligne[2]);
                            $famille->setLibelle($ligne[3]);
                            $this->manager->persist($famille);
                        }
                        $article->setFamille($famille);
                        $article->setPrixPublic(floatval($ligne[4]));
                        $article->setPrixNet(floatval($ligne[5]));
                        $article->setUnite($ligne[6]);
                        $article->setGroupe($ligne[7]);
                        $article->setLibelle($ligne[8]);
                        $article->setNegoce($ligne[9]);
                        $this->manager->persist($article);
                        $nbInject++;
                    }
                }
                $this->manager->flush();
                $io->writeln(sprintf("Insertion terminée de %d articles", $nbInject));
            }catch (Exception $e){
                $io->writeln($e->getMessage());
            }
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}


/**
 * [0] => Code Article
[1] => Chiffre Clé
[2] => Code Famille
[3] => Libellé Famille
[4] => Prix Public
[5] => Prix Net
[6] => Unité
[7] => Code Groupe
[8] => Libellé Article
[9] => Négoce

 */