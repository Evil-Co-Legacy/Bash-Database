<div class="message{if $comment->isDisabled} disabled{/if}">
	<div class="messageInner message{if $this->getStyle()->getVariable('messages.framed')}Framed{/if}{@$this->getStyle()->getVariable('messages.sidebar.alignment')|ucfirst} container-{cycle name=commentCycle}">
		<a id="comment{@$comment->commentID}"></a>

		{include file='messageSidebar'}

		<div class="messageContent">
			<div class="messageContentInner color-{cycle name=messageCycle}">
				<div class="messageHeader">
					<p class="messageCount">
						<a href="index.php?page=ServerDetail&serverID={@$comment->serverID}#comment{@$comment->commentID}" title="{lang}bash.global.permalink.comment{/lang}" class="messageNumber">{if $startIndex|isset}{#$startIndex}{else}{#$comment->commentID}{/if}</a>
					</p>

					<div class="containerIcon">
						<img src="{icon}indexM.png{/icon}" alt="" title="{lang}bash.comment.comment{/lang}" />
					</div>
					
					<div class="containerContent">
						<p class="smallFont light">{lang}bash.page.serverDetail.messageHeader{/lang}</p>
					</div>
				</div>
				
				<div class="messageBody">
					<div id="commentText{@$comment->commentID}">
						{@$comment->getFormatedText()}
					</div>
				</div>
				
				<div class="messageFooter">
					<div class="smallButtons">
						<ul>
							<li class="extraButton"><a href="#top" title="{lang}wcf.global.scrollUp{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/upS.png" alt="{lang}wcf.global.scrollUp{/lang}" /></a></li>
							{if $this->user->userID > 0 && $this->user->getPermission('mod.comment.moderatorPermissions')}<li><a id="toggle{@$comment->commentID}" href="index.php?action=ServerComment{if $comment->isDisabled}Enable{else}Disable{/if}&amp;commentID={@$comment->commentID}{@SID_ARG_2ND}" title="{lang}bash.comment.toggle.{if $comment->isDisabled}enable{else}disable{/if}{/lang}"><img src="{icon}{if $comment->isDisabled}disabled{else}enabled{/if}S.png{/icon}" alt="" /> <span>{lang}bash.comment.toggle.{if $comment->isDisabled}enable{else}disable{/if}{/lang}</span></a></li>{/if}
							{if $this->user->userID > 0 && $this->user->userID == $comment->authorID || $this->user->userID > 0 && $this->user->getPermission('mod.comment.moderatorPermissions')}<li><a id="delete{@$comment->commentID}" href="index.php?action=ServerCommentDelete&amp;commentID={@$comment->commentID}{@SID_ARG_2ND}" title="{lang}bash.comment.delete{/lang}"><img src="{icon}deleteS.png{/icon}" alt="" /> <span>{lang}bash.comment.delete{/lang}</span></a></li>{/if}
							{if $comment->additionalButtons|isset}{@$comment->additionalButtons}{/if}
						</ul>
					</div>
				</div>
				<hr />	
			</div>
		</div>
	</div>
</div>