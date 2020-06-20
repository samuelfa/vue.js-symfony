<?php


namespace Test\Functional;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductRequestsTest extends WebTestCase
{
    private KernelBrowser $client;
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testProductListEmpty(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $form = $crawler->filter('button')->form();

        $form['namespace'] = 'functional';
        $form['name'] = 'Company name';
        $form['nif'] = '12345678Z';
        $form['email_address'] = 'manager@functional.com';
        $form['password'] = 'functional';

        $this->client->submit($form);

        /** @var RedirectResponse $response */
        $response = $this->client->getResponse();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertEquals('http://functional.crm.localhost/crm', $response->getTargetUrl());

        $crawler = $this->client->followRedirect();

        $response = $this->client->getResponse();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('http://functional.crm.localhost/crm', $this->client->getHistory()->current()->getUri());

        $total = $crawler->filter('div.card-body button.btn-primary')->count();
        $this->assertEquals(4, $total);
    }
}