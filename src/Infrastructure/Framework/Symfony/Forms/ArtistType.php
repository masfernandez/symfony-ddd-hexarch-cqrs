<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Framework\Symfony\Forms;

use App\Application\UseCase\Artist\Dto\ArtistDto;
use App\Domain\Model\Album\Album;
use App\Infrastructure\Persistence\Doctrine\Repository\AlbumRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ArtistType
 * @package App\Domain\Model\Artist\Forms
 */
class ArtistType extends AbstractType implements DataMapperInterface
{
    /**
     * @var AlbumRepository
     */
    private $albumRepository;

    /**
     * ArtistType constructor.
     * @param AlbumRepository $albumRepository
     */
    public function __construct(AlbumRepository $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('specialisation', TextType::class)
            ->add('album', EntityType::class, [
                'required' => true,
                'class' => Album::class,
                'choice_label' => 'title',
            ])
            ->add('submit', SubmitType::class)
            ->setDataMapper($this);;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Artist::class,
            'empty_data' => null,
        ]);
    }

    /**
     * @param ArtistDto $data
     * @param FormInterface[]|\Traversable $forms
     */
    public function mapDataToForms($data, $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['name']->setData($data == null ?: $data->getName());
        $forms['specialisation']->setData($data == null ?: $data->getSpecialisation());
        $forms['album']->setData($data == null ?: $this->albumRepository->findOne($data->getAlbum()));
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param array $data
     */
    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);
        $data = [
            'name' => $forms['name']->getData(),
            'specialisation' => $forms['specialisation']->getData(),
            'albumId' => $forms['album']->getData()->getId()
        ];
    }
}