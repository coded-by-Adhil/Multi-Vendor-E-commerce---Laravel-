@extends('admin.admin_master')
@section('admin')

    <!-- index body Container -->

    <!-- Dashboard body Container -->

            <div class="body-container">

                <!-- Cards Container -->
                <div class="card-container">

                    <!-- Card 1 -->
                    <div class="cardBody">
                        <div class="card_header">
                            <div>
                                <p class="title">Total Sales</p>
                                <p class="amount">$1,400</p>
                            </div>
                             <div class="card_cart_div"><i class="bi bi-cart-fill cart"></i> </div>
                        </div> 
                        <p class="description">New orders today</p>
                        <p class="card_link">VIEW MORE <i class="bi bi-arrow-right-circle-fill"></i></p>
                    </div>
                    <!-- End Card 1 -->

                    <!-- Card 2 -->
                    <div class="cardBody">
                        <div class="card_header">
                            <div>
                                <p class="title">New Users</p>
                                <p class="amount">234</p>
                            </div>
                            <div class="card_cart_div">
                            <i class="bi bi-people-fill cart" style="color: #00c853; background: #e8f5e9;"></i>
                            </div>
                        </div> 
                        <p class="description">Joined this week</p>
                        <p class="card_link" style="color: #00c853;">VIEW MORE <i class="bi bi-arrow-right-circle-fill"></i></p>
                    </div>
                    <!-- End Card 2 -->

                    <!-- Card 3 -->
                    <div class="cardBody">
                        <div class="card_header">
                            <div>
                                <p class="title">Revenue</p>
                                <p class="amount">$34k</p>
                            </div>
                             <div class="card_cart_div"><i class="bi bi-currency-dollar cart" style="color: #2979ff; background: #e3f2fd;"></i> </div>
                        </div> 
                        <p class="description">Monthly profit</p>
                        <p class="card_link" style="color: #2979ff;">VIEW MORE <i class="bi bi-arrow-right-circle-fill"></i></p>
                    </div>
                    <!-- End Card 3 -->

                    <!-- Card 4 -->
                    <div class="cardBody">
                        <div class="card_header">
                            <div>
                                <p class="title">Pending</p>
                                <p class="amount">18</p>
                            </div>
                             <div class="card_cart_div"><i class="bi bi-hourglass-split cart" style="color: #ff9100; background: #fff3e0;"></i> </div>
                        </div> 
                        <p class="description">Tasks remaining</p>
                        <p class="card_link" style="color: #ff9100;">VIEW MORE <i class="bi bi-arrow-right-circle-fill"></i></p>
                    </div>
                    <!--End Card 4 -->
                            
                </div> 

    <!-- Table Section -->

                <div class="table-container">
                    <h2>Employee List</h2>
                    <table id="myTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011-07-25</td>
                                <td>$170,750</td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>2009-01-12</td>
                                <td>$86,000</td>
                            </tr>
                            <tr>
                                <td>Cedric Kelly</td>
                                <td>Senior Javascript Developer</td>
                                <td>Edinburgh</td>
                                <td>22</td>
                                <td>2012-03-29</td>
                                <td>$433,060</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

@endsection('admin')