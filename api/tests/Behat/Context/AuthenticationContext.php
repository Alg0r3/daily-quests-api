<?php

namespace App\Tests\Behat\Context;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\ApiUser;
use App\Factory\ApiUserFactory;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AuthenticationContext extends ApiTestCase implements Context
{
    private ?string $password = null;
    private ?ApiUser $user = null;
    private ?ResponseInterface $response = null;

    /**
     * @Given a user with valid credentials
     */
    public function aUserWithValidCredentials(): void
    {
        $this->password = '$ECR3T';
        $this->user = ApiUserFactory::createOne([
            'password' => $this->password,
        ]);
    }

    /**
     * @Given a user with invalid credentials
     */
    public function aUserWithInvalidCredentials(): void
    {
        $this->password = 'R4ND0M';
        $this->user = ApiUserFactory::createOne();
    }

    /**
     * @When the user attempts to authenticate to the API
     *
     * @throws TransportExceptionInterface
     */
    public function theUserAttemptsToAuthenticateToTheAPI(): void
    {
        $client = self::createClient();
        $this->response = $client->request('POST', '/authentication', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'userIdentifier' => $this->user?->getUserIdentifier(),
                'password' => $this->password,
            ],
        ]);
    }

    /**
     * @Then the response HTTP status code should be :expectedCode
     *
     * @throws TransportExceptionInterface
     */
    public function theResponseHTTPStatusCodeShouldBe(int $expectedCode): void
    {
        $actualCode = $this->response?->getStatusCode();

        Assert::assertEquals(
            $expectedCode,
            $actualCode,
            "Expected HTTP status code $expectedCode but got $actualCode instead."
        );
    }

    /**
     * @Given a JWT Token should be successfully returned to the user
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function aJWTTokenShouldBeSuccessfullyReturnedToTheUser(): void
    {
        $content = $this->response?->getContent();

        if (null === $content) {
            throw new \RuntimeException('Response content is null.');
        }

        /** @var array<string, string> $decodedContent */
        $decodedContent = json_decode($content, true);

        Assert::assertArrayHasKey('token', $decodedContent);
    }
}
