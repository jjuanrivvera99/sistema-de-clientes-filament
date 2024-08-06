<!-- resources/views/customers/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-4">Editar Cliente</h1>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="nationality" class="block text-gray-700 font-bold mb-2">Nacionalidad</label>
            <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $customer->nationality) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="residence_place" class="block text-gray-700 font-bold mb-2">Lugar de Residencia</label>
            <input type="text" name="residence_place" id="residence_place" value="{{ old('residence_place', $customer->residence_place) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="postal_code" class="block text-gray-700 font-bold mb-2">Código Postal</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $customer->postal_code) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="cencus" class="block text-gray-700 font-bold mb-2">Empadronamiento Aproximado</label>
            <input type="text" name="cencus" id="cencus" value="{{ old('cencus', $customer->cencus) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="marital_status" class="block text-gray-700 font-bold mb-2">Estado Civil</label>
            <input type="text" name="marital_status" id="marital_status" value="{{ old('marital_status', $customer->marital_status) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="family" class="block text-gray-700 font-bold mb-2">Familia</label>
            <textarea name="family" id="family" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('family', $customer->family) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="document_number" class="block text-gray-700 font-bold mb-2">Número de Documento</label>
            <input type="text" name="document_number" id="document_number" value="{{ old('document_number', $customer->document_number) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="document_type_id" class="block text-gray-700 font-bold mb-2">Tipo de Documento</label>
            <select name="document_type_id" id="document_type_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @foreach($documentTypes as $documentType)
                    <option value="{{ $documentType->id }}" {{ $customer->document_type_id == $documentType->id ? 'selected' : '' }}>{{ $documentType->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="notes" class="block text-gray-700 font-bold mb-2">Notas</label>
            <textarea name="notes" id="notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes', $customer->notes) }}</textarea>
        </div>
        <div id="contacts" class="mb-4">
            <h4 class="text-xl font-semibold mb-2">Contactos</h4>
            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4" id="add-contact">Añadir Contacto</button>
            @foreach($customer->contacts as $index => $contact)
                <div class="contact mb-4">
                    <input type="hidden" name="contacts[{{ $index }}][id]" value="{{ $contact->id }}">
                    <label for="contacts[{{ $index }}][contact_number]" class="block text-gray-700 font-bold mb-2">Número de Contacto</label>
                    <input type="text" name="contacts[{{ $index }}][contact_number]" id="contacts[{{ $index }}][contact_number]" value="{{ old("contacts.$index.contact_number", $contact->contact_number) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    
                    <label for="contacts[{{ $index }}][address]" class="block text-gray-700 font-bold mb-2">Dirección</label>
                    <input type="text" name="contacts[{{ $index }}][address]" id="contacts[{{ $index }}][address]" value="{{ old("contacts.$index.address", $contact->address) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    
                    <label for="contacts[{{ $index }}][email]" class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
                    <input type="email" name="contacts[{{ $index }}][email]" id="contacts[{{ $index }}][email]" value="{{ old("contacts.$index.email", $contact->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 mt-2 remove-contact">Eliminar</button>
                </div>
            @endforeach
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mt-4">Actualizar</button>
        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 mt-4" onclick="window.history.back()">Cancelar</button>
    </form>
</div>

<script>
document.getElementById('add-contact').addEventListener('click', function() {
    var contacts = document.getElementById('contacts');
    var index = contacts.getElementsByClassName('contact').length;
    var contactHtml = `
        <div class="contact mb-4">
            <label for="contacts[${index}][contact_number]" class="block text-gray-700 font-bold mb-2">Número de Contacto</label>
            <input type="text" name="contacts[${index}][contact_number]" id="contacts[${index}][contact_number]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <label for="contacts[${index}][address]" class="block text-gray-700 font-bold mb-2">Dirección</label>
            <input type="text" name="contacts[${index}][address]" id="contacts[${index}][address]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <label for="contacts[${index}][email]" class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
            <input type="email" name="contacts[${index}][email]" id="contacts[${index}][email]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 mt-2 remove-contact">Eliminar</button>
        </div>
    `;
    contacts.insertAdjacentHTML('beforeend', contactHtml);
});

document.getElementById('contacts').addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-contact')) {
        event.target.closest('.contact').remove();
    }
});
</script>
@endsection
