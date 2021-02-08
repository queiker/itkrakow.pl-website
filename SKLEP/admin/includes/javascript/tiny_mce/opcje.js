tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	language : 'pl',
	plugins : "preview,advimage,table,media,googlemaps",
	theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,fontselect,fontsizeselect,forecolor,backcolor",
	theme_advanced_buttons2 : "undo,redo,link,unlink,hr,image,table,separator,cut,copy,paste,separator,preview,cleanup,code,googlemaps,googlemapsdel",
	theme_advanced_buttons2_add : "media",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	convert_urls : false,
	cleanup : true
});

function toggleEditor(id) {
	if (!tinyMCE.get(id))
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}