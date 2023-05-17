<?php

namespace App\Repositories\Student;

use Illuminate\Support\Str;
use App\Models\Student\StudentParent;
use Illuminate\Validation\ValidationException;

class StudentParentRepository
{
    protected $student_parent;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(
        StudentParent $student_parent
    ) {
        $this->student_parent = $student_parent;
    }

    /**
     * Get parent query
     *
     * @return StudentParent query
     */
    public function getQuery()
    {
        return $this->student_parent;
    }

    /**
     * Count parent
     *
     * @return integer
     */
    public function count()
    {
        return $this->student_parent->count();
    }

    /**
     * List all parents by id
     *
     * @return array
     */
    public function listId()
    {
        return $this->student_parent->all()->pluck('id')->all();
    }

    /**
     * Get all parents
     *
     * @return array
     */
    public function getAll()
    {
        return $this->student_parent->all();
    }

    /**
     * Find parent with given id.
     *
     * @param integer $id
     * @return StudentParent
     */
    public function find($id)
    {
        return $this->student_parent->find($id);
    }

    /**
     * Find parent with given id or throw an error.
     *
     * @param integer $id
     * @return StudentParent
     */
    public function findOrFail($id, $field = 'message')
    {
        $student_parent = $this->student_parent->find($id);

        if (! $student_parent) {
            throw ValidationException::withMessages([$field => trans('student.could_not_find_parent')]);
        }

        return $student_parent;
    }

    /**
     * Search parent by father name or mother name
     *
     * @param integer $id
     * @return StudentParent
     */
    public function searchByFatherMotherName($params = array())
    {
        $page_length = gv($params, 'page_length', config('config.page_length'));
        $query = gv($params, 'query');

        if (! $query) {
            throw ValidationException::withMessages(['message' => trans('student.parent_search_query_required')]);
        }

        return $this->student_parent->where('father_name', 'like', '%'.$query.'%')->orWhere('mother_name', 'like', '%'.$query.'%')->paginate($page_length);
    }

    /**
     * Create a new parent.
     *
     * @param array $params
     * @return StudentParent
     */
    public function create($params)
    {
        $this->validateInput($params);

        return $this->student_parent->forceCreate($this->formatParams($params));
    }

    /**
     * Validate all input.
     *
     * @param array $params
     */
    public function validateInput($params = array(), $id = null)
    {
        $father_name             = gv($params, 'father_name');
        $mother_name             = gv($params, 'mother_name');
        $father_contact_number_1 = gv($params, 'father_contact_number_1');

        $parent_exists = ($id) ? $this->student_parent->where('id', '!=', $id) : $this->student_parent->whereNotNull('id');

        if ($parent_exists->filterByFatherName($father_name, 1)->filterByMotherName($mother_name, 1)->filterByFatherContactNumber1($father_contact_number_1)->count()) {
            throw ValidationException::withMessages(['message' => trans('student.parent_exists')]);
        }
    }

    /**
     * Prepare given params for inserting into database.
     *
     * @param array $params
     * @return array
     */
    private function formatParams($params)
    {
        $formatted = [
            'father_name'             => gv($params, 'father_name'),
            'mother_name'             => gv($params, 'mother_name'),
            'father_contact_number_1' => gv($params, 'father_contact_number_1'),
            'options'                 => array()
        ];

        return $formatted;
    }
}
