<?php

namespace App\Tests\Unit;

use App\Service\ImageService;
use Mockery;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Ulid;

class ImageServiceTest extends TestCase
{
    private int $userId = 11;
    private array $imageConfig = ['path' => 'GodOfWar', 'folder' => 'Atreus'];
    private string $projectDir = 'projectDir';
    private string $fileExtension = '.jpg';
    private string $uniqueString = 'AAffbbyI';

    private LoggerInterface $logger;
    private UploadedFile $uploadFile;

    protected function setUp(): void
    {
        $this->logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->uploadFile = $this->getMockBuilder(UploadedFile::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock = Mockery::mock('alias:' . Ulid::class);
        $mock->shouldReceive('generate')
            ->andReturn($this->uniqueString);
    }

    public function testUploadImageSuccess(): void
    {
        $filename = $this->userId . $this->uniqueString . $this->fileExtension;
        $destination = $this->projectDir . $this->imageConfig['path'];
        $expectedResult = sprintf('/%s/%s', $this->imageConfig['folder'], $filename);

        $this->uploadFile->expects($this->once())
            ->method('guessExtension')
            ->willReturn($this->fileExtension);

        $this->uploadFile->expects($this->once())
            ->method('move')
            ->with($destination, $filename);

        $imageService = new ImageService($this->imageConfig, $this->projectDir, $this->logger);
        $this->assertEquals($expectedResult, $imageService->uploadImage($this->uploadFile, $this->userId));
    }

    public function testUploadImageFailed(): void
    {
        $exceptionMessage = 'Kratos Error Happened!!!';

        $this->uploadFile->expects($this->once())
            ->method('guessExtension')
            ->willReturn($this->fileExtension);

        $this->uploadFile->expects($this->once())
            ->method('move')
            ->willThrowException(new FileException($exceptionMessage));

        $this->logger->expects($this->once())
            ->method('error')
            ->with($exceptionMessage);

        $imageService = new ImageService($this->imageConfig, $this->projectDir, $this->logger);
        $this->assertNull($imageService->uploadImage($this->uploadFile, $this->userId));
    }

}
