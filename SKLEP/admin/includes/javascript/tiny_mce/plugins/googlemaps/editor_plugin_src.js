/**
 * $Id: editor_plugin_src.js 520 2008-01-07 16:30:32Z spocke $
 *
 * @author Cees Rijken
 * @copyright www.connectcase.nl
 */

(function() {
	tinymce.PluginManager.requireLangPack('googlemaps');
	tinymce.create('tinymce.plugins.GooglemapsPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceGooglemap', function() {
				ed.windowManager.open({
					file : url + '/googlemaps.htm',
					width : 350 + parseInt(ed.getLang('googlemaps.delta_width', 0)),
					height : 180 + parseInt(ed.getLang('googlemaps.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceGooglemapDelete', function() 
      {
      var gdoc = ed.getDoc();
      ed.dom.remove(gdoc.getElementById('spangooglemaps'));
			});

      	ed.addButton('googlemaps', {
				title : 'googlemaps.desc',
				cmd : 'mceGooglemap',
				image : url + '/img/googlemaps.gif'
			});
				ed.addButton('googlemapsdel', {
				title : 'googlemaps.deldesc',
				cmd : 'mceGooglemapDelete',
				image : url + '/img/googlemapsdel.gif'
			});
			//ed.addButton('googlemaps', {title : 'googlemaps.desc', cmd : 'mceGooglemap'});
			//ed.addButton('googlemapsdel', {title : 'googlemaps.deldesc', cmd : 'mceGooglemapDelete'});

		},

		getInfo : function() {
			return {
				longname : 'Googlemaps',
				author : 'Cees Rijken',
				authorurl : 'http://www.connectcase.nl',
				infourl : 'http://www.connectcase.nl/bl.google.maps.plugin.tinymce.html',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('googlemaps', tinymce.plugins.GooglemapsPlugin);
})();