@extends('layouts.app')


@section('content')

<section id="content">
  <main>
    <form action="{{ route('submit_post', $community->id) }}" method="post" id="submit-post">
      {{ csrf_field() }}
      <input type="number" name="community-id" id="community-id" hidden="hidden" value="{{ $community->id }}">
      <input type="number" name="is-image" id="is-image" hidden="hidden" value="0">
      <input type="text" name="title" id="new-post-title" placeholder="An interesting title..." required>
      <p id="tag">Advertisement</p>
      <textarea name="text" id="new-post-text" required">An interesting post text</textarea>
      <button type="submit">Save</button>
    </form>
  </main>
  <aside>
    @include('partials.aboutcommunity', ['community' => $community])
    @include('partials.communityrules', ['community' => $community])
  </aside>
</section>
@endsection