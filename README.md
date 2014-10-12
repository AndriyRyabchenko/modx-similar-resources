modx-similar-resources
======================

- snippet shows similar resources like articles or news by they tags
- worked with **pdoResources** snippet (pdoTools package)

**Install**
- create new snippet, named similarResources
- copy-paste code from __modx-similar-resources-snippet.php__

**Usage:**
```php
[[!pdoResources?
&tpl=`similarResources_tpl`
&sortby=`RAND()`
&limit=`4`
&parents=`6,8`
&resources=`[[!similarResources?&parents=`6,8`&tags=`[[*tags]]`&tvTagName=`tags`]]`
]]
```
- with this launch - will search in the specified folders (&parents) and 4 show (&limit) like the current document ([[*tags]]) with random sorting.

- &parents - parent resources, comma separated
- &tags - tags string, comma separated
- &tvTagName - name of your TV where contains TAGS
