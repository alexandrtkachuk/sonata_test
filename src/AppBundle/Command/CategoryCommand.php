<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 24.11.17
 * Time: 12:34
 */

namespace AppBundle\Command;


use AppBundle\Entity\Category;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CategoryCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            // php bin/console app:category-command
            ->setName('app:category-command')

            // the short description shown while running "php bin/console list"
            ->setDescription('Category manager.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Create and find category( app:category-command create newNameCat or  app:category-command find 1)')

            ->addArgument('action', InputArgument::REQUIRED, 'some action create|find')
            ->addArgument('param', InputArgument::REQUIRED, 'Some param')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$entityManager = $this->
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');


        if($input->getArgument('action') == 'create') {
            $cat = new Category();

            $cat->setName($input->getArgument('param'));
            $cat->setUserId(1);

            //создание элемента

            $em->persist($cat);
            $em->flush();

            $output->writeln([
                'Create cat id: ' . $cat->getId(),
            ]);


        } elseif ($input->getArgument('action') == 'find') {
            $product = $em ->getRepository(Category::class)
                ->find($input->getArgument('param')) //без этого метода потянет оч моного всего
            ;
            //поиск

            dump($product);

        } else {
            $output->writeln([
               'Not found action',
            ]);
        }

    }
}