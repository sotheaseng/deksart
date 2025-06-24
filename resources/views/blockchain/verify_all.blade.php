@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                Blockchain Chain Integrity Check (All Chains)
            </h2>
            <a href="{{ route('blockchain.index') }}" class="btn btn-secondary" style="margin-top: 1rem;">Back to Blockchain Records</a>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Record ID</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $result['record_type'])) }}</td>
                                <td>{{ $result['record_id'] }}</td>
                                <td>
                                    @if($result['valid'])
                                        <span class="badge badge-success">Valid</span>
                                    @else
                                        <span class="badge badge-danger">Invalid</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($result['error']))
                                        <span style="color: #ef4444;">{{ $result['error'] }}</span>
                                    @elseif(!$result['valid'])
                                        <details>
                                            <summary>Show Details</summary>
                                            <ul style="font-size: 0.95rem;">
                                                @foreach($result['details'] as $step)
                                                    <li>
                                                        <strong>{{ $step['timestamp'] ?? '' }} ({{ $step['action'] ?? '' }})</strong>:
                                                        Hash: <span style="color: {{ $step['hash_valid'] ? '#22c55e' : '#ef4444' }};">{{ $step['hash_valid'] ? 'OK' : 'Invalid' }}</span>,
                                                        Chain: <span style="color: {{ $step['chain_valid'] ? '#22c55e' : '#ef4444' }};">{{ $step['chain_valid'] ? 'OK' : 'Broken' }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </details>
                                    @else
                                        <span style="color: #22c55e;">All OK</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection 