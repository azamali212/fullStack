<?php
namespace App\Repositories\HospitalRegistrationUserRepo;

interface HospitalRegistrationUserRepositoryInterface
{
    /**
     * Get all hospital registration users
     */
    public function getAllHRU($request);

    /**
     * Register a new hospital registration user
     */
    public function registerHospitalRegistrationUser($request);

    /**
     * Login a hospital registration user
     */
    public function loginHospitalRegistrationUser($request);

    public function verifyEmail($email,$verificationCode);

    public function logoutUser($request);
}
