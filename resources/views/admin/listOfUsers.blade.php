@extends('layouts.user') @section('content')
    <div class="row field">
        <nav aria-label="...">
            <ul class="pagination pagination-sm">
                @if ($offset == 1)
                    <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a>
                @else
                    <li class="page-item"><a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => ($offset - 1), 'limit' => $limit]) }}" tabindex="-1">Previous</a>
                @endif
                @for ($i = 1; $i < (($count / $limit) + 1); $i += 1)
                    @if ($i == $offset)
                        <li class="page-item active">
                    @else
                        <li class="page-item">
                    @endif
                    <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $i, 'limit' => $limit]) }}">{{ $i }}</a>
                    </li>
                @endfor
                @if (($offset == ((int) ($count / $limit))) || ($limit > $users->count()))
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Next</a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => ($offset + 1), 'limit' => $limit]) }}">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
        <nav aria-label="...">
        <ul class="pagination pagination-sm">
            @if ($limit == 10)
                <li class="page-item active">
            @else
                <li class="page-item">
            @endif
                <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $offset, 'limit' => 10]) }}" tabindex="-1">10</a>
            </li>
            @if ($limit == 25)
                <li class="page-item active">
            @else
                <li class="page-item">
            @endif
                <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $offset, 'limit' => 25]) }}">25</a>
            </li>
            @if ($limit == 50)
                <li class="page-item active">
            @else
                <li class="page-item">
            @endif
                <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $offset, 'limit' => 50]) }}">50</a>
            </li>
            @if ($limit == ($count * 2))
                <li class="page-item active">
            @else
                <li class="page-item">
            @endif
                <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $offset, 'limit' => ($count * 2)]) }}">all</a>
            </li>
        </ul>
        </nav>
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
                    <td>
                        @if ($user->profileImage)   
                        <div class="reviewImageMain reviewImage squareImage" style="background-image:url('{{ asset('public/img/Profile-Images/' . $user['profileImage']) }}');background-size:cover;background-position:center; border: 1px solid #DDD;"></div>
                        @else
                        <div class="reviewImageMain reviewImage squareImage" style="background-image:url('{{ asset('public/img/Profile-Images/Default-User-Profile-Image.png') }}');background-size:cover;background-position:center; border: 1px solid #DDD;"></div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('user-profile', ['userId' => $user->userId]) }}">
                            {{ $user->fullName }}
                        </a>
                    </td>
                    <td>
                            {{ $user->email }}
                    </td>
                    <td>
                        @if($user->phoneNumber)
                            {{ $user->phoneNumber }}
                        @else
                            n/a
                        @endif
                    </td>
                    <td>
                        {{ $user->NDAStatus }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        <nav aria-label="...">
            <ul class="pagination pagination-sm">
                @if ($offset == 1)
                    <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a>
                @else
                    <li class="page-item"><a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => ($offset - 1), 'limit' => $limit]) }}" tabindex="-1">Previous</a>
                @endif
                @for ($i = 1; $i < (($count / $limit) + 1); $i += 1)
                    @if ($i == $offset)
                        <li class="page-item active">
                    @else
                        <li class="page-item">
                    @endif
                    <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $i, 'limit' => $limit]) }}">{{ $i }}</a>
                    </li>
                @endfor
                @if (($offset == ((int) ($count / $limit))) || ($limit > $users->count()))
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Next</a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => ($offset + 1), 'limit' => $limit]) }}">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
        <nav aria-label="...">
        <ul class="pagination pagination-sm">
            @if ($limit == 10)
                <li class="page-item active">
            @else
                <li class="page-item">
            @endif
                <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $offset, 'limit' => 10]) }}" tabindex="-1">10</a>
            </li>
            @if ($limit == 25)
                <li class="page-item active">
            @else
                <li class="page-item">
            @endif
                <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $offset, 'limit' => 25]) }}">25</a>
            </li>
            @if ($limit == 50)
                <li class="page-item active">
            @else
                <li class="page-item">
            @endif
                <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $offset, 'limit' => 50]) }}">50</a>
            </li>
            @if ($limit == ($count * 2))
                <li class="page-item active">
            @else
                <li class="page-item">
            @endif
                <a class="page-link" href="{{ route('admin-listOfUsers', ['offset' => $offset, 'limit' => ($count * 2)]) }}">all</a>
            </li>
        </ul>
        </nav>
    </div>
@endsection