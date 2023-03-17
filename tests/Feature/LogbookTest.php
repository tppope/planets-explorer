<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogbookTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_logbook_record(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
        mutation {
            createLogbookRecord(input: {mood: ANGER, weather: CLOUDY, space_location: "new location", note: "new note"}) {
                id
            }
        }
        ')->assertJsonFragment([
            'id' => '1',
        ]);
    }

    public function test_error_empty_note_validation(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
        mutation {
            createLogbookRecord(input: {mood: ANGER, weather: CLOUDY, space_location: "new location", note: ""}) {
                id
            }
        }
        ')->assertGraphQLValidationKeys(['input.note']);
    }
}
