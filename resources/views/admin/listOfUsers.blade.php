@extends('layouts.user') @section('content')
    <div class="row field">
    <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Profile Image</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>NDA Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>img</td>
              <td>{{ $user->fullName }}</td>
              <td>{{ $user->email }}</td>
              <td>
                @if($user->phoneNumber)
                    {{ $user->phoneNumber }}
                @else
                    n/a
                @endif
                </td>
              <td>{{ $user->NDAStatus }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @foreach($users as $user)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    @if ($user->profileImage)   
                    <div class="reviewImageMain reviewImage squareImage" style="background-image:url('{{ asset('public/img/Profile-Images/' . $user['profileImage']) }}');background-size:cover;background-position:center; border: 1px solid #DDD;"></div>
                    @else
                    <div class="reviewImageMain reviewImage squareImage" style="background-image:url('{{ asset('public/img/Profile-Images/Default-User-Profile-Image.png') }}');background-size:cover;background-position:center; border: 1px solid #DDD;"></div>
                    @endif
                    <div class="card-body">
                        <h3 class="card-text">{{ $user->fullName }}</h3>
                        <p><span class="glyphicon glyphicon-envelope secondary" aria-hidden="true"></span> {{ $user->email }}</p>
                        @if ($user->phoneNumber)
                        <p><span class="glyphicon glyphicon-phone secondary" aria-hidden="true"></span> {{ $user->phoneNumber }}</p>
                        @endif
                        <p class="card-text">NDA: {{ $user->NDAStatus }}</p>
                        @if ($user->linkedInURL)
                            <p></p>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                            </div>
                            <small class="text-muted">9 mins</small>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
@endsection