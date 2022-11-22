@extends('layouts.app')


@section('content')

<section id="content">
  <main>
    <form action="{{ route('edit_post', $post->id) }}" method="post" id="edit-post">
      {{ csrf_field() }}
      <input type="text" name="new-post-title" id="new-post-title" value="{{$post['title']}}" required>
      <p id="tag">{{ $post->tag['name'] }}</p>
      @if ($post['is_image'])
      <img src="" alt="post image" id="post-image">
      @else
      <textarea name="new-post-text" id="new-post-text" required">{{ $model->find($post['id'])['text']}}</textarea>
      @endif
      <button type="submit">Save</button>
    </form>
  </main>
  <aside>
    @include('partials.aboutcommunity', ['community' => $post->community])
    @include('partials.communityrules', ['community' => $post->community])
  </aside>
</section>
@endsection