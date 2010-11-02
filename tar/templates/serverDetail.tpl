{include file='documentHeader'}
	<head>
		<title>{lang}bash.page.serverDetail.title{/lang} - {PAGE_TITLE}</title>
		{include file='headInclude'}
	</head>
	<body id="{if $templateName|isset}tpl{$templateName|ucfirst}{/if}">
		{include file='header' sandbox=false}
		
		<div id="main">
		    <div class="mainHeadline">
				<img src="{icon}serverL.png{/icon}" alt="" />
				<div class="headlineContainer">
					<h2>{lang}bash.page.serverDetail.title{/lang}</h2>
				</div>
		    </div>
			
			{if $userMessages|isset}{@$userMessages}{/if}
			
			<div id="userCard" class="border">
				<div id="userCardInner" class="container-1">
					<div class="formElement">
						<div class="formFieldLabel">
							<p>{lang}bash.page.serverDetail.serverAddress{/lang}</p>
						</div>
						<div class="formField">
							<p><a href="irc://{$server->serverAddress}:{$server->port}/">{$server->serverAddress}:{$server->port}</a></p>
						</div>
					</div>
					{if $server->description != ''}
						<div class="formElement">
							<div class="formFieldLabel">
								<p>{lang}bash.page.serverDetail.description{/lang}</p>
							</div>
							<div class="formField">
								<p>{$server->getFormatedText()}</p>
							</div>
						</div>
					{/if}
				</div>
			</div>
			
			<div id="serverComments">
				<h3 class="subHeadline">{lang}bash.page.serverDetails.comments{/lang}</h3>
				<div class="contentHeader">
					<div class="largeButtons">
						{if $this->user->getPermission('user.comment.canAddComment') || $additionalLargeButtons|isset}
							<ul>
								{if $this->user->getPermission('user.comment.canAddComment')}<li><a href="index.php?form=ServerCommentAdd&amp;serverID={@$server->serverID}{@SID_ARG_2ND}" title="{lang}bash.comment.add{/lang}"><img src="{icon}addM.png{/icon}" alt="" /> <span>{lang}bash.comment.add{/lang}</span></a></li>{/if}
								{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
							</ul>
						{/if}
					</div>
				</div>
				<div id="commentList">
					{if $this->user->getPermission('mod.comment.moderatorPermissions')}{assign var=comments value=$server->getComments()}{else}{assign var=comments value=$server->getComments(true)}{/if}
					{assign var=sidebarFactory value=$server->getSidebarFacotry()}
					
					{assign var=startIndex value=1}
					
					{if $comments|count}
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
							
							{assign var="startIndex" value=$startIndex + 1}
						{/foreach}
					{else}
						<p class="info">{lang}bash.page.serverDetails.comments.noComments{/lang}</p>
					{/if}
				</div>
			</div>
			
			<div class="contentFooter">
				<div class="largeButtons">
					{if $this->user->getPermission('user.comment.canAddComment') || $additionalLargeButtons|isset}
						<ul>
							{if $this->user->getPermission('user.comment.canAddComment')}<li><a href="index.php?form=ServerCommentAdd&amp;serverID={@$server->serverID}{@SID_ARG_2ND}" title="{lang}bash.comment.add{/lang}"><img src="{icon}addM.png{/icon}" alt="" /> <span>{lang}bash.comment.add{/lang}</span></a></li>{/if}
							{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
						</ul>
					{/if}
				</div>
			</div>
		</div>
		{include file='footer' sandbox=false}
	</body>
</html>