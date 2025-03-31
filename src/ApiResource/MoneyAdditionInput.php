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
            openapi: new OpenApiOperation(
                summary: 'Somma due valori monetari',
                description: 'Esegue la somma di due valori monetari espressi nel formato "Xp Ys Zd". Esempio: 5p 17s 8d + 3p 4s 10d = 9p 2s 6d.'
            )
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