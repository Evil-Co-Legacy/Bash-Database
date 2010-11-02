{assign var=isFavorite value=$entry->isFavorite()}

<div class="message{if $entry->isDisabled} disabled{/if}">
	<div class="messageInner message{if $this->getStyle()->getVariable('messages.framed')}Framed{/if}{@$this->getStyle()->getVariable('messages.sidebar.alignment')|ucfirst} container-{cycle name=entryCycle}">
		<a id="entry{@$entry->entryID}"></a>

		{include file='messageSidebar'}

		<div class="messageContent">
			<div class="messageContentInner color-{cycle name=messageCycle}">
				<div class="messageHeader">
					<p class="messageCount">
						<a href="index.php?page=BashEntry&entryID={@$entry->entryID}" title="{lang}bash.global.permalink{/lang}" class="messageNumber">{#$entry->entryID}</a>
					</p>

					<div class="containerIcon">
						<img src="{icon}{if !$isFavorite}index{else}favorites{/if}M.png{/icon}" alt="" title="{lang}bash.entry.{if $isFavorite}favoriteE{else}e{/if}ntry{/lang}" />
					</div>
					
					<div class="containerContent">
						<p class="smallFont light">{lang}bash.page.random.messageHeader{/lang}</p>
					</div>
				</div>
				
				<div class="messageBody">
					<div id="entryText{@$entry->entryID}">
						{@$entry->getFormatedText()}
					</div>
				</div>
				
				<div class="messageFooter">
					<div class="smallButtons">
						<ul>
							<li class="extraButton"><a href="#top" title="{lang}wcf.global.scrollUp{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/upS.png" alt="{lang}wcf.global.scrollUp{/lang}" /></a></li>
							{if $this->user->userID > 0}<li><a id="favorite{@$entry->entryID}" href="index.php?action=Favorite{if !$isFavorite}Add{else}Remove{/if}&amp;entryID={@$entry->entryID}{@SID_ARG_2ND}" title="{lang}bash.entry.{if $isFavorite}un{/if}favorite{/lang}"><img src="{icon}deleteS.png{/icon}" alt="" /> <span>{lang}bash.entry.{if $isFavorite}un{/if}favorite{/lang}</span></a></li>{/if}
							{if $this->user->userID > 0 && $this->user->getPermission('mod.bash.moderatorPermissions')}<li><a id="toggle{@$entry->entryID}" href="index.php?action=BashEntry{if $entry->isDisabled}Enable{else}Disable{/if}&amp;entryID={@$entry->entryID}{@SID_ARG_2ND}" title="{lang}bash.entry.toggle.{if $entry->isDisabled}enable{else}disable{/if}{/lang}"><img src="{icon}{if $entry->isDisabled}disabled{else}enabled{/if}S.png{/icon}" alt="" /> <span>{lang}bash.entry.toggle.{if $entry->isDisabled}enable{else}disable{/if}{/lang}</span></a></li>{/if}
							{if $this->user->userID > 0 && $this->user->userID == $entry->authorID || $this->user->userID > 0 && $this->user->getPermission('mod.bash.moderatorPermissions')}<li><a id="delete{@$entry->entryID}" href="index.php?action=BashEntryDelete&amp;entryID={@$entry->entryID}{@SID_ARG_2ND}" title="{lang}bash.entry.delete{/lang}"><img src="{icon}deleteS.png{/icon}" alt="" /> <span>{lang}bash.entry.delete{/lang}</span></a></li>{/if}
							{if $this->user->userID > 0 && !$entry->hasVoted() && $this->user->userID != $entry->authorID}<li><a id="vote{@$entry->entryID}Positive" onclick="bashEntryVotePositive('{$entry->entryID}'); return false" href="index.php?action=BashEntryVotePositive&amp;entryID={@$entry->entryID}{@SID_ARG_2ND}" title="{lang}bash.entry.vote.positive{/lang}"><img src="{icon}addS.png{/icon}" alt="" /></a></li>{/if}
							{if $this->user->userID > 0 && !$entry->hasVoted() && $this->user->userID != $entry->authorID}<li><a id="vote{@$entry->entryID}Negative" onclick="bashEntryVoteNegative('{$entry->entryID}'); return false" href="index.php?action=BashEntryVoteNegative&amp;entryID={@$entry->entryID}{@SID_ARG_2ND}" title="{lang}bash.entry.vote.negative{/lang}"><img src="{icon}removeS.png{/icon}" alt="" /></a></li>{/if}
							{if $entry->additionalButtons|isset}{@$entry->additionalButtons}{/if}
						</ul>
					</div>
				</div>
				<hr />	
			</div>
		</div>
	</div>
</div>