@include('print.print-layout.tcheader')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table td {
        min-width: 65px;
    }
    .info-list {
        counter-reset: custom-counter;
        list-style: none;
    }
    .info-list li {
        margin: 0 0.5rem 0.5rem 0;
        counter-increment: custom-counter;
        position: relative;
        padding-left: 2px;
        --size: 17px;
        line-height: var(--size);
    }
    .info-list li::before {
        content: counter(custom-counter)'.';
        color: #000000;
        font-size: 1rem;
        position: absolute;
        --size: 20px;
        left: calc(-1 * var(--size));
        line-height: var(--size);
        min-width: 15px;
        height: var(--size);
        top: 0;
        background: transparent;
        text-align: center;
    }
    .heading {
        text-align: center;
        font-weight: bold;
        font-size: 1.10rem;
        position: relative;
        margin-bottom: 1rem;
    }
    .heading span{
        display: inline-block;
        margin: 0 auto;
        padding: 0.4rem 1.5rem;
        background: #e1e2e3;
        border: 2px solid;
    }
    .text-left {
        text-align: left;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .float-left {
        float: left;
    }
    .float-right {
        float: right;
    }
    .lv-group {
        display: flex;
    }
    .label {
        display: inline-block;
    }
    .value {
        display: inline-block;
        flex-grow: 1;
        border-bottom: 2px dotted #000000;
        margin-left: 0.5rem;
        font-weight: bold;
    }
    .min-width-1 {
        min-width: 1rem;
    }
    .min-width-2 {
        min-width: 2rem;
    }
    .min-width-3 {
        min-width: 3rem;
    }
    .min-width-4 {
        min-width: 4rem;
    }
    .min-width-5 {
        min-width: 2rem;
    }
</style>

    <table style="margin-top: 4cm; margin-left: 0.5cm; margin-right: 1cm;">
        <tr>
            <td colspan="12">
                <div class="heading"><span>TRANSFER CERTIFICATE</span></div>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <div class="lv-group">
                    <span class="label">{{trans('academic.transfer_certificate_sno')}}</span>
                    <span class="value">{{$transfer_certificate->number}}</span>
                </div>
            </td>
            <td colspan="4">
                <div class="lv-group">
                    <span class="label">&nbsp;</span>
                </div>
            </td>
            <td colspan="4">
                <div class="lv-group float-right">
                    <span class="label">{{trans('Admission No')}}</span>
                    <span class="value min-width-5">{{$transfer_certificate->studentRecord->admission->admission_number}}</span>
                </div>
            </td>
        </tr>
    </table>
    <br>

    <ol class="info-list" style="margin-left: 1cm; margin-right: 1cm.">
        <li>
            <table>
                <tr>
                    <td colspan="8">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_student_name')}}</span>
                            <span class="value">{{$transfer_certificate->studentRecord->student->name}}</span>
                        </div>
                    </td>
                    <td colspan="4">
                        <div class="lv-group">
                            <span class="label">{{trans('student.gender')}}</span>
                            <span class="value">{{ucwords($transfer_certificate->studentRecord->student->gender)}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>

        <li>
            <div class="lv-group">
                <span class="label">{{trans('academic.transfer_certificate_mother_name')}}</span>
                <span class="value">{{$transfer_certificate->studentRecord->student->parent->mother_name}}</span>
            </div>
        </li>

        <li>
            <div class="lv-group">
                <span class="label">{{trans('academic.transfer_certificate_father_name')}}</span>
                <span class="value">{{$transfer_certificate->studentRecord->student->parent->father_name}}</span>
            </div>
        </li>

        <li>
            <table>
                <tr>
                    <td colspan="4">
                        <div class="lv-group">
                            <span class="label">{{trans('student.nationality')}}</span>
                            <span class="value">{{$transfer_certificate->studentRecord->student->nationality}}</span>
                        </div>
                    </td>
                    <td colspan="4">
                        <div class="lv-group">
                            <span class="label">{{trans('misc.religion')}}</span>
                            <span class="value">{{optional($transfer_certificate->studentRecord->student->religion)->name}}</span>
                        </div>
                    </td>
                    <td colspan="4">
                        <div class="lv-group">
                            <span class="label">{{trans('misc.caste')}}</span>
                            <span class="value">{{optional($transfer_certificate->studentRecord->student->caste)->name}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>

        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('student.date_of_birth')}} (in figure)</span>
                            <span class="value">{{showDate($transfer_certificate->studentRecord->student->date_of_birth)}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        	<table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">(in words)</span>
                            <span class="value">{{$transfer_certificate->prefix}}
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_admission_in_class')}}</span>
                            <span class="value">{{showDate($transfer_certificate->studentRecord->admission->date_of_admission)}},&nbsp;&nbsp;&nbsp;&nbsp;{{$transfer_certificate->suffix}}
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_course')}}</span>
                            <span class="value">{{$transfer_certificate->studentRecord->batch->course->name}}&nbsp;&nbsp;&nbsp;&nbsp; (in words)&nbsp;&nbsp; {{$transfer_certificate->course_in_words}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_last_exam_with_result')}}</span>
                            <span class="value">{{$transfer_certificate->last_exam_with_result}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_is_last_exam_failed')}}</span>
                            <span class="value">{{$transfer_certificate->is_last_exam_failed}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_qualified_for_promotion')}}</span>
                            <span class="value">{{$transfer_certificate->qualified_for_promotion}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_subject_studied')}}</span>
                            <span class="value">{{$transfer_certificate->subject_studied}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        	<table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_third_language')}}</span>
                            <span class="value">{{$transfer_certificate->third_language}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_fee_paid_upto')}}</span>
                            <span class="value">{{$transfer_certificate->fee_paid_upto}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_working_days')}}</span>
                            <span class="value">{{$transfer_certificate->working_days}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_present_days')}}</span>
                            <span class="value">{{$transfer_certificate->present_days}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_cocurricular_activities')}}</span>
                            <span class="value">{{$transfer_certificate->cocurricular_activities}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_general_conduct')}}</span>
                            <span class="value">{{$transfer_certificate->general_conduct}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_date_of_application')}}</span>
                            <span class="value">{{showDate($transfer_certificate->date_of_application)}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_date_of_issue')}}</span>
                            <span class="value">{{showDate($transfer_certificate->date_of_issue)}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_reason')}}</span>
                            <span class="value">{{$transfer_certificate->reason}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_admission_in_institute')}}</span>
                            <span class="value">{{$transfer_certificate->admission_in_institute}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table>
                <tr>
                    <td colspan="12">
                        <div class="lv-group">
                            <span class="label">{{trans('academic.transfer_certificate_remarks')}}</span>
                            <span class="value">{{$transfer_certificate->remarks}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
    </ol>
    @include('print.print-layout.tcfooter')