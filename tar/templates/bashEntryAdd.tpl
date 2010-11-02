{include file="documentHeader"}
	<head>
		<title>{lang}bash.entry.add{/lang} - {lang}{PAGE_TITLE}{/lang}</title>

		{include file='headInclude' sandbox=false}
		<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/TabbedPane.class.js"></script>
		{if $canUseBBCodes}{include file="wysiwyg"}{/if}
		
		<script type="text/javascript">
			var serverNameIsHidden = false;
		
			function toggleServerName(element) {
				if (element.value == "0" && serverNameIsHidden) {
					Effect.BlindDown('serverNameContainer');
					serverNameIsHidden = false;
				} else if (element.value != "0" && !serverNameIsHidden) {
					Effect.BlindUp('serverNameContainer');
					serverNameIsHidden = true;
				}
			}
		</script>
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
		{include file='header' sandbox=false}

		<div id="main">
			<div class="mainHeadline">
				<img src="{icon}messageAddL.png{/icon}" alt="" />
				<div class="headlineContainer">
					<h2>{lang}bash.entry.add{/lang}</h2>
				</div>
			</div>
			
			{if $userMessages|isset}{@$userMessages}{/if}
			
			{if $errorField}
				<p class="error">{lang}wcf.global.form.error{/lang}</p>
			{/if}
			
			<form method="post" action="index.php?form=BashEntryAdd">
				<div class="border content">
					<div class="container-1">
						<fieldset>
							<legend>{lang}bash.page.bashEntryAdd.information{/lang}</legend>
								
							{if !$this->user->userID}
								<div class="formElement{if $errorField == 'username'} formError{/if}">
									<div class="formFieldLabel">
										<label for="username">{lang}wcf.user.username{/lang}</label>
									</div>
									<div class="formField">
										<input type="text" class="inputText" name="username" id="username" value="{$username}" tabindex="{counter name='tabindex'}" />
										{if $errorField == 'username'}
											<p class="innerError">
												{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
												{if $errorType == 'notValid'}{lang}wcf.user.error.username.notValid{/lang}{/if}
												{if $errorType == 'notAvailable'}{lang}wcf.user.error.username.notUnique{/lang}{/if}
											</p>
										{/if}
									</div>
								</div>
							{/if}
							
							<div class="formElement{if $errorField == 'serverID'} formError{/if}">
								<div class="formFieldLabel">
									<label for="serverID">{lang}bash.page.bashEntryAdd.serverID{/lang}</label>
								</div>
								<div class="formField">
									<select name="serverID" id="serverID" value="{$serverID}" onchange="toggleServerName(this);">
										<option value="0">{lang}bash.page.bashEntryAdd.serverID.own{/lang}</option>
										{foreach from=$serverList item=$server}
											<option value="{@$server->serverID}">{$server->serverAddress}</option>
										{/foreach}
									</select>
									{if $errorField == 'serverID'}
											<p class="innerError">
												{lang}bash.page.bashEntryAdd.serverIDUnknown{/lang}
											</p>
									{/if}
								</div>
							</div>
							
							<div class="formElement{if $errorField == 'serverName'} formError{/if}" id="serverNameContainer">
								<div class="formFieldLabel">
									<label for="serverName">{lang}bash.page.bashEntryAdd.serverName{/lang}</label>
								</div>
								<div class="formField">
									<input type="text" class="inputText" name="serverName" id="serverName" value="{$serverName}" tabindex="{counter name='tabindex'}" />
								</div>
								{if $errorField == 'serverID'}
									<p class="innerError">
										{lang}bash.page.bashEntryAdd.serverNameEmpty{/lang}
									</p>
								{/if}
							</div>
								
							{if $additionalInformationFields|isset}{@$additionalInformationFields}{/if}
						</fieldset>
						
						<fieldset>
							<legend>{lang}bash.page.bashEntryAdd.text{/lang}</legend>
							
							<div class="editorFrame formElement{if $errorField == 'text'} formError{/if}" id="textDiv">
			
								<div class="formFieldLabel">
									<label for="text">{lang}bash.page.bashEntryAdd.text{/lang}</label>
								</div>
								
								<div class="formField">				
									<textarea name="text" id="text" rows="15" cols="40" tabindex="{counter name='tabindex'}">{$text}</textarea>
									{if $errorField == 'text'}
										<p class="innerError">
											{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
											{if $errorType == 'tooLong'}{lang}wcf.message.error.tooLong{/lang}{/if}
											{if $errorType == 'censoredWordsFound'}{lang}wcf.message.error.censoredWordsFound{/lang}{/if}
										</p>
									{/if}
								</div>
								
							</div>
							
							{include file='messageFormTabs'}
							
						</fieldset>
						
						{include file='captcha'}
						{if $additionalFields|isset}{@$additionalFields}{/if}
					</div>
				</div>
		
				<div class="formSubmit">
					<input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" tabindex="{counter name='tabindex'}" />
					<input type="reset" name="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" tabindex="{counter name='tabindex'}" />
					{@SID_INPUT_TAG}
				</div>
			</form>
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>