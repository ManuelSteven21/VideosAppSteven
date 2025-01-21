<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Laravel\Jetstream\Mail\TeamInvitation;
use Livewire\Livewire;
use Tests\TestCase;

class InviteTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_members_can_be_invited_to_team(): void
    {
        if (! Features::sendsTeamInvitations()) {
            $this->markTestSkipped('Team invitations not enabled.');
        }

        Mail::fake();

        // Actúa como el usuario con un equipo personal
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        // Realiza la prueba con Livewire
        Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->set('addTeamMemberForm', [
                'email' => 'test@example.com',
                'role' => 'admin',
            ])
            ->call('addTeamMember');

        // Verifica que la invitación fue enviada
        Mail::assertSent(TeamInvitation::class);

        // Carga explícitamente las invitaciones del equipo
        $user->currentTeam->load('teamInvitations');
        $this->assertCount(1, $user->currentTeam->teamInvitations);
    }

    public function test_team_member_invitations_can_be_cancelled(): void
    {
        if (! Features::sendsTeamInvitations()) {
            $this->markTestSkipped('Team invitations not enabled.');
        }

        Mail::fake();

        // Actúa como el usuario con un equipo personal
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        // Añade al miembro al equipo
        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->set('addTeamMemberForm', [
                'email' => 'test@example.com',
                'role' => 'admin',
            ])
            ->call('addTeamMember');

        // Obtén la invitación recién creada
        $user->currentTeam->load('teamInvitations'); // Carga las invitaciones
        $invitationId = $user->currentTeam->teamInvitations->first()->id;

        // Cancela la invitación del equipo
        $component->call('cancelTeamInvitation', $invitationId);

        // Verifica que la invitación haya sido cancelada
        $this->assertCount(0, $user->currentTeam->teamInvitations);
    }
}
