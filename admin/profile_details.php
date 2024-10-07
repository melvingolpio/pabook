<?php
session_start();
require('../dbconn.php');

if (!isset($_SESSION['username']) || $_SESSION['type'] != 'Admin') {
    header("Location: ../login.php"); 
    exit(); 
}


if ($_SESSION['type'] == 'Admin') {
    $user_id = $_SESSION['id'];
    $query = "SELECT id, first_name, last_name, username, birth_date, gender, contact_number, type, email, penalty, image, password FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $id = $user['id'];
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $fullname = $user['first_name'] . ' ' . $user['last_name'];
        $username = $user['username'];
        $birth_date = $user['birth_date'];
        $gender = $user['gender'];
        $contact_number = $user['contact_number'];
        $type = $user['type'];
        $email = $user['email'];
        $penalty = $user['penalty'];
        $image = $user['image'];
        $current_password_hash = $user['password']; 
    }

    $vehicle_sql = "SELECT plate_number, vehicle_brand, vehicle_type, color, amount FROM vehicle WHERE user_id = ?";
    $stmt = $conn->prepare($vehicle_sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $vehicles = [];
    while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
    }

    if (isset($_POST['submit_profile'])) {
 
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birth_date = $_POST['birth_date'];
        $gender = $_POST['gender'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $provided_password = $_POST['password'];

        if (password_verify($provided_password, $current_password_hash)) {
            if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = '../img/';
                $uploaded_file = $upload_dir . basename($_FILES['update_image']['name']);
                if (move_uploaded_file($_FILES['update_image']['tmp_name'], $uploaded_file)) {
                    $image_path = basename($_FILES['update_image']['name']);
                } else {
                    echo "<script type='text/javascript'>alert('Image upload failed.')</script>";
                    $image_path = $image; 
                }
            } else {
                $image_path = $image; 
            }
    
            $query = "UPDATE users SET first_name = ?, last_name = ?, birth_date = ?, gender = ?, contact_number = ?, email = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssssi", $first_name, $last_name, $birth_date, $gender, $contact_number, $email, $image_path, $user_id);
    
            if ($stmt->execute()) {
                echo "<script type='text/javascript'>
                        alert('Profile update successful!');
                        window.location.href = 'profile_details.php';
                    </script>";  
            } else {
                echo $stmt->error;
                echo "<script type='text/javascript'>alert('Error')</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Incorrect password. Profile update Failed.'); window.location.href = 'profile_details.php'</script>";
        }
    }

    if (isset($_POST['submit_password'])) {
     
        $old_password = $_POST['oldPassword'];
        $new_password = $_POST['newPassword'];
        $confirm_password = $_POST['confirmPassword'];
    
        if (!empty($old_password) && !empty($new_password) && !empty($confirm_password)) {
            if ($new_password === $confirm_password) {
                if (password_verify($old_password, $current_password_hash)) {
                    $password_pattern = '/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/';
                    if (preg_match($password_pattern, $new_password)) {
                        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $query = "UPDATE users SET password = ? WHERE id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("si", $hashed_new_password, $user_id);
    
                        if ($stmt->execute()) {
                            echo "<script type='text/javascript'>
                                alert('Password changed successfully!');
                                window.location.href = 'profile_details.php';
                            </script>";  
                        } else {
                            echo $stmt->error;
                            echo "<script type='text/javascript'>alert('Error')</script>";
                        }
                        $stmt->close();
                    } else {
                        echo "<script type='text/javascript'>alert('New password must be at least 8 characters long, include an uppercase letter and a number.')</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Old password is incorrect')</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('New passwords do not match')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('All password fields are required.')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details</title>
    <link rel="stylesheet" href="assets/css/profilestyles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @media (max-width: 786px){
            body {

                overflow-y: scroll;
            }
            .profile-head {
                font-size: 11px;
            }
            .card-container {
                position: top;
            }
        }
        .prof-pic {
        border: 2px solid #1560bd;
       }
       .logo {
    font-variant: small-caps;
    font-weight: bold;
    color: white;
    text-shadow: 2px 4px 6px rgb(0, 0, 0);
}
.menuicn {
   opacity: 0;
} 
@media (max-width: 786px){
            .prof-pic {
                width: 50px;
                height: 50px;
            }
            .profile-details {
                font-size: 12px;
            }
            .card-profile {
                margin-bottom: -200px;
            }
            .profile-head {
                width: 60%;
            }
            .profile-vehicles {
                width: 40%;
            }
            .card-profile {
                gap:7vh;
            }
    
        }
        @media (max-width: 850px) {
            .menuicn {
                opacity: 1; 
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="picture">
            <div class="dp">
                <img src="../img/<?php echo htmlspecialchars($image); ?>" class="dpicn" alt="Picture">
            </div>
            <div class="name">
                <p><?php echo $_SESSION['username']; ?>!</p>
            </div>
        </div>

        <div class="logosec">
            <div class="logo">Pabook</div>
            <i class="fas fa-bars icn menuicn" id="menuicn" alt="menu-icon"></i>
        </div>
    </header>

    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
            <div class="nav-upper-options">
            <div class="nav-option <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt nav-img" alt="dashboard"></i>
                        <a href="index.php" class="nav-link"><h3>Dashboard</h3></a>
                    </div>
                    <div class="nav-option <?php echo (basename($_SERVER['PHP_SELF']) == 'user_account.php') ? 'active' : ''; ?>">
                        <i class="fas fa-user nav-img" alt="account's"></i>
                        <a href="user_account.php" class="nav-link"><h3>Account's</h3></a>
                    </div>
                    
                    <!--<div class="nav-option ?php echo (basename($_SERVER['PHP_SELF']) == 'qr-scanner.php') ? 'active' : ''; ?>">
                        <i class="fas fa-camera-retro    nav-img" alt="scanner"></i>
                        <a href="qr-scanner.php" class="nav-link"><h3>Scanner</h3></a>
                    </div>-->
                    <div class="nav-option <?php echo (basename($_SERVER['PHP_SELF']) == 'report.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-chart-line"></i>
                        <a href="report.php" class="nav-link"><h3>Report</h3></a>
                    </div>
                    <div class="nav-option <?php echo (basename($_SERVER['PHP_SELF']) == 'transaction.php') ? 'active' : ''; ?>">
                        <i class="fas fa-money-check-alt nav-img" alt="institution"></i>
                        <a href="transaction.php" class="nav-link"><h3>Transaction</h3></a>
                    </div>
                    <div class="nav-option <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : ''; ?>">
                        <i class="fas fa-user-shield nav-img" alt="profile"></i>
                        <a href="profile.php" class="nav-link"><h3>Profile</h3></a>
                        
                    </div>
                    <div class="nav-option">
                        <i class="fas fa-sign-out-alt nav-img" alt="logout"></i>
                        <a href="logout.php"><h3>Logout</h3></a>
                    </div>
            </div>
            </nav>
        </div>
            
        <div class="prof-content">
    <div class="arrow">
        <a href="profile.php" class="nav-btn">
            <i class="fas fa-arrow-left nav-img"></i>
        </a>
    </div>
    <div class="profile-head">
        <img src="../img/<?php echo htmlspecialchars($image); ?>" class="prof-pic" onclick="showFullImage('../img/<?php echo htmlspecialchars($image); ?>')">
        <p class="fullname"><?php echo $username; ?></p>

        <div class="profile-details">
            <div class="profile-item">
                <strong>ID:</strong> <?php echo $id; ?>
            </div>
            <div class="profile-item">
                <strong>Fullname:</strong> <?php echo $fullname; ?>
            </div>
            <div class="profile-item">
                <strong>Birth-date:</strong> <?php echo $birth_date; ?>
            </div>
            <div class="profile-item">
                <strong>Sex:</strong> <?php echo $gender; ?>
            </div>
            <div class="profile-item">
                <strong>Contact Number:</strong> <?php echo $contact_number; ?>
            </div>
            <div class="profile-item">
                <strong>Type:</strong> <?php echo $type; ?>
            </div>
            <div class="profile-item">
                <strong>Email:</strong> <?php echo $email; ?>
            </div>
            <div class="profile-item">
                <strong>Penalty:</strong> <?php echo $penalty; ?>
            </div>
            <br>

            <div class="card-container">
                <div class="card-profile">
                    <h5>Update Profile</h5>
                </div>  
                <div class="card-bdy">
                    <h5>Update Password</h5>
                </div>  
            </div>
        </div>
     
    </div>

            <div class="profile-vehicles">
                <h3>Vehicles:</h3>
                <div class="vehicles-list">
                    <?php 
                    if (!empty($vehicles)) {
                        foreach ($vehicles as $vehicle) {
                            echo '<div class="vehicle-card">';
                            echo '<p><strong>Plate Number:</strong> ' . htmlspecialchars($vehicle['plate_number']) . '</p>';
                            echo '<p><strong>Brand:</strong> ' . htmlspecialchars($vehicle['vehicle_brand']) . '</p>';
                            echo '<p><strong>Type:</strong> ' . htmlspecialchars($vehicle['vehicle_type']) . '</p>';
                            echo '<p><strong>Color:</strong> ' . htmlspecialchars($vehicle['color']) . '</p>';
                            echo '<p><strong>Amount:</strong> ' . htmlspecialchars($vehicle['amount']) . '</p>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <div id="reservationModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close-button">&times;</span>
                    <div class="password-container">
                        <form class="password-change" action="profile_update.php" method="POST">                       
                           
                            <label class="oldPassword" for="oldPassword"><b>Old Password:</b></label>
                            <div class="controls">
                                <input type="password" id="oldPassword" name="oldPassword" required class="span8">
                            </div>
                            <label class="newPassword" for="newPassword"><b>New Password:</b></label>
                            <div class="controls">
                                <input type="password" id="newPassword" name="newPassword" required class="span8">
                                <i class='bx bx-show toggle-password' onclick="togglePassword('newPassword', this)"></i>
                            </div>
                            <label class="confirmPassword" for="confirmPassword"><b>Confirm Password:</b></label>
                            <div class="controls">
                                <input type="password" id="confirmPassword" name="confirmPassword" required class="span8">
                                <i class='bx bx-show toggle-password' onclick="togglePassword('confirmPassword', this)"></i>
                            </div>
                        <br>    
                            <div class="btn-update5">
                                <input type="submit" name="submit_password" value="Change Password" class="btn-update4">
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>

        </div>


                

        <div id="profileModal" class="modal">
            <div class="modal-content">
                <span class="close-button1">&times;</span>
                
                    <h2>Profile Information</h2>
                    <form class="profile" action="profile_details.php" method="POST" enctype="multipart/form-data">
                    <label for="first_name"><b>Profile Picture:</b></label>
                        <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="file-input-label">
                        
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                        
                        <label for="first_name"><b>First Name:</b></label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
                        
                        <label for="last_name"><b>Last Name:</b></label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
                        
                        <label for="birth_date  "><b>Birth-date:</b></label>
                        <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($birth_date); ?>" min="1935-01-01">
                        
                        <label for="gender"><b>Sex:</b></label>
                        <select id="gender" name="gender">
                            <option value="<?php echo htmlspecialchars($gender); ?>"></option>
                            <option value="male" <?php echo ($gender == 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo ($gender == 'female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                        
                        <label for="contact_number"><b>Contact Number:</b></label>
                        <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>">
                        
                        <label for="email"><b>Email:</b></label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        
                        <label for="password"><b>Enter Password to Update Profile:</b></label>
                        <input type="password" id="password" name="password" required>
                        
                        <div class="btn-update3">
                            <input type="submit" name="submit_profile" value="Update" class="btn-update2">
                        </div>
                    </form>
                
            </div>
        </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('reservationModal');
        
        const closeButton = document.querySelector('.close-button');
        
        const cardBdy = document.querySelector('.card-bdy');
        cardBdy.addEventListener('click', function(){
            modal.style.display = 'block';
        });

        closeButton.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('profileModal');     
        const closeButton = document.querySelector('.close-button1');
        const cardBdy = document.querySelector('.card-profile');
        
        cardBdy.addEventListener('click', function(){
            modal.style.display = 'block';
        });

        closeButton.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

    function togglePassword(fieldId, icon) {
        const passwordInput = document.getElementById(fieldId);
        const toggleIcon = icon;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bx-show');
            toggleIcon.classList.add('bx-hide');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bx-hide');
            toggleIcon.classList.add('bx-show');
        }

    }

    
</script>
    <script src="assets/script/image.js"></script>
    <script src="assets/script/index.js"></script>
 
</body>
</html>

    <?php
} else {
    header("Location: ../login.php"); 
    echo "<script type='text/javascript'>alert('Access Denied!!!')</script>";
    exit();

}
?>
