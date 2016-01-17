<div class="main" role="main">
    	<div id="content" class="content full">
      		<div class="container">
            	<div class="listing-header margin-40">
                	<h2>Contact Us</h2>
                </div>
                
            	<div class="row">
                	<div class="col-md-3 col-sm-4">
                    	<i class="fa fa-home"></i></span> <b><?php echo $contacts['company_name'];?>.</b><br>
							<?php echo $contacts['building'];?> <?php echo $contacts['floor'];?> <?php echo $contacts['location'];?><br>
							<?php echo $contacts['address'];?>, <?php echo $contacts['post_code'];?> <?php echo $contacts['city'];?><br><br>
							<i class="fa fa-phone"></i> <b><?php echo $contacts['phone'];?></b><br>
							<!-- <i class="fa fa-fax"></i> <b></b><br> -->
							<i class="fa fa-envelope"></i> <a href="mailto:<?php echo $contacts['email'];?>"><?php echo $contacts['email'];?></a><br><br>
							<i class="fa fa-home"></i> <b><?php echo $contacts['working_weekday']?></b><br>
							<?php echo $contacts['working_weekend']?>
                    </div>
                    <div class="col-md-9 col-sm-8">
                        <form enctype="multipart/form-data" action="<?php echo base_url();?>submit-query"  id = "submit_query" method="post">

                       		<div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" id="name" name="name"  class="form-control input-lg" placeholder="First name*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" id="email" name="email"  class="form-control input-lg" placeholder="Email*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="phone" name="phone" class="form-control input-lg" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <textarea cols="6" rows="8" id="query" name="query" class="form-control input-lg" placeholder="Message" required></textarea>
                                    </div>
                                    <input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg pull-right" value="Submit now!">
                              	</div>
                           	</div>
                		</form>
                        <div class="clearfix"></div>
                        <div id="message"></div>
                    </div>
              	</div>
        	</div>
      	</div>
 	</div>