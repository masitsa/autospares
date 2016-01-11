// JavaScript Document

var link = $('#baseurl').val();
	
/*************************************
*
*	Delete category
*
**************************************/
$(document).on("click","a.delete_category",function(){
	
	var r = confirm("Delete category?");
		if (r == true)
  		{
			//get the category id
			var category_id = $(this).attr('href');
			
			//send the data to the php processing function
			$.post(link + "administration/delete_category/"+category_id,
				function(data){
				
					if(data == 'true'){
						window.location.href = link + "administration/list_categories/1/1";
			
					}else{
						alert(data);
					}	
				
			 }); 
 		}
		else
  		{
  			//window.location.href = link + "administration/list_categories/1/1";
  		}

	return false;
});
	
/*************************************
*
*	View Product: admin
*
**************************************/
$(document).on("click","a.view_product",function(){
	
	//get the product id
	var product_id = $(this).attr('href');
	
	//send the data to the php processing function
	$.post(link + "administration/view_product/"+product_id,
		function(data){
			$("#product_content").html(data);
	 }); 
	return false;
});
	
/*************************************
*
*	Delete product
*
**************************************/
$(document).on("click","a.delete_product",function(){
	
	var r = confirm("Delete product?");
		if (r == true)
  		{
			//get the category id
			var product_id = $(this).attr('href');
			
			//send the data to the php processing function
			$.post(link + "administration/delete_product/"+product_id,
				function(data){
				
					if(data == 'true'){
						window.location.href = link + "administration/list_products/2/3";
			
					}else{
						alert(data);
					}	
				
			 }); 
 		}
		else
  		{
  			//window.location.href = link + "administration/list_categories/1/1";
  		}

	return false;
});
	
/*************************************
*
*	Delete slide
*
**************************************/
$(document).on("click","a.delete_slide",function(){
	
	var r = confirm("Delete slide?");
		if (r == true)
  		{
			//get the category id
			var slideshow_id = $(this).attr('href');
			
			//send the data to the php processing function
			$.post(link + "administration/delete_slideshow/"+slideshow_id,
				function(data){
				
					if(data == 'true'){
						window.location.href = link + "administration/slideshow/4/5";
			
					}else{
						alert(data);
					}	
				
			 }); 
 		}
		else
  		{
  			//window.location.href = link + "administration/list_categories/1/1";
  		}

	return false;
});
	
/*************************************
*
*	Delete module
*
**************************************/
$(document).on("click","a.delete_module",function(){
	
	var r = confirm("Delete module?");
		if (r == true)
  		{
			//get the module id
			var navigation_id = $(this).attr('href');
			
			//send the data to the php processing function
			$.post(link + "administration/delete_module/"+navigation_id,
				function(data){
				
					if(data == 'true'){
						window.location.href = link + "administration/modules/5/7";
			
					}else{
						alert(data);
					}	
				
			 }); 
 		}
		else
  		{
  			//window.location.href = link + "administration/list_categories/1/1";
  		}

	return false;
});
	
/*************************************
*
*	Delete module
*
**************************************/
$(document).on("click","a.delete_sub_module",function(){
	
	var r = confirm("Delete sub module?");
		if (r == true)
  		{
			//get the module id
			var sub_navigation_id = $(this).attr('href');
			
			//send the data to the php processing function
			$.post(link + "administration/delete_sub_module/"+sub_navigation_id,
				function(data){
				
					if(data == 'true'){
						window.location.href = link + "administration/sub_modules/5/9";
			
					}else{
						alert(data);
					}	
				
			 }); 
 		}
		else
  		{
  			//window.location.href = link + "administration/list_categories/1/1";
  		}

	return false;
});
	
/*************************************
*
*	Delete page
*
**************************************/
$(document).on("click","a.delete_page",function(){
	
	var r = confirm("Delete page?");
		if (r == true)
  		{
			//get the module id
			var page_id = $(this).attr('href');
			
			//send the data to the php processing function
			$.post(link + "administration/delete_page/"+page_id,
				function(data){
				
					if(data == 'true'){
						window.location.href = link + "administration/pages/10/13";
			
					}else{
						alert(data);
					}	
				
			 }); 
 		}
		else
  		{
  			//window.location.href = link + "administration/list_categories/1/1";
  		}

	return false;
});
	
/*************************************
*
*Retrieve models
*
**************************************/

$(document).on("change","select.brands",function(){
	//get the brand id
	var brand = $( "#brand_id" ).val();
	
	//send the data to the php processing function
	$.post(link + "administration/get_brand_models/"+brand, 
		function(data){
			$("#models").html(data);
	 	}
	 ); 

	return false;
});
	
/*************************************
*
*	Delete brand
*
**************************************/
$(document).on("click","a.delete_brand",function(){
	
	var r = confirm("Delete brand?");
		if (r == true)
  		{
			//get the module id
			var brand_id = $(this).attr('href');
			
			//send the data to the php processing function
			$.post(link + "administration/delete_brand/"+brand_id,
				function(data){
				
					if(data == 'true'){
						window.location.href = link + "administration/brands/2/17";
			
					}else{
						alert(data);
					}	
				
			 }); 
 		}
		else
  		{
  			//window.location.href = link + "administration/list_categories/1/1";
  		}

	return false;
});
	
/*************************************
*
*	Delete brand model
*
**************************************/
$(document).on("click","a.delete_brand_model",function(){
	
	var r = confirm("Delete model?");
		if (r == true)
  		{
			//get the module id
			var brand_model_id = $(this).attr('href');
			
			//send the data to the php processing function
			$.post(link + "administration/delete_brand_model/"+brand_model_id,
				function(data){
				
					if(data == 'true'){
						window.location.href = link + "administration/brand_models/2/19";
			
					}else{
						alert(data);
					}	
				
			 }); 
 		}
		else
  		{
  			//window.location.href = link + "administration/list_categories/1/1";
  		}

	return false;
});
	
/*************************************
*
*	Delete customer
*
**************************************/
$(document).on("click","a.delete_customer",function(){
	
	var r = confirm("Delete customer?");
		if (r == true)
  		{
			//get the module id
			var customer_id = $(this).attr('href');
			
			//send the data to the php processing function
			$.post(link + "administration/customers/delete_customer/"+customer_id,
				function(data){
				
					if(data == 'true'){
						window.location.href = link + "administration/customers/list_customers/2/21";
					}else{
						alert(data);
					}	
				
			 }); 
 		}
		else
  		{
  			//window.location.href = link + "administration/list_categories/1/1";
  		}

	return false;
});