{include file='documentHeader'}
	<head>
		<title>{lang}bash.page.index.title{/lang} - {PAGE_TITLE}</title>
		{include file='headInclude'}
		{if $this->user->getPermission('mod.bash.canEditNewsEntries')}
			<script type="text/javascript">
				function createNewsInlineEditor(entryID) {
					new Ajax.InPlaceEditor('entryText'+entryID, 'index.php?action=AjaxEditNewsEntry&entryID='+entryID);
					new Ajax.InPlaceEditor('newsTopic'+entryID, 'index.php?action=AjaxEditNewsEntry&entryID='+entryID+'&type=subject');
				}
			</script>
		{/if}
	</head>
	<body id="{if $templateName|isset}tpl{$templateName|ucfirst}{/if}">
		{include file='header' sandbox=false}
		
		<div id="main">
		    <div class="mainHeadline">
				<img src="{icon}indexL.png{/icon}" alt="" />
				<div class="headlineContainer">
					<h2>{lang}bash.page.index.title{/lang}</h2>
				</div>
		    </div>
		    
		    {if $userMessages|isset}{@$userMessages}{/if}
		    
		    <div class="contentHeader">
		    	{assign var=multiplePagesLink value="index.php?page=Index&pageNo=%d"}
		    	{pages print=true assign=pagesOutput link=$multiplePagesLink|concat:SID_ARG_2ND_NOT_ENCODED}
		    	
		    	{if $this->user->getPermission('mod.bash.canAddNewsEntries') || $additionalLargeButtons|isset}
			    	<div class="largeButtons">
						{if $this->user->getPermission('user.comment.canAddComment') || $additionalLargeButtons|isset}
							<ul>
								{if $this->user->getPermission('mod.bash.canAddNewsEntries')}<li><a href="index.php?form=NewsAdd{@SID_ARG_2ND}" title="{lang}bash.page.index.add{/lang}"><img src="{icon}messageAddM.png{/icon}" alt="" /> <span>{lang}bash.page.index.add{/lang}</span></a></li>{/if}
								{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
							</ul>
						{/if}
					</div>
				{/if}
		    </div>
		    
		    {if $entries|count > 0}
		    	{if $this->getStyle()->getVariable('messages.color.cycle')}
					{cycle name=messageCycle values='2,1' print=false}
				{else}
					{cycle name=messageCycle values='1' print=false}
				{/if}
		    
		    	{if $this->getStyle()->getVariable('messages.sidebar.color.cycle')}
					{if $this->getStyle()->getVariable('messages.color.cycle')}
						{cycle name=entryCycle values='1,2' print=false}
					{else}
						{cycle name=entryCycle values='3,2' print=false}
					{/if}
				{else}
					{cycle name=entryCycle values='3' print=false}
				{/if}
		    
		    	{assign var=startIndex value=1}
		    
		    	<div class="newsList">
			    	{foreach from=$entries item=entry}
			    		{assign var="sidebar" value=$sidebarFactory->get('newsEntry', $entry->entryID)}
			    	
			    		<div class="message">
						    <div class="messageInner message{if $this->getStyle()->getVariable('messages.framed')}Framed{/if}{@$this->getStyle()->getVariable('messages.sidebar.alignment')|ucfirst} container-{cycle name=entryCycle}">
						    	<a id="entry{@$entry->entryID}"></a>
						    
						    	{include file='messageSidebar'}
						    
								<div class="messageContent">
									<div class="messageContentInner color-{cycle name=messageCycle}">
										<div class="messageHeader">
											<p class="messageCount">
												<a href="index.php?page=Index#entry{@$entry->entryID}" title="{lang}bash.global.permalink{/lang}" class="messageNumber">{#$startIndex}</a>
											</p>
											
											<div class="containerIcon">
												<img src="{icon}messageM.png{/icon}" alt="" />
											</div>
										
											<div class="containerContent">
												<p class="smallFont light">{@$entry->timestamp|time}</p>
											</div>
										</div>
											
										<h3 id="newsTopic{@$entry->entryID}" class="messageTitle">{$entry->subject}</h3>
							
										<div class="messageBody">
											<div id="entryText{@$entry->entryID}">
												{@$entry->getFormatedText()}
											</div>
										</div>
							
										<div class="messageFooter">
											<div class="smallButtons">
												<ul>
													<li class="extraButton"><a href="#top" title="{lang}wcf.global.scrollUp{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/upS.png" alt="{lang}wcf.global.scrollUp{/lang}" /></a></li>
													{if $this->user->userID > 0 && $this->user->getPermission('mod.bash.canEditNewsEntries')}<li><a id="edit{@$entry->entryID}" href="index.php?form=NewsEdit&amp;entryID={@$entry->entryID}{@SID_ARG_2ND}" title="{lang}bash.page.index.editNewsEntry{/lang}"><img src="{icon}editS.png{/icon}" alt="" /> <span>{lang}bash.page.index.editNewsEntry{/lang}</span></a></li>{/if}
													{if $this->user->userID > 0 && $this->user->getPermission('mod.bash.canDeleteNewsEntries')}<li><a id="delete{@$entry->entryID}" href="index.php?action=NewsDelete&amp;entryID={@$entry->entryID}{@SID_ARG_2ND}" title="{lang}bash.page.index.delete{/lang}"><img src="{icon}deleteS.png{/icon}" alt="" /> <span>{lang}bash.page.index.delete{/lang}</span></a></li>{/if}
													{if $entry->additionalButtons|isset}{@$entry->additionalButtons}{/if}
												</ul>
											</div>
										</div>
										<hr />	
									</div>
								</div>
						    </div>
					    </div>
						
						{if $this->user->getPermission('mod.bash.canEditNewsEntries')}
							<script type="text/javascript">
								createNewsInlineEditor('{$entry->entryID}');
							</script>
					    {/if}
						
					    {assign var="startIndex" value=$startIndex + 1}
			    	{/foreach}
			    </div>
			{else}
			    <p class="info">
					{lang}bash.page.index.noEntries{/lang}
			    </p>
			{/if}
			
			<div class="contentFooter">
				{if $this->user->getPermission('mod.bash.canAddNewsEntries') || $additionalLargeButtons|isset}
			    	<div class="largeButtons">
						{if $this->user->getPermission('user.comment.canAddComment') || $additionalLargeButtons|isset}
							<ul>
								{if $this->user->getPermission('mod.bash.canAddNewsEntries')}<li><a href="index.php?form=NewsAdd{@SID_ARG_2ND}" title="{lang}bash.page.index.add{/lang}"><img src="{icon}messageAddM.png{/icon}" alt="" /> <span>{lang}bash.page.index.add{/lang}</span></a></li>{/if}
								{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
							</ul>
						{/if}
					</div>
				{/if}
			</div>
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>