<?php
namespace App\Repositories\Finance\Fee;

use App\Jobs\SendCustomizedSMS;
use App\Traits\CollectionPaginator;
use App\Models\Finance\Fee\FeeGroup;
use App\Models\Student\StudentRecord;
use App\Models\Student\StudentFeeRecord;
use Illuminate\Validation\ValidationException;
use App\Models\Finance\Transaction\Transaction;
use App\Repositories\Configuration\Academic\CourseGroupRepository;

class ReportRepository
{
    use CollectionPaginator;

    protected $student_record;
    protected $course_group;
    protected $student_fee_record;
    protected $transaction;
    protected $fee_group;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(
        StudentRecord $student_record,
        CourseGroupRepository $course_group,
        StudentFeeRecord $student_fee_record,
        Transaction $transaction,
        FeeGroup $fee_group
    ) {
        $this->student_record = $student_record;
        $this->course_group = $course_group;
        $this->student_fee_record = $student_fee_record;
        $this->transaction = $transaction;
        $this->fee_group = $fee_group;
    }

    /**
     * Get report filters.
     *
     * @return Array
     */
    public function getFilters()
    {
        $batches = $this->course_group->getBatchOption();

        $fee_groups = $this->fee_group->filterBySession()->get(['name', 'id']);

        return compact('batches','fee_groups');
    }

