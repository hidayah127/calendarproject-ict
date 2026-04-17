<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    // ── Core sender ──────────────────────────────────────
    public static function send(int $userId, array $data): void
    {
        Notification::create([
            'user_id'    => $userId,
            'type'       => $data['type'],
            'message'    => $data['message'],
            'url'        => $data['url']        ?? null,
            'icon'       => $data['icon']       ?? 'fa-bell',
            'icon_bg'    => $data['icon_bg']    ?? '#eff6ff',
            'icon_color' => $data['icon_color'] ?? '#1d4ed8',
        ]);
    }

    // ── Role helpers ─────────────────────────────────────
    private static function sendToRole(string $role, array $data): void
    {
        User::where('role', $role)->each(function ($user) use ($data) {
            self::send($user->id, $data);
        });
    }

    private static function sendToAdmin(array $data): void
    {
        self::sendToRole('admin', $data);
    }

    private static function sendToVC(array $data): void
    {
        self::sendToRole('vc', $data);
    }

    private static function sendToUser(int $userId, array $data): void
    {
        self::send($userId, $data);
    }

    // ── Program Created ───────────────────────────────────
    // HD creates → notify Admin + VC
    public static function programCreated(int $hdUserId, string $title, int $programId): void
    {
        $hd = User::find($hdUserId);
        $hdName = $hd?->name ?? 'A Head of Department';

        // Notify all Admins
        self::sendToAdmin([
            'type'       => 'program_created',
            'message'    => "{$hdName} created a new program: \"{$title}\".",
            'url'        => route('admin.dashboard', $programId), // adjust if needed
            'icon'       => 'fa-calendar-plus',
            'icon_bg'    => '#dcfce7',
            'icon_color' => '#15803d',
        ]);

        // Notify all VCs
        self::sendToVC([
            'type'       => 'program_created',
            'message'    => "New program added: \"{$title}\" by {$hdName}.",
            'url'        => route('vc.programs'),
            'icon'       => 'fa-calendar-plus',
            'icon_bg'    => '#dcfce7',
            'icon_color' => '#15803d',
        ]);

        // Notify the HD themselves (confirmation)
        self::sendToUser($hdUserId, [
            'type'       => 'program_created',
            'message'    => "Your program \"{$title}\" has been created successfully.",
            'url'        => route('head.programs.index'),
            'icon'       => 'fa-circle-check',
            'icon_bg'    => '#dcfce7',
            'icon_color' => '#15803d',
        ]);
    }

    // ── Program Rescheduled ───────────────────────────────
    public static function programRescheduled(int $hdUserId, string $title, int $programId): void
    {
        $hd = User::find($hdUserId);
        $hdName = $hd?->name ?? 'A Head of Department';

        self::sendToAdmin([
            'type'       => 'program_rescheduled',
            'message'    => "{$hdName} rescheduled the program \"{$title}\".",
            'url'        => route('admin.dashboard', $programId),
            'icon'       => 'fa-clock-rotate-left',
            'icon_bg'    => '#fef9c3',
            'icon_color' => '#b45309',
        ]);

        self::sendToVC([
            'type'       => 'program_rescheduled',
            'message'    => "Program \"{$title}\" has been rescheduled.",
            'url'        => route('vc.programs'),
            'icon'       => 'fa-clock-rotate-left',
            'icon_bg'    => '#fef9c3',
            'icon_color' => '#b45309',
        ]);

        self::sendToUser($hdUserId, [
            'type'       => 'program_rescheduled',
            'message'    => "You rescheduled \"{$title}\" successfully.",
            'url'        => route('head.programs.index'),
            'icon'       => 'fa-clock-rotate-left',
            'icon_bg'    => '#fef9c3',
            'icon_color' => '#b45309',
        ]);
    }

    // ── Program Cancelled ─────────────────────────────────
    public static function programCancelled(int $hdUserId, string $title, int $programId): void
    {
        $hd = User::find($hdUserId);
        $hdName = $hd?->name ?? 'A Head of Department';

        self::sendToAdmin([
            'type'       => 'program_cancelled',
            'message'    => "{$hdName} cancelled the program \"{$title}\".",
            'url'        => route('admin.dashboard', $programId),
            'icon'       => 'fa-ban',
            'icon_bg'    => '#fee2e2',
            'icon_color' => '#b91c1c',
        ]);

        self::sendToVC([
            'type'       => 'program_cancelled',
            'message'    => "Program \"{$title}\" has been cancelled.",
            'url'        => route('vc.programs'),
            'icon'       => 'fa-ban',
            'icon_bg'    => '#fee2e2',
            'icon_color' => '#b91c1c',
        ]);

        self::sendToUser($hdUserId, [
            'type'       => 'program_cancelled',
            'message'    => "You cancelled \"{$title}\".",
            'url'        => route('head.programs.index'),
            'icon'       => 'fa-ban',
            'icon_bg'    => '#fee2e2',
            'icon_color' => '#b91c1c',
        ]);
    }

    // ── Program Completed (auto by scheduler) ─────────────
    public static function programCompleted(int $hdUserId, string $title, int $programId): void
    {
        $hd = User::find($hdUserId);
        $hdName = $hd?->name ?? 'Head of Department';

        self::sendToAdmin([
            'type'       => 'program_completed',
            'message'    => "Program \"{$title}\" ({$hdName}) has been marked completed.",
            'url'        => route('admin.dashboard', $programId),
            'icon'       => 'fa-circle-check',
            'icon_bg'    => '#e0e7ff',
            'icon_color' => '#4338ca',
        ]);

        self::sendToVC([
            'type'       => 'program_completed',
            'message'    => "Program \"{$title}\" has been completed.",
            'url'        => route('vc.programs'),
            'icon'       => 'fa-circle-check',
            'icon_bg'    => '#e0e7ff',
            'icon_color' => '#4338ca',
        ]);

        self::sendToUser($hdUserId, [
            'type'       => 'program_completed',
            'message'    => "Your program \"{$title}\" is now marked as completed.",
            'url'        => route('head.programs.index'),
            'icon'       => 'fa-circle-check',
            'icon_bg'    => '#e0e7ff',
            'icon_color' => '#4338ca',
        ]);
    }
}