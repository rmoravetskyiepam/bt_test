<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImageService
{
    private array $imageConfig;
    private string $projectDir;

    public function __construct(
        #[Autowire(param: 'app.image_config')]
        array                            $imageConfig,
        #[Autowire(param: 'kernel.project_dir')]
        string                           $projectDir,
        private readonly LoggerInterface $logger,
    )
    {
        $this->imageConfig = $imageConfig;
        $this->projectDir = $projectDir;
    }

    public function uploadImage(UploadedFile $uploadedFile, int $userId): ?string
    {
        $destination = $this->projectDir . $this->imageConfig['path'];
        $filename = $userId . Ulid::generate() . $uploadedFile->guessExtension();
        try {
            $uploadedFile->move($destination, $filename);
        } catch (FileException $e) {
            $this->logger->error($e->getMessage());
            return null;
        }

        return sprintf('/%s/%s', $this->imageConfig['folder'], $filename);
    }
}
