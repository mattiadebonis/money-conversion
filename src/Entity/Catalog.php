<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiSubresource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;


#[ORM\Entity(repositoryClass: 'App\Repository\CatalogRepository')]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/catalogs',
            openapi: new OpenApiOperation(
                summary: 'Recupera la lista dei cataloghi',
                description: 'Restituisce un array di cataloghi, ciascuno con il proprio id, nome ed eventualmente la lista dei prodotti associati.'
            )
        ),
        new Post(
            uriTemplate: '/catalogs',
            openapi: new OpenApiOperation(
                summary: 'Crea un nuovo catalogo',
                description: 'Crea un catalogo specificando il nome. La risposta restituirà il catalogo creato con il relativo id.'
            )
        ),
        new Get(
            uriTemplate: '/catalogs/{id}',
            openapi: new OpenApiOperation(
                summary: 'Recupera un catalogo specifico',
                description: 'Restituisce il catalogo identificato dall\'id, includendo i prodotti associati (se presenti).'
            )
        ),
        new Put(
            uriTemplate: '/catalogs/{id}',
            openapi: new OpenApiOperation(
                summary: 'Aggiorna un catalogo',
                description: 'Aggiorna i dati del catalogo specificato, ad esempio il nome.'
            )
        ),
        new Delete(
            uriTemplate: '/catalogs/{id}',
            openapi: new OpenApiOperation(
                summary: 'Elimina un catalogo',
                description: 'Elimina il catalogo identificato dall\'id. Questa operazione rimuove il catalogo in modo definitivo.'
            )
        )
    ]
)]
class Catalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nome = null;

    #[ORM\OneToMany(mappedBy: 'catalog', targetEntity: Product::class, cascade: ['persist', 'remove'])]
    #[ApiSubresource]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    // Getters e Setters
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

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCatalog($this);
        }
        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            if ($product->getCatalog() === $this) {
                $product->setCatalog(null);
            }
        }
        return $this;
    }
}