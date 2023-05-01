# HouseCeeper module install

Clone repository to `${doc_root}/local/modules`

Install module using admin panel

Set `House Ceeper template` as your primary site template

## Setup modern Bitrix routing

Add `houseceeper.php` in `routing` section of `${doc_root}/bitrix/.settings.php` file:

```php
'routing' => ['value' => [
	'config' => ['houseceeper.php']
]],
```

Put following content into your `${doc_root}/index.php` file:

```php
<?php
require_once __DIR__ . '/bitrix/routing_index.php';
```

Replace following lines in your `${doc_root}/.htaccess` file:

```
-RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite.php$
-RewriteRule ^(.*)$ /bitrix/urlrewrite.php [L]

+RewriteCond %{REQUEST_FILENAME} !/index.php$
+RewriteRule ^(.*)$ /index.php [L]
```

## Symlinks for handy development

You probably want to make following symlinks:

```
local/components/hc -> local/modules/hc.houseceeper/install/components/hc
local/components/js -> local/modules/hc.houseceeper/install/components/js
local/templates/houseceeper -> local/modules/hc.houseceeper/install/templates/houseceeper
local/routes/houseceeper.php -> local/modules/hc.houseceeper/install/routes/houseceeper.php
```
