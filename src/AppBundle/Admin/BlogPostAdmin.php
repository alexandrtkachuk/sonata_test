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

    public function prePersist($object)
    {

        if (method_exists($object, 'setUserId')) {

            $user = $this->getConfigurationPool()->getContainer()
                ->get('security.token_storage')->getToken()->getUser();
            $object->setUserId($user->getId());
        }
        #*/

    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0] . '.userId', ':userId')
        );

        $userId = $this->getConfigurationPool()->getContainer()
            ->get('security.token_storage')->getToken()->getUser()->getId();

        $query->setParameter('userId', $userId);
        return $query;
    }
}