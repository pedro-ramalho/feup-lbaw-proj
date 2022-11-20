<nav id="popC">
    <h2> Popular Communities </h2>
    <div id="PopBottom">
    @foreach ($communities as $community)
        @include('partials.linkCommunity', ['community' => $community, 'userFollowCommunities' => $userFollowCommunities])
    @endforeach
        <form id="PopLoad">
            <button> Load More </button>
        </form>
    </div>
</nav>