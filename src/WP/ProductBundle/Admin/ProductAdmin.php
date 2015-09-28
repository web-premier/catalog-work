<?php
namespace WP\ProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class ProductAdmin extends Admin
{
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title');
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, array('label' => 'Название'))
            ->add('categories', null, array('label' => 'Раздел'))
            ->add('sku', null, array('label' => 'Артикул'))
            ->add('basePrice', null, array('label' => 'Цена'))
            ->add('specialPrice', null, array('label' => 'Спецредложение'))
            ->add('cover', 'sonata_type_model_list', array('label' => 'Главная картинка'), array(
                'link_parameters' => array(
                    'context' => 'product',
                    'provider' => 'sonata.media.provider.image'
                )))
            ->add(
                'images', 'sonata_type_collection',
                [
                    'label' => 'Дополнительные изображения',
                    'by_reference' => false,
                    'required' => false,
                    'type_options' => array(
                        // Prevents the "Delete" option from being displayed
                        'delete' => true
                    )
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'pos'
                ]
            );
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('title', null, array('label' => 'Название'))
            ->add('categories', null, array('label' => 'Раздел'));
    }

}
