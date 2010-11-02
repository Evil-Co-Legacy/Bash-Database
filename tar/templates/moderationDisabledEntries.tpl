{include file="documentHeader"}
	<head>
		<title>{lang}bash.moderation.disabledEntries.title{/lang} - {lang}wcf.user.usercp{/lang} - {lang}{PAGE_TITLE}{/lang}</title>
		
		{include file='headInclude' sandbox=false}
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>

		{include file='header' sandbox=false}

		<div id="main">
			
			{include file="userCPHeader"}
			
			<div class="border tabMenuContent">
				<div class="container-1">
					<h3 class="subHeadline">{lang}bash.moderation.disabledEntries.title{/lang}</h3>
					
					{if $entries|count}
						<div class="contentHeader">
							{assign var=multiplePagesLink value="index.php?page=ModerationDisabledEntries&pageNo=%d"}
							{pages print=true assign=pagesOutput link=$multiplePagesLink|concat:SID_ARG_2ND_NOT_ENCODED}
						</div>
					
					
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
					
						{foreach from=$entries item=$entry}
							{assign var="sidebar" value=$sidebarFactory->get('bashEntry', $entry->entryID)}
							
							{include file='bashEntry'}
						{/foreach}
					{else}
						<p class="info">{lang}bash.moderation.disabledEntries.noEntries{/lang}</p>
					{/if}
				</div>
			</div>
			
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>