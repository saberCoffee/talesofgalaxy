<?php

namespace ToG\ForumBundle\Utility;

class BBcode
{
    private $tags;

    function __construct() {
        $tags = array(
            'b' => array(
                'replacement' => 'strong',
                'pattern'     => '/\[b\](.*?)\[\/b\]/'
            ),
            'i' => array(
                'replacement' => 'em',
                'pattern'     => '/\[i\](.*?)\[\/i\]/'
            ),
            'color' => array(
                'replacement' => 'span',
                'pattern' => '/\[color(?:="(.*?)")\](.*?)\[\/color\]/'
            ),
            'img' => array(
                'replacement' => 'img',
                'pattern'     => '/\[img\](.*?)\[\/img\]/'
            ),
            'quote' => array(
                'replacement' => 'blockquote',
                'pattern'     => array(
                    '/\[quote\](.*?)\[\/quote\]/s',
                    '/\[quote(?:="(.*?)")\](.*?)\[\/quote\]/s'
                )
            ),
            'url' => array(
                'replacement' => 'a',
                'pattern'     => array(
                    '/\[url\](.*?)\[\/url\]/',
                    '/\[url(?:="(.*?)")\](.*?)\[\/url\]/'
                )
            ),
            'size' => array(
                'replacement' => 'span',
                'pattern' => '/\[size(?:="(.*?)")\](.*?)\[\/size\]/'
            )
        );

        $this->setTags($tags);
    }

    /**
     * Get the value of Tags
     *
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set the value of Tags
     *
     * @param mixed tags
     *
     * @return self
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Parse text after replacing BBcode by html
     *
     * @param  string $text The string to parse
     *
     * @return string
     */
    public function parseText($text) {
        $tags = $this->getTags();

        $text = htmlspecialchars($text, ENT_NOQUOTES);

        foreach($tags as $tag => $rules) {
            $pattern = $rules['pattern'];

            switch ($tag) {
                case 'color':
                    $replace = '<' . $rules['replacement'] . ' style="color: $1">$2</span>';
                    $text = preg_replace($pattern, $replace, $text);
                    break;

                case 'img':
                    $replace = '<' . $rules['replacement'] . ' src="$1" />';
                    $text = preg_replace($pattern, $replace, $text);
                    break;

                case 'url':
                    $replace = '<' . $rules['replacement'] . ' href="$1">$1</' . $rules['replacement'] . '>';
                    $text    = preg_replace($pattern[0], $replace, $text);

                    $replace = '<' . $rules['replacement'] . ' href="$1">$2</' . $rules['replacement'] . '>';
                    $text    = preg_replace($pattern[1], $replace, $text);
                    break;

                case 'quote':
                    $replace = '<' . $rules['replacement'] . ' class="bbcode-blockquote"><span class="quoteTitle">Citation</span><div>$1</div></' . $rules['replacement'] . '>';
                    $text    = preg_replace($pattern[0], $replace, $text);

                    $replace = '<' . $rules['replacement'] . ' class="bbcode-blockquote"><span class="quoteTitle">$1</span><div>$2</div></' . $rules['replacement'] . '>';
                    $text    = preg_replace($pattern[1], $replace, $text);
                    break;

                case 'size':
                    $replace = '<' . $rules['replacement'] . ' style="font-size: $1%">$2</span>';
                    $text = preg_replace($pattern, $replace, $text);
                    break;

                default :
                    $replace = '<' . $rules['replacement'] . '>$1</' . $rules['replacement'] . '>';
                    $text = preg_replace($pattern, $replace, $text);
                    break;
            }
        }

        return $text;
    }
}
