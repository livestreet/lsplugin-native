{include file='editor.tpl' sImgToLoad='form_comment_text' sSettingsTinymce='ls.settings.getTinymceComment()' sSettingsMarkitup='ls.settings.getMarkitupComment()'}

<h4 class="reply-header" id="comment_id_0">
    <a href="#" class="link-dotted" onclick="ls.comments.toggleCommentForm(0); return false;">{$aLang.topic_comment_add}</a>
</h4>

<div id="reply" class="reply">
    <form method="post" id="form_comment" onsubmit="return false;" enctype="multipart/form-data">
		{hook run='form_add_comment_begin'}

        <textarea name="comment_text" id="form_comment_text" class="mce-editor markitup-editor input-width-full"></textarea>

		{hook run='form_add_comment_end'}

        <button type="submit"  name="submit_comment"
                id="comment-button-submit"
                onclick="ls.plugin.native.addComment('form_comment',{$iTargetId},'{$sTargetType}'); return false;"
                class="button button-primary">{$aLang.comment_add}</button>
        <button type="button" onclick="ls.comments.preview();" class="button">{$aLang.comment_preview}</button>

        <input type="hidden" name="reply" value="0" id="form_comment_reply" />
        <input type="hidden" name="cmt_target_id" value="{$iTargetId}" />
    </form>
</div>