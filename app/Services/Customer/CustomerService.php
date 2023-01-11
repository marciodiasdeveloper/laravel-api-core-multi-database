<?php

namespace App\Services\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\SignUp\Job;
use App\Models\Customer\Subscription;
use App\Models\Customer\SignUp\Answer;

class CustomerService
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function checkEmailExists($email)
    {
        if ($this->customer->where('email', $email)->first()) {
            return true;
        }

        return false;
    }

    public function save($catalog, $data)
    {

        $customer = $this->customer->saveCustomer($catalog, $data);

        app(Job::class)->createCustomerSignUpJob($customer, $data);
        app(Answer::class)->createOrUpdateAnswers($customer, $data);
        app(Subscription::class)->createTrialSubscription($customer, $data);

        return $customer;
    }
}
