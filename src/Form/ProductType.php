<?php

namespace App\Form;

use App\Entity\Product;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom du produit : ",
                'required' => true,
                'attr' => [
                    "placeholder" => "entrez le nom du produit",
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "le nom du produit ne doit pas etre vide",
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 4000,
                        'minMessage' => "le nom du produit doit contenir au minimum {{ limit }} caractères",
                        'maxMessage' => "le nom du produit ne doit pas contenir plus de {{ limit }} caratères",
                    ]),
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description du produit : ",
                'required' => true,
                'attr' => [
                    "placeholder" => "entrez la description du produit",
                    "row" => 4,
                ],

                'constraints' => [
                    new NotBlank([
                        'message' => "la description du produit ne doit pas etre vide",
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 4000,
                        'minMessage' => "la description du produit doit contenir au minimum {{ limit }} caractères",
                        'maxMessage' => "la description du produit ne doit pas contenir plus de {{ limit }} caratères",
                    ]),
                ],
            ])

            ->add('image', FileType::class, [
                'label' => "uploader une photo du produit",
                'required' => false,
                'multiple' => false,
                'mapped' => false,
                'attr' => [
                    "placeholder" => "uploader une image depuis votre PC",
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                    ]),
                ],
            ])

            ->add('price', IntegerType::class, [
                'label' => "Prix du produit : ",
                'required' => true,
                'attr' => [
                    "placeholder" => "entrez le prix du produit"
                ],
            ])

            ->add('category', EntityType::class, [
                'label' => "choisir la catégorie",
                'placeholder' => '-- choisir une catégorie',
                'class' => Category::class,
                'choice_label' => 'Name',
                "required" => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