    /**
     * Get fee summary data.
     *
     * @param array $params
     * @return Array
     */
    public function getFeeSummaryData($params)
    {
        $sort_by     = gv($params, 'sort_by', 'name');
        $order       = gv($params, 'order', 'asc');
        $first_name  = gv($params, 'first_name');
        $last_name   = gv($params, 'last_name');
        $min_balance = gv($params, 'min_balance', 0);
        $batch_id    = gv($params, 'batch_id');
        $batch_id    = is_array($batch_id) ? $batch_id : ($batch_id ? explode(',', $batch_id) : []);
        $ids         = gv($params, 'ids', []);

        if (! is_numeric($min_balance) || $min_balance < 0) {
            throw ValidationException::withMessages(['message' => trans('validation.numeric', ['attribute' => trans('finance.min_balance')])]);
        }

        $query = $this->student_record->select(['id','student_id','batch_id','admission_id'])->filterBySession()->with([
            'student:id,first_name,middle_name,last_name,contact_number,student_parent_id,uuid',
            'student.parent:id,father_name',
            'admission:id,number',
            'batch:id,name,course_id',
            'batch.course:id,name',
            'studentFeeRecords:id,student_record_id,fee_installment_id,fee_concession_id,transport_circle_id,status,late_fee_charged',
            'studentFeeRecords.feeInstallment:id,title,transport_fee_id',
            'studentFeeRecords.feeInstallment.feeInstallmentDetails:id,fee_installment_id,fee_head_id,amount,is_optional',
            'studentFeeRecords.feeInstallment.feeInstallmentDetails.feeHead:id,name',
            'studentFeeRecords.feeInstallment.transportFee:id,name',
            'studentFeeRecords.feeInstallment.transportFee.transportFeeDetails:id,transport_fee_id,transport_circle_id,amount',
            'studentFeeRecords.studentOptionalFeeRecords:id,student_fee_record_id,fee_head_id',
            'studentFeeRecords.feeConcession:id,name',
            'studentFeeRecords.feeConcession.feeConcessionDetails:id,fee_concession_id,fee_head_id,amount,type'
        ]);

        if (count($ids)) {
            $query->whereIn('id', $ids);
        }

        if (count($batch_id)) {
            $query->whereIn('batch_id', $batch_id);
        }

        if ($first_name) {
            $query->whereHas('student', function($q) use($first_name) {
                $q->where('first_name', 'like', '%'.$first_name.'%');
            });
        }

        if ($last_name) {
            $query->whereHas('student', function($q) use($last_name) {
                $q->where('last_name', 'like', '%'.$last_name.'%');
            });
        }

        $student_records = $query->get();

        $list = array();
        $footer = array();

        $grand_total = 0;
        $grand_balance = 0;
        $grand_late = 0;
        $grand_paid = 0;
        $grand_concession = 0;

        foreach ($student_records as $student_record) {
            $total = 0;
            $paid = 0;
            $late = 0;
            $balance = 0;
            $concession = 0;

            foreach ($student_record->studentFeeRecords as $student_fee_record) {
                $fee_installment = $student_fee_record->feeInstallment;

                $installment = 0;
                $transport = 0;
                $total_installment = 0;

                foreach ($fee_installment->feeInstallmentDetails as $fee_installment_detail) {

                    $optional = $student_fee_record->studentOptionalFeeRecords->firstWhere('fee_head_id', $fee_installment_detail->fee_head_id);

                    $fee_concession = ($student_fee_record->fee_concession_id) ?  $student_fee_record->feeConcession->feeConcessionDetails->firstWhere('fee_head_id', $fee_installment_detail->fee_head_id) : null;

                    $amount = (! $optional) ? $fee_installment_detail->amount : 0;

                    if ($fee_concession && $amount > 0) {
                        $type = $fee_concession->type;
                        $fee_concession_amount = $fee_concession->amount;
                        $concession_amount = ($type == 'percent') ? round(($amount * ($fee_concession_amount / 100))) : round($fee_concession_amount);
                        $concession += $concession_amount;
                        $amount = $amount - $concession_amount;
                    }

                    $installment += $amount;
                }

                $transport_fee = ($student_fee_record->transport_circle_id && $fee_installment->transport_fee_id) ? $fee_installment->transportFee->transportFeeDetails->firstWhere('transport_circle_id', $student_fee_record->transport_circle_id) : null;
                $transport  = ($transport_fee) ? $transport_fee->amount : 0;

                $total_installment = $installment + $transport + $student_fee_record->late_fee_charged;
                $total += $total_installment;

                if ($student_fee_record->status == 'cancelled') {
                    $total -= $total_installment;
                }

                if ($student_fee_record->status == 'paid') {
                    $paid += $total_installment;
                }

                $balance = $total - $paid;

                $late += $student_fee_record->late_fee_charged;
            }

            $list[] = array(
                'uuid'             => $student_record->student->uuid,
                'id'               => $student_record->id,
                'name'             => $student_record->student->name,
                'batch'            => $student_record->batch->course->name.' '.$student_record->batch->name,
                'father_name'      => $student_record->student->parent->father_name,
                'contact_number'   => $student_record->student->contact_number,
                'admission_number' => $student_record->admission->number,
                'total'            => $total,
                'concession'       => $concession,
                'paid'             => $paid,
                'balance'          => $balance,
                'late'             => $late
            );

            $grand_total += $total;
            $grand_balance += $balance;
            $grand_paid += $paid;
            $grand_late += $late;
            $grand_concession += $concession;
        }

        $list = array_filter($list, function($element) use($min_balance) {
            return $element['balance'] > $min_balance;
        });

        array_multisort(array_map(function($element) use($sort_by) {
              return $element[$sort_by];
        }, $list), $order == 'asc' ? SORT_ASC : SORT_DESC, $list);

        $footer = array(
            'grand_total'      => $grand_total,
            'grand_balance'    => $grand_balance,
            'grand_late'       => $grand_late,
            'grand_paid'       => $grand_paid,
            'grand_concession' => $grand_concession
        );

        return compact('list','footer');
    }

    /**
     * Get summary of all student's fee
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateFeeSummary($params)
    {
        $page = gv($params, 'page', 1);
        $page_length = gv($params, 'page_length', config('config.page_length'));

        $data = $this->getFeeSummaryData($params);

        $list = $data['list'];
        $footer = $data['footer'];

        $list = $this->collectionPaginate($list, $page_length, $page);

        return compact('list','footer');
    }

    /**
     * Get all filtered data for printing
     *
     * @param array $params
     * @return Array
     */
    public function printFeeSummary($params)
    {
        $data = $this->getFeeSummaryData($params);
        
        $list = $data['list'];
        $footer = $data['footer'];

        return compact('list','footer');
    }

