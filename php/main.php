<?php
session_start();
$error = '';
if (empty($_SESSION)) {
   session_destroy();
   echo '<script>
					window.location="index.php";
			</script>';
}
if($_SESSION['sts']==0){
  echo '<script>
					window.location="change.php";
			</script>';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="main.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="mainpage.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- JavaScript Bundle with Popper -->
<title>Mainpage</title>
</head>

<body>
<div class="container">
<ul class="nav">

    <li class="nav-item">
      <a class="nav-link" href="add_card.php">Add a new card</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="transfers.php">Transfers</a>
    </li>
    <li class="nav-item">
      <!-- card to wallet -->
      <a class="nav-link" href="sendmoney.php">Send money</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="withdrawal.php">Withdrawal</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="phone_card.php">Buy phone cards</a>
    </li>
   <!-- &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
      <li> <form class="form-inline" action="/action_page.php">
        <input class="form-control mr-sm-2" type="text" placeholder="Search">
      </form></li>
      <li> <form class="form-inline" action="/action_page.php">
        <button class="btn btn-success" type="submit">Search</button>
      </form></li> -->
      <ul class="nav justify-content-end">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          Account
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="information.php">Information</a>
          <a class="dropdown-item" href="transactionhistoryall.php">Transaction money</a>
          <a class="dropdown-item" href="reset.php">Reset password</a>
          <a class="dropdown-item" href="logout.php">Log out</a>
      </li>
      </ul>
  </ul>
<article>
<div class="table1"><center>
<center><h1 style='color: white;'>PTPAY</h1></center>
<div class="container">       
  <table class="table table-bordered">
    <thead>
      <tr>
      <th>Name of foreign currency</th>
        <th>Foreign currency code</th>
        <th>Cash</th>
        <th>Transfer</th>
        <th>Selling Price</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>AUSTRALIAN DOLLAR</td>
        <td>AUD</td>
        <td>16,060.13</td>
        <td>16,222.35</td>
        <td>16,745.28</td>
      </tr>
      <tr>
        <td>CANADIAN DOLLAR</td>
        <td>CAD</td>
        <td>17,703.44</td>
        <td>17,882.26</td>
        <td>18,458.70</td>
      </tr>
      <tr>
        <td>SWISS FRANC</td>
        <td>CHF</td>
        <td>23,587.96</td>
        <td>23,826.23</td>
        <td>24,594.27</td>
      </tr>
      <tr>
        <td>EURO</td>
        <td>EUR</td>
        <td>24,263.11</td>
        <td>24,508.19</td>
        <td>25,622.23</td>
      </tr>
      <tr>
        <td>KOREAN WON</td>
        <td>KRW</td>
        <td>15.91</td>
        <td>17.68</td>
        <td>19.38</td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<icon><center>
  <i class="fa fa-cc-jcb"></i>
  <i class="fa fa-cc-visa"></i>
  <i class="fa fa-cc-mastercard"></i>
  <i class="fa fa-cc-diners-club"></i>
  <i class="fa fa-google-wallet"></i>
  <i class="fa fa-paypal"></i>
  <i class="fa fa-cc-amex"></i>
  </icon></center>
</article>
</div>
<div id="about" class="about">
    <h1 class="PTPAY">About us</h1>
    <p>PTPAY is a financial app that allows you to send and receive money. Super quick, simple to use, and completely secure! PTPAY enables you to pay for all of your necessities, including top-up phones from all carriers, payment of energy and water bills, internet, consumer loans, movie tickets, airline tickets, and more, anytime, anywhere, and for FREE. Hundreds of different services are available.</p>
    </div>
    <div id="contact" class="contact">
        <h2 class="contact" >CONTACT</h2>
      <p>  HoChiMinh, VietNam<p>
     <p>  Phone: +0123456789<p>
      <p>   Email: user@mail.com<p>
        
        <input class="" type="text" placeholder="Name" required name="Name">
        <input class="" type="text" placeholder="Email" required name="Email">
        <input class="" type="text" placeholder="Message" required name="Message">
        <br>
        <button class="" type="submit">SEND</button>
        </form>
        
        <img src="image/HCM.jpg" class="w3-image" style="width:100%">
        </div>
</body>
</html>