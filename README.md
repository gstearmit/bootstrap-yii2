# Bootstrap for Yii2

[![Build Status](https://travis-ci.org/rkit/bootstrap-yii2.svg?branch=master)](https://travis-ci.org/rkit/bootstrap-yii2)
[![Code Coverage](https://scrutinizer-ci.com/g/rkit/bootstrap-yii2/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/rkit/bootstrap-yii2/?branch=master)
[![codecov.io](http://codecov.io/github/rkit/bootstrap-yii2/coverage.svg?branch=master)](http://codecov.io/github/rkit/bootstrap-yii2?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rkit/bootstrap-yii2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rkit/bootstrap-yii2/?branch=master)

## Features

- Users, Roles, Registration, Basic and social authorization
- Countries, Regions, Cities
- Tags
- [Settings](https://github.com/rkit/settings-yii2)
- [File Manager](https://github.com/rkit/filemanager-yii2)
- [Webpack for assets](https://webpack.github.io/)

Screenshots:
- [User List](https://cloud.githubusercontent.com/assets/4242765/5601755/2d9aad0c-9341-11e4-8ee2-ab5e02f90314.png)
- [User Form](https://cloud.githubusercontent.com/assets/4242765/5601756/2fb0cdb0-9341-11e4-8d25-6aca3bc9baf8.png)

## Installation

1. Create project
   ```
   composer global require "fxp/composer-asset-plugin:~1.0"
   composer create-project --prefer-dist --stability=dev rkit/bootstrap-yii2
   cd bootstrap-yii2
   ```

2. Check requirements
   ```
   php requirements.php
   ```

3. Create a new database and local config
   ```
   php yii create-local-config/init --path=@app/config/local/config.php
   ```
   > config will be created in *config/local/config.php*  
   > fill in the database settings

4. Run
   ```
   composer install-app
   ```

Access to the Control Panel
```
username: editor  
password: fghfgh
```

## Configuring Server

Set document root to be `/path/to/source/web`

## Development

### Debug mode

- Apache Configuration
  ```apache
  SetEnv APPLICATION_ENV "development"
  ```

- Nginx Configuration
  ```nginx
  fastcgi_param APPLICATION_ENV development;
  ```

### Assets

- Watch mode (debug)
  ```
  npm run watch
  ```

- Build for production
  ```
  npm run build
  ```

### Tests

- [See docs](/tests/#tests)

### Coding Standard

- PHP Code Sniffer — [phpcs.xml](./phpcs.xml)
- PHP Mess Detector — [phpmd.xml](./phpmd.xml)
- ESLint — [.eslintrc](./.eslintrc)
