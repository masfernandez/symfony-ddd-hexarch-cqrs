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

[Unreleased]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.0.2...develop
[0.0.2]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/v0.0.1...v0.0.2
[0.0.1]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/releases/tag/v0.0.1