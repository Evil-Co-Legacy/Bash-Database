{include file='documentHeader'}
	<head>
		<title>{lang}bash.page.random.title{/lang} - {PAGE_TITLE}</title>
		
		{include file='headInclude'}
	</head>
	<body id="{if $templateName|isset}tpl{$templateName|ucfirst}{/if}">
		{include file='header' sandbox=false}
		
		<div id="main">
		    <div class="mainHeadline">
				<img src="{icon}randomL.png{/icon}" alt="" />
				<div class="headlineContainer">
					<h2>{lang}bash.page.random.title{/lang}</h2>
				</div>
		    </div>
			
			{if $userMessages|isset}{@$userMessages}{/if}
		    
		    <div class="contentHeader">
		    	{assign var=multiplePagesLink value="index.php?page=Random&pageNo=%d"}
		    	{pages print=true assign=pagesOutput link=$multiplePagesLink|concat:SID_ARG_2ND_NOT_ENCODED}
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
		    
		    	<div class="randomBashEntryList">
			    	{foreach from=$entries item=entry}
			    		{assign var="sidebar" value=$sidebarFactory->get('bashEntry', $entry->entryID)}
			    	
			    		{include file='bashEntry'}
			    	{/foreach}
			    </div>
			{else}
			    <p class="info">
					{lang}bash.page.random.noEntries{/lang}
			    </p>
			{/if}
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>