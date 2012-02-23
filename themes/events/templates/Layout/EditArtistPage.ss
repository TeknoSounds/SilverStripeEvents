<% require themedCSS(overrideforms) %>
<% require themedCSS(editartistpage) %>
<% require themedCSS(statusmessages) %>
<% require themedCSS(globaloverrides) %>

<% if LoggedIn %>
	<% if CanEditPost %>
		<p id="MainInfo">Feel free to add/update any info for this artist.</p>
		$ArtistForm
	<% else %>
		<p id="NotYetPromoted">Sorry, this username has yet to be promoted. We are keeping an eye on top promoters, so your time will come soon.</p>
		<p id="Successful">Thank for continuing to keep the scene alive!</p>
	<% end_if %>
<% else %>
	<p id="MainInfo">Please <a href="login">login</a> to edit artist pages and gain community rep.</p>
<% end_if %>
