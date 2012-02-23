<% require themedCSS(eventlisting) %>
<% require themedCSS(globaloverrides) %>

<% control Cities %>
    $City<br/>
<% end_control %>
<div id="ExpandLink">
    Expand All
</div>

 <% if false %>
<div class="EventsList">
    <% control Users %>
        <div class="UserHolder">
            $Name - {$MajorRepPoints}.{$MinorRepPoints}
        </div>
    <% end_control %>
</div>
 <% end_if %>

<div class="EventsList">
    <% control Events %>
        <div class="EventHolder">
                    <a name="{$ID}"></a>
                <div class="TimeDateBar">
                    <div class="BarInfo">
                        <% if top.CanEditPost %>
                            <div class="EditLink">
                                (<a href="event/edit/{$ID}">e</a>)
                            </div>
                        <% end_if %>
                        <div class="Month">
                            $Date.format(M)
                        </div>
                        <div class="Day">
                            $Date.format(D)
                            $Date.format(d)
                        </div>
                        <div class="Title">
                            <a href="event/show/{$ID}">
                                $Name
                                <% if DoorPrice %>
                                     - ${$DoorPrice}
                                <% end_if %>
                            </a>
                        </div>
                        <div class="HeadlinerList">
                            <% control OrderedHeadliners %>
                                <% if Last %>
                                    $Name
                                <% else %>
                                    $Name,
                                <% end_if %>
                            <% end_control %>
                        </div>
                        <div class="Venue">
                            $Venue,<br/>
                            <% if OtherCity %>
                                 $OtherCity
                            <% else  %>
                                 $City
                            <% end_if %>
                        </div>
                    </div>
                </div>
                <div class="container4">
                    <div class="container3">
                        <div class="container2">
                            <div class="container1">
                                <div class="col1">
                                    <% if FlyerImage %>
                                        <a href="{$FlyerImage.URL}"><img src="{$FlyerImage.EventListingImage.Link}"/></a>
                                    <% end_if %>
                                    &nbsp;
                                </div>
                                <div class="col2">
                                    <% if Time %>
                                        <h3>Start Time:</h3> $Time.format(h:i A) - $Date.format(m.d.y)
                                    <% end_if %>
                                    <% if EndDate %>
                                        <h3>End Date:</h3> $EndDate.format(m.d.y)
                                    <% end_if %>
                                    <% if EndTime %>
                                        <h3>End Time:</h3> $EndTime.format(h:i A)
                                    <% end_if %>
                                    <% if Address %>
                                        <h3>Address:</h3>
                                            $Address (<a href="http://maps.google.com/maps?q={$Address}, {$City}{$OtherCity}, {$State}{$OtherState}">Map</a>)
                                    <% end_if %>
                                    <% if ProductionCompany %>
                                        <h3>Production Company:</h3> $ProductionCompany.Name
                                    <% end_if %>
                                    <% if TicketLink %>
                                        <a href="{$TicketLink}"><h3>Tickets</h3></a>
                                    <% end_if %>
                                    <% if RSPVLink %>
                                        <a href="{$RSPVLink}"><h3>RSPV Link</h3></a>
                                    <% end_if %>
                                    <% if LastKnownPrice %>
                                        <h3>Last Known Price:</h3> $ $LastKnownPrice
                                    <% end_if %>
                                    <% if DoorPrice %>
                                        <h3>Door:</h3> $ $DoorPrice
                                    <% end_if %>
                                    <% if FacebookEID %>
                                        <a href="http://www.facebook.com/events/{$FacebookEID}"><h3>Facebook</h3></a>
                                    <% end_if %>
                                    <% if Talkback %>
                                        <a href="http://dev.teknosounds.com/messageboard/showthread.php/{$Talkback}"><h3>Talkback</h3></a>
                                    <% end_if %>
                                    <% if EventGallery %>
                                        <a href="{$EventGallery}"><h3>Event Gallery</h3></a>
                                    <% end_if %>
                                    <br/>
                                </div>
                                <div class="col3">
                                    Headliners:
                                    <% control OrderedHeadliners %>
                                        <div id="Headliner">
                                            <a href="artist/show/{$ID}">
                                                $Name
                                            </a>
                                            <% if YoutubeSingle1 %>
                                                <a href="{$YoutubeSingle1}">S</a>
                                            <% end_if %>
                                            <% if YoutubeSingle2 %>
                                                <a href="{$YoutubeSingle2}">S</a>
                                            <% end_if %>
                                            <% if YoutubeSingle3 %>
                                                <a href="{$YoutubeSingle3}">S</a>
                                            <% end_if %>
                                            <% if OfficialWebpage %>
                                                <a href="{$OfficialWebpage}">OW</a>
                                            <% end_if %>
                                            <% if Soundcloud %>
                                                <a href="{$Soundcloud}">SC</a>
                                            <% end_if %>
                                            <% if Facebook %>
                                                <a href="{$Facebook}">FB</a>
                                            <% end_if %>
                                            <% if Twitter %>
                                                <a href="{$Twitter}">TW</a>
                                            <% end_if %>
                                            <% if Myspace %>
                                                <a href="{$Myspace}">MS</a>
                                            <% end_if %>
                                            <% if OfficialYoutube %>
                                                <a href="{$OfficialYoutube}">YT</a>
                                            <% end_if %>
                                        </div>
                                    <% end_control %>
                                </div>
                                <div class="col4">
                                    Local:
                                    <% control LocalSupport %>
                                        <div id="LocalSupport">
                                            <a href="artist/show/{$ID}">
                                                $Name
                                            </a>
                                            <% if YoutubeSingle1 %>
                                                <a href="{$YoutubeSingle1}">S</a>
                                            <% end_if %>
                                            <% if YoutubeSingle2 %>
                                                <a href="{$YoutubeSingle2}">S</a>
                                            <% end_if %>
                                            <% if YoutubeSingle3 %>
                                                <a href="{$YoutubeSingle3}">S</a>
                                            <% end_if %>
                                            <% if OfficialWebpage %>
                                                <a href="{$OfficialWebpage}">OW</a>
                                            <% end_if %>
                                            <% if Soundcloud %>
                                                <a href="{$Soundcloud}">SC</a>
                                            <% end_if %>
                                            <% if Facebook %>
                                                <a href="{$Facebook}">FB</a>
                                            <% end_if %>
                                            <% if Twitter %>
                                                <a href="{$Twitter}">TW</a>
                                            <% end_if %>
                                            <% if Myspace %>
                                                <a href="{$Myspace}">MS</a>
                                            <% end_if %>
                                            <% if OfficialYoutube %>
                                                <a href="{$OfficialYoutube}">YT</a>
                                            <% end_if %>
                                        </div>
                                    <% end_control %>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <% end_control %>
