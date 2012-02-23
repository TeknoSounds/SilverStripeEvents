<% require themedCSS(loginpage) %>
<% require themedCSS(statusmessages) %>
<% require themedCSS(globaloverrides) %>

<% if LoggedIn %>
    <p id="SuccessfulBigger">Login Successful</p>
    <p id="MainInfo">Click <a href="login/logoff">here</a> to logoff. A logoff tab is coming soon!</p>
<% else %>
    <% if Failed %>
        <p id="Failure">Please try again.</p>
        <p id="MainInfo">Please login or click <a href="$URLSegment/createuser/newuser">here</a> to create an account.</p>
    <% else_if UserCreated %>
        <p id="SuccessfulBigger">User successfully created. You may now log in.</p>
    <% else_if DuplicateUser %>
        <p id="Failure">Sorry, this username is taken. Please try another one.</p>
    <% else_if CreatingUser %>
        <p id="MainInfo">Fill out the form to create an account.</p>
    <% else %>
        <p id="MainInfo">Please login or click <a href="$URLSegment/createuser/newuser">here</a> to create an account.</p>
    <% end_if %>
    $LoginForm
<% end_if %>
