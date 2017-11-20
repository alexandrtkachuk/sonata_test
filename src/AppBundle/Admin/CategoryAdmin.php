<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 14.11.17
 * Time: 22:15
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
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
