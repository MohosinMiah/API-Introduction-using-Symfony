<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\BlogPost;
use App\Entity\User;
use App\Entity\Comment;

class ApiFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->load_author($manager);
        $this->load_blog_post($manager);
        $this->load_comments($manager);
    }

    public function load_blog_post(ObjectManager $manager)
    {
        $user = $this->getReference('user');
        $blog = new BlogPost();
        $blog->setTitle("Heading One");
        $blog->setPublished(new \DateTime('2019-07-05 12:00:00'));
        $blog->setSlug('heading-one');
        $blog->setAuthor($user);
        $manager->persist($blog);

        
        $blog = new BlogPost();
        $blog->setTitle("Heading Two");
        $blog->setPublished(new \DateTime('2019-11-05 12:00:00'));
        $blog->setSlug('heading-two');
        $blog->setAuthor($user);
        $manager->persist($blog);

        $manager->flush();
    }
    public function load_comments(ObjectManager $manager)
    {
        $user = $this->getReference('user');

        $comment = new Comment();
        $comment->setContent("This is really very good");
        $comment->setPublished(new \DateTime('2019-07-05 12:00:00'));
        $comment->setAuthor($user);

        $manager->persist($comment);

        $manager->flush();
    }
    public function load_author(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("Mohosin");
        $user->setPassword("Mohosin");
        $user->setEmail("mohosin@gmail.com");
        $user->setFullname("Md.Mohosin Miah");
        $this->addReference("user",$user);
        $manager->persist($user);
        $manager->flush();
    }


}
