{include file="documentHeader"}
	<head>
		<title>{lang}wcf.user.profile.title{/lang} - {lang}wcf.user.profile.members{/lang} - {lang}{PAGE_TITLE}{/lang}</title>
		{include file='headInclude' sandbox=false}
		<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/MultiPagesLinks.class.js"></script>	
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
		{include file='header' sandbox=false}

		<div id="main">
			{include file="userProfileHeader"}
		
			<div class="border {if $this|method_exists:'getUserProfileMenu' && $this->getUserProfileMenu()->getMenuItems('')|count > 1}tabMenuContent{else}content{/if}">
				<div class="container-1 gallery">
					{if $entries|count > 0}
						<div class="userProfileBox">
							<div class="userProfileBoxInner">
								<h3 class="subHeadline">{lang}bash.user.favorites.title{/lang} <span>({#$items})</span></h3>
					
								<div class="contentHeader">
									{pages print=true assign=pagesOutput link="index.php?page=UserFavorites&userID=$userID&pageNo=%d"|concat:SID_ARG_2ND_NOT_ENCODED}								
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
								
								<div class="contentFooter">
									{@$pagesOutput}
								</div>
							</div>
						</div>
					{else}
						<div class="userProfileBox">
							<div class="userProfileBoxInner">
								<h3 class="subHeadline">{lang}bash.user.favorites.title{/lang}</h3>
									{lang}bash.user.favorites.noEntries{/lang}
							</div>
						</div>
					{/if}					
				</div>
			</div>
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>