<% require themedCSS(artistpage) %>
<% require themedCSS(statusmessages) %>
<% require themedCSS(globaloverrides) %>


<% if UpdateSucccess %>
    <p id="Successful">Thanks for updating another artist listing on Teknosounds! Your rep just went up accordingly!</p>
<% end_if %>

<% if top.CanEditPost %>
<div id="EditLink">
    <a href="artist/edit/{$ID}">
        (edit)
    </a>
</div>
<% end_if %>

 <% if ArtistImage %>
    <div id="ArtistImage">
        <img src="{$ArtistImage.URL}"/>
    </div>
<% end_if %>
<div id="Name">
    $Name
</div>
<% if YoutubeSingle1 %>
    <div id="YoutubeSingle1">
        $YoutubeSingle1
    </div>
<% end_if %>
<% if YoutubeSingle2 %>
    <div id="YoutubeSingle2">
        $YoutubeSingle2
    </div>
<% end_if %>
<% if YoutubeSingle3 %>
    <div id="YoutubeSingle3">
        $YoutubeSingle3
    </div>
<% end_if %>
<% if OfficialWebpage %>
    <div id="OfficialWebpage">
        $OfficialWebpage
    </div>
<% end_if %>
<% if Soundcloud %>
    <div id="Soundcloud">
        $Soundcloud
    </div>
<% end_if %>
<% if Facebook %>
    <div id="Facebook">
        $Facebook
    </div>
<% end_if %>
<% if Twitter %>
    <div id="Twitter">
        $Twitter
    </div>
<% end_if %>
<% if Myspace %>
    <div id="Myspace">
        $Myspace
    </div>
<% end_if %>
<% if OfficialYoutube %>
    <div id="OfficialYoutube">
        $OfficialYoutube
    </div>
<% end_if %>
<% if GenreList %>
    <div id="GenreList">
        $GenreList
    </div>
<% end_if %>
