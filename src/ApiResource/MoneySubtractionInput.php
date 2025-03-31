<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\MoneySubtractionController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/money/subtraction',
            controller: MoneySubtractionController::class,
            read: false,
            deserialize: true,
            openapi: new OpenApiOperation(
                summary: 'Sottrazione di due valori monetari',
                description: 'Esegue la sottrazione di due valori monetari espressi nel formato "Xp Ys Zd". Esempio: 5p 17s 8d - 3p 4s 10d = 2p 12s 10d.'
            )
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