<?php
namespace App\Repositories\Academic;

use Illuminate\Support\Str;
use App\Models\Employee\Employee;
use App\Models\Academic\TransferCertificate;
use App\Models\Student\StudentRecord;
use Illuminate\Validation\ValidationException;

class TransferCertificateRepository
{
    protected $transfer_certificate;
    protected $student_record;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(
        TransferCertificate $transfer_certificate,
        StudentRecord $student_record
    ) {
        $this->transfer_certificate = $transfer_certificate;
        $this->student_record = $student_record;
    }

    /**
     * Get transfer certificate query
     *
     * @return Certificate query
     */
    public function getQuery()
    {
        return $this->transfer_certificate;
    }

    /**
     * Count Certificate
     *
     * @return integer
     */
    public function count()
    {
        return $this->transfer_certificate->filterBySession()->count();
    }

    /**
     * Get all transfer certificates
     *
     * @return array
     */
    public function getAll()
    {
        return $this->transfer_certificate->all();
    }

    /**
     * Find transfer certificate with given id.
     *
     * @param integer $id
     * @return Certificate
     */
    public function find($id)
    {
        return $this->transfer_certificate->info()->filterBySession()->filterById($id)->first();
    }

    /**
     * Find transfer certificate with given id or throw an error.
     *
     * @param integer $id
     * @return Certificate
     */
    public function findOrFail($id, $field = 'message')
    {
        $transfer_certificate = $this->transfer_certificate->info()->filterBySession()->filterById($id)->first();

        if (! $transfer_certificate) {
            throw ValidationException::withMessages([$field => trans('academic.could_not_find_transfer_certificate')]);
        }

        return $transfer_certificate;
    }

    /**
     * Find transfer certificate with given uuid.
     *
     * @param string $uuid
     * @return Certificate
     */
    public function findByUuid($uuid)
    {
        return $this->transfer_certificate->info()->filterBySession()->filterByUuid($uuid)->first();
    }

    /**
     * Find transfer certificate with given uuid or throw an error.
     *
     * @param string $uuid
     * @return Certificate
     */
    public function findByUuidOrFail($uuid, $field = 'message')
    {
        $transfer_certificate = $this->transfer_certificate->info()->filterBySession()->filterByUuid($uuid)->first();

        if (! $transfer_certificate) {
            throw ValidationException::withMessages([$field => trans('academic.could_not_find_transfer_certificate')]);
        }

        return $transfer_certificate;
    }

    /**
     * Get all filtered data
     *
     * @param array $params
     * @return Certificate
     */
    public function getData($params)
    {
        $sort_by                 = gv($params, 'sort_by', 'date_of_certificate');
        $order                   = gv($params, 'order', 'desc');

        $date_of_issue_start_date = gv($params, 'date_of_issue_start_date');
        $date_of_issue_end_date   = gv($params, 'date_of_issue_end_date');

        $query = $this->transfer_certificate->info()->filterBySession()->dateOfIssueBetween([
                'start_date' => $date_of_issue_start_date,
                'end_date' => $date_of_issue_end_date
            ]);

        return $query->orderBy($sort_by, $order);
    }

    /**
     * Paginate all transfer certificate using given params.
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($params)
    {
        $page_length = gv($params, 'page_length', config('config.page_length'));

        return $this->getData($params)->paginate($page_length);
    }

    /**
     * Get all filtered data for printing
     *
     * @param array $params
     * @return Certificate
     */
    public function print($params)
    {
        return $this->getData($params)->get();
    }

    /**
     * Get pre requisite
     *
     * @return Array
     */
    public function getPreRequisite()
    {
    }

    /**
     * Get course filters.
     *
     * @return Array
     */
    public function getFilters()
    {
        return $this->getPreRequisite();
    }

    /**
     * Create a new transfer certificate.
     *
     * @param array $params
     * @return TransferCertificate
     */
    public function create($params)
    {
        return $this->transfer_certificate->forceCreate($this->formatParams($params));
    }

    /**
     * Prepare given params for inserting into database.
     *
     * @param array $params
     * @param string $type
     * @return array
     */
    private function formatParams($params, $transfer_certificate_id = null)
    {
        $student_record_id = gv($params, 'student_record_id');

        if (! $student_record_id) {
            throw ValidationException::withMessages(['message' => trans('validation.required', ['attribute' => trans('student.student')])]);
        }

        $student_record = $this->student_record->filterbyId($student_record_id)->first();

        if (! $student_record) {
            throw ValidationException::withMessages(['message' => trans('student.could_not_find_student')]);
        }

        $formatted = $params;
        $formatted['options'] = [];

        if (! $transfer_certificate_id) {
            $formatted['uuid'] = Str::uuid();
        }

        return $formatted;
    }

    /**
     * Update given transfer certificate.
     *
     * @param TransferCertificate $transfer_certificate
     * @param array $params
     *
     * @return TransferCertificate
     */
    public function update(TransferCertificate $transfer_certificate, $params)
    {
        $transfer_certificate->forceFill($this->formatParams($params, $transfer_certificate->id))->save();

        return $transfer_certificate;
    }

    /**
     * Delete transfer certificate.
     *
     * @param integer $id
     * @return bool|null
     */
    public function delete(TransferCertificate $transfer_certificate)
    {
        return $transfer_certificate->delete();
    }

    /**
     * Delete multiple transfer certificate.
     *
     * @param array $ids
     * @return bool|null
     */
    public function deleteMultiple($ids)
    {
        return $this->transfer_certificate->whereIn('id', $ids)->delete();
    }
}