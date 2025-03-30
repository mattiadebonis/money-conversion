<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\MoneySubtractionController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Post(
            controller: MoneySubtractionController::class,
            read: false,
            deserialize: true,
        
        )
    ]
)]
class MoneySubtractionInput
{
    #[Assert\NotBlank]
    #[Groups(['input'])]
    public ?string $first = null;

    #[Assert\NotBlank]
    #[Groups(['input'])]
    public ?string $second = null;
}