<% require themedCSS(eventlisting) %>
<% require themedCSS(globaloverrides) %>

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
                <div class="TimeDateBar" id="{$ID}">
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
                            <% if Venue %>$Venue<% else %>TBA<% end_if %>,<br/>
                            <% if OtherCity %>
                                 $OtherCity
                            <% else %>
                                 $City
                            <% end_if %>
                        </div>
                    </div>
                </div>
                <div class="container4 $UnderscoredCity" id="{$ID}_details">
                    <div class="container3">
                        <div class="container2">
                            <div class="container1">
                                <div class="col1">
                                    <% if FlyerImage %>
                                        <a href="event/show/{$ID}"><img src="{$FlyerImage.EventListingImage.Link}"/></a>
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
                                        <a href="http://teknosounds.com/messageboard/showthread.php/{$Talkback}"><h3>Forum Thread</h3></a>
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
<div id="floatsidebar">
    <div id="Expand_header">
        Expand:
    </div>
    <% control Cities %>
        <div id="Expand_$UnderscoredCity" class="ExpandLink">
            $City<br/>
        </div>
    <% end_control %>
    <br/>
    <div id="ExpandAll" class="ExpandLink">
        All
    </div>
    <div id="CollapseAll" class="ExpandLink">
        Collapse All
    </div>
</div>
<script type="text/javascript">
    (function($) {
        $(document).ready(function(){
            // SINGLE EXPANSION CODE

            $('.TimeDateBar').click(function() {
                if ($('#' + this.id + '_details').css('display') == "none")
                    $('#' + this.id + '_details').show();
                else
                    $('#' + this.id + '_details').hide();
            });



            // EXPANDING CODE

            // Begin by showing everything
            $('.container4').show();
            $('#ExpandAll').text('[All]').addClass('Expanded');

            // On each expanding click, hide all and reset text
            $('.ExpandLink').click(function() {
                $('#ExpandAll').text('All').removeClass('Expanded');
                <% control Cities %>
                    $('#Expand_$UnderscoredCity').text('$City').removeClass('Expanded');
                <% end_control %>
                $('#CollapseAll').text('Collapse All').removeClass('Expanded');
                $('.container4').hide();
            });

            // Expand the cities
            <% control Cities %>
                $('#Expand_$UnderscoredCity').click(function() {
                    $('.$UnderscoredCity').show();
                    $('#Expand_$UnderscoredCity').text('[$City]').addClass('Expanded');
                });
            <% end_control %>

            // Expand all events
            $('#ExpandAll').click(function() {
                $('.container4').show();
                $('#ExpandAll').text('[All]').addClass('Expanded');
            });

            // Collapse all events
            $('#CollapseAll').click(function() {
                $('.container4').hide();
                $('#CollapseAll').text('[Collapse All]').addClass('Expanded');
            });
        })
    })(jQuery);
</script>
