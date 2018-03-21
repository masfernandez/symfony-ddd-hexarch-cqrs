<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Framework\Symfony\Forms;

use App\Application\UseCase\Album\Dto\AlbumDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AlbumType
 * @package App\Domain\Model\Album\Forms
 */
class AlbumType extends AbstractType implements DataMapperInterface
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('publishing_date', DateType::class)
            ->add('submit', SubmitType::class)
            ->setDataMapper($this);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Album::class,
            'empty_data' => null,
        ]);
    }

    /**
     * @param AlbumDto $data
     * @param FormInterface[]|\Traversable $forms
     */
    public function mapDataToForms($data, $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['title']->setData($data ? $data->getTitle() : '');
        $forms['publishing_date']->setData($data ? $data->getPublishingDate() : new \DateTime());
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param array $data
     */
    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);

        $data = [
            'title' => $forms['title']->getData(),
            'publishing_date' => $forms['publishing_date']->getData()
        ];
    }
}