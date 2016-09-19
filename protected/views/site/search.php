<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Поиск');
$this->breadcrumbs=array(
	tc('Поиск'),
);
?>

<div id="posts-list" class="articles-list">
	<h2 class="page-heading"><span><?php echo tc('Результаты поиска');?>: "<?php echo $words;?>"</span></h2>

	<?php
	$this->widget('zii.widgets.CListView', array(
		'id' => 'search-result-list',
		'dataProvider' => $itemsProvider,
		'viewData' => array('words' => $words, 'wordsArr' => $wordsArr),
		'itemView'=>'_search_item',
		'ajaxUpdate'=> true,
		'emptyText'=>tc('По данному запросу ничего не найдено.'),
		'summaryText'=>"{start}&mdash;{end} из {count}",
		'template'=>'{pager} {summary} {items} {pager}',
		'pager'=>array(
			'class'=>'itemPaginator',
			'header'=>false,
		),
	));
	?>
</div>