    /**
     * Send fee summary via SMS
     *
     * @param array $params
     * @return null
     */
    public function smsSummary($params)
    {
        $filter        = gv($params, 'filter', []);
        $filter['ids'] = gv($params, 'ids', []);
        $sms           = gv($params, 'sms');
        $records       = $this->getFeeSummaryData($filter);

        $data = array();
        foreach ($records['list'] as $record) {
            $new_sms = $sms;
            $new_sms = str_replace('#NAME#', gv($record, 'name'), $new_sms);
            $new_sms = str_replace('#BATCH#', gv($record, 'batch'), $new_sms);
            $new_sms = str_replace('#FATHER_NAME#', gv($record, 'father_name'), $new_sms);
            $new_sms = str_replace('#LATE_FEE#', gv($record, 'late'), $new_sms);
            $new_sms = str_replace('#TOTAL_FEE#', gv($record, 'total'), $new_sms);
            $new_sms = str_replace('#PAID_FEE#', gv($record, 'paid'), $new_sms);
            $new_sms = str_replace('#BALANCE_FEE#', gv($record, 'balance'), $new_sms);

            $data[] = array('to' => gv($record, 'contact_number'), 'sms' => $new_sms);
        }

        $collection = collect($data);

        foreach ($collection->chunk(config('config.max_sms_per_chunk')) as $chunk) {
            SendCustomizedSMS::dispatch($chunk);
        }
    }

    /**
     * Get fee concession data.
     *
     * @param array $params
     * @return Array
     */
    public function getFeeConcessionData($params)
    {
        $sort_by     = gv($params, 'sort_by', 'name');
        $order       = gv($params, 'order', 'asc');
        $first_name  = gv($params, 'first_name');
        $last_name   = gv($params, 'last_name');
        $batch_id    = gv($params, 'batch_id');
        $batch_id    = is_array($batch_id) ? $batch_id : ($batch_id ? explode(',', $batch_id) : []);
        $ids         = gv($params, 'ids', []);

        $query = $this->student_record->select(['id','student_id','batch_id','admission_id'])->filterBySession()->with([
            'student:id,first_name,middle_name,last_name,contact_number,student_parent_id,uuid',
            'student.parent:id,father_name',
            'admission:id,number',
            'batch:id,name,course_id',
            'batch.course:id,name',
            'studentFeeRecords:id,student_record_id,fee_installment_id,fee_concession_id,transport_circle_id,status,late_fee_charged',
            'studentFeeRecords.feeInstallment:id,title,fee_allocation_group_id',
            'studentFeeRecords.feeInstallment.feeInstallmentDetails',
            'studentFeeRecords.feeInstallment.feeAllocationGroup:id,fee_group_id',
            'studentFeeRecords.feeInstallment.feeAllocationGroup.feeGroup:id,name',
            'studentFeeRecords.feeConcession:id,name',
            'studentFeeRecords.feeConcession.feeConcessionDetails:id,fee_concession_id,fee_head_id,amount,type',
            'studentFeeRecords.feeConcession.feeConcessionDetails.feeHead'
        ]);

        if (count($ids)) {
            $query->whereIn('id', $ids);
        }

        if (count($batch_id)) {
            $query->whereIn('batch_id', $batch_id);
        }

        if ($first_name) {
            $query->whereHas('student', function($q) use($first_name) {
                $q->where('first_name', 'like', '%'.$first_name.'%');
            });
        }

        if ($last_name) {
            $query->whereHas('student', function($q) use($last_name) {
                $q->where('last_name', 'like', '%'.$last_name.'%');
            });
        }

        $student_records = $query->get();

        $list = array();
        $footer = array();

        foreach ($student_records as $student_record) {
            $concession = array();

            $student_fee_records = $student_record->studentFeeRecords;

            foreach ($student_fee_records as $student_fee_record) {
                $concession = array();
                if ($student_fee_record && $student_fee_record->fee_concession_id) {
                    foreach ($student_fee_record->feeConcession->feeConcessionDetails as $fee_concession_detail) {
                        $fee_installment_details = $student_fee_record->feeInstallment->feeInstallmentDetails;
                        $fee_installment_detail = $fee_installment_details->firstWhere('fee_head_id', $fee_concession_detail->fee_head_id);
                        $amount = $fee_installment_detail ? $fee_installment_detail->amount : 0;

                        if ($amount) {
                            if ($fee_concession_detail->type == 'percent') {
                                // $amount -= ($amount * $fee_concession_detail->amount/100);
                                $amount = ($amount * $fee_concession_detail->amount/100);
                            } else {
                                $amount = $fee_concession_detail->amount;
                                // $amount -= $fee_concession_detail->amount;
                            }

                            if ($amount)
                            $concession[] = array(
                                'name' => $fee_concession_detail->feeHead->name,
                                'value' => currency($amount, 1)
                            );
                        }
                    }

                    if ($concession)
                        $list[] = array(
                            'uuid'             => $student_record->student->uuid,
                            'id'               => $student_record->id,
                            'name'             => $student_record->student->name,
                            'batch'            => $student_record->batch->course->name.' '.$student_record->batch->name,
                            'father_name'      => $student_record->student->parent->father_name,
                            'contact_number'   => $student_record->student->contact_number,
                            'admission_number' => $student_record->admission->number,
                            'fee_installment'  => $student_fee_record->feeInstallment->title.' ('.$student_fee_record->feeInstallment->feeAllocationGroup->feeGroup->name.')',
                            'concession'       => $concession,
                        );
                }
            }
        }

        array_multisort(array_map(function($element) use($sort_by) {
              return $element[$sort_by];
        }, $list), $order == 'asc' ? SORT_ASC : SORT_DESC, $list);

        $footer = array();

        return compact('list','footer');
    }

