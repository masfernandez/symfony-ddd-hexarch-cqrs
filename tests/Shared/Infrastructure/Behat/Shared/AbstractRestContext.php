<?php

/**
 * @noinspection PhpUnused
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection MissingService
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpDocSignatureInspection
 * @noinspection ThrowRawExceptionInspection
 * @noinspection PhpUndefinedMethodInspection
 */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Shared\Infrastructure\Behat\Shared;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behatch\Context\RestContext;
use Behatch\HttpCall\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use JsonException;
use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumPrice;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\TokenMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject\UserEmailMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumMother;
use Masfernandez\Tests\MusicLabel\Shared\Domain\Id\UserIdMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\UserMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject\UserPasswordMother;
use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractRestContext extends RestContext
{
    private string $headerAndPayloadInAuthHeader;
    private string $signatureInCookie;
    private EntityManager $entityManager;

    public function __construct(Request $request, protected readonly ContainerInterface $driverContainer)
    {
        parent::__construct($request);
    }

    /**
     * @BeforeScenario
     * @throws ORMException
     * @noinspection PhpUnused
     */
    public function createNewEntityManager(): void
    {
        $entityManager = $this->driverContainer->get('doctrine.orm.mysql80_entity_manager');
        if (!$entityManager instanceof EntityManager) {
            throw new RuntimeException();
        }

        $this->entityManager = EntityManager::create(
            connection: $entityManager->getConnection(),
            config:     $entityManager->getConfiguration()
        );
    }

    /**
     * @throws ORMException
     */
    private function getEntityManager(): EntityManager
    {
        if (!$this->entityManager->isOpen()) {
            $entityManager = EntityManager::create(
                connection: $this->entityManager->getConnection(),
                config:     $this->entityManager->getConfiguration()
            );
            return $this->entityManager = $entityManager;
        }

        return $this->entityManager;
    }

    /**
     * @Given  There is already an Album in database with id :id title :title and release_date :release_date
     */
    public function thereIsAnAlbumInDatabase(string $id, string $title, string $release_date): void
    {
        $this->getEntityManager()->persist(
            AlbumMother::create(
                id:             new AlbumId($id),
                title:          new AlbumTitle($title),
                releasedAtDate: new AlbumReleasedAtDate($release_date),
            )
        );
        $this->getEntityManager()->flush();
    }

    /**
     * @Given There is a user stored in database with id :id
     */
    public function thereIsAUserStoredInDatabase(string $id): void
    {
        $this->getEntityManager()->persist(
            entity: UserMother::create(
                id: UserIdMother::create($id),
            )
        );
        $this->getEntityManager()->flush();
    }

    /**
     * @Given There are some albums stored in database:
     */
    public function thereAreTwoAlbumsInDatabase(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->getEntityManager()->persist(
                AlbumMother::create(
                    id:             new AlbumId($row['id']),
                    title:          new AlbumTitle($row['title']),
                    releasedAtDate: new AlbumReleasedAtDate($row['release_date']),
                    price:          new AlbumPrice((float)$row['price']),
                )
            );
        }
        $this->getEntityManager()->flush();
    }

    /**
     * @Given There is a VALID token with value :token_value associated to the user with id :id
     */
    public function thereIsAValidTokenForTheUser(string $token_value, string $id): void
    {
        $user  = $this->getEntityManager()->find(User::class, $id);
        $token = TokenMother::create(
            user:  $user,
            value: $token_value,
        );
        $this->getEntityManager()->persist($token);
        $this->getEntityManager()->flush();
    }

    /**
     * @Then the JSON response should be equal to:
     */
    public function theResponseShouldBeEqualTo(PyStringNode|string $expected): void
    {
        $raw = $expected->getRaw();
        try {
            // phpcs:ignore
            $expected = ($raw === '') || ($raw === '{}') ? $raw : json_encode(
                json_decode($raw, true, 512, JSON_THROW_ON_ERROR),
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            $expected = sprintf('There was a JsonException, message: %s', $e->getMessage());
        }
        $actual  = $this->request->getContent();
        $message = "Actual response is '$actual', but expected '$expected'";
        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @Given There is a user stored in database with id :id email :email password :password
     */
    public function thereIsAUserStoredInDatabaseWithIdEmailPassword(string $id, string $email, string $password): void
    {
        $this->getEntityManager()->persist(
            entity: UserMother::create(
                id:       UserIdMother::create($id),
                email:    UserEmailMother::create($email),
                password: UserPasswordMother::create($password)
            )
        );
        $this->getEntityManager()->flush();
    }

    /**
     * @Given There is VALID a JwToken for the user with id :id email :email password :password
     */
    public function thereIsAValidJwTokenForTheUser(string $id, string $email, string $password): void
    {
        /** @noinspection ClassConstantCanBeUsedInspection */
        $tokenGenerator = $this->driverContainer->get(
            'Masfernandez\MusicLabel\Infrastructure\Api\JsonWebToken\Generator'
        );

        $user = UserMother::create(
            id:       UserIdMother::create($id),
            email:    UserEmailMother::create($email),
            password: UserPasswordMother::create($password)
        );

        $jwt                                = $tokenGenerator->create($user);
        $jwtParts                           = explode('.', (string)$jwt->getValue());
        $this->headerAndPayloadInAuthHeader = $jwtParts[0] . '.' . $jwtParts[1];
        $this->signatureInCookie            = $jwtParts[2];
    }

    /**
     * @When I add :header header token value - JWT header and payload
     */
    public function iAddHeaderWithJwTokenVale(string $header): void
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
