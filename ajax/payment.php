    
    <?php
    DEFINE(SITETILE,"Green Olive Surveys");
    ?>
    
    <title><?php echo SITETITLE;?></title>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="style/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">
          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Step 3 of 3: Payment Information</h3>
             	
              	<?php
              	  include("incs/public-nav.php");
				?>
              
            </div>
          </div>
          <div class="inner cover">
          
             <div class="row">
				<p class="instructions">Last Step! We need to get some billing info, then you're all set to get started! Note, quarterly plans are billed once every three months and annual plans are billed as an upfront one-time fee.</p>
			</div>	
			<div class="row">
				<div class="subrow">
				<form id="braintree-payment-form" action="../ajax/handlepmt.php" method="POST">
        				<select name='plan' id='plan' class="input-lg plans">
						<option value="100000">Monthly: $12 / month</option>
						<option value="100010">Quarterly: $33 (1 month free per year) </option>
						<option value="100020" selected>1 Year Plan: $120 (2 months free per year) </option>
						<option value="100030">2 Year Plan: $216 (6 months free per year) </option>
					</select>
       			</div>
				<div class="subrow">	
       				<input name="first_name" id="first_name" class="input-lg sname" type="text" autocomplete="off"  placeholder="first name" />&nbsp; <input name="last_name" id="last_name" type="text" class="input-lg sname" autocomplete="off" placeholder="last name" />
      			</div>
       			<div class="subrow">
				<input type="text" class='input-lg sname' autocomplete="off"  data-encrypted-name="number" placeholder="Card Number"/>				
				&nbsp;
				<input type="text" class='input-lg sname' autocomplete="off"  data-encrypted-name="nameOnCard" placeholder="Name on Card"/>
      			
				</div> 
        			<div class="subrow">
       			
					<input type="text" name="postal_code" id="postal_code"  class="input-lg zip" autocomplete="off"  placeholder="postal code"/>&nbsp;
      				<input type="text" class="input-lg cvv" autocomplete="off" data-encrypted-name="cvv" placeholder="cvv" />&nbsp;
					<input type="text" autocomplete="off"  class="input-lg state" data-encrypted-name="month" placeholder="MM"/> / 
					<input type="text" autocomplete="off"  class="input-lg anno" data-encrypted-name="year" placeholder="YYYY"/>
				</div>
        			
      			
       			<div class="subrow"> 	
       				<button type="submit" id="submit" class="btn btn-primary btn-lg">Submit</button>
				</form>
				</div>
				<div class="subrow">
					<span id="showResult">Hello</span>
				</div>


   
    
    <script src="https://js.braintreegateway.com/v1/braintree.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script>
    var ajax_submit = function (e) {
      form = $('#braintree-payment-form');
      e.preventDefault();
      $("#submit").attr("disabled", "disabled");
      $.post(form.attr('action'), form.serialize(), function (data) {
        //form.parent().replaceWith(data);
     	$("#showResult").html(data); 
	 });
    }
    var braintree = Braintree.create("MIIBCgKCAQEAux4jZkVmbQKhB9WdL7OLbPMwR/PyqkxTjiIhbFSeH5TaWvxjYeWyPo2XhzuesR5LpCLcBc5wYT7zImNLJfwztu4ShmNrEjQXNwLnVBB5V7hx2UCggDAKLlecEcBbDp1rnLl79jHwJSw7fjZL8A/pcB54CoTzVEu+DGRjTHysJZGtD0sMGkNzql0hWfkXHAU/2mp9eQKg+ZFrZfaP7CkmCNbNS39HxKBvc/Y9BrVhtZViLzb+jRxItTRhG2NbUf77nbEMCM3V2ECpzcyROt9Ovcc5fXMsDMN73fYEG5mGzUCmV7RQargvvySjnRw75sl4uxV9HUZK8lT2LUFrUsoQXQIDAQAB");
    braintree.onSubmitEncryptForm('braintree-payment-form', ajax_submit);
    
  </script>