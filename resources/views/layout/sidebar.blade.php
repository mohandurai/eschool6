<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            eSchool</span>
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
                <a href="{{ url('dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>


            <!-- Starts Students Menu Listing -->

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#student" role="button" aria-expanded="" aria-controls="student">
                    <i class="link-icon" data-feather="user-plus"></i>
                    <span class="link-title">Student Mgmt.</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="student">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/student/index') }}" class="nav-link">Students</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Terms</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Classes</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Sections</a>
                        </li>

                    </ul>
                </div>
            </li>

            <!-- Ends Students Menu Listing -->

            <!-- Starts Staff Menu Listing -->

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#staff" role="button" aria-expanded="" aria-controls="staff">
                    <i class="link-icon" data-feather="user-plus"></i>
                    <span class="link-title">School Mgmt.</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="staff">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Staff Info</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Add Staff</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Pay Slips</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Others</a>
                        </li>

                    </ul>
                </div>
            </li>

            <!-- Ends Staff Menu Listing -->


            <!-- Starts Students Activity Menu Listing -->

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#training" role="button" aria-expanded="" aria-controls="training">
                    <i class="link-icon" data-feather="book-open"></i>
                    <span class="link-title">Students Activity</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="training">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/olexam/index') }}" class="nav-link">Attend Exam</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/projlab/studprojindex') }}" class="nav-link">Act./Proj. Lab Submit</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/homework/homeworkindex') }}" class="nav-link">Home Work Submit</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/qnbankview') }}" class="nav-link">View Question Bank</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Schedule Class</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Ends Students Activity Menu Listing -->


            <!-- Starts Teachers Activity Menu Listing -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#evaluation" role="button" aria-expanded="" aria-controls="evaluation">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Teachers Activity</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="evaluation">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/classlist') }}" class="nav-link">Teacher Training Kit (TTK)</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/cltlist') }}" class="nav-link">Computer Lab Tutor (CLT)</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/olexam/correct') }}" class="nav-link">Exam Paper Evaluation</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/projlab/projevaln') }}" class="nav-link">Act./Proj. Evaluation</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/homework/homeworkevaln') }}" class="nav-link">Home Work Evaluation</a>
                        </li>

                    </ul>
                </div>

            </li>
            <!-- Ends Teachers Activity Menu Listing -->



            <!-- Starts Masters Menu Listing -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#masters" role="button" aria-expanded="" aria-controls="email">
                <i class="link-icon" data-feather="user-plus"></i>
                <span class="link-title">Masters</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="masters">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                    <a href="{{ url('/subject/index') }}" class="nav-link">Subject Master</a>
                    </li>
                    <li class="nav-item">
                    <a href="{{ url('/chapter/index') }}" class="nav-link">Chapter Master</a>
                    </li>
                    <li class="nav-item">
                    <a href="{{ url('/video/index') }}" class="nav-link">Video Master</a>
                    </li>
                    <li class="nav-item">
                    <a href="{{ url('/content/index') }}" class="nav-link">Content Master</a>
                    </li>
                    <li class="nav-item">
                    <a href="{{ url('/question/index') }}" class="nav-link">Question Master</a>
                    </li>
                    <li class="nav-item">
                    <a href="{{ url('/alloctest/index') }}" class="nav-link">Allocate Test</a>
                    </li>
                    <li class="nav-item">
                    <a href="{{ url('/qnbank/index') }}" class="nav-link">Question Bank</a>
                    </li>
                </ul>
                </div>
            </li>

        <!-- Ends Masters Menu Listing -->



            <!-- Starts Payments Menu Listing -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#payment" role="button" aria-expanded="" aria-controls="payment">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Payments</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="payment">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/payment/online') }}" class="nav-link">Online Fees Pay</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Ends Payments Menu Listing -->


            <!-- Starts Reports Menu Listing -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#reports" role="button" aria-expanded="" aria-controls="reports">
                    <i class="link-icon" data-feather="eye"></i>
                    <span class="link-title">Reports</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="reports">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/gradereport/report') }}" class="nav-link">Students Grade</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/projlab/index') }}" class="nav-link">Act./Proj. Lab</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/homework/index') }}" class="nav-link">Home Work </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">List of Students</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Fee Collection</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Ends Reports Menu Listing -->


            <!-- Starts Forum/Discussion Menu Listing -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#forum" role="button" aria-expanded="" aria-controls="forum">
                    <i class="link-icon" data-feather="square"></i>
                    <span class="link-title">Discussion-Forum</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="forum">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">General Comments</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Discussions</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Ends Forum/Discussion Menu Listing -->


            <!-- Starts Admin Panel Listing -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#admin" role="button" aria-expanded="" aria-controls="admin">
                    <i class="link-icon" data-feather="circle"></i>
                    <span class="link-title">System Admin</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="admin">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/asset/index') }}" class="nav-link">Asset Management</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Config Setting</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/rbac/index') }}" class="nav-link">RBAC Setting</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Role Master</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Global Config</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Ends Admin Panel Listing -->


        </ul>
    </div>
</nav>

<nav class="settings-sidebar">
    <div class="sidebar-body">
        <a href="#" class="settings-sidebar-toggler">
            <i data-feather="settings"></i>
        </a>
        <div class="theme-wrapper">
            <h6 class="text-muted mb-2">Light Version:</h6>
            <a class="theme-item" href="https://www.nobleui.com/laravel/template/light/">
                <img src="{{ url('assets/images/screenshots/light.jpg') }}" alt="light version">
            </a>
            <h6 class="text-muted mb-2">Dark Version:</h6>
            <a class="theme-item active" href="https://www.nobleui.com/laravel/template/dark/">
                <img src="{{ url('assets/images/screenshots/dark.jpg') }}" alt="light version">
            </a>
        </div>
    </div>
</nav>


@push('custom-scripts')
<script>
    $(document).ready(function() {
        // $(".link-arrow").click(function() {
            // $(this).collapse('toggle');
            // alert("Settings page was loaded");
            // return false;
        // });
        // $(".nav nav-item li.trigger-collapse a").click(function(event) {
        //   $(".nav-item").collapse('hide');
        // });
    });
</script>
@endpush
