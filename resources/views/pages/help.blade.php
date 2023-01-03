@extends('layouts.app')

@section('content')

<section id="help-content">
    <h1>Help Page</h1>
    <p>This page was created to guide the user through the various sections of this website. Each page has a corresponding section on this documentation, so it can be easier for the user to find the info they are looking for:</p>
    
    <h2 id="search-page">Search Page</h2>
    <p>This page is shown right after you typed and submitted something in the search bar. It will present you 3 categories of results:</p> 
    <ul>
        <li><b>"Exact post matches"</b> - If your search corresponds exactly to the title of a post, its preview will be show in here. If there was no posts with this condition, the "No matches were found" message will be shown instead;</li>
        <li><b>"Other post matches"</b> - If part of a post contains what you've searched for, it will be shown here. If there was no posts with this condition, the "No matches were found" message will be shown instead;</li>
        <li><b>"User matches"</b> - If you searched for a user and they exist, they will be shown in here.If there was no users with this condition, the "No matches were found" message will be shown instead.</li>
    </ul>

    <h2 id="main-page">Main Page</h2>
    <p>In this part, you can view some post's previews of various communities. You can also sort them in various ways:</p>
    <ul>
        <li><b>"Hot"</b> - Sorts the posts in descending order taking into account the number of likes and comments of each one. You could see it has a list of the most "controversial" posts;</li>
        <li><b>"New"</b> - Sorts the posts in ascending order taking into account the time when they were posted. The list starts with the most recent post;</li>
        <li><b>"Top"</b> - Sorts the posts in descending order taking into account the number of likes of each one. If two posts have the same number of likes, the one with least dislikes comes first.</li>
    </ul>
    <p>There also is a table with the most popular communities at the moment. You can quickly follow them by clicking on the "Follow" button on the right side of each one.</p>
    <p>In order to view each post, you just need to click on its preview. If you wish to like or dislike it, you just need to click on the corresponding icon. Follow this same logic if you want to add it to your favorite posts list.</p>
    
    <h2 id="profile-page">Profile Page</h2>
    <p>On this page, you can find various info about your own account. Right below the page's header, you can find a menu with several options:</p>
    <ul>
        <li><b>"Overview"</b> - Shows the general information about your profile, such as your profile picture, username, date of registration, reputation score, biography and number of followers, posts and comments (left side of the page);</li>
        <li><b>"Posts"</b> - Displays your own posts, with a sort bar similar to the one presented on the <a href="/help/#main-page">main page</a>;</li>
        <li><b>"Comments"</b> - Lists all of comments you've made at any post;</li>
        <li><b>"Liked"</b> - Exhibits all of the posts that you liked;</li>
        <li><b>"Disliked"</b> - Presents all of the posts that you disliked;</li>
        <li><b>"Favorites"</b> - Shows all of the posts you added to your favorites.</li>
    </ul>
    <p>In order for you to edit your own biography, you just need to click on the pen icon, write to watever you want to change to and click on the "Save" button when you are done.</p>
    
    <h2 id="community-page">Community Page</h2>
    <p>Here you have plenty of information about a certain community. Firstly, right after the header, you have the community's banner and corresponding name and icon. Below that you can find the previews of the posts made in that community
        (with a sort option as well). On the right side, the are two separate tables:
    </p>
    <ul>
        <li><b>"About Community"</b> - Displays important information about the community, such as its description, the date in which it was created, and the number of its members. You can follow a certain community 
            by pressing the "Follow" button presented in this table;
        </li>
        <li><b>"Community's rules"</b> - This table shows every single rule the users must follow by using this community. They are defined by its owner.</li>
    </ul>
    <p>There is also a button to create a post. If you click on it, you will be presented by a template you must fill with whatever you want (Title, Tag, Text/Image). When you are done, click "Submit" and your post will be shown in the community page.</p>
    
    <h2 id="post-page">Post Page</h2>
    <p>In the post page, you can see many important details about it. Right on the first line, it is shown what user submitted the post (u/) and to which community they posted it (c/). The time of the submition is also presented. <br>
    On the following lines, you can read the title of the post (the bigger text), the tags of the post (blue rectangle) and its content, it being text or an image. Finally, the info about the post regarding number of likes/dislikes and 
    comments and the option to either report the post or add it to your favorites  are also presented in the post box. For you to comment on it, just write your comment in the text box and click on "Comment" when you're done.
    <br>On the right side, there also is some information about the community where this post was submitted. This information was already described <a href="/help/#community-page">here</a>.</p>

    <h2 id="admin-page">Admin Page</h2>
    <p>On this last page, exclusive to the admins of the platform, there are many important aspects on display:</p>
    <ul>
        <li><b>"Post Reports"</b> Table - This table shows data of the reported posts such as it's ID, the ID of the user who posted it and their usermame, the reason why the post was reported and the date in which it was reported;</li>
        <li><b>"Comment Reports"</b> Table - This table collects the same data of the previously mentioned one, the only difference being corresponding to comments and not posts;</li>
        <li><b>"Delete a User"</b> - As the name suggests, this feature allows the admin to delete a user by inserting their username on the input box and clicking on the button "Delete";</li>
        <li><b>"Create a User"</b> - This last feature allows the administrator to create new user by inputing the necessary fields and submit that info by clicking the "Create" button.</li>
    </ul>
</section>

@endsection