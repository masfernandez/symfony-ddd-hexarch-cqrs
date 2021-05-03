# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
### Changed
### Deprecated
### Removed
### Fixed
### Security



## [0.3.8] - 2021-05-01
### Added
- Github action file
- New preprod env
### Changed
- Re-create vault secrets
- Organize env files and rename env vars
### Deprecated
### Removed
### Fixed
- Reformat code PSR-12
- Small refactors
### Security
- Salt user passwords



## [0.3.7] - 2021-04-30
### Added
- Travis CI
- Behat test JsonWebToken
### Changed
### Deprecated
### Removed
### Fixed
- Reformat code PSR-12
- Small refactors
### Security
- Salt user passwords



## [0.3.6] - 2021-04-28
### Added
- Repo stats
- ObjectMothers
### Changed
- Name exceptions
### Deprecated
### Removed
### Fixed
- Validate token format in AuthenticationSubscriber
### Security
- http code 401, when user not found



## [0.3.5] - 2021-04-27
### Added
### Changed
- Makefile, targets refactor
### Deprecated
### Removed
### Fixed
- rector run
- Doc updated
- Fix phpstan fatal error memory allocation 
### Security



## [0.3.4] - 2021-04-26
### Added
- Add Filebeat and Kibana docker
- Symfony log levels
- CORS: added hosts
### Changed
### Deprecated
### Removed
### Fixed
- Typos
- Nginx and Symfony logs
### Security



## [0.3.3] - 2021-04-02
### Added
### Changed
- Makefile clean
### Deprecated
### Removed
### Fixed
- phpcs
- rector
### Security



## [0.3.2] - 2021-04-02
### Added
- Token behat tests
### Changed
- Solve some todo's
### Deprecated
### Removed
### Fixed
- Add prod.decrypt.private.php
### Security



## [0.3.1] - 2021-04-02
### Added
- Doc: Some curl examples to /albums PUT with JWToken
### Changed
- PUT /albums with Authentication (header+payload) and signature in cookie
- Using domain exception wrapper for /authentication endpoints
- Behat test for Authentication (header+payload) and signature in cookie
### Deprecated
### Removed
### Fixed
### Security



## [0.3.0] - 2021-04-01
### Added
- JWT authorization for endpoints under /albums wit PUT verb
- Domain exceptions wrapper to HTTP codes 
### Changed
- Acceptation and Unit tests for a new feature added
- Documentation
- Delete some *Exception *Interfaces suffixes from class names
### Deprecated
### Removed
### Fixed
### Security



## [0.2.3] - 2021-01-28
### Added
- DumpEnvCommand to generate .env.local.php properly
### Changed
### Deprecated
### Removed
### Fixed
- Rector and Psalm errors
- README
### Security



## [0.2.2] - 2021-01-20
### Added
### Changed
### Deprecated
### Removed
### Fixed
- Move Backend symfony app from Catalog to MusicLabelApp
### Security


## [0.2.1] - 2021-01-18
### Added
### Changed
- Move backend symfony app to parent folder
### Deprecated
### Removed
### Fixed
- Default conf file for supervisord to avoid error message
- Add final to all classes (except some entities)
### Security



## [0.2.0] - 2021-01-18
### Added
- NoSql code examples, with Redis as a database's results cache
- SNC bundle to manage Redis
- Redis service in docker stack
### Changed
- Acceptation and Unit tests for a new feature added
- Documentation
### Deprecated
### Removed
### Fixed
### Security



## [0.1.0] - 2021-01-17
### Added
- Symfony Command to create users
- Examples in README.MD doc
- Behat tests for albums: Patch and Put features
- Documentation: about docker images
### Changed
- Behat tables when creating fake data
### Deprecated
### Removed
### Fixed
- "Create Token" static function array bug
- Docker image sources
- Semantic versioning for upcoming releases
### Security



## [0.0.2] - 2021-01-14
### Added
- Add sections to "Table of Contents" README.md
- Auth module: Token and User models, repository, mappings, etc.
- Database migrations
- Added credentials requirement for POST /albums endpoints
- Different <object>Mother to generate fake data to test
### Changed
- Move all albums' inputRequests to BC/module Album
### Deprecated
### Removed
### Fixed
- ValueObjectAbstract sharing static constraints between classes
- Makefile targets
- Test to working with the new feature including credentials to POST an Album
### Security



## [0.0.1] - 2021-01-11
### Added
- First project version
### Changed
### Deprecated
### Removed
### Fixed
### Security



[Unreleased]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/master...develop
[0.3.8]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.3.7...v0.3.8
[0.3.7]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.3.6...v0.3.7
[0.3.6]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.3.5...v0.3.6
[0.3.5]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.3.4...v0.3.5
[0.3.4]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.3.3...v0.3.4
[0.3.3]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.3.2...v0.3.3
[0.3.2]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.3.1...v0.3.2
[0.3.1]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.3.0...v0.3.1
[0.3.0]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.2.3...v0.3.0
[0.2.3]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.2.2...v0.2.3
[0.2.2]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.2.1...v0.2.2
[0.2.1]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.0.2...v0.1.0
[0.0.2]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.0.1...v0.0.2
[0.0.1]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/releases/tag/v0.0.1