<?php

namespace App\Actions\Customers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer as CustomerModel;

class Customer
{
    /**
     * Get all customers paginated by 10 each page
     */
    public static function retrieveAll()
    {
        return CustomerResource::collection(CustomerModel::paginate(10));
    }

    /**
     * Create new customer
     */
    public static function createCustomer($data)
    {
        $customer = CustomerModel::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);

        return $customer;
    }

    /**
     * Get customer by id
     */
    public static function retrieveById($id)
    {
        return new CustomerResource(CustomerModel::findOrFail($id));
    }

    /**
     * Update customer
     */
    public static function updateCustomer($data)
    {
        $customer = CustomerModel::findOrFail($data['id']);
        $customer->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);

        return $customer;
    }

    /**
     * Delete customer
     */
    public static function deleteCustomer($id)
    {
        $customer = CustomerModel::find($id);
        $customer->delete();

        return $customer;
    }
}
