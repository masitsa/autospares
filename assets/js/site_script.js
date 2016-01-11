
var link = $('#base_url').val();

/*
*	Search for brand models of a particular brand
*/
$(document).on("change","select.search_brand_model",function(){
	
	var brand_id = $('#brand_id').val();
	
	$.post(link + "site/search_brand_models/"+brand_id,
	
  		function(data){
			if(data != "false")
			{
				$("#brand_model_id").fadeOut("slow");
				$("#brand_model_id").html("<option value='0'>---Select Brand Model---</option>"+data);
				$("#brand_model_id").fadeIn("slow");
			}
			else
			{
				$("#brand_model_id").fadeOut("slow");
				$("#brand_model_id").html("<option value='0'>This brand has no model</option>");
				$("#brand_model_id").fadeIn("slow");
			}
 		 });

	return false;
});

/*
*	Search for children of a particular category
*/
$(document).on("change","select.search_category_children",function(){
	
	var category_id = $('#category_id').val();
	
	$.post(link + "site/search_category_children/"+category_id,
	
  		function(data){
			if(data != "false")
			{
				$("#category_child").fadeOut("slow");
				$("#category_child").html("<option value='0'>---Select Sub Category---</option>"+data);
				$("#category_child").fadeIn("slow");
			}
			else
			{
				$("#category_child").fadeOut("slow");
				$("#category_child").html("<option value='0'>Does not have sub categories</option>");
				$("#category_child").fadeIn("slow");
			}
 		 });

	return false;
});

