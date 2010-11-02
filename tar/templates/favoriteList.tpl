{include file="documentHeader"}
	<head>
		<title>{lang}bash.page.favoriteList.title{/lang} {if $pageNo > 1}- {lang}wcf.page.pageNo{/lang} {/if}- {lang}wcf.user.usercp{/lang} - {PAGE_TITLE}</title>
		
		{include file='headInclude' sandbox=false}
		
		{if $entries|count > 0}
			<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/MultiPagesLinks.class.js"></script>
		{/if}
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
		{include file='header' sandbox=false}

		<div id="main">
			
			{include file="userCPHeader"}
			
			<div class="border tabMenuContent">
				<div class="container-1">
					<h3 class="subHeadline">{lang}bash.page.favoriteList.title{/lang}</h3>
					
					{if $entries|count > 0}
						<div class="contentHeader">
							{pages assign=pagesOutput link="index.php?page=FavoriteList&pageNo=%d"|concat:SID_ARG_2ND_NOT_ENCODED}
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
					{else}
						<p class="info">{lang}bash.page.favoriteList.noFavorites{/lang}</p>
					{/if}
				</div>
			</div>
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>