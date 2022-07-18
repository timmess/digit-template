<?php

namespace App\Form;

use App\Entity\Digit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DigitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextareaType::class)
            ->add('methods', ChoiceType::class, [
                "choices" => [
                    "iptc" => "iptc",
                    "concepts" => "concepts",
                    "finalEntities" => "finalEntities",
                    "finalEntitiesAmb" => "finalEntitiesAmb",
                    "entitiesNotWiki" => "entitiesNotWiki",
                    "nec" => "nec",
                    "aliasTabAll" => "aliasTabAll",
                    "enhancedWiki" => "enhancedWiki",
                    "keywordsDetails" => "keywordsDetails",
                ],
                "multiple" => true,
                "expanded" => true,
            ])
            ->add('Analyser', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Digit::class,
        ]);
    }
}
