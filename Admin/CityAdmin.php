<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CityAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array(
                'label' => 'weather.label_name',
            ))
            ->add('woeid', null, array(
                'label' => 'weather.label_woeid',
            ))
            ->add('createdAt', 'doctrine_orm_date', array(
                'field_type' => 'sonata_type_datetime_picker',
                'label' => 'weather.label_created_at',
            ))
            ->add('updatedAt', 'doctrine_orm_date', array(
                'field_type' => 'sonata_type_datetime_picker',
                'label' => 'weather.label_updated_at',
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name', null, array(
                'label' => 'weather.label_name',
            ))
            ->add('slug')
            ->add('woeid', null, array(
                'label' => 'weather.label_woeid',
            ))
            ->add('createdAt', null, array(
                'label' => 'weather.label_created_at',
            ))
            ->add('updatedAt', null, array(
                'label' => 'weather.label_updated_at',
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array(
                'label' => 'weather.label_name',
            ))
            ->add('slug', null, array('disabled' => true))
            ->add('woeid', null, array(
                'label' => 'weather.label_woeid',
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name', null, array(
                'label' => 'weather.label_name',
            ))
            ->add('slug')
            ->add('woeid', null, array(
                'label' => 'weather.label_woeid',
            ))
            ->add('createdAt', null, array(
                'label' => 'weather.label_created_at',
            ))
            ->add('updatedAt', null, array(
                'label' => 'weather.label_updated_at',
            ))
        ;
    }
}
