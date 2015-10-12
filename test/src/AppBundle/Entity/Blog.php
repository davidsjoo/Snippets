<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-07
 * Time: 15:19
 */

namespace AppBundle\Entity;


class Blog
{

    protected $title;
    protected $blog_post;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getBlogPost()
    {
        return $this->blog_post;
    }

    public function setBlogPost($blog_post)
    {
        $this->blog_post = $blog_post;
    }

}