    /**
     * Get concession of all student's fee
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateFeeConcession($params)
    {
        $page = gv($params, 'page', 1);
        $page_length = gv($params, 'page_length', config('config.page_length'));

        $data = $this->getFeeConcessionData($params);

        $list = $data['list'];
        $footer = $data['footer'];

        $list = $this->collectionPaginate($list, $page_length, $page);

        return compact('list','footer');
    }

    /**
     * Get all filtered data for printing
     *
     * @param array $params
     * @return Array
     */
    public function printFeeConcession($params)
    {
        $data = $this->getFeeConcessionData($params);
        
        $list = $data['list'];
        $footer = $data['footer'];

        return compact('list','footer');
    }

    /**
     * Get fee due data.
     *
     * @param array $params
     * @return Array
     */
    public function getFeeDueData($params)
    {
        $sort_by      = gv($params, 'sort_by', 'name');
        $order        = gv($params, 'order', 'asc');
        $first_name   = gv($params, 'first_name');
        $last_name    = gv($params, 'last_name');
        $min          = gv($params, 'min', 0);
        $batch_id     = gv($params, 'batch_id');
        $batch_id     = is_array($batch_id) ? $batch_id : ($batch_id ? explode(',', $batch_id) : []);
        $fee_group_id = gv($params, 'fee_group_id');
        $fee_group_id = is_array($fee_group_id) ? $fee_group_id : ($fee_group_id ? explode(',', $fee_group_id) : []);
        $ids          = gv($params, 'ids', []);

        if (! is_numeric($min) || $min < 0) {
            throw ValidationException::withMessages(['message' => trans('validation.numeric', ['attribute' => trans('finance.amount')])]);
        }

        $query = $this->student_fee_record->filterByStatus('unpaid')->whereHas('studentRecord', function($q) {
            $q->filterBySession();
        })->select(['id','student_record_id','fee_installment_id','fee_concession_id','transport_circle_id','status','late_fee_charged','due_date','late_fee_applicable','late_fee_frequency','late_fee'])->with([
            'studentRecord:id,student_id,batch_id,admission_id',
            'studentRecord.student:id,uuid,student_parent_id,first_name,middle_name,last_name,contact_number',
            'studentRecord.student.parent:id,father_name',
            'studentRecord.admission:id,number',
            'studentRecord.batch:id,name,course_id',
            'studentRecord.batch.course:id,name',
            'feeInstallment:id,fee_allocation_group_id,title,transport_fee_id,due_date,late_fee_applicable,late_fee_frequency,late_fee',
            'feeInstallment.feeAllocationGroup:id,fee_group_id',
            'feeInstallment.feeAllocationGroup.feeGroup:id,name',
            'feeInstallment.feeInstallmentDetails:id,fee_installment_id,fee_head_id,amount,is_optional',
            'feeInstallment.feeInstallmentDetails.feeHead:id,name',
            'feeInstallment.transportFee:id,name',
            'feeInstallment.transportFee.transportFeeDetails:id,transport_fee_id,transport_circle_id,amount',
            'studentOptionalFeeRecords:id,student_fee_record_id,fee_head_id',
            'feeConcession:id,name',
            'feeConcession.feeConcessionDetails:id,fee_concession_id,fee_head_id,amount,type'
        ])->where(function($q) {
            $q->where(function($q1) {
                $q1->whereNotNull('due_date')->where('due_date','<', date('Y-m-d'));
            })->orWhere(function($q2) {
                $q2->whereNull('due_date')->whereHas('feeInstallment', function($q3) {
                    $q3->where('due_date','<',date('Y-m-d'));
                });
            });
        });

        if (count($ids)) {
            $query->whereIn('id', $ids);
        }

        if (count($batch_id)) {
            $query->whereHas('studentRecord', function($q) use($batch_id) {
                $q->whereIn('batch_id', $batch_id);
            });
        }

        if (count($fee_group_id)) {
            $query->whereHas('feeInstallment', function($q) use($fee_group_id) {
                $q->whereHas('feeAllocationGroup', function($q1) use($fee_group_id) {
                    $q1->whereIn('fee_group_id', $fee_group_id);
                });
            });
        }

        if ($first_name) {
            $query->whereHas('studentRecord', function($q) use($first_name) {
                $q->whereHas('student', function($q1) use($first_name) {
                    $q1->where('first_name', 'like', '%'.$first_name.'%');
                });
            });
        }

        if ($last_name) {
            $query->whereHas('studentRecord', function($q) use($last_name) {
                $q->whereHas('student', function($q1) use($last_name) {
                    $q1->where('last_name', 'like', '%'.$last_name.'%');
                });
            });
        }

        $student_fee_records = $query->get();

        $list = array();
        $footer = array();

        $grand_total = 0;

        foreach ($student_fee_records as $student_fee_record) {
            $fee_installment = $student_fee_record->feeInstallment;

            $installment = 0;
            $transport = 0;
            $total_installment = 0;

            foreach ($fee_installment->feeInstallmentDetails as $fee_installment_detail) {

                $optional = $student_fee_record->studentOptionalFeeRecords->firstWhere('fee_head_id', $fee_installment_detail->fee_head_id);

                $fee_concession = ($student_fee_record->fee_concession_id) ?  $student_fee_record->feeConcession->feeConcessionDetails->firstWhere('fee_head_id', $fee_installment_detail->fee_head_id) : null;

                $amount = (! $optional) ? $fee_installment_detail->amount : 0;

                if ($fee_concession && $amount > 0) {
                    $type = $fee_concession->type;
                    $fee_concession_amount = $fee_concession->amount;
                    $amount = ($type == 'percent') ? round($amount - ($amount * ($fee_concession_amount / 100))) : round($amount - $fee_concession_amount);
                }

                $installment += $amount;
            }

            $transport_fee = ($student_fee_record->transport_circle_id && $fee_installment->transport_fee_id) ? $fee_installment->transportFee->transportFeeDetails->firstWhere('transport_circle_id', $student_fee_record->transport_circle_id) : null;
            $transport  = ($transport_fee) ? $transport_fee->amount : 0;

            $total_installment = $installment + $transport;

            $due_date = $student_fee_record->due_date ? : $student_fee_record->feeInstallment->due_date;

            $late_fee = 0;
            $late_days = dateDiff($due_date, date('Y-m-d'));
            if (($student_fee_record->late_fee_applicable == null && $student_fee_record->feeInstallment->late_fee_applicable) || $student_fee_record->late_fee_applicable) {

                $late_fee_frequency = $student_fee_record->late_fee_frequency ? : $student_fee_record->feeInstallment->late_fee_frequency;

                if ($late_fee_frequency === 500) {
                    if ($late_days < 10) {
                        $late_fee = 20;
                    } else {
                        $late_fee = 50;
                    }
                } else {
                    $per_period = floor($late_days / ($late_fee_frequency));
                    $late_fee = ($student_fee_record->late_fee ? : $student_fee_record->feeInstallment->late_fee) * $per_period;
                }

                // $late_fee_frequency = getLateFeeFrequenciesInWord($student_fee_record->late_fee_frequency ? : $student_fee_record->feeInstallment->late_fee_frequency);
                // $late_fee = currency($student_fee_record->late_fee ? : $student_fee_record->feeInstallment->late_fee,1).' /'.$late_fee_frequency;
            }

            $list[] = array(
                'id'                => $student_fee_record->id,
                'uuid'              => $student_fee_record->studentRecord->student->uuid,
                'student_record_id' => $student_fee_record->studentRecord->id,
                'name'              => $student_fee_record->studentRecord->student->name,
                'batch'             => $student_fee_record->studentRecord->batch->course->name.' '.$student_fee_record->studentRecord->batch->name,
                'father_name'       => $student_fee_record->studentRecord->student->parent->father_name,
                'contact_number'    => $student_fee_record->studentRecord->student->contact_number,
                'admission_number'  => $student_fee_record->studentRecord->admission->number,
                'fee_group'         => $student_fee_record->feeInstallment->feeAllocationGroup->feeGroup->name,
                'total'             => $total_installment,
                'due_date'          => $due_date,
                'overdue'           => dateDiff($due_date, date('Y-m-d')),
                'late_fee'          => $late_fee
            );

            $grand_total += $total_installment;
        }

        $list = array_filter($list, function($element) use($min) {
            return $element['total'] > $min;
        });

        array_multisort(array_map(function($element) use($sort_by) {
              return $element[$sort_by];
        }, $list), $order == 'asc' ? SORT_ASC : SORT_DESC, $list);

        $footer = array(
            'grand_total'   => $grand_total
        );

        return compact('list','footer');
    }

