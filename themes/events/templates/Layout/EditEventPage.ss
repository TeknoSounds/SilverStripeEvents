<% require themedCSS(overrideforms) %> 
<% require themedCSS(editeventpage) %> 
<% require themedCSS(statusmessages) %> 
<% require themedCSS(globaloverrides) %> 

<% if Success %>
	<p id="SuccessfulBigger">Thanks for creating another event listing on Teknosounds! Your rep just went up!</p>
<% else_if Duplicate %>
	<p id="Duplicate">This event is already being tracked by Teknsounds, but you still get a +1 for good karma! :)</p>
<% end_if %>

<% if LoggedIn %>
	<% if CanEditPost %>
		<p id="MainInfo">Feel free to add any info promoting EDM music throughout Texas.</p>
		$EventForm
	<% else %>
		<p id="NotYetPromoted">Sorry, this username has yet to be promoted. We are keeping an eye on top promoters, so your time will come soon.</p>
		<p id="Successful">Thank for continuing to keep the scene alive!</p>
	<% end_if %>
<% else %>
	<p id="MainInfo">Please <a href="login">login</a> to add events and gain community rep.</p>
<% end_if %>



<script type="text/javascript">
	(function($) {
		$(document).ready(function(){
			ctrlDown = false;
			$('#target').keydown(function(event) {
				if (event.keyCode == '17')
					ctrlDown = true;
			});
			$('#target').keyup(function(event) {
				if (event.keyCode == '17')
					ctrlDown = false;
				if (ctrlDown && event.keyCode == '86')
					$('#Form_EventForm').submit();
			});

			$('#Form_EventForm_Name').focus();
			
			if ($('#Form_EventForm_Date').val() == '')
				$('#Time').hide();
			if ($('#Form_EventForm_EndDate').val() == '')
				$('#EndTime').hide();
			if ($('#Form_EventForm_City').val() != 'Other')
				$('#OtherCity').hide();
			if ($('#Form_EventForm_State').val() != 'Other')
				$('#OtherState').hide();
			if ($('#Form_EventForm_LastKnownPrice').val() == '')
				$('#DoorPrice').hide();
				
			$("#Form_EventForm_Date").focus( function() {
				$(this).click();
			});
			$("#Form_EventForm_Date").change( function() {
				if ($(this).val() != ''){
					$("#Form_EventForm_Date").focus();
					$('#Time').show();
					$("#Form_EventForm_Time").focus();
				}else{
					$("#Form_EventForm_Date").focus();
					$('#Time').hide();
					$("#Form_EventForm_Time").focus();
				}
			});
			$("#Form_EventForm_EndDate").change( function() {
				if ($(this).val() != ''){
					$("#Form_EventForm_EndDate").focus();
					$('#EndTime').show();
					$("#Form_EventForm_EndTime").focus();
				}else{
					$("#Form_EventForm_EndDate").focus();
					$('#EndTime').hide();
					$("#Form_EventForm_EndTime").focus();
				}
			});
			$("#Form_EventForm_City").change( function() {
				$("#Form_EventForm_OtherCity").val(null);
				if ($(this).val() == 'Other'){
					$('#OtherCity').show();
					$("#Form_EventForm_OtherCity").focus();
				}else{
					$('#OtherCity').hide();
					$("#Form_EventForm_City").focus();
				}
			});
			$("#Form_EventForm_State").change( function() {
				$("#Form_EventForm_OtherState").val(null);
				if ($(this).val() == 'Other'){
					$('#OtherState').show();
					$("#Form_EventForm_OtherState").focus();
				}else{
					$('#OtherState').hide();
					$("#Form_EventForm_State").focus();
				}
			});
			$("#Form_EventForm_LastKnownPrice").change( function() {
				if ($(this).val() != ''){
					$('#DoorPrice').show();
					$("#Form_EventForm_DoorPrice").focus();
				}else{
					$('#DoorPrice').hide();
					$("#Form_EventForm_LastKnownPrice").focus();
				}
			});
		})
	})(jQuery);
</script>