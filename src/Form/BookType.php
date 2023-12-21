<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Regex;

class BookType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a title.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Title cannot be longer than {{ limit }} characters.',
                    ]),
                    new Type([
                        'type' => 'string',
                        'message' => 'Title must be a valid string.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Za-z])(?=.*\d).+$/',
                        'message' => 'Title must contain at least one letter and one digit.',
                    ]),
                ],
            ])
            ->add('author', TextType::class, [
                'label' => 'Author',
                'constraints' => [
                    new NotBlank(['message' => 'Please enter an author.']),
                    new Type([
                        'type' => 'string',
                        'message' => 'Author must be a valid string.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Za-z])(?=.*\d).+$/',
                        'message' => 'Author must contain at least one letter and one digit.',
                    ]),
                ],
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
                'constraints' => [
                    new NotBlank(['message' => 'Please enter an ISBN.']),
                    new Type([
                        'type' => 'string',
                        'message' => 'ISBN must be a valid string.',
                    ]),
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'ISBN must contain only digits.',
                    ]),
                ],
            ])
            ->add('publishedAt', DateType::class, [
                'label' => 'Published At',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Save']);
    }
}