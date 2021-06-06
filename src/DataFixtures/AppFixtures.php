<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Menu;
use App\Entity\Recipe;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = ['Vegan', 'Végétarien', 'Pescovégétarien'];
        $tabObjCategory = [];

        foreach($categories as $c) {
            $cat = new Category;
            $cat-> setName($c);
            $manager->persist($cat);
            array_push($tabObjCategory,$cat);
        }
        $menus = ['Entrée', 'Plat', 'Dessert'];
        $tabObjMenu = [];

        foreach($menus as $m) {
            $menu = new Menu;
            $menu-> setName($m);
            $manager->persist($menu);
            array_push($tabObjMenu,$menu);
        }
        $recipe = new Recipe;
        $recipe
            ->setName('Galette de pommes de terre')
            ->setCookTime('45')
            ->setIngredients('4 grosses pommes de terre type Bintje
            2 oignons
            1 œuf
            2 c. à soupe de farine blanche
            2 c. à soupe d’huile de tournesol
            sel, poivre')
            ->setInstructions("1.Épluchez vos pommes de terre et vos oignons et râpez-les avec une râpe côté gros trous.
            2. Mélangez bien les pommes de terre, les oignons, la farine et l’œuf dans un saladier,
             salez et poivrez. Vous pouvez aussi ajouter des herbes aromatiques ou des épices.
             3. Dans une poêle, faites chauffer l'huile et disposez des petites galettes (versez une grosse cuiller de
              la préparation pour chaque galette, et aplatissez-la à l'aide de la cuiller).
              4.Faites cuire à feu moyen jusqu'à ce que les galettes soient bien dorées de chaque côté.
              5.Continuez tant qu'il reste de la pâte, puis servez les galettes accompagnées de salade verte.")
            ->setCreatedAt(new DateTime('Europe/Paris'))
            ->setCategory($tabObjCategory[0])
            ->setMenu($tabObjMenu[0])
            ->setImageFile('recette.jpeg')
            ->setCatchline('blablabla');
        $manager->persist($recipe);

        $manager->flush();

    }

    // $product = new Product();
    // $manager->persist($product);

}
