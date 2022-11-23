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
      <h2>Post Reports</h2>
      <table>
          <tr>
            <th>Content ID</th>
            <th>User ID</th>
            <th>Reason</th>
            <th>Date</th>
          </tr>
        <tbody>
          @each('partials.reportposts', $post__reports, 'report')
        </tbody>
      </table>
    </section>
    <section id="report-comments">
      <h2>Comment Reports</h2>
      <table>
        <tr>
          <th>Content ID</th>
          <th>User ID</th>
          <th>Reason</th>
          <th>Date</th>
        </tr>
        <tbody>
          @each('partials.reportposts', $comment__reports, 'report')
        </tbody>
      </table>
    </section>
  </section>
  <section id="manage-users">
    <h2>Delete a User</h2>
    <form method="POST" action="{{ route('admin') }}">
      {{ csrf_field() }}
      <label for="username">Username</label>
        <input id="username" type="text" name="username" required autofocus>
      <button type="submit">Delete</button>
    </form>
    <h2>Create a User</h2>
  </section>
</section>
@endsection('content')