    /**
     * Get of all student's fee due
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateFeeDue($params)
    {
        $page = gv($params, 'page', 1);
        $page_length = gv($params, 'page_length', config('config.page_length'));

        $data = $this->getFeeDueData($params);

        $list = $data['list'];
        $footer = $data['footer'];

        $list = $this->collectionPaginate($list, $page_length, $page);

        return compact('list','footer');
    }

    /**
     * Get all filtered data for printing
     *
     * @param array $params
     * @return Array
     */
    public function printFeeDue($params)
    {
        $data = $this->getFeeDueData($params);
        
        $list = $data['list'];
        $footer = $data['footer'];

        return compact('list','footer');
    }

    /**
     * Send fee due via SMS
     *
     * @param array $params
     * @return null
     */
    public function smsDue($params)
    {
        $filter        = gv($params, 'filter', []);
        $filter['ids'] = gv($params, 'ids', []);
        $sms           = gv($params, 'sms');
        $records       = $this->getFeeDueData($filter);

        $data = array();
        foreach ($records['list'] as $record) {
            $new_sms = $sms;
            $new_sms = str_replace('#NAME#', gv($record, 'name'), $new_sms);
            $new_sms = str_replace('#BATCH#', gv($record, 'batch'), $new_sms);
            $new_sms = str_replace('#FATHER_NAME#', gv($record, 'father_name'), $new_sms);
            $new_sms = str_replace('#FEE_GROUP#', gv($record, 'fee_group'), $new_sms);
            $new_sms = str_replace('#TOTAL_FEE#', gv($record, 'total'), $new_sms);
            $new_sms = str_replace('#DUE_DATE#', gv($record, 'due_date'), $new_sms);
            $new_sms = str_replace('#OVERDUE#', gv($record, 'overdue'), $new_sms);
            $new_sms = str_replace('#LATE_FEE#', gv($record, 'late_fee'), $new_sms);

            $data[] = array('to' => gv($record, 'contact_number'), 'sms' => $new_sms);
        }

        $collection = collect($data);

        foreach ($collection->chunk(config('config.max_sms_per_chunk')) as $chunk) {
            SendCustomizedSMS::dispatch($chunk);
        }
    }

