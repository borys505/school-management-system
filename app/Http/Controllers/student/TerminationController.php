<?php

namespace App\Http\Controllers\Student;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student\StudentRecord;
use App\Http\Requests\Student\TerminationRequest;
use App\Repositories\Student\TerminationRepository;
use App\Repositories\Student\StudentRecordRepository;

class TerminationController extends Controller
{
    protected $request;
    protected $repo;
    protected $student_record;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Request $request,
        TerminationRepository $repo,
        StudentRecordRepository $student_record
    ) {
        $this->request = $request;
        $this->repo = $repo;
        $this->student_record = $student_record;
    }

    /**
     * Used to get list of students who are terminated
     * @get ("/api/student/terminated")
     * @return Response
     */
    public function index()
    {
        $this->authorize('list', StudentRecord::class);

        $student_records = $this->repo->paginate($this->request->all());

        $filters = $this->repo->getFilters();

        return $this->success(compact('student_records', 'filters'));
    }

    /**
     * Used to print list of students who are terminated
     * @post ("/api/students/terminated/print")
     * @return Response
     */
    public function print()
    {
        $this->authorize('list', StudentRecord::class);

        $student_records = $this->repo->print(request('filter'));

        $filter = request('filter');

        return view('print.student.termination', compact('student_records', 'filter'))->render();
    }

    /**
     * Used to generate pdf of list of students who are terminated
     * @post ("/api/students/terminated/pdf")
     * @return Response
     */
    public function pdf()
    {
        $this->authorize('list', StudentRecord::class);

        $student_records = $this->repo->print(request('filter'));

        $filter = request('filter');

        $uuid = Str::uuid();
        $pdf = \PDF::loadView('print.student.termination', compact('student_records', 'filter'))->save('../storage/app/downloads/'.$uuid.'.pdf');

        return $uuid;
    }

    /**
     * Used to terminate student
     * @post ("/api/student/{uuid}/terminate/{record_id}")
     * @return Response
     */
    public function terminate(TerminationRequest $request, $uuid, $record_id)
    {
        $this->authorize('terminate', StudentRecord::class);

        $student_record = $this->student_record->findByUuidOrFail($uuid, $record_id);

        $this->repo->terminate($student_record, $this->request->all());

        return $this->success(['message' => trans('student.terminated')]);
    }
}
