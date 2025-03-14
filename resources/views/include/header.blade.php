{{-- Left navbar --}}
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars text-white"></i>
        </a>
    </li>
</ul>

{{-- Right Navbar --}}
<ul class="navbar-nav ms-auto">
    {{-- Message Dropdown --}}
    <li class="nav-item dropdown">
        <a class="nav-link" id="messageDropdown" data-bs-toggle="dropdown" aria-expanded="false" href="#">
            <i class="fa-solid fa-user"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messageDropdown" style="min-width: 300px;">
            <li>
                <a id="viewProfileBtn{{ Auth::id() }}" class="dropdown-item" href="#" title="View Profile">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-circle me-3" style="font-size: 50px; color: #00743f;"></i> <!-- User icon -->
                        <div>
                            <h6 class="dropdown-item-title" style="margin: 0;">{{ Auth::user()->name }}</h6> 
                            <small class="text-muted">{{ Auth::user()->role->role_name }}</small> <!-- Optional: Display user role -->
                        </div>
                    </div>
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a id="changePasswordBtn{{ Auth::id() }}" class="dropdown-item" href="#" title="Change Password">
                    <i class="fas fa-lock me-2"></i> Change Password
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{route('logout')}}">
                    <i class="fas fa-power-off me-2"></i> Logout
                </a>
            </li>
        </ul>
    </li>
</ul>



