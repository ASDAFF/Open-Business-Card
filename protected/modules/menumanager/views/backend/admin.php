<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.jstree/apple/style.css" />
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/browser_fix.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.jstree.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.dialog-plugin.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/blockUI.js', CClientScript::POS_HEAD);

$this->pageTitle=Yii::app()->name . ' - '.tc('Управление новостями');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление пунктами меню'),
);

$this->menu = array(
	array(),
);

$this->adminTitle = tc('Управление пунктами меню');
?>

<div class="flash-notice">
	<?php echo tc('На наименовании пункта меню кликните правой клавишей мыши и увидите контекстное меню с доступными действиями. Максимум можно добавить 3 уровня. Есть возможность  зажать левую клавишу мыши и перемещать элементы меню вверх и вниз.');?>
</div>

<script type="text/javascript">

var dlgStatus=$().dialogPlugin();
var dlgConfirm=$().dialogPlugin();
var jstree;

function jstree_loaded(){
	$(this).find('li[rel=root]').find('.jstree-checkbox:first').hide();
}

// редактирование элемента
function editItem(obj){
	var pid=$(this._get_node(obj)).attr('pid');
	if($.isNumeric(pid)) {
		var url = '<?php echo $this->createUrl("update"); ?>';

		if(url.indexOf("?") != -1) {
			window.location=url +'&id='+pid;
		}
		else {
			window.location=url +'?id='+pid;
		}
	}
	else
		dlgStatus.notice(<?php echo CJavaScript::encode(tc("Невозможно редактировать данный раздел")); ?>,<?php echo CJavaScript::encode(tc("Error")); ?>).open();
}

// добавление узла
function create_node(e, data){
	var title=data.rslt.name;
	if(typeof data.rslt.obj.parents("li:eq(0)").attr("pid")=='undefined'){
		dlgStatus.notice(<?php echo CJavaScript::encode(tc("Родительский узел не был создан, повторите попытку позже.")); ?>,<?php echo CJavaScript::encode(tc("Error")); ?>).open();
		$.jstree.rollback(data.rlbk);
		return;
	}
	if(title==<?php echo CJavaScript::encode(tc("Введите название пункта меню")); ?>){
		$.jstree.rollback(data.rlbk);
		return;
	}
	jstree.jstree('lock');
	$.post(
		'<?php echo $this->createUrl("create"); ?>',
		{
			"parentId" : data.rslt.obj.parents("li:eq(0)").attr("pid"),
			"title" : title,
			"number": data.rslt.position
		},
		function(respdata){
			jstree.jstree('unlock');
			$(data.rslt.obj).attr("pid", respdata);
			jstree.jstree("refresh");
		}
	)
		.error(function(jqXHR){
			jstree.jstree('unlock');
			$.jstree.rollback(data.rlbk);
			dlgStatus.notice(jqXHR.responseText,<?php echo CJavaScript::encode(tc("Ошибка")); ?>).open();
			jstree.jstree("refresh");
		});
};

//переименовать узел
function rename_node(e,data){
	var oldName=data.rslt.old_name;
	var newName=data.rslt.new_name;

	if(oldName==newName) return;

	dlgConfirm.confirm("<?php echo CJavaScript::encode(tc("Вы действительно хотите переименовать пункт меню")); ?> "+oldName+" <?php echo CJavaScript::encode(tc("в")); ?> "+newName+" ",<?php echo CJavaScript::encode(tc("Переименовать пункт меню")); ?>,
		function(){
			$.post(
				'<?php echo $this->createUrl("rename"); ?>',
				{
					"pid" : data.rslt.obj.attr("pid"),
					"title" : newName
				},
				function (respdata) {
					jstree.jstree("refresh");
				}
			)
				.error(function(jqXHR){
					$.jstree.rollback(data.rlbk);
					dlgStatus.notice(jqXHR.responseText,<?php echo CJavaScript::encode(tc("Ошибка")); ?>).open();
				});
		},true,
		function(){
			$.jstree.rollback(data.rlbk);
		}
	).open();
};

//переключение чекбокса
function change_state(e, data){
	var checked=data.inst.is_checked(data.rslt)?1:0;
	var pid=data.rslt.attr("pid");
	if(typeof pid=='undefined') return;
	$.post(
		'<?php echo $this->createUrl("setVisible"); ?>',
		{
			"pid" : pid,
			"visible" : checked
		}
	)
		.error(function(jqXHR){
			dlgStatus.notice(jqXHR.responseText,<?php echo CJavaScript::encode(tc("Ошибка")); ?>).open();
		});
}

