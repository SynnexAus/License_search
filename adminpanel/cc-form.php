<div class="join-now">
	<div class="container">
		<div class="join-bg">
			<div class="join-lh">
				Join Now<br><span>Get a FREE</span>
			</div>
			<div class="join-form">
				<form name="contactform" id="contactform1" method="post" action="" novalidate="novalidate">
            <div id="SUCCMSG"></div>
            <div class="row">
              <div class="control-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label class="control-label">Name <span>*</span></label>
                <div class="controls">
                  <input type="text" class="form-control required" size="16" maxlength="50" value="" name="name" id="name">
                </div>
              </div>
              <div class="control-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label class="control-label">Phone <span>*</span></label>
                <div class="controls">
                  <input type="text" class="form-control required" size="16" maxlength="50" value="" name="phone" id="phone">
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <div class="row">
              <div class="control-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="control-group">
                  <label class="control-label">Email <span>*</span></label>
                  <div class="controls">
                    <input type="text" class="form-control required email" size="16" maxlength="60" value="" name="email" id="email">
                  </div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <div class="control-group col-lg-12">
              <div class="row">
                <div class="control-group">
                  <label class="control-label">Message</label>
                  <div class="controls">
                    <textarea title="Message" name="message" id="message" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <div class="row">
              <div class="control-group col-lg-12">
                <label class="control-label pull-left captchalab">Captcha Required</label>
                <div class="pull-left"><img border="0" class="capimg" alt="" src="captcha/image.php" id="captcha"></div>
                <div class="pull-left caplab"><a href="JavaScript: new_captcha();"><img alt="Contact Support" src="images/refresh.png"></a></div>
                <div class="col-lg-5 col-md-4 col-sm-6 col-xs-12 captctfield">
                  <input type="text" class="form-control required" size="16" value="" name="security_code" id="security_code">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="control-group col-lg-12">
                <hr>
                <input type="hidden" value="" name="pageState" id="pageState">
                <input type="hidden" value="" name="pageCity" id="pageCity">
                <input type="submit" value="SEND MESSAGE" class="btn">
              </div>
            </div>
          </form>
			</div>
		</div>
	</div>
</div>

<script>

function new_captcha() {
	var c_currentTime = new Date();
	var c_miliseconds = c_currentTime.getTime();
	document.getElementById('captcha').src = 'captcha/image.php?x='+ c_miliseconds;
}
</script>
<script>
jQuery(document).ready(function($) {
$("#contactform1").validate({	
		errorElement: "lable",
		submitHandler: function(form)
		{
			$.ajax({
				url: "sendcontactmail.php",
				type: "POST",
				data:  $("#contactform1").serialize(),
				success: function(data)
				{ 					
					if(data==1)
					{
						alert("Please enter correct captcha code.");
						document.getElementById('security_code').value="";
						document.getElementById('security_code').focus();
						new_captcha();
						return false;
					}
					else
					{
						$("#SUCCMSG").html(data);						
						$('#contactform1').each (function(){
							this.reset();
						});
						return false;
					}
				}
			});
			return false;
		}
	});
});
</script>