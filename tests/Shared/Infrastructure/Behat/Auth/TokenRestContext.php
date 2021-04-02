<?php

/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpDocSignatureInspection
 * @noinspection ThrowRawExceptionInspection
 * @noinspection PhpUndefinedMethodInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Infrastructure\Behat\Auth;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behatch\Context\RestContext;
use Behatch\HttpCall\Request;
use JsonException;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserEmailMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserIdMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserPasswordMother;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class TokenRestContext extends RestContext
{

    public function __construct(Request $request, private ContainerInterface $container)
    {
        parent::__construct($request);
    }

    /**
     * @Given There is a user stored in database with id :id email :email password :pasword
     */
    public function thereIsAUserStoredInDatabaseWithIdEmailPassword(string $id, string $email, string $password): void
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $em->persist(UserMother::create(
            UserIdMother::create($id),
            UserEmailMother::create($email),
            UserPasswordMother::create($password)
        ));
        $em->flush();
    }

    /**
     * @Then the JSON response should be equal to:
     */
    public function theJsonResponseShouldBeEqualTo(PyStringNode $expected): void
    {
        $raw = $expected->getRaw();
        try {
            // phpcs:ignore
            $expected = ($raw === '') || ($raw === '{}') ? $raw : $json = json_encode(json_decode($raw, true, 512, JSON_THROW_ON_ERROR), JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $expected = sprintf('There was a JsonException, message: %s', $e->getMessage());
        }
        $actual = $this->request->getContent();
        $message = "Actual response is '$actual', but expected '$expected'";
        $this->assertEquals($expected, $actual, $message);
    }
}
