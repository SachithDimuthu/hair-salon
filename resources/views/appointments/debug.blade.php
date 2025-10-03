@extends('layouts.app')

@section('title', 'My Appointments - Debug')

@section('content')
<div class="p-4">
    <h1>Appointments Debug</h1>
    
    @if(isset($appointments))
        <p>✅ $appointments variable is set</p>
        <p>Type: {{ gettype($appointments) }}</p>
        <p>Count: {{ $appointments->count() }}</p>
        
        @if($appointments->count() > 0)
            <h3>Appointments:</h3>
            <ul>
                @foreach($appointments as $appointment)
                    <li>{{ $appointment->service_name ?? 'Unknown Service' }} - {{ $appointment->booking_date ?? 'No Date' }}</li>
                @endforeach
            </ul>
        @else
            <p>No appointments found</p>
        @endif
    @else
        <p>❌ $appointments variable is NOT set</p>
        <p>Available variables:</p>
        <pre>{{ print_r(get_defined_vars(), true) }}</pre>
    @endif
</div>
@endsection