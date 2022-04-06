<?php

namespace Tests\Support;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

trait AuthenticationSudo
{
    /** @var User $sudo **/
    protected $sudo;

    protected $role_sudo;

    /**
     * @before
     */
    public function setUpUser()
    {
        $this->afterApplicationCreated(function () {
            $this->role_sudo = $this->new_role('sudo', 'Super Administrador');

            $this->sudo = User::factory()->create();
            $this->sudo->assignRole($this->role_sudo);
            Profile::factory()->forUser($this->sudo)->create();
        });
    }

    public function authenticated(Authenticatable $user = null)
    {
        return $this->actingAs($user ?? $this->sudo);
    }
}