<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;


class Image extends \WikiTagXhtml
{

    protected $name = 'image';
    public $beginTag = 'http://';
    public $endTag = '.png';
    protected $attribute = array('alt', 'src');

    public function getContent()
    {
        $src = $this->beginTag . $this->wikiContentArr[0] . $this->endTag;
        $processedLink = $this->config->processLink($src, $this->name);
        $src = $processedLink[0];
        // on retourne le lien généré
        return "<img src=\"$src\" alt=\"$src\" />";
    }

}

