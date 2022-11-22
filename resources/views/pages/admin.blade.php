@extends('layouts.app')

<?php use App\Models\ReportInformation;
  use Illuminate\Support\Facades\DB;
  $all_reports = ReportInformation::where(DB::raw(1), '=', 1);
  $post_reports = $all_reports->join('content', 'report_information.id_content', '=', 'content.id');
  $post__reports = $post_reports->where('content.is_post', true)->get();
  $comment__reports = $post_reports->where('content.is_post', false)->get();
?>

@section('content')

<section id="admin-content">
  <section id="reports">
    <section id="report-posts">
      <table>
        <tr>
          <th>Content ID</th>
          <th>User ID</th>
          <th>Reason</th>
          <th>Date</th>
        </tr>
        @each('partials.reportposts', $post__reports, 'report')
      </table>
    </section>
    <section id="report-comments">
      <table>
        <tr>
          <th>Content ID</th>
          <th>User ID</th>
          <th>Reason</th>
          <th>Date</th>
        </tr>
        @each('partials.reportposts', $comment__reports, 'report')
      </table>
    </section>
  </section>
  <section id="manage-users">
    <form method="POST" action="{{ route('admin') }}">
      {{ csrf_field() }}
      <label for="username">Username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
      <button type="submit">Delete</button>
    </form>
  </section>
</section>
@endsection('content')
