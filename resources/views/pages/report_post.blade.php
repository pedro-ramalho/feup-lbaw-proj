@extends('layouts.app')


@section('content')
    <form action="{{ route('report_post')}}" method="post" id="report-post">
        
        <p id="header">Report post:</p>
        <p id="question">In what terms do you consider this post to violate the guidelines?</p>
        <div id="checkboxes">
            <ul>
                <li><input type="checkbox" class="largecheckbox"> checkbox 1</li>
                <li><input type="checkbox" class="largecheckbox"> checkbox 2</li>
                <li><input type="checkbox" class="largecheckbox"> checkbox 3</li>
                <li><input type="checkbox" class="largecheckbox"> checkbox 4</li>
            </ul>
        </div>
        <button type="submit">Save</button>
        
    </form>
@endsection
