<?php

namespace App\Form;

use App\Entity\SupportCase;
use App\Entity\Enum\StatusType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateCaseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('summary', TextType::class, [
                'required' => true,
                'label' => 'Summary',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ],
                'attr' => [
                    'placeholder' => 'Enter Summary',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a summary']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your summary should be at least {{ limit }} characters',
                        'max' => 60,
                        'maxMessage' => 'Your summary is limited to {{ limit }} characters',
                    ]),
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ],
                'attr' => [
                    'placeholder' => 'Enter Description',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter description']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your description should be at least {{ limit }} characters',
                        'max' => 1000,
                        'maxMessage' => 'Your description is limited to {{ limit }} characters',
                    ]),
                ]
            ])
//            ->add('status', EnumType::class, ['class' => StatusType::class])
            ->add('imageFile', FileType::class, ['required' => false, 'mapped' => false])
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupportCase::class,
        ]);
    }
}
