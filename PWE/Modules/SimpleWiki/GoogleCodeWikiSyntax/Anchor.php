<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;


class Anchor extends \WikiTagXhtml
{

    protected $name = 'anchor';
    public $beginTag = '~#';
    public $endTag = '#~';
    protected $attribute = array('name');
    public $separators = array('|');

    public function getContent()
    {
        $identifier = $this->config->titleToIdentifier(0, $this->wikiContentArr[0]);
        return ('<a id="' . $this->config->getParam('anchorsPrefix') . $identifier . '"></a>');
    }

}

