<nav id="pop-c">
    <h2> Popular Communities </h2>
    <div id="pop-bottom">
        @foreach ($communities as $community)
            @include('partials.linkCommunity', ['community' => $community, 'userFollowCommunities' => $userFollowCommunities])
        @endforeach
        <!--<form id="pop-load">
            <button> Load More </button>
        </form>-->
    </div>
</nav>