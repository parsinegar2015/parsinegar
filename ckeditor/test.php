<html>
<head>
<style type="text/css">
blockquote
{
	font-style: italic;
	font-family: Georgia, Times, "Times New Roman", serif;
	padding: 2px 0;
	border-style: solid;
	border-color: #ccc;
	border-width: 0;
	padding-left: 8px;
	padding-right: 20px;
	border-right-width: 5px;
}
</style>
<script src="ckeditor.js"></script>
<script>

CKEDITOR.on( 'instanceCreated', function( event ) {
			var editor = event.editor;

editor.config.language = 'fa';			
editor.config.height = 200;

if(editor.name == 'min_ckeditor'){
editor.on( 'configLoaded', function() {

// Remove unnecessary plugins to make the editor simpler.
					editor.config.removePlugins = 'colorbutton,find,flash,font,' +
						'forms,iframe,image,newpage,removeformat,' +
						'smiley,specialchar,stylescombo,templates';

					// Rearrange the layout of the toolbar.
					editor.config.toolbarGroups = [
						{ name: 'editing',		groups: [ 'basicstyles','align' ] },
						{ name: 'undo' },
						{ name: 'clipboard',	groups: [ 'selection', 'clipboard' ] },
						{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] }
						
					];
				});

}			
});
</script>
</head>
<body>

<h1>full_ckeditor</h1>
<br/>
<textarea class="ckeditor" id="full_ckeditor"></textarea>
<br/>
<br/>
<h1>min_ckeditor</h1>
<br/>
<textarea class="ckeditor" name="min_ckeditor"></textarea>
<br/>
</body>
</html>