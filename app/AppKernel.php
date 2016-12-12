<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // Bundles par défaut de Symfony
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),

            // Bundle permettant d'alimenter automatiquement la BdD
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            // Bundle permettant de migrer automatiquement la BdD lors de changements de modèle de données
	        new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),

            // Gestion des utilisateurs
            new FOS\UserBundle\FOSUserBundle(),

            // Sonata Bundles
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new \Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new \Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\ClassificationBundle\SonataClassificationBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
        		
        	// Ajout de champs de formulaires supplémentaires et intégration avec Twitter Bootstrap
        	new Genemu\Bundle\FormBundle\GenemuFormBundle(),
        	new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),

            // Nos bundles :
            // Bundle par défaut, contenant la majorité de nos pages
            new AppBundle\AppBundle(),
            // Bundle contenant nos entités et pages liées à la gestion des utilisateurs
            new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
            // Bundle contenant nos entités et pages liées à la gestion des médias (images, fichiers)
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
            new Application\Sonata\ClassificationBundle\ApplicationSonataClassificationBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            // Les bundles uniquement activés pour les développements mais inactifs en production
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
