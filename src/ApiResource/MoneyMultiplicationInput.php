<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\MoneyMultiplicationController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/money/multiplication',
            controller: MoneyMultiplicationController::class,
            read: false,
            deserialize: true,
            
        )
    ]
)]
class MoneyMultiplicationInput
{
    #[Assert\NotBlank]
    #[Groups(['input'])]
    public ?string $value = null;

    #[Assert\NotNull]
    #[Assert\Type(type: 'integer')]
    #[Groups(['input'])]
    public ?int $multiplier = null;
}