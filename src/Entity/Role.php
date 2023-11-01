<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoleRepository;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table(name: 'roles')]
class Role
{
    const CUSTOMER_ROLE = 'ROLE_CUSTOMER';
    const SUPPORT_SPECIALIST_ROLE = 'ROLE_SUPPORT_SPECIALIST';
    const ROLE_SUPPORT_MANAGER = 'ROLE_SUPPORT_MANAGER';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    private ?int $id = null;

    #[ORM\Column(name: 'name', type: 'string', length: 200, nullable: false)]
    private ?string $name = null;

    #[ORM\Column(name: 'create_case', type: 'boolean', nullable: false)]
    private bool $createCase = false;

    #[ORM\Column(name: 'post_comments', type: 'boolean', nullable: false)]
    private bool $postComments = false;

    #[ORM\Column(name: 'view_case_comments', type: 'boolean', nullable: false)]
    private bool $viewCaseComments = false;

    #[ORM\Column(name: 'view_statistic', type: 'boolean', nullable: false)]
    private bool $viewStatistic = false;

    #[ORM\Column(name: 'view_all_customers_cases', type: 'boolean', nullable: false)]
    private bool $viewAllCustomersCases = false;

    #[ORM\Column(name: 'change_status', type: 'boolean', nullable: false)]
    private bool $updateStatus = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function isCreateCase(): bool
    {
        return $this->createCase;
    }

    public function setCreateCase(bool $createCase): self
    {
        $this->createCase = $createCase;
        return $this;
    }

    public function isPostComments(): bool
    {
        return $this->postComments;
    }

    public function setPostComments(bool $postComments): self
    {
        $this->postComments = $postComments;
        return $this;
    }

    public function isViewStatistic(): bool
    {
        return $this->viewStatistic;
    }

    public function setViewStatistic(bool $viewStatistic): self
    {
        $this->viewStatistic = $viewStatistic;
        return $this;
    }

    public function isViewCaseComments(): bool
    {
        return $this->viewCaseComments;
    }

    public function setViewCaseComments(bool $viewCaseComments): self
    {
        $this->viewCaseComments = $viewCaseComments;
        return $this;
    }

    public function isViewAllCustomersCases(): bool
    {
        return $this->viewAllCustomersCases;
    }

    public function setViewAllCustomersCases(bool $viewAllCustomersCases): self
    {
        $this->viewAllCustomersCases = $viewAllCustomersCases;
        return $this;
    }

    public function isUpdateStatus(): bool
    {
        return $this->updateStatus;
    }

    public function setUpdateStatus(bool $updateStatus): self
    {
        $this->updateStatus = $updateStatus;
        return $this;
    }

}
