// just for the demos, avoids form submit
		jQuery.validator.setDefaults({
		  	debug: true,
		  	success:  function(label){
        		label.attr('id', 'valid');
   		 	},
		});

		$( "#myform" ).validate({
		  	rules: {
			    password: "required",
		    	comfirm_password: {
		      		equalTo: "#password"
		    	}
		  	},
		  	messages: {
		  		first_name: {
		  			required: "Please enter a first name"
		  		}, 
		  		last_name: {
		  			required: "Please enter a last name"
		  		},
		  		login: {
		  			required: "Please enter a login"
		  		},	  		
		  		
		  		password: {
	  				required: "Please enter a password"
		  		},

		  		your_phone_number: {
		  			required: "Please provide an phonenumber"
		  		},

		  		comfirm_password: {
		  			required: "Please enter a password",
		      		equalTo: "Wrong Password"
		    	}
		  	}
		});

	