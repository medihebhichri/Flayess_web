<?php

namespace App\Test\Controller;

use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoriesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/categories/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Categories::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Category index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'category[categoryName]' => 'Testing',
            'category[subfield]' => 'Testing',
            'category[typeOfFunding]' => 'Testing',
            'category[profitabilityIndex]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Categories();
        $fixture->setCategoryName('My Title');
        $fixture->setSubfield('My Title');
        $fixture->setTypeOfFunding('My Title');
        $fixture->setProfitabilityIndex('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Category');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Categories();
        $fixture->setCategoryName('Value');
        $fixture->setSubfield('Value');
        $fixture->setTypeOfFunding('Value');
        $fixture->setProfitabilityIndex('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'category[categoryName]' => 'Something New',
            'category[subfield]' => 'Something New',
            'category[typeOfFunding]' => 'Something New',
            'category[profitabilityIndex]' => 'Something New',
        ]);

        self::assertResponseRedirects('/categories/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCategoryName());
        self::assertSame('Something New', $fixture[0]->getSubfield());
        self::assertSame('Something New', $fixture[0]->getTypeOfFunding());
        self::assertSame('Something New', $fixture[0]->getProfitabilityIndex());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Categories();
        $fixture->setCategoryName('Value');
        $fixture->setSubfield('Value');
        $fixture->setTypeOfFunding('Value');
        $fixture->setProfitabilityIndex('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/categories/');
        self::assertSame(0, $this->repository->count([]));
    }
}
