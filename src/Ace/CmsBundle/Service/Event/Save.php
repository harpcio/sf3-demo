<?php

namespace Ace\CmsBundle\Service\Event;

use Ace\CommonBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Save
{
    private $uploadPath;

    public function __construct($uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    public function handle(Entity\Event $event)
    {
        /** @var UploadedFile $file */
        if (($file = $event->getBrochure())) {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move($this->uploadPath, $fileName);

            $event->setBrochure($fileName);
        }
    }
}