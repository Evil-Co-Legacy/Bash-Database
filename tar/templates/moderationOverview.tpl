{include file="documentHeader"}
	<head>
		<title>{lang}bash.moderation.overview.title{/lang} - {lang}wcf.user.usercp{/lang} - {lang}{PAGE_TITLE}{/lang}</title>
		
		{include file='headInclude' sandbox=false}
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>

		{include file='header' sandbox=false}

		<div id="main">
			
			{include file="userCPHeader"}
			
			<div class="border tabMenuContent">
				<div class="container-1">
					<h3 class="subHeadline">{lang}bash.moderation.overview.title{/lang}</h3>
					
					<ul class="moderationOverview">
						{if $this->user->getPermission('mod.bash.moderatorPermissions')}
							<li>
								<img src="{icon}indexL.png{/icon}" alt="" />				
								<ul>
									{if $this->user->getPermission('mod.bash.moderatorPermissions')}<li><a href="index.php?page=ModerationDisabledEntries{@SID_ARG_2ND}">{lang}bash.moderation.disabledEntries.count{/lang}</a></li>{/if}
								</ul>
							</li>
						{/if}
						
						{if $this->user->getPermission('mod.comment.moderatorPermissions')}
							<li>
								<img src="{icon}messageL.png{/icon}" alt="" />
								<ul>
									{if $this->user->getPermission('mod.comment.moderatorPermissions')}<li><a href="index.php?page=ModerationDisabledComments{@SID_ARG_2ND}">{lang}bash.moderation.disabledComments.count{/lang}</a></li>{/if}
								</ul>
							</li>
						{/if}
					</ul>
				</div>
			</div>
			
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>