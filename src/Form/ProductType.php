<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name') // Champ pour le nom
            ->add('description') // Champ pour la description
            ->add('price') // Champ pour le prix
            ->add('quantity') // Champ pour la quantité
            ->add('image', FileType::class, [ // Champ pour téléverser un fichier
                'required' => false, // Le fichier n'est pas obligatoire
                'mapped' => false,
            ])
            ->add('category', EntityType::class, [ // Champ pour choisir une catégorie
                'class' => Category::class // Lié à l'entité Category
            ])
            ->add('Submit' , SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class, // Le formulaire est lié à l'entité Product
        ]);
    }
}
