<?php

namespace App\Http\Controllers;

use App\Actions\Customers\Customer;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'customers' => Customer::retrieveAll(),
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric',
            'address' => 'nullable',
        ]);

        // Call action to create customer
        Customer::createCustomer($attributes);

        return redirect()->route('dashboard')->with('message', 'Customer created successfully.');
    }

    public function edit(Request $request)
    {
        return Customer::retrieveById($request->id);
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric',
            'address' => 'nullable',
        ]);

        $attributes['id'] = $id;

        // Call action to update customer
        Customer::updateCustomer($attributes);

        return redirect()->route('dashboard')->with('message', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        Customer::deleteCustomer($id);

        return redirect()->route('dashboard')->with('message', 'Customer deleted successfully.');
    }
}
