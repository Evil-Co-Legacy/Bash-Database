{include file="documentHeader"}
	<head>
		<title>{lang}bash.moderation.disabledComments.title{/lang} - {lang}wcf.user.usercp{/lang} - {lang}{PAGE_TITLE}{/lang}</title>
		
		{include file='headInclude' sandbox=false}
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>

		{include file='header' sandbox=false}

		<div id="main">
			
			{include file="userCPHeader"}
			
			<div class="border tabMenuContent">
				<div class="container-1">
					<h3 class="subHeadline">{lang}bash.moderation.disabledComments.title{/lang}</h3>
					
					{if $comments|count}
						<div class="contentHeader">
							{assign var=multiplePagesLink value="index.php?page=ModerationDisabledComments&pageNo=%d"}
							{pages print=true assign=pagesOutput link=$multiplePagesLink|concat:SID_ARG_2ND_NOT_ENCODED}
						</div>
					
					
						{if $this->getStyle()->getVariable('messages.color.cycle')}
							{cycle name=messageCycle values='2,1' print=false}
						{else}
							{cycle name=messageCycle values='1' print=false}
						{/if}
							
						{if $this->getStyle()->getVariable('messages.sidebar.color.cycle')}
							{if $this->getStyle()->getVariable('messages.color.cycle')}
								{cycle name=commentCycle values='1,2' print=false}
							{else}
								{cycle name=commentCycle values='3,2' print=false}
							{/if}
						{else}
							{cycle name=commentCycle values='3' print=false}
						{/if}
					
						{foreach from=$comments item=$comment}
							{assign var="sidebar" value=$sidebarFactory->get('serverComment', $comment->commentID)}
							
							{include file='serverComment'}
						{/foreach}
					{else}
						<p class="info">{lang}bash.moderation.disabledComments.noComments{/lang}</p>
					{/if}
				</div>
			</div>
			
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>