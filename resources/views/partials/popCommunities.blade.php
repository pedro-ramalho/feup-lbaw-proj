<nav id="popC">
    <h2> Popular Communities </h2>
    <div id="PopBottom">
        @each('partials.linkCommunity', $communities, 'community')
        <form id="PopLoad">
            <button> Load More </button>
        </form>
    </div>
</nav>