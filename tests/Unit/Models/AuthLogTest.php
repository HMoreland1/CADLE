<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AuthLog;
use App\Models\User;

class AuthLogTest extends TestCase
{
    use RefreshDatabase;

    public function testFillableAttributes()
    {
        $fillable = ['user_id', 'ip_address', 'user_agent', 'login_at', 'logout_at', 'type'];
        $authLog = new AuthLog();

        $this->assertEquals($fillable, $authLog->getFillable());
    }

}
