# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.1] - 2024-09-25

### Fixed

- Fixed issue with `GET` requests to Azure Key Vault API.

## [1.0.0] - 2021-02-08

### Changed

- Instead of a hard coded dependency to guzzle/http we now use the PSR-17 and PSR-18 interfaces instead.

## [0.0.2] - 2020-09-22

### Changed

- Downgraded required version of PHP to 7.2

## [0.0.1] - 2020-09-18

### Added

- This CHANGELOG file.
- Functionality for fetching certificates.
- Functionality for fetching secrets.

[1.0.1]: https://github.com/itk-dev/AzureKeyVaultPhp/compare/1.0.0...HEAD
[1.0.0]: https://github.com/itk-dev/AzureKeyVaultPhp/compare/0.0.2...1.0.0
[0.0.2]: https://github.com/itk-dev/AzureKeyVaultPhp/compare/0.0.1...0.0.2
[0.0.1]: https://github.com/itk-dev/AzureKeyVaultPhp/releases/tag/0.0.1
