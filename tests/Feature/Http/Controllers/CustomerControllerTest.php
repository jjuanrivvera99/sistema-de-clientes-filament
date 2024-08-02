<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use App\Models\DocumentType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CustomerController
 */
final class CustomerControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $customers = Customer::factory()->count(3)->create();

        $response = $this->get(route('customers.index'));

        $response->assertOk();
        $response->assertViewIs('customers.index');
        $response->assertViewHas('customers');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('customers.create'));

        $response->assertOk();
        $response->assertViewIs('customers.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CustomerController::class,
            'store',
            \App\Http\Requests\CustomerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $document_number = $this->faker->word();
        $document_type = DocumentType::factory()->create();

        $response = $this->post(route('customers.store'), [
            'name' => $name,
            'document_number' => $document_number,
            'document_type_id' => $document_type->id,
        ]);

        $customers = Customer::query()
            ->where('name', $name)
            ->where('document_number', $document_number)
            ->where('document_type_id', $document_type->id)
            ->get();
        $this->assertCount(1, $customers);
        $customer = $customers->first();

        $response->assertRedirect(route('customers.index'));
    }


    #[Test]
    public function show_displays_view(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('customers.show', $customer));

        $response->assertOk();
        $response->assertViewIs('customers.show');
        $response->assertViewHas('customer');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('customers.edit', $customer));

        $response->assertOk();
        $response->assertViewIs('customers.edit');
        $response->assertViewHas('customer');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CustomerController::class,
            'update',
            \App\Http\Requests\CustomerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $customer = Customer::factory()->create();
        $name = $this->faker->name();
        $document_number = $this->faker->word();
        $document_type = DocumentType::factory()->create();

        $response = $this->put(route('customers.update', $customer), [
            'name' => $name,
            'document_number' => $document_number,
            'document_type_id' => $document_type->id,
        ]);

        $customer->refresh();

        $response->assertRedirect(route('customers.index'));

        $this->assertEquals($name, $customer->name);
        $this->assertEquals($document_number, $customer->document_number);
        $this->assertEquals($document_type->id, $customer->document_type_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->delete(route('customers.destroy', $customer));

        $response->assertRedirect(route('customers.index'));

        $this->assertModelMissing($customer);
    }
}
