$(document).ready(function(){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});

	NProgress.start();

	// Trigger finish when page fully loaded
	$(window).load(function () {
        NProgress.done();
    });
    
	$(document).ajaxStart(function(){
        NProgress.start();
    });

    $(document).ajaxError(function(){
        NProgress.inc();
    });

    $(document).ajaxComplete(function(){
        NProgress.done();
    });

    // Trigger bar when exiting the page
    $(window).unload(function () {
        NProgress.start();
    });

	// Begin of login, signup processing

	var $formTabs = $('#main-nav');
		$loginButton = $formTabs.find(".access").eq(0);
		$signupButton = $formTabs.find(".access").eq(1);
		$modalTitle = $("#modal-title");
		$modalLogin = $("#modal-login");
		$modalsignup = $("#modal-signup");
		$modalPwd = $("#modal-forgotPwd");

		$loginButton.click(function(){
			$("#authModal").modal();
		});
		$formTabs.click(function(e){
			if($(e.target).is($loginButton)){
				$("#authModal").modal();
				login_selected();
			}else if($(e.target).is($signupButton)){
				$("#authModal").modal();
				signup_selected();
			}
		});

		$("#signupLink").click(function(){
			signup_selected();
		});
		$("#loginLink").click(function(){
			login_selected();
		});
		$("#passwdLink").click(function(){
			passwd_selected();
		});

		function login_selected(){

			$modalLogin.addClass('is-selected');
			$modalsignup.removeClass('is-selected');
			$modalPwd.removeClass('is-selected');
			$modalTitle.children('span').eq(0).addClass('glyphicon-lock');
			$modalTitle.children('span').eq(0).removeClass('glyphicon-cog');
			$modalTitle.children('span').eq(1).text(' LOGIN');

			$(".message").empty();

			$("#loginForm").validate({  
				rules: {
					email: {
						required: true,
						email: true
					},
					password: {
						required: true,
					}
				},
	            messages: {
	            	email: {
	            		required: "Please enter your email",
	            		email: "Please enter a valid email"
	            	},
	            	password: "Please enter your password"
	            },
	            errorPlacement: function (error , element) { 
	                element.parents('div.form-group').find('.message').html(error);
	            }          
			});
		};

		function signup_selected(){
			$modalLogin.removeClass('is-selected');
			$modalsignup.addClass('is-selected');
			$modalPwd.removeClass('is-selected');
			$modalTitle.children('span').eq(0).removeClass('glyphicon-lock');
			$modalTitle.children('span').eq(0).addClass('glyphicon-cog');
			$modalTitle.children('span').eq(1).text(' SIGN UP');

			$(".message").empty();

			$("#signupForm").validate({  
				rules: {
					fullname: {
						required: true
					},
					email: {
						required: true,
						email: true,
						remote: {
							url: '/checkEmailExist',
							type: 'post',
							dataType: 'json'
						}
					},
					password: {
						required: true,
						minlength: 6
					},
					password_confirmation: {
						required: true,
						equalTo: "#pwd"
					}
				},
	            messages: {
	            	fullname: "Please enter your full name",
	            	email: {
	            		required: "Please enter your email",
	            		email: "Please enter a valid email",
	            		remote: "This email was taken, you had account, login here"
	            	},
	            	password: "Please enter your password",
	            	confirmPwd: {
	            		required: "Please confirm your password",
	            		equalTo: "Password don't match, Please try again"
	            	}
	            },
	            errorPlacement: function (error , element) { 
	                element.parents('div.form-group').find('.message').html(error);
	            }          
			});
		};

		function passwd_selected(){

			$modalLogin.removeClass('is-selected');
			$modalsignup.removeClass('is-selected');
			$modalPwd.addClass('is-selected');
			$modalTitle.children('span').eq(0).removeClass('glyphicon-lock');
			$modalTitle.children('span').eq(1).text(' FORGOT PASSWORD');

			$(".message").empty();

			$("#resetPwdForm").validate({  
				rules: {
					email: {
						required: true,
						email: true
					}
				},
	            messages: {
	            	email: {
	            		required: "Please enter your email",
	            		email: "Please enter a valid email"
	            	}
	            },
	            errorPlacement: function (error , element) { 
	                element.parents('div.form-group').find('.message').html(error);
	            }          
			});
		};

		// End of login, signup processing
		var $sidebar   = $("#sidebar"), 
	        $window    = $(window),
	        offset     = $sidebar.offset(),
	        topPadding = 15,
	    	footer = $('#footer').offset(),
	    	sidebarDelta = footer.top - $("#header").offset().top - $("#header").outerHeight() - $("#slider").outerHeight() - $sidebar.outerHeight() - $('.recommended_items').outerHeight();
	    
	    $window.scroll(function() {
	    	console.log($window.scrollTop()+" - "+offset.top+" - "+footer.top);
	    	console.log(sidebarDelta +" = "+ Math.min($window.scrollTop() - offset.top + topPadding, sidebarDelta));
	        if ($window.scrollTop() > offset.top) {
	            $sidebar.stop().animate({
	                marginTop: Math.min($window.scrollTop() - offset.top + topPadding, sidebarDelta)
	            });
	        }else{
	        	$sidebar.stop().animate({
	                marginTop: 0
	            });
	        }
	    });
});
