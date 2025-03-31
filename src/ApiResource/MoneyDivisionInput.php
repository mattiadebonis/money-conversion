<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\MoneyDivisionController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;


#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/money/division',
            controller: MoneyDivisionController::class,
            read: false,
            deserialize: true,
            openapi: new OpenApiOperation(
                summary: 'Divisione di un valore monetario',
                description: 'Divisione resto (da indicare tra parentesi) con un intero (no decimali). Esempio: 18p 16s 1d / 15 = 1p 5s 0d (1s 1d).'
            )
        )
    ]
)]
class MoneyDivisionInput
{
    #[Assert\NotBlank]
    #[Groups(['input'])]
    public ?string $first = null;

    #[Assert\NotBlank]
    #[Groups(['input'])]
    public ?string $second = null;
}