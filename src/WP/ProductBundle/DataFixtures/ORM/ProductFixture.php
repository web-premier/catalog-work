<?php

namespace WP\ProductBundle\DataFixtures\ORM;

use Application\Sonata\ClassificationBundle\Entity\Context;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use WP\MainBundle\DataFixtures\BaseFixture;
use WP\CategoryBundle\Entity\Category;
use WP\ProductBundle\Entity\Product;
use Application\Sonata\MediaBundle\Entity\Media;

/**
 * Adds products
 */
class ProductFixture extends BaseFixture implements  ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    protected function getRandomName()
    {
        $names = [
            'Комплект',
            'Украшение',
            'Кольцо',
            'Браслет'
        ];

        return $names[array_rand($names)];
    }

    public function load(ObjectManager $manager)
    {
        $context = new Context();
        $context->setId('product');
        $context->setName('product');
        $context->setEnabled(true);
        $manager->persist($context);

        $category = new \Application\Sonata\ClassificationBundle\Entity\Category();
        $category->setName('product');
        $category->setContext($context);
        $category->setEnabled(true);
        $manager->persist($category);


        for ($i = 0; $i < 20; $i++) {
            $product = new Product;

            $product->setBasePrice(mt_rand(100, 10000));

            if (mt_rand(0, 1) == 1) {
                $product->setSpecialPrice($product->getBasePrice() - mt_rand(10, 90));
            }

            $product->setSku($this->generateRandomString(mt_rand(6, 10)));
            $product->setTitle($this->getRandomName());

            /** @var Media $media */
            $media = $this->container->get('sonata.media.manager.media')->create();

            $media->setBinaryContent(sprintf('%s/images/%s.jpg', __DIR__, mt_rand(1, 19)));

            $media->setDescription($product->getTitle());
            $media->setCategory($category);

            $media->setEnabled(true);


            $this->container->get('sonata.media.manager.media')->save($media, 'product', 'sonata.media.provider.image');



            $product->setCover($media);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
