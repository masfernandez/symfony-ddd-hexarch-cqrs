<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Label\Delete;

use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\SyncCommand;
use Masfernandez\MusicLabel\Shared\Domain\Id\LabelId;
use Masfernandez\ValueObject\ValueObjectException;

class DeleteLabelCommand implements SyncCommand
{
    private readonly LabelId $id;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $id,
    ) {
        $this->id = new LabelId($id);
    }

    public function getId(): LabelId
    {
        return $this->id;
    }
}
