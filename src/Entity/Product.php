<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;


#[ORM\Entity(repositoryClass: 'App\Repository\ProductRepository')]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/products',
            openapi: new OpenApiOperation(
                summary: 'Recupera la lista di tutti i prodotti',
                description: 'Restituisce un array di prodotti, ciascuno con id, nome, costo e il catalogo associato (se presente).'
            )
        ),
        new Post(
            uriTemplate: '/products',
            openapi: new OpenApiOperation(
                summary: 'Crea un nuovo prodotto',
                description: 'Crea un prodotto specificando nome, costo e l\'IRI del catalogo a cui associarlo (es. "/api/catalogs/1").'
            )
        ),
        new Get(
            uriTemplate: '/products/{id}',
            openapi: new OpenApiOperation(
                summary: 'Recupera un prodotto',
                description: 'Restituisce il prodotto identificato dall\'id (identificatore univoco).'
            )
        ),
        new Put(
            uriTemplate: '/products/{id}',
            openapi: new OpenApiOperation(
                summary: 'Aggiorna un prodotto',
                description: 'Aggiorna completamente un prodotto. È necessario inviare tutti i campi (nome, costo, catalog).'
            )
        ),
        new Patch(
            uriTemplate: '/products/{id}',
            openapi: new OpenApiOperation(
                summary: 'Aggiornamento parziale di un prodotto',
                description: "Aggiorna uno o più campi del prodotto. Utile per rimuovere l'associazione con un catalogo (inviando 'catalog': null) oppure assegnarne uno nuovo. Imposta il Content-Type a 'application/merge-patch+json' o 'application/json'."
            )
        ),
        new Delete(
            uriTemplate: '/products/{id}',
            openapi: new OpenApiOperation(
                summary: 'Elimina un prodotto',
                description: 'Elimina definitivamente il prodotto identificato dall\'id.'
            )
        )
    ]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nome = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $costo = null;

    #[ORM\ManyToOne(targetEntity: Catalog::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Catalog $catalog = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getCosto(): ?float
    {
        return $this->costo;
    }

    public function setCosto(float $costo): self
    {
        $this->costo = $costo;
        return $this;
    }

    public function getCatalog(): ?Catalog
    {
        return $this->catalog;
    }

    public function setCatalog(?Catalog $catalog): self
    {
        $this->catalog = $catalog;
        return $this;
    }
}