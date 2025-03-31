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
                summary: 'Divisione di un valore monetario per un intero',
                description: 'Divide un valore monetario, espresso nel formato "Xp Ys Zd", per un intero (no decimali) e restituisce il quoziente ed il resto (indicato tra parentesi). Esempio: 18p 16s 1d / 15 = 1p 5s Od (1s 1d).'
            )
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