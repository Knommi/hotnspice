<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.emp_sidebar activePage="emp_upd"></x-navbars.emp_sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Employee Update'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <form action="/get_month" method="post">
                    @csrf

                    <input type="month" name="month" id="month">
                    <input type="submit" value="submit">
                </form>
                <h5 style="margin-left: auto;">{{$monthdigit}}</h5>
             
                <h5>{{$empA[0]->employee_name}}</h5>
                
                
                <table class="table table-dark table-striped">
                    <thead>

                        <tr>
                            <th>Date</th>
                            <th>Clock In</th>
                            <th>Lunch In</th>
                            <th>Lunch Out</th>
                            <th>Clock In</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empA as $e)
                        <tr>

                            <td>{{$e->Date}}</td>
                            <td>{{$e->Clock_in}}</td>
                            <td>{{$e->Lunch_in}}</td>
                            <td>{{$e->Lunch_out}}</td>
                            <td>{{$e->Clock_out}}</td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                </table>
            </div>

        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>

</x-layout>
