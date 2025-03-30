<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;
use App\Controller\MoneyAdditionController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/money/addition',
            controller: MoneyAdditionController::class,
            read: false,
            deserialize: true,
        )
    ]
)]
class MoneyAdditionInput
{
    #[Assert\NotBlank]
    #[Groups(['input'])]
    public ?string $first = null;

    #[Assert\NotBlank]
    #[Groups(['input'])]
    public ?string $second = null;
}