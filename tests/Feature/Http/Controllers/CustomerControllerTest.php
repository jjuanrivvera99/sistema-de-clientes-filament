<?php

namespace Tests\Feature\Http\Controllers;

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
        $this->markTestSkipped('Customer routes handled by Filament, not traditional Laravel routes');
    }

    #[Test]
    public function create_displays_view(): void
    {
        $this->markTestSkipped('Customer routes handled by Filament, not traditional Laravel routes');
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
        $this->markTestSkipped('Customer routes handled by Filament, not traditional Laravel routes');
    }

    #[Test]
    public function show_displays_view(): void
    {
        $this->markTestSkipped('Customer routes handled by Filament, not traditional Laravel routes');
    }

    #[Test]
    public function edit_displays_view(): void
    {
        $this->markTestSkipped('Customer routes handled by Filament, not traditional Laravel routes');
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
        $this->markTestSkipped('Customer routes handled by Filament, not traditional Laravel routes');
    }

    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $this->markTestSkipped('Customer routes handled by Filament, not traditional Laravel routes');
    }
}
