<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\ReportController;

/**
 *
 *
 * @ApiResource(
 *     collectionOperations={
 *          "get_xml"={
 *              "method"="GET",
 *              "route_name"="report_xml"
 *          },
 *          "get_json"={
 *              "method"="GET",
 *              "route_name"="report_json"
 *          },
 *     },
 * )
 *
 * @ORM\Entity(repositoryClass=App\Repository\TeamRepository::class)
 * @ORM\Table(name="teams")
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;


    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    public string $name;

    /**
     * @var Collection|Account[] $accounts
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Account", mappedBy="team")
     */
    private Collection $accounts;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
