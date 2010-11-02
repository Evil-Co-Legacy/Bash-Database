{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/packageInstallL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}bash.acp.serverAdd.title{/lang}</h2>
	</div>
</div>

{if $errorField != ''}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}bash.acp.serverAdd.success{/lang}</p>
{/if}

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?page=ServerList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}bash.acp.serverList.title{/lang}"><img src="{@RELATIVE_BASH_DIR}icon/serverM.png" alt="" /> <span>{lang}bash.acp.serverList.title{/lang}</span></a></li>
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>

<form method="post" action="index.php?form=ServerAdd">
	<div class="border content">
		<div class="container-1">
			<fieldset>
				<legend>{lang}bash.acp.serverAdd.information{/lang}</legend>
				
				<div class="formElement{if $errorField == 'serverName'} formError{/if}">
					<div class="formFieldLabel">
						<label for="serverName">{lang}bash.acp.serverAdd.serverName{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" name="serverName" id="serverName" value="{$serverName}" />
						{if $errorField == 'serverName'}
							<p class="innerError">
								{lang}wcf.global.error.empty{/lang}
							</p>
						{/if}
					</div>
				</div>
				
				<div class="formElement{if $errorField == 'serverPort'} formError{/if}">
					<div class="formFieldLabel">
						<label for="serverPort">{lang}bash.acp.serverAdd.serverPort{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" name="serverPort" id="serverPort" value="{$serverPort}" />
						{if $errorField == 'serverPort'}
							<p class="innerError">
								{lang}wcf.global.error.empty{/lang}
							</p>
						{/if}
					</div>
				</div>
				
				<div class="editorFrame formElement{if $errorField == 'serverDescription'} formError{/if}" id="textDiv">
					<div class="formFieldLabel">
						<label for="serverDescription">{lang}bash.acp.serverAdd.serverDescription{/lang}</label>
					</div>
								
					<div class="formField">				
						<textarea name="serverDescription" id="serverDescription" rows="15" cols="40" tabindex="{counter name='tabindex'}">{$serverDescription}</textarea>
						{if $errorField == 'serverDescription'}
							<p class="innerError">
								{lang}wcf.global.error.empty{/lang}
							</p>
						{/if}
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	
	<div class="formSubmit">
		<input type="submit" accesskey="s" name="submitButton" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
 		{@SID_INPUT_TAG}
	</div>
</form>

{include file='footer'}