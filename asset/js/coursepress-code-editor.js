/* global jQuery, wp */
( function( $ ) {
	'use strict';

	var modes = {
		php: 'text/x-php',
		javascript: 'text/javascript',
		python: 'text/x-python',
		java: 'text/x-java',
		csharp: 'text/x-csharp',
		cpp: 'text/x-c++src',
		html: 'text/html',
		css: 'text/css',
		sql: 'text/x-sql',
		shell: 'text/x-sh'
	};

	function indentAtCursor( event ) {
		var textarea = event.target;
		var start;
		var end;

		if ( event.key !== 'Tab' ) {
			return;
		}

		event.preventDefault();
		start = textarea.selectionStart;
		end = textarea.selectionEnd;
		textarea.value = textarea.value.slice( 0, start ) + '\t' + textarea.value.slice( end );
		textarea.selectionStart = textarea.selectionEnd = start + 1;
		$( textarea ).trigger( 'input' );
	}

	$( function() {
		$( '.coursepress-code-editor' ).each( function() {
			var textarea = this;
			var language = $( textarea ).closest( '.coursepress-code-submission' ).data( 'language' );
			var editor;

			if ( ! window.wp || ! wp.codeEditor || ! wp.codeEditor.initialize ) {
				$( textarea ).on( 'keydown', indentAtCursor );
				return;
			}

			editor = wp.codeEditor.initialize( textarea, {
				codemirror: {
					indentUnit: 4,
					lineNumbers: true,
					lineWrapping: true,
					mode: modes[ language ] || 'text/plain',
					tabSize: 4
				}
			} );

			if ( editor.codemirror ) {
				editor.codemirror.on( 'change', function() {
					editor.codemirror.save();
					$( textarea ).trigger( 'input' );
				} );
			}
		} );
	} );
}( jQuery ) );
