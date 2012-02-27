<% require themedCSS(fbquickaddpage) %>
<% require themedCSS(statusmessages) %>
<% require themedCSS(globaloverrides) %>

<% if Success %>
    <p id="SuccessfulBigger">Thanks for creating another event listing on Teknosounds! Your rep just went up by 1!</p>
<% else_if Duplicate %>
    <p id="Duplicate">This event is already being tracked by Teknsounds, but you still get a +1 for good karma! :)</p>
<% else_if NonFBEvent %>
    <p id="Failure">This event was not a valid Facebook Event Link. Please try again.</p>
<% end_if %>

<% if LoggedIn %>
    <% if CanFBPost %>
        <p id="MainInfo">Feel free to add the link to any Facebook event page promoting EDM music throughout Texas.</p>
        $NewEventForm
    <% else %>
        <p id="Failure">Sorry, this username has been banned from promoting. Please contact site admins if you feel this is an error.</p>
    <% end_if %>
<% else %>
    <p id="MainInfo">Please <a href="login">login</a> to add events and gain community rep.</p>
<% end_if %>

<script type="text/javascript">
    document.getElementById("Form_NewEventForm_FacebookEvent").focus();

    ctrlDown = false;
    (function($) {
        $(document).ready(function(){
            $('#Form_NewEventForm').bind('paste', null, function() {
                $('#Form_NewEventForm').submit();
            });
        })
    })(jQuery);
</script>
