<?php $this->view('shared/header', _('Edit Quantity')); ?>
<?php $this->view('shared/navigation/nav'); ?>

<div class='common-container' align='center'>
	<p class="sign" align="center"><?=_('Edit Product Quantity')?></p>
	
	<?php 
		if ($_SESSION['user_type']=="admin") {
			echo "<form action='/Product/editQuantity/$data->pq_id' method='post' enctype='multipart/form-data'>";
		}
		if ($_SESSION['user_type']=="employee") {
			echo "<form action='/Product/quantityUpdate/$data->pq_id' method='post' enctype='multipart/form-data'>";
		}
	?>	

		<div class="grid-50" align="center">
			<label><?=_('Produced Date')?></label>
			<input class="input-qty" type="date" required autocomplete="off" name="produced_date" value="<?= $data->produced_date ?>"<?php if ($_SESSION['user_type']=="employee") {echo "style='border:3px solid red;' readonly";}?>>

			<label><?=_('Expired Date')?></label>
			<input class="input-qty" type="date" required autocomplete="off" name="expired_date" value="<?= $data->expired_date ?>" <?php if ($_SESSION['user_type']=="employee") {echo "style='border:3px solid red;' readonly";}?>>

			<label><?=_('Quantity')?></label>
			<input class="input-qty" type="number" min="0" step="1" id="totalAmt" name="quantity" value="<?= $data->quantity ?>"<?php if ($_SESSION['user_type']=="employee") {echo "";}?>>

			<label><?=_('Price')?></label>
			<input class="input-qty" type="number" min="0" step="0.01" id="totalAmt" name="price" value="<?= $data->price ?>" <?php if ($_SESSION['user_type']=="employee") {echo "style='border:3px solid red;' readonly";}?>>

			<input class="submit-inv" type="submit" align="" value="<?=_('Edit Quantity')?>" name="action">

			<a class="btn-general" href="/Product/productDetails/<?=$data->product_id?>" role="button"><?= _('Back') ?></a>
		</div>
	</form>

</div>

<?php $this->view('shared/footer'); ?>