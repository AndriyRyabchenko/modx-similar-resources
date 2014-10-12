<?php
/*

Usage:
[[!pdoResources?
&tpl=`similarResources_tpl`
&sortby=`RAND()`
&limit=`4`
&parents=`6,8`
&resources=`[[!similarResources?&parents=`6,8`&tags=`[[*tags]]`&tvTagName=`tags`]]`
]]

&parents - родители для сравнения
&tags - строка тегов через зпт.
&tvTagName - название ТВ параметра с тегами документов
*/

//получения id всех дочерних страниц для родителей указанных в &parents
$ids = $modx->runSnippet('pdoResources',array(
   'parents' => $parents,
   'depth' => 1,
   'returnIds' => 1,
   'limit' => 0,
   'select' => 'id',
   'includeTVs' => $tvTagName,
   'where' => "[\" $tvTagName NOT LIKE '' \"]"
));

//echo $ids;
$idsAr = explode(',',$ids);

//теги текущей страницы
$tagsAr = explode(",", $tags);

//в цикле получаем наборы тегов для каждого дочернего ресурса из массива $idsAr
foreach ($idsAr as $docId){
    $resource = $modx->getObject('modResource',  $docId);
    $tagsTStr = $resource->getTVValue($tvTagName);
    if (strpos($tagsTStr,',')!==false){
      //обязательно очищаем массив перед записью нового набора тегов
       $tagsTAr = array();
       $tagsTAr = explode(",", $tagsTStr);
    }
    else{
       $tagsTAr = array();
       $tagsTAr[0] = $tagsTStr;
    }

//обнуление счетчика повторений
    $count=0;
    //перебираем все теги текущей страницы
    foreach ($tagsAr as $tag){
       //перебираем все теги для рассматриваемого набора тегов одной из статей
       foreach ($tagsTAr as $tagT){
           //если названия тегов совпадают
           if (!strcmp($tagT,$tag)){
               $count++;
               //записываем в массив $arr обновленное значение счетчика для ключа $id
               $arr[$docId]=$count;
           }
       }
    }
}

//сортируем полученный массив по значениям счетчиков
arsort($arr);
foreach ($arr as $key=>$var){
    $resIds .= $key.',';
}
$resIds=substr($resIds, 0, strlen($resIds)-1);
return $resIds;