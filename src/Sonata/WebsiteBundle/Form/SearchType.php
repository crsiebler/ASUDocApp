<?php

namespace Sonata\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\NavbarFormInterface;

class SearchType extends AbstractType implements NavbarFormInterface {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->setAttribute('render_fieldset', false)
                ->setAttribute('label_render', false)
                ->setAttribute('show_legend', false)
                ->add('searchTerm', 'text', array(
                    'widget_control_group' => false,
                    'widget_controls' => false,
                    'attr' => array(
                        'placeholder' => "search",
                        'class' => "input-medium search-query"
                    )
                ))
        ;
    }

    public function getName() {
        return 'sonata_websitebundle_searchtype';
    }

    public function getRoute() {
        return 'sonata_website_default_search';
    }

}