//удалить узел
function remove_node(e,data){
dlgConfirm.confirm("<?php echo CJavaScript::encode(tc("Вы действительно хотите удалить пункт меню")); ?> "+data.inst.get_text(data.rslt.obj)+" <?php echo CJavaScript::encode(tc("и всех его потомков?")); ?>",<?php echo CJavaScript::encode(tc("Удалить пункт меню")); ?>,
		function(){
			$.post(
				'<?php echo $this->createUrl("deleteItem"); ?>',
				{
					"pid" : data.rslt.obj.attr("pid")
				},
				function (respdata) {
					jstree.jstree("refresh");
				}
			)
				.error(function(jqXHR){
					$.jstree.rollback(data.rlbk);
					dlgStatus.notice(jqXHR.responseText,<?php echo CJavaScript::encode(tc("Ошибка")); ?>).open();
				});
		},true,
		function(){
			$.jstree.rollback(data.rlbk);
		}
	).open();
};

function move_node(e,data){
	var ref=data.rslt.r.attr("pid");
	var pos=data.rslt.p;
	if(ref==0 && (pos=='after' || pos=='before')){
		$.jstree.rollback(data.rlbk);
		return;
	}
	jstree.jstree('lock');


	$.post(
		'<?php echo $this->createUrl("move"); ?>',
		{
			"pid" : data.rslt.o.attr("pid"),
			"dst" : data.rslt.np.attr("pid"),
			"ref" : ref,
			"pos": pos
		},
		function(){
			jstree.jstree('unlock');
			jstree.jstree("refresh");
		}
	)
		.error(function(jqXHR){
			jstree.jstree('unlock');
			$.jstree.rollback(data.rlbk);
			jstree.jstree('refresh');
			dlgStatus.notice(jqXHR.responseText,<?php echo CJavaScript::encode(tc("Ошибка")); ?>).open();
		});
};

function contextMenu(node){
	var items={
		create : {
			label	: <?php echo CJavaScript::encode(tc("Создать внутри")); ?>,
			action: function(){jstree.jstree('create')}
		},
		rename : {
			label	: <?php echo CJavaScript::encode(tc("Переименовать")); ?>,
			action: function(){jstree.jstree('rename')}
		},
		remove : {
			label	: <?php echo CJavaScript::encode(tc("Удалить")); ?>,
			action: function(){jstree.jstree('remove')}
		},
		edit : {
			label: <?php echo CJavaScript::encode(tc("Редактировать")); ?>,
			separator_before: true,
			action: editItem
		},
		ccp: false
	}

	if ($(node).attr('rel') == 'root') {
		delete items.rename;
		delete items.remove;
		delete items.edit;
	}
	else {
		switch($(node).attr('rel')){
		}

		switch($(node).attr('special')){
			case '1':
				delete items.create;
				delete items.remove;
				break;
		}

		switch($(node).attr('level')){
			case '0':
			case '1':
			case '2':
				break;
			case '<?php echo Menu::MAX_LEVEL;?>':
				delete items.create;
				break;
		}
	}

	jstree.jstree("deselect_all");
	jstree.jstree("select_node", node);

	return items;
}

$(function(){
	var freeHeight=$(window).height()-110;
	$("#pageList").height(freeHeight);

	jstree=$("#pageList").jstree({
		core:{
			"strings":{
				new_node    : <?php echo CJavaScript::encode(tc("Введите название пункта меню")); ?>,
				loading     : <?php echo CJavaScript::encode(tc("Загрузка ...")); ?>
			}
		},
		json_data : {
			"ajax" : {
				"url" : "<?php echo $this->createUrl("getPageList"); ?>"
			}
		},
		themes:{
			"theme" : "apple",
			"url" : '<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.jstree/apple/style.css',
			"dots" : true,
			"icons" : true
		},
		checkbox:{
			two_state: true
		},
		contextmenu: {items: contextMenu},
		types:{
			"types" : {
				"root" : {
					"icon" : {
						'position': '-56px -37px'
					},
					"start_drag" : false,
					"move_node" : false,
					"delete_node" : false,
					"rename" : false,
					"remove" : false,
					"change_state" : false
				},
				"default" : {
					"icon" : {
						'position': '-75px -38px'
					}
				}
			}
		},
		plugins : ["themes", "json_data", "contextmenu", "crrm", "dnd", "checkbox", "ui", "types"]
	})
		.bind("loaded.jstree", jstree_loaded)
		.bind("rename.jstree", rename_node)
		.bind('change_state.jstree', change_state)
		.bind("remove.jstree", remove_node)
		.bind("create.jstree", create_node)
		.bind("move_node.jstree", move_node)
	;

});
</script>


<div id="pageList" style="height: 400px; overflow: auto"></div>