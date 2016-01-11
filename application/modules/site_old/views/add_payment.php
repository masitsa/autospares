    	<div class="payment_form grey-background">
        <h3>Payment Section</h3>
    	<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Success!</strong> You have successfully added a part. Please follow the instructions to activate your item.
        </div>
    	<?php
		$attributes = array('role' => 'form', 'class' => 'form-horizontal add_product');

		echo form_open_multipart(site_url()."site/validate_payment/", $attributes);
		?>
		
		<div class='row'>
			<div class="col-md-12">
				<fieldset>
					<legend>Instructions</legend>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">Go to your MPesa menu</li>
                            <li class="list-group-item">Send an amount of KES <strong>50</strong> to <strong>0726 200 331</strong></li>
                            <li class="list-group-item">After sending the amount you will be receive a confirmation message that the amount was sent to Autospares Ltd.</li>
                            <li class="list-group-item">Enter your transaction number in the field below</li>
                            <li class="list-group-item">Click the button to activate your item</li>
                        </ul>
                    </div>
				</fieldset>
			</div>
        </div>
        
		<div class='row'>
			<div class="col-md-12">
				<fieldset>
					<legend>Transaction Number</legend>
					<div class='btn_align' id="transaction_error">
                    </div>
					<div class="form-group">
						<div class=" col-sm-12 input-group">
						  <span class="input-group-addon"><span class="glyphicon glyphicon-record"></span></span>
						  <input type="text" class="form-control" name="transaction_number" placeholder="Enter Transaction Number" required>
                          <input type="hidden" name="product_id" id="product_id" value="<?php echo $_SESSION['product_id'];?>"/>
						</div>
					</div>
		
                    <div class='btn_align'>
                        <input type="submit" value="Activate Item" class="login_btn btn btn_dark_pink btn-lg btn_width">
                    </div>
				</fieldset>
			</div>
		</div>
		<?php
			form_close();
		?>
		</div>