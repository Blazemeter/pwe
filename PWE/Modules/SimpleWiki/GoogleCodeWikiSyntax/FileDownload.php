<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;

use PWE\Core\PWECore;
use PWE\Modules\FileDownloads\FileDownloads;

class FileDownload extends \WikiTagXhtml
{

    protected $name = 'file';
    public $beginTag = '<download:';
    public $endTag = '>';
    public $separators = array(';');

    public function getContent()
    {
        /* @var $pwe PWECore */
        $pwe = $this->config->getPWE();
        $dlCtrl = new FileDownloads($pwe);
        return $dlCtrl->getFileBlock($this->wikiContentArr[0], $this->wikiContentArr[1]);
    }

    public function isOtherTagAllowed()
    {
        return false;
    }

}

