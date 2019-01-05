<div class="pagoefectivo">
	<div class="pagoefectivo-estado">
		<div class="pe-header">
			<h2>Actualizar estado del CIP</h2>
		</div>
		<div class="pe-content">
			<input type="hidden" name="submitCIP" value="1" />
			{foreach from=$estadoInputVar item=input}
				{if $input.type == 'text'}
					<ul>
						<p>{$input.label|escape:'htmlall':'UTF-8'}</p>
						<li><input class="full input_pe" type="{$input.type|escape:'htmlall':'UTF-8'}" id="{$input.name|escape:'htmlall':'UTF-8'}" name="{$input.name|escape:'htmlall':'UTF-8'}" value="{$input.value|escape:'htmlall':'UTF-8'}"/></li>
						<p class="nota">{$input.desc}</p>
					</ul>
				{/if}
				<ul>
					<li><input type="submit" name="submit" class="pe-button" value="Estado" /></li>
				</ul>
			{/foreach}

			{if $mensaje_actualizarestado}
				<div class="mensaje">
					{$mensaje_actualizarestado}
				</div>
			{/if}

		</div>
	</div>
</div>
