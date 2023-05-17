@foreach ($transactions as $transaction)
    @include('print.print-layout.receipt-header')
    <table class="fancy-detail">
        <tr>
            <th style="text-align: center;">Fee Receipt</th>
        </tr>
    </table>
    <table class="fancy-detail">
        <tbody>
            <tr>
                <td><strong>{{trans('finance.receipt').' #'}}</strong></td>
                <td>{{$transaction->voucher_number}}</td>
                <td><strong>{{trans('general.date')}}</strong></td>
                <td>{{showDate($transaction->date)}}</td>
            </tr>
            <tr>
                <td><strong>{{trans('student.admission_number')}}</strong></td>
                <td>{{$student_record->admission->number}}</td>
                <td><strong>{{trans('academic.session')}}</strong></td>
                <td>{{config('config.default_academic_session.name')}}</td>
            </tr>
            <tr>
                <td><strong>{{trans('student.name')}}</strong></td>
                <td>{{$student_record->student->name}}</td>
                <td><strong>{{trans('academic.course')}}</strong></td>
                <td>{{$student_record->batch->course->name.' '.$student_record->batch->name}}</td>
            </tr>
            <tr>
                <td><strong>{{trans('finance.fee_installment')}}</strong></td>
                <td>{{$transaction->studentFeeRecord->feeInstallment->title}}</td>
                <td><strong>{{trans('transport.route')}}</strong></td>
                <td>
                    @if ($student_record->transportRouteStudent)
                        {{$student_record->transportRouteStudent->transportRouteDetail->transportRoute->name}}
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>{{trans('transport.stoppage')}}</strong></td>
                <td>
                    @if ($student_record->transportRouteStudent)
                        {{$student_record->transportRouteStudent->transportRouteDetail->transportStoppage->name}}
                    @endif
                </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table class="fancy-detail" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>SNo</th>
                <th>Description</th>
                <th>Due</th>
                <th>Concession</th>
                <th style="text-align: right;">Paid</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach($transaction->studentFeeRecordDetails as $student_fee_record_detail)
                <tr>
                    <td>{{$i}}</td>
                    <td style="width: 60%;" class="font-weight-bold">{{$student_fee_record_detail->FeeHead->name}}</td>
                    <td>
                        @php
                            $fee_installment_detail = $transaction->studentFeeRecord->feeInstallment->feeInstallmentDetails->firstWhere('fee_head_id', $student_fee_record_detail->fee_head_id);
                            $amount = $fee_installment_detail ? $fee_installment_detail->amount : 0;
                        @endphp
                        {{currency($amount,1)}}
                    </td>
                    <td>
                        @php
                            $fee_concession = $transaction->studentFeeRecord->feeConcession;

                            $concession_amount = 0;
                            if ($fee_concession) {
                                $fee_concession_detail = $fee_concession->feeConcessionDetails->firstWhere('fee_head_id', $student_fee_record_detail->fee_head_id);
                                if ($fee_concession_detail) {
                                    if ($fee_concession_detail->type == 'percent') {
                                        $concession_amount = ($amount * $fee_concession_detail->amount/100);
                                    } else {
                                        $concession_amount = $fee_concession_detail->amount;
                                    }
                                }
                            }
                        @endphp
                        {{currency($concession_amount,1)}}
                    </td>
                    <td style="text-align: right;">{{currency($student_fee_record_detail->amount,1)}}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            @if($transaction->getOption('transport_fee'))
                <tr>
                    <td>{{$i}}</td>
                    <td style="width: 60%;" class="font-weight-bold">{{trans('transport.fee')}}</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{currency($transaction->getOption('transport_fee'),1)}}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endif
            @if($transaction->getOption('late_fee'))
                <tr>
                    <td>{{$i}}</td>
                    <td style="width: 60%;" class="font-weight-bold">{{trans('finance.late_fee')}}</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{currency($transaction->getOption('late_fee'),1)}}</td>
                </tr>
            @endif
            <tr style="font-size: 14px;">
                <td></td>
                <td class="font-weight-bold">{{trans('finance.total_amount_received')}}</td>
                <td></td>
                <td></td>
                <td style="text-align: right;">{{currency($transaction->amount,1)}}</td>
            </tr>
        </tbody>
    </table>
    @if($transaction->payment_method_id)
        <table class="fancy-detail">
            <tr>
                <th style="text-align: center;">Pay Mode Information</th>
            </tr>
        </table>
        <p style="font-size: 12px; margin-left: 10px;">
            {{trans('finance.payment_method').': '.$transaction->paymentMethod->name}}
            @if($transaction->instrument_number){{trans('finance.instrument_number')}} <u>{{$transaction->instrument_number}} </u> @endif
            @if($transaction->instrument_date){{trans('finance.instrument_date')}} <u>{{showDate($transaction->instrument_date)}} </u> @endif
            @if($transaction->instrument_bank_detail){{trans('finance.instrument_bank_detail')}} <u>{{$transaction->instrument_bank_detail}} </u> @endif
            @if($transaction->instrument_clearing_date){{trans('finance.instrument_clearing_date')}} <u>{{showDate($transaction->instrument_clearing_date)}} </u> @endif
            @if($transaction->reference_number){{trans('finance.reference_number')}} <u>{{$transaction->reference_number}}</u> @endif
        </p>
    @else
        <p style="font-size: 12px; margin-left: 10px;">
            {{trans('finance.payment_method').': '.trans('finance.online_payment')}} ({{$transaction->reference_number}})
        </p>
    @endif
    <table class="fancy-detail" style="margin-top: 20px;">
        <tbody>
            <tr>
                <td>Total</td>
                <td style="text-align: right; font-weight: bold;">{{currency($transaction->amount,1)}}</td>
            </tr>
            <tr>
                <td  style="text-align: right; font-weight: bold;" colspan="2">{{currencyInWord($transaction->amount)}}</td>
            </tr>
        </tbody>
    </table>
    @include('print.print-layout.signatory')
    <div class="page-break"></div>
@endforeach