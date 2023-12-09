<?php require "../config/config.php"?>
<?php require "../includes/header.php"?>
<?php 

if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $rePassword = $_POST['rePassword'];
  $img = 'https://images.unsplash.com/photo-1511367461989-f85a21fda167?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZmlsZXxlbnwwfHwwfHx8MA%3D%3D';

  if(empty($username) || empty($password) || empty($email) || empty($rePassword)){
    echo "<script>alert('some inputs are missing!') </script>";
  
  }else {
    //check if email is already taken
    $emailCheck = $conn->prepare("SELECT * FROM users WHERE email = :email and username = :username");
    $emailCheck->execute([':email' => $email]); //search all email if and match
    $existingUser = $emailCheck->fetch(PDO::FETCH_ASSOC); //return found query

    if($existingUser){
      echo "<script>alert('Email Already Taken') </script>";
       
    } else {

    //compare password logic
    if($password == $rePassword){
      $insert = $conn->prepare("INSERT INTO users (username, email, mypassword, img)
      VALUES (:username, :email, :mypassword, :img)");

      $insert ->execute([
        ':username' => $username,
        ':email' => $email,
        ':mypassword' => password_hash ($password, PASSWORD_DEFAULT),
        ':img' => $img,


      ]);
      echo "<script>alert('Welcome!') </script>";

    }else{
      echo "<script>alert('Password does not match') </script>";
    }
  }
}
}

?>



    <!-- HOME -->
    <section class="section-hero overlay inner-page bg-image" style="background-image: url('../images/hero_1.jpg');" id="home-section">
      <div class="container">
        <div class="row">
          <div class="col-md-7">
            <h1 class="text-white font-weight-bold">Register</h1>
            <div class="custom-breadcrumbs">
              <a href="#">Home</a> <span class="mx-2 slash">/</span>
              <span class="text-white"><strong>Register</strong></span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-5">
            <form action="register.php" method="POST" class="p-4 border rounded">

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="fname">Username</label>
                  <input type="text" id="fname" class="form-control" placeholder="Username" name="username">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="email">Email</label>
                  <input type="text" id="email" class="form-control" placeholder="Email address" name="email">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="password">Password</label>
                  <input type="password" id="password" class="form-control" placeholder="Password" name="password">
                </div>
              </div>
              <div class="row form-group mb-4">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="rePassword">Re-Type Password</label>
                  <input type="password" id="rePassword" class="form-control" placeholder="Re-type Password" name="rePassword">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Sign Up" class="btn px-4 btn-primary text-white" name="submit">
                </div>
              </div>

            </form>
          </div>
      
        </div>
      </div>
    </section>
    <?php require "../includes/footer.php"?>