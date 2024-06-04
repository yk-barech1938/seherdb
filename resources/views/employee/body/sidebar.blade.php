<nav class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
          SEHER - <span></span>
        </a>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
          @if(auth()->check() && auth()->user()->role_id != 11)
          <li class="nav-item nav-category">Legal Protection Services</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="mail"></i>
              <span class="link-title">Legal Service</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="emails">
              <ul class="nav sub-menu">
                
                <li class="nav-item">
                  <a href="{{ route('employee.legal.awareness')}}" class="nav-link">Awareness Session</a>
                </li>
                @if(auth()->check() && auth()->user()->role_id == 2)
                <li class="nav-item">
                  <a href="{{ route('employee.legal.cbpl')}}" class="nav-link">Comm Based ParaLegal</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('employee.legal.camp')}}" class="nav-link">Legal Camp</a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          <li class="nav-item">
              <a href="{{ route('complaint.create') }}" class="nav-link">
                  <i class="link-icon" data-feather="calendar"></i>
                  <span class="link-title">Complaint</span>
              </a>
          </li>
          @endif
          @if(auth()->check() && auth()->user()->role_id == 11)
          <li class="nav-item nav-category">ALAC</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
              <i class="link-icon" data-feather="feather"></i>
             <span class="link-title">Calls</span>
             <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="uiComponents">
              <ul class="nav sub-menu">
                <li class="nav-item">
                 <a href="{{ route('employee.helplinecalls')}}" class="nav-link">Helpline Calls</a>
                </li>
                <!--<li class="nav-item">-->
                <!--  <a href="#" class="nav-link">Low Court</a>-->
                <!--</li>-->
               
              </ul>
            </div>
          </li>
          @endif
          <li class="nav-item">
            <!--<a href="#" class="nav-link">-->
            <!--  <i class="link-icon" data-feather="calendar"></i>-->
            <!--  <span class="link-title">Complaint</span>-->
            <!--</a>-->
          </li>
         
          <li class="nav-item nav-category">Pages</li>
        
          <li class="nav-item nav-category">Docs</li>
          <li class="nav-item">
            <a href="#" target="_blank" class="nav-link">
              <i class="link-icon" data-feather="hash"></i>
              <span class="link-title">Documentation</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>

  