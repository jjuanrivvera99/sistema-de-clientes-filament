<!-- resources/views/customers/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-4">Clientes</h1>
    <a href="{{ route('customers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4 inline-block">Añadir Cliente</a>

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table id="customersTable" class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">ID</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Nombre</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Nacionalidad</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Lugar de Residencia</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Código Postal</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Empadronamiento Aproximado</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Estado Civil</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Familia</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Número de Documento</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Tipo de Documento</th>
                    <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($customers as $customer)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->id }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->nationality }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->residence_place }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->postal_code }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->approx_enrollment }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->marital_status }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->family }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->document_number }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $customer->documentType->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">
                            <div class="flex space-x-2">
                                <a href="{{ route('customers.edit', $customer) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 w-24 text-center">Editar</a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 w-24">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#customersTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nada encontrado - lo siento",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>
@endsection
