<script type="text/javascript">
	{if $oUserCurrent}
    	ls.registry.set('user_is_authorization',{json var=true});
	{else}
    	ls.registry.set('user_is_authorization',{json var=false});
	{/if}

    ls.lang.load({lang_load name="comment_answer"});
    ls.registry.set('plugin.native.add_comment_show_popup',{json var=$oConfig->Get('plugin.native.add_comment_show_popup')});
</script>
