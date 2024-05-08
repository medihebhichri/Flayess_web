<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Projects
 *
 * @ORM\Table(name="projects", uniqueConstraints={@ORM\UniqueConstraint(name="uc_name", columns={"NAME"})}, indexes={@ORM\Index(name="projects_ibfk_1", columns={"category_id"})})
 * @ORM\Entity
 */
class Projects
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @ORM\Column(name="image", type="string", length=900, nullable=true)
     */
    private ?string $image = null;

    /**
     * @ORM\Column(name="NAME", type="string", length=255, nullable=true, unique=true)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\Column(name="target_audience", type="string", length=255, nullable=true)
     */
    private ?string $targetAudience = null;

    /**
     * @ORM\Column(name="demand_in_market", type="string", length=255, nullable=true)
     */
    private ?string $demandInMarket = null;

    /**
     * @ORM\Column(name="development_timeline", type="string", length=255, nullable=true)
     */
    private ?string $developmentTimeline = null;

    /**
     * @ORM\Column(name="budget_funding_requirements", type="float", precision=10, scale=0, nullable=true)
     */
    private ?float $budgetFundingRequirements = null;

    /**
     * @ORM\Column(name="risk_analysis", type="text", length=65535, nullable=true)
     */
    private ?string $riskAnalysis = null;

    /**
     * @ORM\Column(name="market_strategy", type="text", length=65535, nullable=true)
     */
    private ?string $marketStrategy = null;

    /**
     * @ORM\Column(name="exit_strategy", type="text", length=65535, nullable=true)
     */
    private ?string $exitStrategy = null;

    /**
     * @ORM\Column(name="team_background", type="text", length=65535, nullable=true)
     */
    private ?string $teamBackground = null;

    /**
     * @ORM\Column(name="tags", type="text", length=65535, nullable=true)
     */
    private ?string $tags = null;

    /**
     * @ORM\Column(name="unique_selling_points", type="string", length=1000, nullable=true)
     */
    private ?string $uniqueSellingPoints = null;

    /**
     * @ORM\Column(name="daily_price_of_assets", type="text", length=65535, nullable=true)
     */
    private ?string $dailyPriceOfAssets = null;

    /**
     * @ORM\Column(name="investors_equity", type="text", length=65535, nullable=true)
     */

     /**
 * @ORM\Column(name="state", type="string", length=255, options={"default"="waiting"})
 */
    private string $state = "waiting";
    private ?string $investorsEquity = null;

    /**
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private ?Categories $category = null; // Make the property nullable and initialize it to null

    // Other methods...

    public function __construct()
    {
        // Initialize any other properties if needed
        $this->category = null; // Ensure category is initialized to null
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTargetAudience(): ?string
    {
        return $this->targetAudience;
    }

    public function setTargetAudience(?string $targetAudience): static
    {
        $this->targetAudience = $targetAudience;

        return $this;
    }

    public function getDemandInMarket(): ?string
    {
        return $this->demandInMarket;
    }

    public function setDemandInMarket(?string $demandInMarket): static
    {
        $this->demandInMarket = $demandInMarket;

        return $this;
    }

    public function getDevelopmentTimeline(): ?string
    {
        return $this->developmentTimeline;
    }

    public function setDevelopmentTimeline(?string $developmentTimeline): static
    {
        $this->developmentTimeline = $developmentTimeline;

        return $this;
    }

    public function getBudgetFundingRequirements(): ?float
    {
        return $this->budgetFundingRequirements;
    }

    public function setBudgetFundingRequirements(?float $budgetFundingRequirements): static
    {
        $this->budgetFundingRequirements = $budgetFundingRequirements;

        return $this;
    }

    public function getRiskAnalysis(): ?string
    {
        return $this->riskAnalysis;
    }

    public function setRiskAnalysis(?string $riskAnalysis): static
    {
        $this->riskAnalysis = $riskAnalysis;

        return $this;
    }

    public function getMarketStrategy(): ?string
    {
        return $this->marketStrategy;
    }

    public function setMarketStrategy(?string $marketStrategy): static
    {
        $this->marketStrategy = $marketStrategy;

        return $this;
    }

    public function getExitStrategy(): ?string
    {
        return $this->exitStrategy;
    }

    public function setExitStrategy(?string $exitStrategy): static
    {
        $this->exitStrategy = $exitStrategy;

        return $this;
    }

    public function getTeamBackground(): ?string
    {
        return $this->teamBackground;
    }

    public function setTeamBackground(?string $teamBackground): static
    {
        $this->teamBackground = $teamBackground;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    public function getUniqueSellingPoints(): ?string
    {
        return $this->uniqueSellingPoints;
    }

    public function setUniqueSellingPoints(?string $uniqueSellingPoints): static
    {
        $this->uniqueSellingPoints = $uniqueSellingPoints;

        return $this;
    }

    public function getDailyPriceOfAssets(): ?string
    {
        return $this->dailyPriceOfAssets;
    }

    public function setDailyPriceOfAssets(?string $dailyPriceOfAssets): static
    {
        $this->dailyPriceOfAssets = $dailyPriceOfAssets;

        return $this;
    }

    public function getInvestorsEquity(): ?string
    {
        return $this->investorsEquity;
    }

    public function setInvestorsEquity(?string $investorsEquity): static
    {
        $this->investorsEquity = $investorsEquity;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
    }
    public function getState(): string
{
    return $this->state;
}

public function setState(string $state): static
{
    $this->state = $state;

    return $this;
}


}
