<?php

namespace App\Test\Controller;

use App\Entity\Projects;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/projects/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Projects::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Project index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'project[image]' => 'Testing',
            'project[name]' => 'Testing',
            'project[description]' => 'Testing',
            'project[targetAudience]' => 'Testing',
            'project[demandInMarket]' => 'Testing',
            'project[developmentTimeline]' => 'Testing',
            'project[budgetFundingRequirements]' => 'Testing',
            'project[riskAnalysis]' => 'Testing',
            'project[marketStrategy]' => 'Testing',
            'project[exitStrategy]' => 'Testing',
            'project[teamBackground]' => 'Testing',
            'project[tags]' => 'Testing',
            'project[uniqueSellingPoints]' => 'Testing',
            'project[dailyPriceOfAssets]' => 'Testing',
            'project[investorsEquity]' => 'Testing',
            'project[category]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Projects();
        $fixture->setImage('My Title');
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setTargetAudience('My Title');
        $fixture->setDemandInMarket('My Title');
        $fixture->setDevelopmentTimeline('My Title');
        $fixture->setBudgetFundingRequirements('My Title');
        $fixture->setRiskAnalysis('My Title');
        $fixture->setMarketStrategy('My Title');
        $fixture->setExitStrategy('My Title');
        $fixture->setTeamBackground('My Title');
        $fixture->setTags('My Title');
        $fixture->setUniqueSellingPoints('My Title');
        $fixture->setDailyPriceOfAssets('My Title');
        $fixture->setInvestorsEquity('My Title');
        $fixture->setCategory('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Project');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Projects();
        $fixture->setImage('Value');
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setTargetAudience('Value');
        $fixture->setDemandInMarket('Value');
        $fixture->setDevelopmentTimeline('Value');
        $fixture->setBudgetFundingRequirements('Value');
        $fixture->setRiskAnalysis('Value');
        $fixture->setMarketStrategy('Value');
        $fixture->setExitStrategy('Value');
        $fixture->setTeamBackground('Value');
        $fixture->setTags('Value');
        $fixture->setUniqueSellingPoints('Value');
        $fixture->setDailyPriceOfAssets('Value');
        $fixture->setInvestorsEquity('Value');
        $fixture->setCategory('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'project[image]' => 'Something New',
            'project[name]' => 'Something New',
            'project[description]' => 'Something New',
            'project[targetAudience]' => 'Something New',
            'project[demandInMarket]' => 'Something New',
            'project[developmentTimeline]' => 'Something New',
            'project[budgetFundingRequirements]' => 'Something New',
            'project[riskAnalysis]' => 'Something New',
            'project[marketStrategy]' => 'Something New',
            'project[exitStrategy]' => 'Something New',
            'project[teamBackground]' => 'Something New',
            'project[tags]' => 'Something New',
            'project[uniqueSellingPoints]' => 'Something New',
            'project[dailyPriceOfAssets]' => 'Something New',
            'project[investorsEquity]' => 'Something New',
            'project[category]' => 'Something New',
        ]);

        self::assertResponseRedirects('/projects/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getTargetAudience());
        self::assertSame('Something New', $fixture[0]->getDemandInMarket());
        self::assertSame('Something New', $fixture[0]->getDevelopmentTimeline());
        self::assertSame('Something New', $fixture[0]->getBudgetFundingRequirements());
        self::assertSame('Something New', $fixture[0]->getRiskAnalysis());
        self::assertSame('Something New', $fixture[0]->getMarketStrategy());
        self::assertSame('Something New', $fixture[0]->getExitStrategy());
        self::assertSame('Something New', $fixture[0]->getTeamBackground());
        self::assertSame('Something New', $fixture[0]->getTags());
        self::assertSame('Something New', $fixture[0]->getUniqueSellingPoints());
        self::assertSame('Something New', $fixture[0]->getDailyPriceOfAssets());
        self::assertSame('Something New', $fixture[0]->getInvestorsEquity());
        self::assertSame('Something New', $fixture[0]->getCategory());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Projects();
        $fixture->setImage('Value');
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setTargetAudience('Value');
        $fixture->setDemandInMarket('Value');
        $fixture->setDevelopmentTimeline('Value');
        $fixture->setBudgetFundingRequirements('Value');
        $fixture->setRiskAnalysis('Value');
        $fixture->setMarketStrategy('Value');
        $fixture->setExitStrategy('Value');
        $fixture->setTeamBackground('Value');
        $fixture->setTags('Value');
        $fixture->setUniqueSellingPoints('Value');
        $fixture->setDailyPriceOfAssets('Value');
        $fixture->setInvestorsEquity('Value');
        $fixture->setCategory('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/projects/');
        self::assertSame(0, $this->repository->count([]));
    }
}
