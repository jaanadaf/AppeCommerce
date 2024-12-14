<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->name;
    }
}

/*La méthode __toString() dans une classe PHP permet de définir comment un objet de cette classe doit être
 représenté sous forme de chaîne de caractères lorsque vous tentez de l'afficher ou de l'utiliser dans une 
 situation où une chaîne de caractères est attendue.
Dans le cas de l'entité Category, la méthode __toString() est ajoutée pour spécifier que, lorsqu'un objet Category
 est affiché dans un contexte où une chaîne est attendue (comme dans un formulaire Twig), il doit afficher le nom 
 de la catégorie plutôt que l'ID ou d'autres informations.
Pourquoi l'ajouter dans Category.php
Lors de l'utilisation du champ EntityType dans un formulaire Symfony (comme pour le champ category dans le formulaire ProductType),
 Symfony essaie de convertir l'entité en une chaîne de caractères pour afficher les options dans le sélecteur. Sans la méthode __toString(),
  Symfony essaierait de l'afficher sous forme d'un identifiant ou d'un objet qui ne sera pas très lisible.
En ajoutant cette méthode __toString() dans l'entité Category, vous spécifiez que, lorsqu'un objet Category est affiché,
 il doit afficher la valeur du champ name, qui représente la marque de l'ordinateur ou la catégorie, plutôt que l'objet entier ou son identifiant.*/
