<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Student\StudentParent;
use App\Http\Controllers\Controller;
use App\Repositories\Student\StudentParentRepository;

class StudentParentController extends Controller
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
        StudentParentRepository $repo
    ) {
        $this->request = $request;
        $this->repo = $repo;
    }

    /**
     * Used to search parent
     * @get ("/api/student/parent/search")
     * @return Response
     */
    public function search()
    {
        $this->authorize('search', StudentParent::class);

        return $this->ok($this->repo->searchByFatherMotherName($this->request->all()));
    }
}
