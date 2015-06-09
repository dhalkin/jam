<?php

namespace Assignment\JamStorageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Assignment\JamStorageBundle\Services\JamJarService;

/**
 * Class JamJarAdmin
 * @package Assignment\JamStorageBundle\Admin
 */
class JamJarAdmin extends Admin
{

    /**
     * @var JamJarService
     */
    private $jamJarService;

    /**
     * @param JamJarService $jamJarService
     */
    public function setJamJarService(JamJarService $jamJarService)
    {
        $this->jamJarService = $jamJarService;
    }

    /**
     *
     * @param mixed $jamJar
     */
    public function prePersist($jamJar)
    {
        $amount = (int)$this->getForm()->get('amount')->getData();
        if ($amount > 1) {
            $this->jamJarService->createAdditional($jamJar, --$amount);
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', 'entity', ['class' => 'Assignment\JamStorageBundle\Entity\JamType'])
            ->add('year', 'entity', ['class' => 'Assignment\JamStorageBundle\Entity\Year'])
            ->add('comment', 'text', ['required' => false, 'label' => 'jam.jar.comment.label']);
        $jamJar = $this->getSubject();
        if (!$jamJar->getId()) {
            $formMapper->add(
                'amount',
                'number',
                ['mapped' => false, 'data' => 1, 'label' => 'jam.jar.amount.label']
            );
        }
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type')
            ->add('year');
    }


    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('type')
            ->add('year')
            ->add('comment')
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                )
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('type')
            ->add('year')
            ->add('comment');
    }
}
