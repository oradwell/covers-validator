# CONTRIBUTING

## Building PHAR for releases

### Pre-requisites

- Install [clue/phar-composer](https://github.com/clue/phar-composer) via composer
- Create a tag for the release

### Build PHAR archive

Run phar-composer in build mode to build the phar archive for the specified tag in the following way:

```bash
phar-composer build ockcyp/covers-validator:<gitref>
```

For example:

```bash
php -d phar.readonly=off vendor/bin/phar-composer build ockcyp/covers-validator:1.7.0
```

The phar archive will be saved to the `./covers-validator.phar` path.
