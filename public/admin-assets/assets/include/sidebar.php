
        <!--///////////Page sidebar begin///////////////-->
        <aside class="page-sidebar aside-dark bg-dark">
          <div class="h-100 flex-column d-flex" data-simplebar>

            <!--Aside-logo-->
            <div class="aside-logo">
              <a href="index.html" class="d-block">
                <div class="d-flex align-items-center flex-no-wrap text-truncate">
                  <!--Sidebar-icon-->
                  <span class="fs-5 lh-1"> 
                    <img src="../app/assets/media/logo/logo.svg">  
                  </span>
                  
                </div>
              </a>
            </div>
            <!--Aside-Menu-->
            <div class="aside-menu px-2 my-auto flex-column-fluid">
              <nav class="flex-grow-1 h-100" id="page-navbar">
                <!--:Sidebar nav-->
                <ul class="nav flex-column collapse-group collapse d-flex pt-4">
                  <li class="nav-item">
                    <a href="dashboard.html" class="nav-link d-flex align-items-center text-truncate active">
                      <span class="sidebar-icon">
                        <i data-feather="activity" class="fe-2x"></i>
                      </span>
                      <!--Sidebar nav text-->
                      <span class="sidebar-text">Dashboard</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a data-bs-toggle="collapse"
                      class="nav-link d-flex align-items-center text-truncate "
                      aria-expanded="false" href="#ui-pages">
                      <span class="sidebar-icon">
                        <i data-feather="file-text" class="fe-2x"></i>
                      </span>
                      <!--Sidebar nav text-->
                      <span class="sidebar-text">Pages</span>
                    </a>
                    <ul id="ui-pages" class="sidebar-dropdown list-unstyled collapse">
                      <li class="sidebar-item">
                        <a href="#pages-account" data-bs-toggle="collapse" aria-expanded="false" class="sidebar-link">
                          Account
                        </a>
                        <ul id="pages-account" class="sidebar-dropdown list-unstyled collapse sd-second-level">
                          <li class="sidebar-item">
                            <a class="sidebar-link" href="account-general.html">General</a>
                          </li>
                          <li class="sidebar-item">
                            <a class="sidebar-link" href="account-billing.html">Billing</a>
                          </li>
                        </ul>
                      </li>
                      <li class="sidebar-item">
                        <a href="#pages-profile" data-bs-toggle="collapse" aria-expanded="false" class="sidebar-link">
                          Profile
                        </a>
                        <ul id="pages-profile" class="sidebar-dropdown list-unstyled collapse sd-second-level">
                          <li class="sidebar-item">
                            <a class="sidebar-link" href="profile.html">Overview</a>
                          </li>
                        </ul>
                      </li>
                      <li class="sidebar-item">
                        <a href="#pages-authentication" data-bs-toggle="collapse" aria-expanded="false" class="sidebar-link">
                          Authentication
                        </a>
                        <ul id="pages-authentication" class="sidebar-dropdown list-unstyled collapse sd-second-level">
                          <li class="sidebar-item">
                            <a class="sidebar-link" href="page-auth-signin.html">SignIn</a>
                          </li>
                          <li class="sidebar-item">
                            <a class="sidebar-link" href="page-auth-signup.html">SignUp</a>
                          </li>
                        </ul>
                      </li>
                      <li class="sidebar-item">
                        <a href="#pages-projects" data-bs-toggle="collapse" aria-expanded="false" class="sidebar-link">
                          Projects
                        </a>
                        <ul id="pages-projects" class="sidebar-dropdown list-unstyled collapse sd-second-level">
                          <li class="sidebar-item">
                            <a class="sidebar-link" href="projects-list.html">List</a>
                          </li>
                          <li class="sidebar-item">
                            <a class="sidebar-link" href="project-detail.html">Details</a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="app-chat.html"
                      class="nav-link d-flex align-items-center text-truncate ">
                      <span class="sidebar-icon">
                        <i data-feather="message-square" class="fe-2x"></i>
                      </span>
                      <span class="sidebar-text">Chat</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="alert.html"
                      class="nav-link d-flex align-items-center text-truncate ">
                      <span class="sidebar-icon">
                        <i data-feather="message-square" class="fe-2x"></i>
                      </span>
                      <span class="sidebar-text">Alert</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="form.html"
                      class="nav-link d-flex align-items-center text-truncate ">
                      <span class="sidebar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 fe-2x"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                      </span>
                      <span class="sidebar-text">Form</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </aside>
        <!--///////////Page Sidebar End///////////////-->