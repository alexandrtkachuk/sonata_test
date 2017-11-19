<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 19.11.17
 * Time: 20:10
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BlogPostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        // ... configure $formMapper
        $formMapper
            ->add('title', 'text')
            ->add('body', 'textarea')

            ->add('category', 'sonata_type_model', array(
                'class' => 'AppBundle\Entity\Category',
                'property' => 'name',
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        // ... configure $listMapper

        $listMapper
            ->addIdentifier('title')
            ->add('category.name')
            ->add('draft')
        ;

    }
}