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

&parents - �������� ��� ���������
&tags - ������ ����� ����� ���.
&tvTagName - �������� �� ��������� � ������ ����������
*/

//��������� id ���� �������� ������� ��� ��������� ��������� � &parents
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

//���� ������� ��������
$tagsAr = explode(",", $tags);

//� ����� �������� ������ ����� ��� ������� ��������� ������� �� ������� $idsAr
foreach ($idsAr as $docId){
    $resource = $modx->getObject('modResource',  $docId);
    $tagsTStr = $resource->getTVValue($tvTagName);
    if (strpos($tagsTStr,',')!==false){
      //����������� ������� ������ ����� ������� ������ ������ �����
       $tagsTAr = array();
       $tagsTAr = explode(",", $tagsTStr);
    }
    else{
       $tagsTAr = array();
       $tagsTAr[0] = $tagsTStr;
    }

//��������� �������� ����������
    $count=0;
    //���������� ��� ���� ������� ��������
    foreach ($tagsAr as $tag){
       //���������� ��� ���� ��� ���������������� ������ ����� ����� �� ������
       foreach ($tagsTAr as $tagT){
           //���� �������� ����� ���������
           if (!strcmp($tagT,$tag)){
               $count++;
               //���������� � ������ $arr ����������� �������� �������� ��� ����� $id
               $arr[$docId]=$count;
           }
       }
    }
}

//��������� ���������� ������ �� ��������� ���������
arsort($arr);
foreach ($arr as $key=>$var){
    $resIds .= $key.',';
}
$resIds=substr($resIds, 0, strlen($resIds)-1);
return $resIds;