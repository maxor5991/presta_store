<div class="pagoefectivo">
	<div class="pagoefectivo-estado">
		<div class="pe-header">
			<h2>Actualizar fecha de expiración del CIP</h2>
		</div>
		<div class="pe-content">
			<input type="hidden" name="submitCIP" value="1" />
			{foreach from=$fechaInputVar item=input}
				{if $input.type == 'text'}
					<ul>
						<p>{$input.label|escape:'htmlall':'UTF-8'}</p>
						<li><input class="full input_pe" type="{$input.type|escape:'htmlall':'UTF-8'}" id="{$input.name|escape:'htmlall':'UTF-8'}" name="{$input.name|escape:'htmlall':'UTF-8'}" value="{$input.value|escape:'htmlall':'UTF-8'}"/>
						</li>
						<p class="nota">{$input.desc}</p>
					</ul>
				{/if}
			{/foreach}

				<ul class="fecha">
		            <li>
		            	<p>Nueva fecha de expiración</p>
		            	<div class="input-group">
			            	<input type="text" name="CfechaCIP" id="CfechaCIP" class="datepickerCIP"/>
			            	<div class="input-group-addon">
								<i class="icon-calendar-o"></i>
							</div>
						</div>
		            </li>
		            <p class="nota">
		        		Se puede Ingresar el valor de un CIP o más separados por comas (máximo 10 CIPs). Ej: 1724393, 1723897 o 1724393 y <br />Colocar la fecha de expiraci&oacute;n mayor a la fecha que se le asigno al inicio al CIP al generarlo.
		        	</p><br />
	        	</ul>
	        	<ul>
					<li><input type="submit" name="submit" class="pe-button" value="Fecha" /></li>
				</ul>
			{if $mensaje_actualizarfecha}
				<div class="mensaje">
					{$mensaje_actualizarfecha}
				</div>
			{/if}

		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.datepickerCIP').datetimepicker({
			prevText: '',
			nextText: '',
			dateFormat: 'dd/mm/yy',
			// Define a custom regional settings in order to use PrestaShop translation tools
			currentText: 'Ahora',
			closeText: 'Finalizar',
			ampm: false,
			amNames: ['AM', 'A'],
			pmNames: ['PM', 'P'],
			timeFormat: 'hh:mm:ss tt',
			timeSuffix: '',
			timeOnlyTitle: 'Seleccionar tiempo',
			timeText: 'Tiempo',
			hourText: 'Hora',
			minuteText: 'Minutos'
		});
	});
</script>
