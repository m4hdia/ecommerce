@extends('layouts.app')

@section('content')
<section class="admin-hero">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <p class="eyebrow text-white-50 mb-2">Customers</p>
            <h1 class="hero-title text-white mb-0">Customers</h1>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="table-responsive shadow-sm bg-white rounded-4">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Orders</th>
                        <th>Joined</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-light text-uppercase text-dark">{{ $user->role }}</span></td>
                            <td>{{ $user->orders_count }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.customers.show', $user) }}" class="btn btn-sm btn-outline-dark rounded-pill">History</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</section>
@endsection

