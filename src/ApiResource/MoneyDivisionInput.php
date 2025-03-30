<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\MoneyDivisionController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/money/division',
            controller: MoneyDivisionController::class,
            read: false,
            deserialize: true,
        
        )
    ]
)]
class MoneyDivisionInput
{
    #[Assert\NotBlank]
    #[Groups(['input'])]
    public ?string $value = null;

    #[Assert\NotNull]
    #[Assert\Type(type: 'integer')]
    #[Groups(['input'])]
    public ?int $divisor = null;
}