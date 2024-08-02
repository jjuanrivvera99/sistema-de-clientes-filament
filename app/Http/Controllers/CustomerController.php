<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\View\View;
use App\Models\DocumentType;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = Customer::with('documentType')->get();

        return view('customers.index', compact('customers'));
    }

    public function create(Request $request): View
    {
        $documentTypes = DocumentType::all();

        return view('customers.create', compact('documentTypes'));
    }

    public function store(CustomerStoreRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $customer = Customer::create($request->validated());

            // Crear contactos si existen
            if ($request->has('contacts')) {
                foreach ($request->contacts as $contactData) {
                    $customer->contacts()->create($contactData);
                }
            }
        });

        return redirect()->route('customers.index')->with('success', 'Cliente creado con éxito.');
    }

    public function show(Request $request, Customer $customer): View
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Request $request, Customer $customer): View
    {
        $documentTypes = DocumentType::all();

        return view('customers.edit', compact('customer', 'documentTypes'));
    }

    public function update(CustomerUpdateRequest $request, Customer $customer): RedirectResponse
    {
        DB::transaction(function () use ($request, $customer) {
            $customer->update($request->validated());

            // Obtener los IDs de los contactos actuales
            $currentContactIds = $customer->contacts()->pluck('id')->toArray();

            // IDs de los contactos recibidos en la solicitud
            $receivedContactIds = array_filter(array_column($request->contacts, 'id'));

            // Eliminar contactos que ya no existen
            $contactsToDelete = array_diff($currentContactIds, $receivedContactIds);
            Contact::destroy($contactsToDelete);

            // Crear o actualizar contactos
            foreach ($request->contacts as $contactData) {
                if (isset($contactData['id'])) {
                    // Actualizar contacto existente
                    $contact = Contact::find($contactData['id']);
                    if ($contact) {
                        $contact->update($contactData);
                    }
                } else {
                    // Crear nuevo contacto
                    $customer->contacts()->create($contactData);
                }
            }
        });

        return redirect()->route('customers.index')->with('success', 'Cliente actualizado con éxito.');
    }

    public function destroy(Request $request, Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Cliente eliminado con éxito.');
    }
}
