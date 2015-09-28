<?php

namespace WP\CategoryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use WP\MainBundle\DataFixtures\BaseFixture;
use WP\CategoryBundle\Entity\Category;

/**
 * Adds categories
 */
class CategoryFixture extends BaseFixture
{
    /**
     * Create category from array
     *
     * @param array $data
     *
     * @return Category
     */
    public function createCategory(array $data)
    {
        $category = new Category;
        $category->setTitle($data['title']);

        foreach ($data['childs'] as $child) {
            $category->addChildren($this->createCategory($child));
        }

        return $category;
    }

    public function load(ObjectManager $manager)
    {
        $data = [
            [
                'title' => 'Свадебная бижутерия',
                'childs' => [
                    ['title' => 'Комплекты', 'childs' => []],
                    ['title' => 'Аксессуары для волос', 'childs' => []],
                    ['title' => 'Итальянская коллекция', 'childs' => []],
                ]
            ],
            [
                'title' => 'Детская бижутерия',
                'childs' => [
                    ['title' => 'Серьги', 'childs' => []],
                    ['title' => 'Браслеты', 'childs' => []]
                ]
            ],
        ];

        foreach ($data as $category) {
            $manager->persist($this->createCategory($category));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
