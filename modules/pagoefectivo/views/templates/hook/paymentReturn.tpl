<p class="alert alert-success">Su pedido está completo.</p>

<div class="box order-confirmation">

	<h3 class="page-subheading">Tu pedido con PagoEfectivo esta completo</h3>
	<!--Iframe Pagoefectivo-->
	<center class="pe-iframe"><iframe src="{$server}GenPagoIF.aspx?Token={$token}" width="100%" height="1209px" style="border:1px solid #000000; margin-bottom:40px; margin-top:40px;"></iframe></center>
	<!--Iframe Pagoefectivo-->

	<h3 class="page-subheading">Detalles</h3>

    <p>
        - {l s='Importe del pago' mod='pagoefectivo'} <span class="price"><strong>{$total_to_pay}</strong></span><br>
    </p>

    <p>
    {if !isset($reference)}
	    {l s='- Número de orden #%d.' sprintf=$id_order mod='pagoefectivo'}
    {else}
	    {l s='- Número de orden de referencia %s.' sprintf=$reference mod='pagoefectivo'}
    {/if}
	</p>

	<p><strong>{l s='Le enviaremos su pedido en cuanto recibamos el pago.' mod='pagoefectivo'}</strong></p>

	<p>{l s='Para cualquier duda, por favor contacte con nosotros' mod='pagoefectivo'} <a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='atención al cliente.' mod='pagoefectivo'}</a></p>

</div>