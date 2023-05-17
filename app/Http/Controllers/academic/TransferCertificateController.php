<?php

namespace App\Http\Controllers\Academic;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Academic\TransferCertificate;
use App\Http\Requests\Academic\TransferCertificateRequest;
use App\Repositories\Academic\TransferCertificateRepository;

class TransferCertificateController extends Controller
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
        TransferCertificateRepository $repo
    ) {
        $this->request = $request;
        $this->repo = $repo;

        $this->middleware('academic.session.set');
    }

    /**
     * Used to get pre requisites
     * @get ("/api/transfer-certificate/pre-requisite")
     * @return Response
     */
    public function preRequisite()
    {
        return $this->success($this->repo->getPreRequisite());
    }

    /**
     * Used to get all Transfer Certificates
     * @get ("/api/transfer-certificate")
     * @return Response
     */
    public function index()
    {
        $this->authorize('list', TransferCertificate::class);

        $transfer_certificates = $this->repo->paginate($this->request->all());

        $filters = $this->repo->getFilters();

        return $this->success(compact('transfer_certificates', 'filters'));
    }

    /**
     * Used to print all Transfer Certificatess
     * @post ("/api/transfer-certificate/print")
     * @return Response
     */
    public function print()
    {
        $transfer_certificates = $this->repo->print(request('filter'));

        return view('print.academic.transfer-certificate', compact('transfer_certificates'))->render();
    }

    /**
     * Used to generate pdf all Transfer Certificatess
     * @post ("/api/transfer-certificate/pdf")
     * @return Response
     */
    public function pdf()
    {
        $transfer_certificates = $this->repo->print(request('filter'));

        $uuid = Str::uuid();
        $pdf = \PDF::loadView('print.academic.transfer-certificate', compact('transfer_certificates'))->save('../storage/app/downloads/'.$uuid.'.pdf');

        return $uuid;
    }

    /**
     * Used to store Transfer Certificate
     * @post ("/api/transfer-certificate")
     * @param ({
     *      @Parameter("student_record_id", type="integer", required="true", description="Id of Student Record"),
     * })
     * @return Response
     */
    public function store(TransferCertificateRequest $request)
    {
        $this->authorize('create', TransferCertificate::class);

        $transfer_certificate = $this->repo->create($this->request->all());

        return $this->success(['message' => trans('academic.transfer_certificate_added')]);
    }

    /**
     * Used to print Transfer Certificate detail
     * @get ("/academic/transfer-certificate/{uuid}/print")
     * @param ({
     *      @Parameter("uuid", type="string", required="true", description="Unique Id of Transfer Certificate"),
     * })
     * @return Response
     */
    public function printCertificate($uuid)
    {
        $this->authorize('list', TransferCertificate::class);

        $transfer_certificate = $this->repo->findByUuidOrFail($uuid);
        $print_options = array('no_border' => true, 'no_header' => true);

        return view('print.academic.selected-transfer-certificate',compact('transfer_certificate','print_options'));
    }

    /**
     * Used to get Transfer Certificate detail
     * @get ("/api/transfer-certificate/{uuid}")
     * @param ({
     *      @Parameter("uuid", type="string", required="true", description="Unique Id of Transfer Certificate"),
     * })
     * @return Response
     */
    public function show($uuid)
    {
        $this->authorize('list', TransferCertificate::class);

        $transfer_certificate = $this->repo->findByUuidOrFail($uuid);

        return $this->success(compact('transfer_certificate'));
    }

    /**
     * Used to update Transfer Certificate
     * @patch ("/api/transfer-certificate/{uuid}")
     * @param ({
     *      @Parameter("uuid", type="string", required="true", description="Unique Id of Transfer Certificate"),
     * })
     * @return Response
     */
    public function update($uuid, TransferCertificateRequest $request)
    {
        $this->authorize('update', TransferCertificate::class);

        $transfer_certificate = $this->repo->findByUuidOrFail($uuid);

        $transfer_certificate = $this->repo->update($transfer_certificate, $this->request->all());

        return $this->success(['message' => trans('academic.transfer_certificate_updated')]);
    }

    /**
     * Used to delete Transfer Certificate
     * @delete ("/api/transfer-certificate/{uuid}")
     * @param ({
     *      @Parameter("uuid", type="string", required="true", description="Unique Id of Transfer Certificate"),
     * })
     * @return Response
     */
    public function destroy($uuid)
    {
        $this->authorize('delete', TransferCertificate::class);

        $transfer_certificate = $this->repo->findByUuidOrFail($uuid);

        $this->repo->delete($transfer_certificate);

        return $this->success(['message' => trans('academic.transfer_certificate_deleted')]);
    }
}