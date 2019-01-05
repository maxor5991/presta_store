<link href="{$css|escape:'htmlall':'UTF-8'}pagoefectivo.css" rel="stylesheet" type="text/css">
<div class="ctwrapper">
	<div class="container_pe">
		<form action="{$formCIP|escape:'htmlall':'UTF-8'}" method="POST">
			{foreach from=$tab item=div}
				<div id="{$div.tab|escape:'htmlall':'UTF-8'}" class="{$div.style}">
					{$div.content}
				</div>
			{/foreach}
		</form>
		<div class="clear"></div>
	</div>
</div>