<!DOCTYPE html>

<html lang="$ContentLocale">
  <head>
        <% base_tag %>
        <title><% if MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
        $MetaTags(false)
        <link rel="shortcut icon" href="/favicon.ico" />

        <% require themedCSS(layout) %>
        <% require themedCSS(typography) %>
        <% require themedCSS(form) %>
        <% require themedCSS(events) %>
        <% require themedCSS(globaloverrides) %>

        <!--[if IE 6]>
            <style type="text/css">
             @import url(themes/blackcandy/css/ie6.css);
            </style>
        <![endif]-->
        <script type="text/javascript" src="/home/tsadmin/public_html/listings/events/javascript/floatingmenu.v1.7.js"></script>
    </head>
<body>
    <div id="BgContainer">
        <div id="Container">
            <a href="http://events.teknosounds.com">
                <div id="Header">
                    $SearchForm
                    <h1>$SiteConfig.Title</h1>
                    <p>$SiteConfig.Tagline</p>
                </div>
            </a>

            <div id="TopBanner">
                <% include TopBanner %>
            </div>
            <div id="Navigation">
                <% include Navigation %>
            </div>

            <div class="clear"><!-- --></div>

            <div id="Layout">
              $Layout
            </div>

           <div class="clear"><!-- --></div>
        </div>
        <div id="Footer">
            <% include Footer %>
        </div>
    </div>
</body>
</html>
