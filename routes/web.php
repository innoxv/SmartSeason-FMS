<?php

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Fields\CreateField;
use App\Livewire\Admin\Fields\EditField;
use App\Livewire\Admin\Fields\FieldsList;
use App\Livewire\Admin\Agents\AgentsList;
use App\Livewire\Agent\Dashboard as AgentDashboard;
use App\Livewire\Agent\Fields\MyFields;
use App\Livewire\Agent\Fields\FieldDetail;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Shared dashboard redirect based on role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('agent.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Admin Routes ─────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/fields', FieldsList::class)->name('fields.index');
    Route::get('/fields/create', CreateField::class)->name('fields.create');
    Route::get('/fields/{field}/edit', EditField::class)->name('fields.edit');
    Route::get('/agents', AgentsList::class)->name('agents.index');
});

// ── Agent Routes ─────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', AgentDashboard::class)->name('dashboard');
    Route::get('/fields', MyFields::class)->name('fields.index');
    Route::get('/fields/{field}', FieldDetail::class)->name('fields.show');
});

// Profile (shared)
Route::get('/profile', Profile::class)->middleware(['auth'])->name('profile');

// Health Check Route
Route::get('/db-health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'ok',
            'database' => 'connected',
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'database' => 'disconnected',
            'message' => $e->getMessage()
        ], 500);
    }
});

require __DIR__.'/auth.php';
