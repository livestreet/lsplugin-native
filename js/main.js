var ls = ls || {};
ls.plugin = ls.plugin || {};


ls.plugin.native = (function ($) {

	this.options = {

	};

	this.init = function() {
		if (ls.registry.get('user_is_authorization')) {
			return false;
		}
		ls.comments.toggleCommentForm(0);

		$.each($('ul.comment-info'),function(k,v){
			var id=$(v).parent().attr('id').replace('comment_id_','');
			$(v).append(
				'<li><a href="#" onclick="ls.comments.toggleCommentForm('+id+'); return false;" class="reply-link link-dotted">'+ls.lang.get('comment_answer')+'</a></li>'
			);
		});

		ls.hook.inject([ls.vote,'vote'], 'if (!ls.plugin.native.checkVote()) { return false; }','voteBefore');
	};

	this.checkVote = function() {
		if (ls.registry.get('user_is_authorization')) {
			return true;
		}
		$('.js-registration-form-show').trigger('click');
		return false;
	};

	this.addComment = function(formObj, targetId, targetType) {
		if (this.options.wysiwyg) {
			$('#'+formObj+' textarea').val(tinyMCE.activeEditor.getContent());
		}
		formObj = $('#'+formObj);

		var url = aRouter['ajax']+'native/request/save/';
		var params = formObj.serializeJSON();
		//params.sRequestSavePath=document.location.href;
		params.sRequestSavePath=aRouter['blog']+'addcomment/';
		params.submit_comment=1;
		ls.hook.marker('addCommentBefore');
		ls.ajax(url, params, function(result) {
			if (result.bStateError) {
				ls.msg.error(null, result.sMsg);
			} else {
				ls.hook.run('ls_plugin_native_add_comment_after',[formObj, targetId, targetType, result],null);
				if (ls.registry.get('plugin.native.add_comment_show_popup')) {
					$('.js-registration-form-show').trigger('click');
				} else {
					document.location.href=aRouter['registration'];
				}
			}
		});
	};

	jQuery(document).ready(function($){
		this.init();
	}.bind(this));

	return this;
}).call(ls.plugin.native || {},jQuery);