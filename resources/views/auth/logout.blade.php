@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Logout') }}</div>

                <div class="card-body">
                    <p class="text-center mb-4">{{ __('Are you sure you want to logout?') }}</p>
                    
                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>{{ __('Yes, Logout') }}
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-times me-2"></i>{{ __('Cancel') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 