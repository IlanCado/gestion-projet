<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Forcer le chargement des routes API
        $this->loadRoutesFrom(base_path('routes/api.php'));
    }
}