    /**
     * Get fee payment data.
     *
     * @param array $params
     * @return Array
     */
    public function getFeePaymentData($params)
    {
        $sort_by           = gv($params, 'sort_by', 'date');
        $order             = gv($params, 'order', 'desc');
        $first_name        = gv($params, 'first_name');
        $last_name         = gv($params, 'last_name');
        $reference_number  = gv($params, 'reference_number');
        $instrument_number = gv($params, 'instrument_number');
        $is_online_payment = gbv($params, 'is_online_payment');
        $is_cancelled      = gbv($params, 'is_cancelled');
        $batch_id          = gv($params, 'batch_id');
        $batch_id          = is_array($batch_id) ? $batch_id : ($batch_id ? explode(',', $batch_id) : []);
        $start_date        = gv($params, 'start_date');
        $end_date          = gv($params, 'end_date');
        $ids               = gv($params, 'ids', []);

        $query = $this->transaction->with([
                'account:id,name',
                'paymentMethod:id,name',
                'studentFeeRecord:id,student_record_id,fee_installment_id',
                'studentFeeRecord.feeInstallment:id,title',
                'studentFeeRecord.studentRecord:id,student_id,batch_id,admission_id',
                'studentFeeRecord.studentRecord.batch:id,name,course_id',
                'studentFeeRecord.studentRecord.batch.course:id,name',
                'studentFeeRecord.studentRecord.student:id,uuid,student_parent_id,first_name,middle_name,last_name,contact_number',
                'studentFeeRecord.studentRecord.student.parent:id,father_name',
                'studentFeeRecord.studentRecord.admission:id,number',
            ])->select(['id','prefix','number','student_fee_record_id','payment_method_id','account_id','amount','date','is_online_payment','source','reference_number'])->filterBySession()->whereNotNull('student_fee_record_id')->filterByHead('fee')->dateBetween([
                'start_date' => $start_date,
                'end_date' => $end_date
            ])->filterByReferenceNumber($reference_number)->filterByInstrumentNumber($instrument_number);

        if (count($ids)) {
            $query->whereIn('id', $ids);
        }

        if ($is_online_payment) {
            $query->whereIsOnlinePayment(1);
        }

        if ($is_cancelled) {
            $query->whereIsCancelled(1);
        } else {
            $query->whereIsCancelled(0);
        }

        if (count($batch_id)) {
            $query->whereHas('studentFeeRecord', function($q) use($batch_id) {
                $q->whereHas('studentRecord', function($q1) use($batch_id) {
                    $q1->whereIn('batch_id', $batch_id);
                });
            });
        }

        if ($first_name) {
            $query->whereHas('studentFeeRecord', function($q) use($first_name) {
                $q->whereHas('studentRecord', function($q1) use($first_name) {
                    $q1->whereHas('student', function($q2) use($first_name) {
                        $q2->where('first_name', 'like', '%'.$first_name.'%');
                    });
                });
            });
        }

        if ($last_name) {
            $query->whereHas('studentFeeRecord', function($q) use($last_name) {
                $q->whereHas('studentRecord', function($q1) use($last_name) {
                    $q1->whereHas('student', function($q2) use($last_name) {
                        $q2->where('last_name', 'like', '%'.$last_name.'%');
                    });
                });
            });
        }

        $transactions = $query->get();

        $list = array();
        $footer = array();

        $grand_total = 0;

        foreach ($transactions as $transaction) {
            $list[] = array(
                'id'                    => $transaction->id,
                'uuid'                  => $transaction->studentFeeRecord->studentRecord->student->uuid,
                'student_record_id'     => $transaction->studentFeeRecord->studentRecord->id,
                'student_fee_record_id' => $transaction->studentFeeRecord->id,
                'receipt_no'            => $transaction->prefix.$transaction->number,
                'name'                  => $transaction->studentFeeRecord->studentRecord->student->name,
                'batch'                 => $transaction->studentFeeRecord->studentRecord->batch->course->name.' '.$transaction->studentFeeRecord->studentRecord->batch->name,
                'father_name'           => $transaction->studentFeeRecord->studentRecord->student->parent->father_name,
                'contact_number'        => $transaction->studentFeeRecord->studentRecord->student->contact_number,
                'admission_number'      => $transaction->studentFeeRecord->studentRecord->admission->number,
                'fee_installment'       => $transaction->studentFeeRecord->feeInstallment->title,
                'amount'                => currency($transaction->amount),
                'date'                  => $transaction->date,
                'payment_method'        => $transaction->is_online_payment ? ($transaction->source.' ('.$transaction->reference_number.')') : ($transaction->payment_method_id ? $transaction->paymentMethod->name : '-'),
                'account'               => $transaction->account_id ? $transaction->account->name : '-'
            );
            $grand_total += $transaction->amount;
        }

        array_multisort(array_map(function($element) use($sort_by) {
              return $element[$sort_by];
        }, $list), $order == 'asc' ? SORT_ASC : SORT_DESC, $list);

        $footer = array(
            'grand_total'   => $grand_total
        );

        return compact('list','footer');
    }