/*
*	Save Product
*/
$(document).on("submit","div.input_form2 form",function(e){
	e.preventDefault();
	
	
	
	var formData = new FormData(this);
	/*
	*	Javascript form validation
	*/
	var selling_price = $(this).find('input[name=product_selling_price]').val();//parseInt($(this).find('input[name=product_selling_price]').val());
	var balance = 1;
	
	if(isNaN(selling_price) == true)
	{
		$("#product_selling_price_error").addClass('has-error');
		$("#product_selling_price_error_msg").html('A number is required');
		
	}
	
	else
	{
	
		if(isNaN(balance) == true)
		{
			$("#product_balance_error").addClass('has-error');
			$("#product_balance_error_msg").html('A number is required');
			
		}
		
		else
		{
	
			$.ajax({
				type:'POST',
				url: $(this).attr('action'),
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				dataType: 'text json',
				success:function(data){
					/*console.log("success");
					console.log(data);
					alert(data);*/
					
					if(data.result == "success")
					{
						$.get(link + "site/add_payment", function(cart){
							$(".main_items").html(cart);
							document.getElementById('product_id').value = data.product_id;
						});
						
						//window.location.href = link+"site/sell_parts";
					}
					else
					{
						if(data.result == "validation_fail")
						{
							var email_error = data.error.user_email;
							$("#user_email_error").addClass('has-error');
							
						}
						else if(data.result == "upload_fail")
						{
							var upload_error = data.error;
							$("#user_email_error").removeClass('has-error');
							$("#upload_error_msg").addClass(upload_error);
							
						}
						else if(data.result == "gallery_fail")
						{
							$("#gallery_error").html(data.error);
							
						}
						else
						{
							alert(data.result);
							
						}
					}
				},
				error: function(xhr, status, error) {
					alert("\nerrorThrown=" + error + "XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status);
					
				}
			});
		}
	}
	//return false;
});

/*
*	Search for brand models of a particular brand on product addition
*/
$(document).on("change","select.product_brands",function()
{
	var brand_id = $(this).val();
	
	$.post(link + "site/sell/search_brand_models/"+brand_id,
	
  		function(data){
			if(data != "false")
			{
				$("#product_model_id").fadeOut("slow");
				$("#product_model_id").html(data);
				$("#product_model_id").fadeIn("slow");
				
			}
			else
			{
				$("#product_model_id").fadeOut("slow");
				$("#product_model_id").html("<option value='0'>This brand has no model</option>");
				$("#product_model_id").fadeIn("slow");
				
			}
 		 });

	return false;
});

/*
*	Search for children of a particular category
*/
$(document).on("change","select.product_category_children",function(){
	
	
	var category_id = $(this).val();//alert(link + "site/search_category_children/"+category_id);
		 
	$.ajax({
		type:'POST',
		url: link + "site/sell/search_category_children/"+category_id,
		cache:false,
		contentType: false,
		processData: false,
		dataType: 'text json',
		success:function(data){
			
			if(data == "false")
			{
				$("#product_category_child").fadeOut("slow");
				$("#product_category_child").html("<option value='0'>Does not have sub categories</option>");
				$("#product_category_child").fadeIn("slow");
				
			}
			else
			{
				$("#product_category_child").fadeOut("slow");
				$("#product_category_child").html(data.children);
				$("#product_category_child").fadeIn("slow");
				
				$("#product_category_sub_child").fadeOut("slow");
				$("#product_category_sub_child").html(data.sub_children);
				$("#product_category_sub_child").fadeIn("slow");
			}
		},
		error: function(xhr, status, error) 
		{
			alert("\nerrorThrown=" + error + "XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status);
			
		}
	});

	return false;
});

/*
*	Search for sub children of a particular category child
*/
$(document).on("change","select.product_category_sub_children",function()
{
	var category_id = $(this).val();//alert(link + "site/search_category_children/"+category_id);
	
	$.post(link + "site/sell/search_category_sub_children/"+category_id,
	
  		function(data){
			if(data != "false")
			{
				$("#product_category_sub_child").fadeOut("slow");
				$("#product_category_sub_child").html(data);
				$("#product_category_sub_child").fadeIn("slow");
				
			}
			else
			{
				$("#product_category_sub_child").fadeOut("slow");
				$("#product_category_sub_child").html("<option value='0'>Does not have sub categories</option>");
				$("#product_category_sub_child").fadeIn("slow");
				
			}
 		 });

	return false;
});

/*
*	Testing image upload
*/
$(document).on("submit","div.upload_images form",function(e){
	e.preventDefault();
	
	var box1;
	box1 = new ajaxLoader(".upload_images");
	
	var formData = new FormData(this);
	
	$.ajax({
		type:'POST',
		url: $(this).attr('action'),
		data:formData,
		cache:false,
		contentType: false,
		processData: false,
		dataType: 'text json',
		success:function(data){
			/*console.log("success");
			console.log(data);
			alert(data);*/
			
			if(data.result == "success")
			{
				
				window.location.href = link+"site/sell_parts";
			}
			else
			{
				alert(data.result);
				
			}
		},
		error: function(xhr, status, error) {
			alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
			
		}
	});
});

/*
*	Add transaction id to product
*/
$(document).on("submit","div.payment_form2 form",function(e){
	e.preventDefault();
	
	
	
	var formData = new FormData(this);
	
	$.ajax({
		type:'POST',
		url: $(this).attr('action'),
		data:formData,
		cache:false,
		contentType: false,
		processData: false,
		dataType: 'text json',
		success:function(data){
			/*console.log("success");
			console.log(data);
			alert(data);*/
			
			if(data.result == "success")
			{
				
				window.location.href = link+"site/";
			}
			else
			{
				$('#transaction_error').html('<div class="alert alert-danger">'+data.error.product_id+data.error.transaction_number+'</div>');
				
			}
		},
		error: function(xhr, status, error) {
			alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
			
		}
	});
});
	
/*************************************
*
*	View Product: site
*
**************************************/
$(document).on("click","a.site_product",function(){
	
	//get the product id
	var product_id = $(this).attr('href');
	
	//send the data to the php processing function
	$.post(link + "site/view_product/"+product_id,
		function(data){
			$("#product_details").html(data);
	 }); 
	return false;
});