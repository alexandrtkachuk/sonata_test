<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 24.11.17
 * Time: 10:32
 */


namespace AppBundle\Command;

use AppBundle\Entity\Category;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class MyTestCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            // php bin/console app:my-test
            ->setName('app:my-test')

            // the short description shown while running "php bin/console list"
            ->setDescription('Simple test command.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to some echo...')

            ->addArgument('testParam', InputArgument::REQUIRED, 'Some text.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            ' Hi, people',
            '============',
            '',
        ]);

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

        $output->writeln('Youre message:' .$input->getArgument('testParam'));

        // outputs a message without adding a "\n" at the end of the line
        $output->write('End ');
        $output->write('msg.' . "\n");

        //$entityManager = $this->
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');


        if($input->getArgument('testParam') == 'create') {
            $cat = new Category();

            $cat->setName('Some Lalala');
            $cat->setUserId(1);

            //создание элемента

            $em->persist($cat);
            $em->flush();
        } elseif ($input->getArgument('testParam') == 'find') {
            $product = $em ->getRepository(Category::class)
                ->find() //без этого метода потянет оч моного всего
            ;
            //поиск

            dump($product);

        }

    }


}