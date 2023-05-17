@include('print.print-layout.exam',compact('print_options'))
    <h2 style="text-align: center;">{{config('config.default_academic_session.name')}}</h2>

    <h2 style="text-align: center;">{{gv($data, 'batch')}} - {{gv($data, 'exam_term')}}</h2>

    <table class="report-card" style="margin-top: 20px;">
		<tr>
			<td>#</td>
			<td style="font-weight: bold;">{{trans('student.name')}}</td>
			<td style="font-weight: bold;">{{trans('student.admission_number_short')}}</td>
			<td style="font-weight: bold;">{{trans('exam.exam')}}</td>
			@foreach(gv($data, 'header') as $header)
				<td colspan="{{gv($header, 'colspan',1)}}" style="font-weight: bold; text-align: center;">
					{{gv($header, 'name')}}
					@if (gv($header, 'shortcode'))
						({{gv($header, 'shortcode')}})
					@endif
				</td>
			@endforeach
			<td style="font-weight: bold; text-align: center;">{{trans('exam.total_code')}}</td>
			<td style="font-weight: bold; text-align: center;">{{trans('exam.percentage_code')}}</td>
			<td style="font-weight: bold; text-align: center;">{{trans('exam.grade_code')}}</td>
		</tr>

		@foreach(gv($data, 'rows') as $row)
			<tr>
				<td rowspan="{{gv($row, 'rowspan') + 2}}">{{$loop->index + 1}}</td>
				<td rowspan="{{gv($row, 'rowspan') + 2}}">{{gv($row, 'student')}}</td>
				<td rowspan="{{gv($row, 'rowspan') + 2}}">{{gv($row, 'admission_number')}}</td>

				@foreach(gv($row, 'exam_rows', []) as $exam_row)
					@if ($loop->first)
						<td>{{gv($exam_row, 'exam_name')}}</td>
						@foreach(gv($exam_row, 'marks', []) as $mark)
							<td style="text-align: center;">{{gv($mark, 'mark')}}</td>
						@endforeach
						<td style="text-align: center;">{{gv($exam_row, 'total')}}/{{gv($exam_row, 'max_mark')}}</td>
						<td style="text-align: center;">{{gv($exam_row, 'percentage')}}</td>
						<td style="text-align: center;">{{gv($exam_row, 'grade')}}</td>
					@endif
				@endforeach
			</tr>

			@foreach(gv($row, 'exam_rows', []) as $exam_row)
				@if (! $loop->first)
					<tr>
						<td>{{gv($exam_row, 'exam_name')}}</td>
						@foreach(gv($exam_row, 'marks', []) as $mark)
							<td style="text-align: center;">{{gv($mark, 'mark')}}</td>
						@endforeach
						<td style="text-align: center;">{{gv($exam_row, 'total')}}/{{gv($exam_row, 'max_mark')}}</td>
						<td style="text-align: center;">{{gv($exam_row, 'percentage')}}</td>
						<td style="text-align: center;">{{gv($exam_row, 'grade')}}</td>
					</tr>
				@endif
			@endforeach

			<tr>
				<td>Total</td>
				@foreach (gv($row, 'subject_wise_total', []) as $total)
					<td style="text-align: center;">{{$total}}</td>
				@endforeach
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Grade</td>
				@foreach (gv($row, 'subject_wise_grade', []) as $grade)
					<td style="text-align: center;">{{$grade}}</td>
				@endforeach
				<td></td>
				<td></td>
				<td></td>
			</tr>
		@endforeach
    </table>

@include('print.print-layout.footer')