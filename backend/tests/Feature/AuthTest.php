<?php
use App\Models\User;
it('logs in with username and password', function(){ $user=User::factory()->create(['username'=>'demo','password'=>'password12345']); $this->postJson('/api/v1/auth/login',['username'=>'demo','password'=>'password12345'])->assertOk()->assertJsonPath('user.username','demo'); });
