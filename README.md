<div align="center">
  <br>
  <h1>Laravel - API-CORE Multi Database 🌱</h1>
  <strong>WebService Multi Tenant Database</strong>
</div>
<br>


---

# Rodar Testes

php artisan test

# Rodar Testes com coverage

php artisan test --coverage-html tests/reports/coverage

php artisan test --coverage

vendor/bin/phpunit --coverage-html reports/

vendor/bin/phpunit --testsuite Feature

php -dxdebug.mode=coverage vendor/bin/phpunit --coverage-html reports/
php -dxdebug.mode=coverage vendor/bin/phpunit --coverage-html reports/

php artisan test --filter "CustomerSignUpJobTest"

php artisan test CustomerServiceTest

## Brew php versions

brew unlink php@7.4
brew link php@8.1 --force --overwrite

##
