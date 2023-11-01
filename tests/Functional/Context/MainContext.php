<?php

namespace EsTodosApi\Tests\Functional\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\DBAL\Connection;
use MongoDB\Client;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use EsTodosApi\Tests\Functional\Context\Wildcards\WildcardsTrait;

class MainContext implements Context
{
    use WildcardsTrait {
        WildcardsTrait::__construct as private __wilcardsConstruct;
    }

    const MONGODB_DATABASE_NAME = 'es_todos_api';

    private static KernelInterface $kernel;
    private static Connection $doctrine;
    private static Response $response;
    private static Client $mongodb;
    private static array $headers;

    public function __construct(
        KernelInterface $kernel,
        Connection $doctrine,
        Client $mongodb
    ) {
        $this->__wilcardsConstruct();
        
        self::$kernel = $kernel;
        self::$doctrine = $doctrine;
        self::$mongodb = $mongodb;
        self::$headers = [];
        
        self::$mongodb->dropDatabase(self::MONGODB_DATABASE_NAME);
    }

    /**
     * @beforeScenario
     */
    public function startScenario(): void
    {
        self::$doctrine->beginTransaction();
    }

    /**
     * @afterScenario
     */
    public function rollbackScenario(): void
    {
        self::$headers = [];
        self::$doctrine->rollBack();
        self::$mongodb->dropDatabase(self::MONGODB_DATABASE_NAME);
    }

    /**
     * @Given /^I call "([^"]*)" "([^"]*)"$/
     *
     * @param string $verb
     * @param string $path
     * @throws \Exception
     */
    public function iCall(string $verb, string $path): void
    {
        $this->iCallWithBody($verb, $path);
    }

    /**
     * @Then /^I call "([^"]*)" "([^"]*)" with body:$/
     *
     * @param string $verb
     * @param string $path
     * @param PyStringNode $string
     * @throws \Exception
     */
    public function iCallWithBody($verb, $path, PyStringNode $string = null): void
    {
        $request = Request::create(
            $path,
            $verb,
            [],
            [],
            [],
            [],
            $string ? $string->getRaw() : null
        );

        $request->headers->add(self::$headers);

        self::$response = self::$kernel->handle($request);
    }

    /**
     * @Then /^the status code should be (\d+)$/
     *
     * @param int $statusCode
     */
    public function theStatusCodeShouldBe(int $statusCode): void
    {
        Assert::assertEquals($statusCode, self::$response->getStatusCode());
    }

    /**
     * @Given /^the response should be a JSON like$/
     */
    public function theResponseShouldBeAJSONLike(PyStringNode $jsonString): void
    {
        Assert::assertJsonStringEqualsJsonString($jsonString->getRaw(), self::$response->getContent());
    }

    /**
     * @Given /^the response should matches$/
     */
    public function theResponseShouldMatches(PyStringNode $pattern): void
    {
        $jsonString = json_encode(json_decode($pattern->getRaw()), JSON_UNESCAPED_UNICODE);
        $string = '/^' . $this->replaceWildcards($jsonString) . '$/';

        $expected = json_encode(json_decode(self::$response->getContent()), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        Assert::assertMatchesRegularExpression($string, $expected);
    }

    /**
     * @Given /^the response should be empty$/
     */
    public function theResponseShouldBeEmpty(): void
    {
        $expected = '';

        Assert::assertEquals($expected, self::$response->getContent());
    }

    /**
     * @Given /^the property "([^"]*)" should be equals "([^"]*)"$/
     */
    public function thePropertyShouldBeEquals(string $propertyPath, $value): void
    {
        $pathArray = explode('.', $propertyPath);
        $currentValue = json_decode(self::$response->getContent(), true);

        foreach ($pathArray as $currentKey) {
            if (!array_key_exists($currentKey, $currentValue)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'No data exists at the given path: "%s"',
                        $propertyPath
                    )
                );
            }

            $currentValue = $currentValue[$currentKey];
        }

        if ($value === 'null') {
            $value = null;
        }

        if ($value === 'true' || $value === 'false') {
            $value = filter_var($value, FILTER_VALIDATE_BOOL);
        }

        if (substr($value, 0, 1) === '[' && substr($value, strlen($value) - 1) === ']') {
            $value = json_decode(str_replace("'", '"', $value), true);
        }
        
        Assert::assertEquals($value, $currentValue);
    }
}
