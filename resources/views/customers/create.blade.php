<!-- resources/views/customers/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-4">Crear Cliente</h1>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nombre</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="nationality" class="block text-gray-700 font-bold mb-2">Nacionalidad</label>
            <input type="text" name="nationality" id="nationality" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="residence_place" class="block text-gray-700 font-bold mb-2">Lugar de Residencia</label>
            <input type="text" name="residence_place" id="residence_place" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="postal_code" class="block text-gray-700 font-bold mb-2">Código Postal</label>
            <input type="text" name="postal_code" id="postal_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="cencus" class="block text-gray-700 font-bold mb-2">Empadronamiento Aproximado</label>
            <input type="date" name="cencus" id="cencus" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="marital_status" class="block text-gray-700 font-bold mb-2">Estado Civil</label>
            <input type="text" name="marital_status" id="marital_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="family" class="block text-gray-700 font-bold mb-2">Familia</label>
            <textarea name="family" id="family" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div class="mb-4">
            <label for="document_number" class="block text-gray-700 font-bold mb-2">Número de Documento</label>
            <input type="text" name="document_number" id="document_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="document_type_id" class="block text-gray-700 font-bold mb-2">Tipo de Documento</label>
            <select name="document_type_id" id="document_type_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @foreach($documentTypes as $documentType)
                    <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                @endforeach
            </select>
        </div>
        <div id="contacts" class="mb-4">
            <h4 class="text-xl font-semibold mb-2">Contactos</h4>
            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4" id="add-contact">Añadir Contacto</button>

            <div class="contact mb-4">
                <label for="contact_number" class="block text-gray-700 font-bold mb-2">Número de Contacto</label>
                <input type="text" name="contacts[0][contact_number]" id="contact_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                
                <label for="address" class="block text-gray-700 font-bold mb-2">Dirección</label>
                <input type="text" name="contacts[0][address]" id="address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                
                <label for="email" class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
                <input type="email" name="contacts[0][email]" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 mt-2 remove-contact">Eliminar</button>
            </div>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mt-4">Registrar</button>
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
