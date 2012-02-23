<% require themedCSS(eventpage) %>
<% require themedCSS(statusmessages) %>
<% require themedCSS(globaloverrides) %>

<% if UpdateSucccess %>
	<p id="Successful">Thanks for updating another event listing on Teknosounds! Your rep just went up accordingly!</p>
<% end_if %>

<% if FlyerImage %>
	<div id="FlyerImage" class="clear">
		<img src="{$FlyerImage.URL}"/>
	</div>
<% end_if %>
<div id="Details">
	<div class="ShareContainer">
		<a class="Share" href="http://twitter.com/share?
											via=TeknoSounds
											&text=I'm attending: $Name on $Date.format(m.d.y)!
											&url={$BaseHref}event/show/{$ID}">
			<img src="../themes/events/images/eicons/twitter.png" height="15px"/>
		</a>
		<a class="Share" href="http://www.facebook.com/share.php?u={$BaseHref}event/show/{$ID}">
			<img src="../themes/events/images/eicons/facebook.png" height="15px"/>
		</a>
		<a class="Share" href="mailto:?
											&subject=I'm attending: $Name on $Date.format(m.d.y)!
											&body=Hope to see you there too! \n\n{$BaseHref}event/show/{$ID}">
			<img src="../themes/events/images/eicons/gmail.png" height="15px"/>
		</a>
	</div>
	<% if Name %>
		<div id="Name" class="clear">
			<div id="Title">Name</div>
			<div id="Value">$Name</div>
		</div>
	<% end_if %>
	<% if Date %>
		<div id="Date" class="clear">
			<div id="Title">Date</div>
			<div id="Value">$Date</div>
		</div>
	<% end_if %>
	<% if Time %>
		<div id="Time" class="clear">
			<div id="Title">Time</div>
			<div id="Value">$Time</div>
		</div>
	<% end_if %>
	<% if EndDate %>
		<div id="EndDate" class="clear">
			<div id="Title">End Date</div>
			<div id="Value">$EndDate</div>
		</div>
	<% end_if %>
	<% if EndTime %>
		<div id="EndTime" class="clear">
			<div id="Title">End Time</div>
			<div id="Value">$EndTime</div>
		</div>
	<% end_if %>
	<% if Venue %>
		<div id="Venue" class="clear">
			<div id="Title">Venue</div>
			<div id="Value">$Venue</div>
		</div>
	<% end_if %>
	<% if Address %>
		<div id="Address" class="clear">
			<div id="Title">Address</div>
			<div id="Value">$Address</div>
		</div>
	<% end_if %>
	<div id="City" class="clear">
		<% if OtherCity %>
			<div id="Title">City</div>
			<div id="Value">$OtherCity</div>
		<% else %>
			<div id="Title">City</div>
			<div id="Value">$City</div>
		<% end_if %>
	</div>
	<div id="State" class="clear">
		<% if OtherState %>
			<div id="Title">State</div>
			<div id="Value">$OtherState</div>
		<% else %>
			<div id="Title">State</div>
			<div id="Value">$State</div>
		<% end_if %>
	</div>
	<% if TicketLink %>
		<div id="TicketLink" class="clear">
			<div id="Title">Ticket Link</div>
			<div id="Value"><a href="{$TicketLink}">Link</a></div>
		</div>
	<% end_if %>
	<% if LastKnownPrice %>
		<div id="LastKnownPrice" class="clear">
			<div id="Title">Last Known Price</div>
			<div id="Value">$LastKnownPrice</div>
		</div>
	<% end_if %>
	<% if DoorPrice %>
		<div id="DoorPrice" class="clear">
			<div id="Title">Door Price</div>
			<div id="Value">$DoorPrice</div>
		</div>
	<% end_if %>
	<% if RSPVLink %>
		<div id="RSPVLink" class="clear">
			<div id="Title">RSPV Link</div>
			<div id="Value"><a href="{$RSPVLink}">Link</a></div>
		</div>
	<% end_if %>
	<% if FacebookEID %>
		<div id="Facebook" class="clear">
			<div id="Title">Facebook</div>
			<div id="Value"><a href="http://www.facebook.com/events/{$FacebookEID}">Link</a></div>
		</div>
	<% end_if %>
	<% if Talkback %>
		<div id="Talkback" class="clear">
			<div id="Title">Talkback</div>
			<div id="Value"><a href="http://dev.teknosounds.com/messageboard/showthread.php/{$Talkback}">Link</a></div>
		</div>
	<% end_if %>
	<% if Headliners %>
		<div id="Headliners" class="clear">
			<div id="Title">Headliners</div>
			<div id="Value">
				<% control Headliners %>
					$Name<br/>
				<% end_control %>
			</div>
		</div>
	<% end_if %>
	<% if LocalSupport %>
		<div id="LocalSupport" class="clear">
			<div id="Title">Local DJs</div>
			<div id="Value">
				<% control LocalSupport %>
					$Name<br/>
				<% end_control %>
			</div>
		</div>
	<% end_if %>
	<% if EventGallery %>
		<div id="EventGallery" class="clear">
			<div id="Title">EventGallery</div>
			<div id="Value"><a href="{$EventGallery}">Link</a></div>
		</div>
	<% end_if %>
</div>
<% if Description %>
	<div id="Description" class="clear">
		<div id="Title">Description</div>
		<div id="Value">$Description</div>
	</div>
<% end_if %>
