<?php

namespace ToG\ForumBundle\Twig;

use ToG\ForumBundle\Utility\BBcode;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('bbcode', array($this, 'bbcodeFilter')),
        );
    }

    public function bbcodeFilter($string)
    {
        $BBcode = new BBcode();
        return $BBcode->parseText($string);
    }
}
