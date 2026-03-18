# dvo-patches
Verzameling van patches voor de DvO-composer

In deze repo verzamelen we alle patches die we toepassen in DvO tijdens de composer build.

## Afspraken
* Plaats patches altijd in een subdirectory van de module:
/core/.
/webform/.
etc.

* Begin de patch altijd met het issue-id van drupal.org.
* Als er geen issue is, begin de patch altijd met het Jira-ticket waarvoor hij toegepast is.

3432428-webform-form_filesize_limit_message-3a.patch
DVGEM-1234-webform-form_filesize_limit_message-3a.patch

We committen gewoon in main, en in composer nemen we directe url naar de raw-file op:
https://raw.githubusercontent.com/iodigital-com/dvo-patches/refs/heads/main/3216010-js-script-too-opinionated.patch
