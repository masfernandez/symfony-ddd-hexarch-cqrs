<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Label\Create;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\ValueObject\LabelName;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\SyncCommand;
use Masfernandez\MusicLabel\Shared\Domain\Id\LabelId;
use Masfernandez\ValueObject\Exception\ValueObjectException;

class CreateLabelCommand implements SyncCommand
{
    private readonly LabelId $id;
    private readonly LabelName $name;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $id,
        string $name,
    ) {
        $this->id   = new LabelId($id);
        $this->name = new LabelName($name);
    }

    public function getId(): LabelId
    {
        return $this->id;
    }

    public function getName(): LabelName
    {
        return $this->name;
    }
}
