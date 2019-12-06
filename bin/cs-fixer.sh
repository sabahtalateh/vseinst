#!/bin/sh

php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix src --rules=@Symfony,-phpdoc_no_empty_return,-class_keyword_remove,-phpdoc_summary,-yoda_style --verbose --show-progress=estimating
php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix tests --rules=@Symfony,-phpdoc_no_empty_return,-class_keyword_remove,-phpdoc_summary,-yoda_style --verbose --show-progress=estimating
