ChangeLog Bundle
===================

## Install

```bash
composer require gupalo/changelog-bundle
```

Add to `config/bundles.php`

```php
Gupalo\ChangeLogBundle\ChangeLogBundle::class => ['all' => true]
```

Add to `config/packages/doctrine.yaml`
```yaml
mappings:
    ChangeLogBundle:
        type: attribute
```

Add to config/routes/annotations.yaml

```yaml
changeLog:
    resource: '@ChangeLogBundle/Resources/config/routes.yaml'
```


## Execute

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
php bin/console assets:install
```
