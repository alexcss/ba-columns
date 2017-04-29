
(function() {
	tinymce.PluginManager.add('ba_col_mce_button', function(editor, url) {
		editor.addButton('ba_col_mce_button', {
			text: 'BA Column',
			icon: 'table',
			type: "menubutton",
			menu: [
				{
					text: 'One half',
					onclick: function() {
						var shortCode = "[ba_col_1_2] \n" +  editor.selection.getContent() + "\n [/ba_col_1_2] \n";
						editor.insertContent(shortCode);
					}
				},
				{
					text: 'One half end',
					onclick: function() {
						var shortCode = "[ba_col_1_2_end] " +  editor.selection.getContent() + "[/ba_col_1_2_end]";
						editor.insertContent(shortCode);
					}
				},
				{
					text: 'One third',
					onclick: function() {
						var shortCode = "[ba_col_1_3] " +  editor.selection.getContent() + "[/ba_col_1_3]";
						editor.insertContent(shortCode);
					}
				},
				{
					text: 'One third end',
					onclick: function() {
						var shortCode = "[ba_col_1_3_end] " +  editor.selection.getContent() + "[/ba_col_1_3_end]";
						editor.insertContent(shortCode);
					}
				},
			]
		});
	});
})();

