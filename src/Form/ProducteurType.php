<?php

namespace App\Form;

use App\Entity\Producteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProducteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,['attr'=>['class'=>'form-control']])
            ->add('prenoms', TextType::class,['attr'=>['class'=>'form-control']])
            ->add('pseudonyme', TextType::class,[
				'attr'=>['class'=>'form-control'],
	            'required' => false
            ])
            ->add('entreprise', TextType::class,['attr'=>['class'=>'form-control']])
            ->add('email', EmailType::class,['attr'=>['class'=>'form-control']])
            ->add('telephone', TelType::class,['attr'=>['class'=>'form-control']])
            ->add('artistes', TextType::class,[
				'attr'=>['class'=>'form-control tags', 'placeholder'=>"Noms des artistes - albums", 'data-role'=>"tagsinput"],
	            'help' => 'Séparez par des virgules les noms des artistes et albums produits',
	            'label' => 'Artistes et albums produits'
            ])
	        /*->add('albums', TextType::class,[
				'attr'=>['class'=>'form-control', 'placeholder' => "Titres des albums", 'data-role'=>"tagsinput"],
				'help' => 'Séparez par des virgules les titres des albums produits'
			])
			/*->add('explication', TexteaType::class,[
				'attr'=>['class'=>'form-control', 'rows'=>5],
				'label' => "Pourquoi voulez-vous intégrer l'APRODEMCI? "
			])*/
            ->add('accord', CheckboxType::class,[
				'attr'=>['class'=>'form-check-input'],
	            'label'=>"En cochant cette case vous faites votre demande d'adhésion à l'APRODEMCI"
            ])
            //->add('statut')
            ->add('media', FileType::class,[
	            'attr'=>['class'=>"dropify-fr", 'data-preview' => ".preview"],
	            'label' => "Télécharger votre photo",
	            'mapped' => false,
	            'multiple' => false,
	            'constraints' => [
		            new File([
			            'maxSize' => "1000000k",
			            'mimeTypes' =>[
				            'image/png',
				            'image/jpeg',
				            'image/jpg',
				            'image/gif',
				            'image/webp',
			            ],
			            'mimeTypesMessage' => "Votre fichier doit être de type image"
		            ])
	            ],
	            'required' => false
            ])
            //->add('slug')
            //->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producteur::class,
        ]);
    }
}
