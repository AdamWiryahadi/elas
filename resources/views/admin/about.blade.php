<x-admin-layout>
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-info-circle mr-2"></i>About</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">About</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-3">
        <!-- Intro Row -->
        <div class="row align-items-center">
            <!-- Text -->
            <div class="col-md-6">
                <h2 class="mb-3">Welcome to LeaveSync.</h2>
                <p>
                    LeaveSync simplifies leave management for modern organizations. From applying for leave to tracking balances and approvals, we make it easy, efficient, and paperless.
                </p>

                <h5 class="mt-4">Core Features:</h5>
                <ul style="list-style-type: none; padding-left: 1rem;">
                    <li>✔ Apply and approve leaves with ease</li>
                    <li>✔ Real-time leave balance tracking</li>
                    <li>✔ Instant email notifications</li>
                    <li>✔ Transparent leave history</li>
                    <li>✔ User-friendly dashboard</li>
                </ul>

                <!-- Container to position the bubble -->
                <div style="position: relative; display: inline-block;">

                    <!-- Bubble -->
                    <div id="bubbleInfo" style="
                        display: none;
                        position: absolute;
                        top: 110%;
                        left: 50%;
                        transform: translateX(-50%);
                        background: #222;
                        color: #fff;
                        padding: 1rem 1.5rem;
                        border-radius: 12px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                        width: 260px;
                        font-size: 0.9rem;
                        z-index: 1050;
                    ">
                        <strong>Contact Support</strong><br>
                        Phone: +60 11 3788 2324<br>
                        Email: frshaneefa@enetech.com.my<br>
                        Hours: Mon-Fri, 9 AM - 6 PM<br>
                        Live Chat available on website
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="col-md-6 text-center mt-4 mt-md-0">
                <img src="{{ asset('images/removed-bg.png') }}" alt="About LeaveSync" class="img-fluid" style="max-height: 650px;">
            </div>
        </div>

        <!-- Why Choose Section -->
        <div class="mt-5">
            <h3 class="text-center mb-4">Why Choose LeaveSync?</h3>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-bolt fa-2x mb-3 text-dark"></i>
                            <h5>Fast & Efficient</h5>
                            <p class="small">Streamlined processes reduce administrative work and speed up approvals.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-lock fa-2x mb-3 text-dark"></i>
                            <h5>Secure & Reliable</h5>
                            <p class="small">Your data is protected with top-level security practices and encryption.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-users fa-2x mb-3 text-dark"></i>
                            <h5>User-Friendly</h5>
                            <p class="small">Intuitive interface for both employees and managers with zero learning curve.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials -->
        <div class="mt-5">
            <h3 class="text-center mb-2">What Our Users Say</h3>
            
            <!-- Rating Stars -->
            <div class="text-center mb-4 text-warning">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <p class="text-muted small mt-2">Rated 4.8/5 based on 120+ user reviews</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <p class="fst-italic">“LeaveSync has revolutionized how we handle time-off requests. It’s simple, intuitive, and saves hours of admin time every week.”</p>
                            <p class="mb-0 fw-bold text-secondary">– Izdihar Abdul Wahab, Business Development Director</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <p class="fst-italic">“We love how transparent the system is. Our employees always know where their leave balance stands.”</p>
                            <p class="mb-0 fw-bold text-secondary">– Abdullah Egol, Account Manager</p>
                        </div>
                    </div>
                </div>

                <!-- NEW Testimonials -->
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <p class="fst-italic">“The dashboard is incredibly user-friendly. I applied for leave in just 2 clicks!”</p>
                            <p class="mb-0 fw-bold text-secondary">– Nik Nur Fatin Aisyah, Admin Executive</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <p class="fst-italic">“As a manager, LeaveSync makes it so easy to approve and track team leaves without back-and-forth emails.”</p>
                            <p class="mb-0 fw-bold text-secondary">– Nor Kartina, Project Manager</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <p class="fst-italic">“LeaveSync has significantly improved our team's productivity by simplifying the entire leave approval process.”</p>
                            <p class="mb-0 fw-bold text-secondary">– Muhd Khairuddin, Technical Manager</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
