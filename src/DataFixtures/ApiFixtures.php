<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\BlogPost;
use App\Entity\User;
use App\Entity\Comment;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Faker\Factory;
use ApiPlatform\Core\Annotation\ApiResource;

class ApiFixtures extends Fixture
{
    private $encoder;
    private $faker;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = Factory::create();
    }



    public function load(ObjectManager $manager)
    {
        $this->load_author($manager);
        $this->load_blog_post($manager);
        $this->load_comments($manager);
    }

    public function load_blog_post(ObjectManager $manager)
    {
        for ($i = 10; $i < 100; $i++) {

            $user = new User();
            $user = $this->getReference("user" . strval($i) . "id");


            $blog = new BlogPost();
            $this->addReference("blog_post" . strval($i) . "id", $blog);

            $blog->setTitle($this->faker->realText(rand(10, 40)));
            $blog->setPublished($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $blog->setSlug('heading-one');
            $blog->setAuthor($user);
            $manager->persist($blog);
        }


        $manager->flush();
    }
    public function load_comments(ObjectManager $manager)
    {

        for ($i = 10; $i < 50; $i++) {
            $user = new User();
            $user = $this->getReference("user" . strval($i) . "id");

            $comment = new Comment();
            $comment->setContent($this->faker->realText(rand(10, 410)));
            $comment->setPublished($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $comment->setAuthor($user);

            $blog = new BlogPost();
            $blog  =  $this->getReference("blog_post" . strval($i) . "id");
            $comment->setPosts($blog);

            $manager->persist($comment);
        }

        $manager->flush();
    }
    public function load_author(ObjectManager $manager)
    {
        for ($i = 0; $i < 200; $i++) {

            $user = new User();


            $user->setUsername($this->faker->realText(rand(10, 20)));
            $password = $this->encoder->encodePassword($user, $this->faker->realText(rand(10, 30)));

            $user->setPassword($password);
            $user->setEmail("mohosin@gmail.com");
            $user->setFullname($this->faker->name);
            $this->addReference("user" . strval($i) . "id", $user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
