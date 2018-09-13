<?php

namespace Fixtures;

use App\Entity\Post\Content;
use App\Entity\Post\Meta;
use App\Entity\Post\Post;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class BlogFixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $post = new Post(
                \DateTimeImmutable::createFromMutable($faker->dateTime),
                trim($faker->sentence, '.'),
                new Content(
                    $faker->text(500),
                    $faker->paragraphs(5, true)
                ),
                new Meta(
                    trim($faker->sentence, '.'),
                    $faker->text(200)
                )
            );

            $count = random_int(0, 10);
            for ($j = 0; $j < $count; $j++) {
                $post->addComment(
                    \DateTimeImmutable::createFromMutable($faker->dateTime),
                    $faker->name,
                    $faker->text(200)
                );
            }

            $manager->persist($post);
        }

        $manager->flush();
    }
}