NextEuropa Integration
======================

Backend
------------------
TBC.

Producer
------------------
TBC.

Consumer component
------------------

This component extends Migrate functionality allowing to import multi-language
content from standard Integration Layer JSON format.

Destination entities have to be translatable using Entity Translation module in
order for the migration to work correctly.

Integration Layer JSON format
-----------------------------

Each content item is defined by a JSON document having the following features:

### Metadata
Each JSON document is required to have the following metadata properties:

```
{
  "_id": "b849bh0qh0qnciwpvi3tn342kc39c24b",    # Unique document ID.
  "type": "article",                            # Content type.
  "default_language": "en",                     # Default content language.
  "languages": ["fr", "en"],                    # Languages the content is available in.
```

### Content fields
Content fields are exposed in the format below:

```
  "fields": {
    "title": {
      "en": ["English title article 1"],
      "fr": ["French title article 1"]
    },
    "abstract": {
      "en": ["English abstract article 1"],
      "fr": ["French abstract article 1"]
    }
```

 - Each "fields" property represent a content field.
 - "fields" property keys are the actual field names.
 - "fields" property values are objects having as property keys valid
   ISO 639-1 format language codes, plus "und" for language neutral content
   (e.g. in case of fields referencing other documents).
 - Language code-keyed properties have, as value, an array holding the actual
   field content, expressed in the respective language. Values must always be
   arrays, regardless if the field has only one or several values.

Using migration classes with Migrate
------------------------------------

In order to implement your own migration using Migrate refer to:
[Getting started with Migrate](https://www.drupal.org/node/1006982).

In order to be able to import Integration Layer JSON documents make sure that
your migration classes extend ```Drupal\nexteuropa_integration\Consumer\Migrate\AbstractMigration```
instead the default ```Migration``` class, provided by the Migrate module.

Also use ```Drupal\nexteuropa_integration\Consumer\Migrate\MigrateItemJSON``` 
instead of default ```MigrateItemJSON```, provided by Migrate module.

Below an example about how to setup migration source using "NextEuropa Migrate"
classes:

```
<?php

use Drupal\nexteuropa_integration\Consumer\Migrate\MigrateItemJSON;
use Drupal\nexteuropa_integration\Consumer\Migrate\AbstractMigration;

class NextEuropaMigration extends AbstractMigration {

  public function __construct($arguments) {
    // Ordinary Migrate code goes here.

    $this->setSource(new MigrateSourceList(
      new \MigrateListJSON('http://example.com/list.json'),
      new MigrateItemJSON('http://example.com/document-:id.json', array()),
      array()
    ));
  }

}
```

### Field mapping
Field mapping works exactly as in a standard Migrate migration. The only
requirement we must meet is to always provide the following field mappings:

```
    // Entity translation requires that both title fields are mapped.
    $this->addFieldMapping('title', 'title');
    $this->addFieldMapping('title_field', 'title');

    // Mapping default language is necessary for correct translation handling.
    $this->addFieldMapping('language', 'default_language');
```

For more in-depth examples on how to setup your migration please refer to
```nexteuropa_integration_test``` migration classes:

- ./tests/nexteuropa_integration_test/includes/nexteuropa_integration_test.abstract.inc
- ./tests/nexteuropa_integration_test/includes/nexteuropa_integration_test.articles.inc
- ./tests/nexteuropa_integration_test/includes/nexteuropa_integration_test.categories.inc
- ./tests/nexteuropa_integration_test/includes/nexteuropa_integration_test.news.inc
