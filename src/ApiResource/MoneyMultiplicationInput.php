<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\MoneyMultiplicationController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/money/multiplication',
            controller: MoneyMultiplicationController::class,
            read: false,
            deserialize: true,
            openapi: new OpenApiOperation(
                summary: 'Moltiplicazione di un valore monetario per un intero',
                description: 'Moltiplica un valore monetario, espresso nel formato "Xp Ys Zd", per un intero (no decimali). Esempio: 5p 17s 8d * 2 = 11p 15s 4d.'
            )
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