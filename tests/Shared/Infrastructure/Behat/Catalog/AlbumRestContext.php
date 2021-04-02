<?php

/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpDocSignatureInspection
 * @noinspection ThrowRawExceptionInspection
 * @noinspection PhpUndefinedMethodInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Infrastructure\Behat\Catalog;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behatch\Context\RestContext;
use Behatch\HttpCall\Request;
use JsonException;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\User;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token\TokenMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token\TokenValueMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserEmailMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserIdMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserPasswordMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class AlbumRestContext extends RestContext
{
    private string $headerAndPayloadInAuthHeader;
    private string $signatureInCookie;

    public function __construct(Request $request, private ContainerInterface $container)
    {
        parent::__construct($request);
    }

    /**
     * @Given  There is already an Album in database with id :id title :title and publishing_date :publishing_date
     */
    public function thereIsAnAlbumInDatabase(string $id, string $title, string $publishing_date): void
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $em->persist(AlbumMother::create(
            new AlbumId($id),
            new AlbumTitle($title),
            new AlbumPublishingDate($publishing_date)
        ));
        $em->flush();
    }

    /**
     * @Given There is a user stored in database with id :id
     */
    public function thereIsAUserStoredInDatabase(string $id): void
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $em->persist(UserMother::create(
            UserIdMother::create($id)
        ));
        $em->flush();
    }

    /**
     * @Given There are some albums stored in database:
     */
    public function thereAreTwoAlbumsInDatabase(TableNode $table): void
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        foreach ($table as $row) {
            $em->persist(AlbumMother::create(
                new AlbumId($row['id']),
                new AlbumTitle($row['title']),
                new AlbumPublishingDate($row['publishing_date'])
            ));
        }
        $em->flush();
    }

    /**
     * @Given There is VALID a token with value :token_value associated to the user with id :id
     */
    public function thereIsAValidTokenForTheUser(string $token_value, string $id): void
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $user = $em->find(User::class, $id);
        $em->persist(TokenMother::create(
            $user,
            TokenValueMother::create($token_value)
        ));
        $em->flush();
    }

    /**
     * @Then the JSON response should be equal to:
     */
    public function theResponseShouldBeEqualTo(PyStringNode $expected): void
    {
        $raw = $expected->getRaw();
        try {
            $expected = ($raw === '') || ($raw === '{}') ? $raw : $json = json_encode(json_decode($raw, true, 512, JSON_THROW_ON_ERROR), JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $expected = sprintf('There was a JsonException, message: %s', $e->getMessage());
        }
        $actual = $this->request->getContent();
        $message = "Actual response is '$actual', but expected '$expected'";
        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @Given There is a user stored in database with id :id email :email password :password
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
     * @Given There is VALID a JwToken for the user with id :id email :email password :password
     */
    public function thereIsAValidJwTokenForTheUser(string $id, string $email, string $password ): void
    {
        $tokenGenerator = $this->container->get('Masfernandez\MusicLabel\Auth\Infrastructure\Jwt\Generator');
        $user = UserMother::create(
            UserIdMother::create($id),
            UserEmailMother::create($email),
            UserPasswordMother::create($password)
        );
        $jwt = $tokenGenerator->create($user);
        $jwtParts = explode('.', $jwt);
        $this->headerAndPayloadInAuthHeader = $jwtParts[0] . '.' . $jwtParts[1];
        $this->signatureInCookie = $jwtParts[2];
    }

    /**
     * @When I add :header header token value - JWT header and payload
     */
    public function iAddHeaderWithJwtokenVale(string $header): void
    {
        $this->request->setHttpHeader($header, $this->headerAndPayloadInAuthHeader);
    }

    /**
     * @When I add cookie :cookie value - jwt signature
     */
    public function iAddCookieWithSignatureVale(string $cookie): void
    {
        $this->getSession()->setCookie($cookie, $this->signatureInCookie);
    }
}
