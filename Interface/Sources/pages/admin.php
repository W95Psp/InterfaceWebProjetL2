
<script src="/scripts/admin.js"></script>
<style>
	h1{
		display: inline-block;
		float: left;
		font-size: 24px;
		padding: 10px;
		color: #bdc3c7;
		transition: color 100ms linear;
		position: relative;
		top: 0px;
		cursor: default;
	}
	h1[state='true']{
		color: black;
		transition: color 100ms linear;
	}
	h1:hover{
		top: -2px;
		transition: top 100ms ease-out;
	}
	.view{
		width: 760px;
		overflow: hidden;
	}
	.panels{
		position: relative;
		width: 4000px;
	}
	.panels[state="0"]{left: 0px;		transition: left 400ms ease-out;}
	.panels[state="1"]{left: -760px;	transition: left 400ms ease-out;}
	.panels[state="2"]{left: -1520px;	transition: left 400ms ease-out;}
	.panels[state="3"]{left: -2280px;	transition: left 400ms ease-out;}
	
	.panel{
		float: left;
		width: 760px;
	}
</style>
<script type="text/javascript" src="TinyEditor/packed.js"></script>
<link rel="stylesheet" href="TinyEditor/style.css"/><?php if(isset($parseParam[1], $parseParam[2], $_POST['content']) && $parseParam[1]=='presentation' && $parseParam[2]=='update'){
	$html = explode('<style>*{font-family: \'Open Sans\';}</style>', $_POST['content'], 2)[1];
	file_put_contents('pages/presentation-content.html', $html);
}
echo '<div class=\'page interface-admin\' ng-controller=\'admin\' ng-init=\'';
echo 'pages = ["Encadrants", "Groupes", "Présentation", "Modalité notes"]; currentPage = 0;';
if(isset($parseParam[1]) && $parseParam[1]=='presentation')
	echo 'currentPage = 2;';
echo '\'>';
 ?>
<h1 ng-repeat="(k,page) in pages" state="{{currentPage==k}}" ng-click="$parent.currentPage=k">{{page}}</h1><br/>
<div class="view">
	<div state="{{currentPage}}" class="panels">
		<div class="panel">
			<h2>[Page à inclure ici] ~T1</h2>
		</div>
		<div class="panel"> 
			<h2>[Page à inclure ici] ~T2</h2>
		</div>
		<div class="panel"> 
			<h2>Page de présentation</h2>
			<form method="POST" action="/?admin/presentation/update">
				<textarea id="input" name="content" style="width:760px; height:400px; margin: auto;">
					<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300"/>
					<style>*{font-family: 'Open Sans';}</style><?php echo file_get_contents('pages/presentation-content.html'); ?>
				</textarea>
				<script>
					var editor = new TINY.editor.edit('editor',{
						id:'input',
						width:660,
						height:300,
						cssclass:'te',
						controlclass:'tecontrol',
						rowclass:'teheader',
						dividerclass:'tedivider',
						controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
								  'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
								  'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n',
								  'image','hr','link','unlink','|','cut','copy','paste','print'],
						footer:true,
						fonts:['Open Sans','Arial','Georgia','Trebuchet MS'],
						xhtml:true,
						cssfile:'style.css',
						bodyid:'editor',
						footerclass:'tefooter',
						resize:{cssclass:'resize'}
					});
				</script>
				<button onclick="editor.post();">Mettre à jour</button>
			</form>
		</div>
		<div class="panel"> 
			<h2>[Page à inclure ici] ~T4</h2>
		</div>
	</div>
</div><?php echo '</div>'; ?>