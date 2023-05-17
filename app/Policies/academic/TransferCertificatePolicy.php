<?php

namespace App\Policies\Academic;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferCertificatePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can fetch certificates pre requisite
     *
     * @param  \App\User  $user
     * @param  \App\Models\Academic\TransferCertificate  $transfer_certificates
     * @return mixed
     */
    public function preRequisite(User $user)
    {
        return $user->can('create-transfer-certificate') || $user->can('edit-transfer-certificate');
    }

    /**
     * Determine whether the user can list all the certificates.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Academic\TransferCertificate  $transfer_certificates
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->can('list-transfer-certificate');
    }

    /**
     * Determine whether the user can create certificates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create-transfer-certificate');
    }

    /**
     * Determine whether the user can view the certificates.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Academic\TransferCertificate  $transfer_certificates
     * @return mixed
     */
    public function show(User $user)
    {
        return $user->can('list-transfer-certificate');
    }

    /**
     * Determine whether the user can update the certificates.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Academic\TransferCertificate  $transfer_certificates
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->can('edit-transfer-certificate');
    }

    /**
     * Determine whether the user can delete the certificates.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Academic\TransferCertificate  $transfer_certificates
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->can('delete-transfer-certificate');
    }
}
