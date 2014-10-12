modx-similar-resources
======================

snippet shows similar resources like articles or news by they tags


Usage:
```php
[[!pdoResources?
&tpl=`similarResources_tpl`
&sortby=`RAND()`
&limit=`4`
&parents=`6,8`
&resources=`[[!similarResources?&parents=`6,8`&tags=`[[*tags]]`&tvTagName=`tags`]]`
]]
```
&parents - parent resources, comma separated
&tags - tags string, comma separated
&tvTagName - name of your TV where contains TAGS
