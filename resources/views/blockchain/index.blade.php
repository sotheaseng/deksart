@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Blockchain Records
                </h2>
            </div>
        </div>
    </header>
    @if(isset($allValid))
        @if(!$allValid)
            <div class="alert alert-danger mt-4 mb-0 rounded-0">Warning: One or more blockchain chains are invalid!</div>
        @endif
    @endif
    <div class="card mt-4">
        <div class="card-body">
            <form method="GET" class="flex gap-4 mb-6">
                <select name="record_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="room" {{ request('record_type') === 'room' ? 'selected' : '' }}>Room</option>
                    <option value="housekeeping_task" {{ request('record_type') === 'housekeeping_task' ? 'selected' : '' }}>Housekeeping Task</option>
                    <option value="user" {{ request('record_type') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="reservation" {{ request('record_type') === 'reservation' ? 'selected' : '' }}>Reservation</option>
                </select>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
            @php
                // Group records by (record_type, record_id) and get only the latest for each
                $latestRecords = $records->groupBy(fn($r) => $r->record_type . '-' . $r->record_id)
                    ->map(function($group) {
                        return $group->sortByDesc('id')->first();
                    });
            @endphp
            @if($latestRecords->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Version</th>
                                <th>Type</th>
                                <th>Record ID</th>
                                <th>Action</th>
                                <th>User</th>
                                <th>Timestamp</th>
                                <th>Hash</th>
                                <th>Chain Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestRecords as $record)
                                @php
                                    $chainStatus = collect($chainStatusList)->first(fn($c) => $c['record_type'] === $record->record_type && $c['record_id'] == $record->record_id);
                                    $version = \App\Models\BlockchainRecord::where('record_type', $record->record_type)
                                        ->where('record_id', $record->record_id)
                                        ->where('id', '<=', $record->id)
                                        ->count();
                                @endphp
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    <td>{{ $version }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $record->record_type)) }}</td>
                                    <td>{{ $record->record_id }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($record->action === 'create') badge-success
                                            @elseif($record->action === 'update') badge-warning
                                            @else badge-danger @endif">
                                            {{ ucfirst($record->action) }}
                                        </span>
                                    </td>
                                    <td>{{ $record->user->name }}</td>
                                    <td>{{ $record->timestamp->format('Y-m-d H:i:s') }}</td>
                                    <td class="font-monospace text-sm">{{ substr($record->hash, 0, 16) }}...</td>
                                    <td>
                                        @if($chainStatus && $chainStatus['valid'])
                                            <span class="badge badge-success">Valid</span>
                                        @else
                                            <span class="badge badge-danger">Invalid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('blockchain.show', $record) }}" class="btn btn-secondary btn-sm">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $records->links() }}
                </div>
            @else
                <p class="text-muted text-center py-5">No blockchain records found.</p>
            @endif
        </div>
    </div>
@endsection
