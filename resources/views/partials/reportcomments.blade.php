@if(!($report->reviewed))
<tr>
  <td>{{ $report->id_content }}</td>
  <td>{{ $report->id_user }}</td>
  <td>{{ $report->user->username }}</td>
  <td>{{ $report->reason }}</td>
  <td>{{ date('Y-m-d', strtotime($report->report_date))}}</td>
</tr>
@endif
