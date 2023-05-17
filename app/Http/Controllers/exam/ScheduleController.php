<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Exam\Schedule;
use App\Http\Requests\Exam\ScheduleRequest;
use App\Repositories\Exam\ScheduleRepository;

class ScheduleController extends Controller
{
    protected $request;
    protected $repo;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Request $request,
        ScheduleRepository $repo
    ) {
        $this->request = $request;
        $this->repo = $repo;

        $this->middleware('academic.session.set');
    }

    /**
     * Used to get pre requisites
     * @get ("/api/exam/schedule/pre-requisite")
     * @return Response
     */
    public function preRequisite()
    {
        $this->authorize('preRequisite', Schedule::class);

        return $this->ok($this->repo->getPreRequisite());
    }

    /**
     * Used to get all Exam Schedules
     * @get ("/api/exam/schedule")
     * @return Response
     */
    public function index()
    {
        $this->authorize('list', Schedule::class);

        return $this->ok($this->repo->paginate($this->request->all()));
    }

    /**
     * Used to print all Exam Schedules
     * @post ("/api/exam/schedule/print")
     * @return Response
     */
    public function print()
    {
        $exam_schedules = $this->repo->print(request('filter'));

        return view('print.exam.schedule', compact('exam_schedules'))->render();
    }

    /**
     * Used to generate pdf all Exam Schedules
     * @post ("/api/exam/pdf")
     * @return Response
     */
    public function pdf()
    {
        $exam_schedules = $this->repo->print(request('filter'));

        $uuid = Str::uuid();
        $pdf = \PDF::loadView('print.exam.schedule', compact('exam_schedules'))->save('../storage/app/downloads/'.$uuid.'.pdf');

        return $uuid;
    }

    /**
     * Used to store Exam Schedule
     * @post ("/api/exam/schedule")
     * @param ({
     *      @Parameter("batch_id", type="integer", required="true", description="Id of Batch"),
     *      @Parameter("exam_id", type="integer", required="true", description="Id of Exam"),
     *      @Parameter("exam_grade_id", type="integer", required="true", description="Id of Exam Grade"),
     *      @Parameter("records", type="array", required="required", description="Array of Subjects")
     * })
     * @return Response
     */
    public function store(ScheduleRequest $request)
    {
        $this->authorize('create', Schedule::class);

        $exam = $this->repo->create($this->request->all());

        return $this->success(['message' => trans('exam.exam_added')]);
    }

    /**
     * Used to get Exam Schedule detail
     * @get ("/api/exam/schedule/{id}")
     * @param ({
     *      @Parameter("id", type="integer", required="true", description="Id of Exam Schedule"),
     * })
     * @return Response
     */
    public function show($id)
    {
        $this->authorize('list', Schedule::class);

        return $this->ok($this->repo->findOrFail($id));
    }

    /**
     * Used to update Exam Schedule
     * @patch ("/api/exam/schedule/{id}")
     * @param ({
     *      @Parameter("id", type="integer", required="true", description="Id of Exam Schedule"),
     *      @Parameter("batch_id", type="integer", required="true", description="Id of Batch"),
     *      @Parameter("exam_id", type="integer", required="true", description="Id of Exam"),
     *      @Parameter("exam_grade_id", type="integer", required="true", description="Id of Exam Grade"),
     *      @Parameter("records", type="array", required="required", description="Array of Subjects")
     * })
     * @return Response
     */
    public function update($id, ScheduleRequest $request)
    {
        $this->authorize('update', Schedule::class);

        $exam_schedule = $this->repo->findOrFail($id);

        $exam_schedule = $this->repo->update($exam_schedule, $this->request->all());

        return $this->success(['message' => trans('exam.schedule_updated')]);
    }

    /**
     * Used to delete Exam Schedule
     * @delete ("/api/exam/schedule/{id}")
     * @param ({
     *      @Parameter("id", type="integer", required="true", description="Id of Exam Schedule"),
     * })
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Schedule::class);

        $exam_schedule = $this->repo->deletable($id);

        $this->repo->delete($exam_schedule);

        return $this->success(['message' => trans('exam.schedule_deleted')]);
    }
}