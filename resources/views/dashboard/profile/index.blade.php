@extends('dashboard.layouts.main')

@section('body')
    
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Profile</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
        <div class="breadcrumb-item">Profile</div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">Hi, {{ auth()->user()->name }}</h2>
      <p class="section-lead">
        Change information about yourself on this page.
      </p>

          <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
              <form method="post" action="/dashboard/profile/update" class="needs-validation" novalidate="">
                @method('patch')
                @csrf
                <div class="card-header">
                  <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                       
                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="level"  value="{{ auth()->user()->level }}">
                  
                    <div class="form-group ">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required="">
                        <div class="invalid-feedback">
                          Please fill in the name
                        </div>
                      </div>

                    <div class="form-group ">
                        <label>Age</label>
                        <input type="number" name="age" class="form-control" value="{{ auth()->user()->age }}" required="">
                        <div class="invalid-feedback">
                          Please fill in the age
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control selectric" name="gender" >
                          <option value="pria" {{ auth()->user()->gender == "pria" ? 'selected' : '' }}>Pria</option>
                          <option value="wanita" {{ auth()->user()->gender == "wanita" ? 'selected' : '' }}>Wanita</option>
                        </select>
                      </div> 
                      
                      <div class="form-group ">
                        <label>Email</label>
                        <input type="email"  name="email" class="form-control" value="{{ auth()->user()->email }}" required="">
                        <div class="invalid-feedback">
                          Please fill in the email
                        </div>
                      </div>
                      <div class="form-group ">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="">
                      </div>
                    </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
 @endsection
