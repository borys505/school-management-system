@include('print.print-layout.header')
    <h2 style="text-align: center;">{{config('config.default_academic_session.name')}}</h2>
    <h2>{{trans('academic.transfer_certificate').' '.trans('general.total_result_count',['count' => count($transfer_certificates)])}}</h2>
    <table class="fancy-detail">
        <thead>
            <tr>
                <th>{{trans('student.student')}}</th>
                <th>{{trans('academic.date_of_issue')}}</th>
                <th>{{trans('academic.date_of_application')}}</th>
                <th>{{trans('general.created_at')}}</th>
            </tr>
        </thead>
        <tbody>
        	@foreach($transfer_certificates as $transfer_certificate)
        		<tr>
                    <td>{!!$transfer_certificate->student_record_id ? ($transfer_certificate->studentRecord->student->name.' <br />'.$transfer_certificate->studentRecord->batch->batch_with_course) : '-'!!}</td>
                    <td>{{showDate($transfer_certificate->date_of_issue)}}</td>
                    <td>{{showDate($transfer_certificate->date_of_application)}}</td>
                    <td>{{showDateTime($transfer_certificate->created_at)}}</td>
        		</tr>
        	@endforeach
        </tbody>
    </table>
@include('print.print-layout.footer')