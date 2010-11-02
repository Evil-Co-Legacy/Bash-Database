{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_BASH_DIR}icon/serverL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}bash.acp.serverList.title{/lang}</h2>
	</div>
</div>

<div class="contentHeader">
	{if $this->user->getPermission('admin.bash.canAddServers') || $additionalLargeButtons|isset}
		<div class="largeButtons">
			<ul>
				{if $this->user->getPermission('admin.bash.canAddServers')}<li><a href="index.php?form=ServerAdd&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}bash.acp.serverList.add{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/packageInstallM.png" alt="" /> <span>{lang}bash.acp.serverList.add{/lang}</span></a></li>{/if}
				{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
			</ul>
		</div>
	{/if}
</div>

{if $serverList|count > 0}
	{foreach from=$serverList item=$server}
		<div class="message content styleList">
			<div class="messageInner container-{cycle name='styles' values='1,2'}">
				
				<h3 class="subHeadline">
					{$server->serverAddress}:{$server->port}
				</h3>

				<div class="messageBody">
					{@$server->getFormatedText()}
				</div>
				
				<div class="messageFooter">
					<div class="smallButtons">
						<ul>
							<li class="extraButton"><a href="#top" title="{lang}wcf.global.scrollUp{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/upS.png" alt="{lang}wcf.global.scrollUp{/lang}" /></a></li>
							{if $this->user->getPermission('admin.bash.canDeleteServers')}
								<li><a href="index.php?action=ServerDelete&amp;serverID={@$server->serverID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}bash.acp.serverList.delete{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" /> <span>{lang}bash.acp.serverList.delete{/lang}</span></a></li>
							{/if}
						</ul>
					</div>
				</div>
				<hr />
			</div>
		</div>
	{/foreach}
{else}
	<p class="info">{lang}bash.acp.serverList.noEntries{/lang}</p>
{/if}

<div class="contentFooter">
	{if $this->user->getPermission('admin.bash.canAddServers') || $additionalLargeButtons|isset}
		<div class="largeButtons">
			<ul>
				{if $this->user->getPermission('admin.bash.canAddServers')}<li><a href="index.php?form=ServerAdd&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}bash.acp.serverList.add{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/packageInstallM.png" alt="" /> <span>{lang}bash.acp.serverList.add{/lang}</span></a></li>{/if}
				{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
			</ul>
		</div>
	{/if}
</div>