    /**
     * Get of all student's fee payment
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateFeePayment($params)
    {
        $page = gv($params, 'page', 1);
        $page_length = gv($params, 'page_length', config('config.page_length'));

        $data = $this->getFeePaymentData($params);

        $list = $data['list'];
        $footer = $data['footer'];

        $list = $this->collectionPaginate($list, $page_length, $page);

        return compact('list','footer');
    }

    /**
     * Get all filtered data for printing
     *
     * @param array $params
     * @return Array
     */
    public function printFeePayment($params)
    {
        $data = $this->getFeePaymentData($params);
        
        $list = $data['list'];
        $footer = $data['footer'];

        return compact('list','footer');
    }

    /**
     * Send fee payment via SMS
     *
     * @param array $params
     * @return null
     */
    public function smsPayment($params)
    {
        $filter        = gv($params, 'filter', []);
        $filter['ids'] = gv($params, 'ids', []);
        $sms           = gv($params, 'sms');
        $records       = $this->getFeePaymentData($filter);

        $data = array();
        foreach ($records['list'] as $record) {
            $new_sms = $sms;
            $new_sms = str_replace('#NAME#', gv($record, 'name'), $new_sms);
            $new_sms = str_replace('#BATCH#', gv($record, 'batch'), $new_sms);
            $new_sms = str_replace('#FATHER_NAME#', gv($record, 'father_name'), $new_sms);
            $new_sms = str_replace('#RECEIPT_NO#', gv($record, 'receipt_no'), $new_sms);
            $new_sms = str_replace('#AMOUNT#', gv($record, 'amount'), $new_sms);
            $new_sms = str_replace('#DATE#', gv($record, 'date'), $new_sms);
            $new_sms = str_replace('#PAYMENT_METHOD#', gv($record, 'payment_method'), $new_sms);

            $data[] = array('to' => gv($record, 'contact_number'), 'sms' => $new_sms);
        }

        $collection = collect($data);

        foreach ($collection->chunk(config('config.max_sms_per_chunk')) as $chunk) {
            SendCustomizedSMS::dispatch($chunk);
        }
    }
}