</div>
<div id="floatdiv" style="
    position:absolute;
    width:200px;height:50px;left:10px;
    padding:16px;background:#FFFFFF;
    opacity:0.4;
    filter:alpha(opacity=40); /* For IE8 and earlier */
    border:2px solid #2266AA;
    color:red;
    font-weight:normal;
    z-index:100">
This is a floating javascript menu.
</div>

<script type="text/javascript">
    floatingMenu.add('floatdiv',
        {
            // Represents distance from left or right browser window
            // border depending upon property used. Only one should be
            // specified.
            targetLeft: 10,
            // targetRight: 10,

            // Represents distance from top or bottom browser window
            // border depending upon property used. Only one should be
            // specified.
            // targetTop: 10,
            // targetBottom: 0,

            // Uncomment one of those if you need centering on
            // X- or Y- axis.
            // centerX: true,
            centerY: true,

            // Remove this one if you don't want snap effect
            snap: true
        });
</script>
<script type="text/javascript">
    (function($) {
        $(document).ready(function(){
            $('.container4').hide();
            expanded = false;
            $('#ExpandLink').click(function() {
                if (!expanded){
                    $('.container4').show();
                    $('.HeadlinerList').hide();
                    expanded = true;
                } else {
                    $('.container4').hide();
                    $('.HeadlinerList').show();
                    expanded = false;
                }
            });
        })
    })(jQuery);
</script>
